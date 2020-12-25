<?php
require_once 'XML/Parser.php';

/**
 * Class to read XML configuration files
 */
class ConfigReader
{
   /**
    * selected environment
    */
    private $environment;

   /**
    * sections that already have been parsed
    */
    private $sections = array();
    
   /**
    * temporarily store data during parsing
    */
    private $currentSection = null;
    private $currentData = null;
    
   /**
    * Create a new ConfigReader
    *
    * @param    string  environment to use
    */
    public function __construct($environment = 'online')
    {
        $this->environment = $environment;
    }

   /**
    * handle opening tags
    *
    * @param    resource    parser resource
    * @param    string      tag name
    * @param    array       attributes
    */
    public function startHandler($parser, $name, $attribs)
    {
        switch ($name) {
        	case 'section':
                // check, whether the correct environment is set
        		if (!isset($attribs['environment'])
        		    || $attribs['environment'] == $this->environment) {
        		        
                    // store the name of the section
        			$this->currentSection = $attribs['name'];
                    // create an empty array for this section        			
        			$this->sections[$this->currentSection] = array();
        		}
        		break;
            case 'configuration':
                break;
            default:
                $this->currentData = '';
                break;
        }
    }

   /**
    * handle character data
    *
    * @param    resource    parser resource
    * @param    string      character data
    */
    public function cDataHandler($parser, $cData)
    {
        if (trim($cData) === '') {
            return;
        }
        $this->currentData .= $cData;
    }
    
   /**
    * handle closing tags
    *
    * @param    resource    parser resource
    * @param    string      tag name
    */
    public function endHandler($parser, $name)
    {
        switch ($name) {
            // end of </section>, clear the current section
        	case 'section':
                $this->currentSection = null;
        		break;
            case 'configuration':
                break;
            default:
                if ($this->currentSection == null) {
                	return;
                }
                // store the current data in the configuration
                $this->sections[$this->currentSection][$name] = trim($this->currentData);
                break;
        }
    }

   /**
    * Fetch a configuration option
    *
    * @param    string      name of the section
    * @param    string      name of the option
    * @return   mixed       configuration option or false if not set
    */
    public function getConfigurationOption($section, $value)
    {
        if (!isset($this->sections[$section])) {
        	return false;
        }
        if (!isset($this->sections[$section][$value])) {
        	return false;
        }
        return $this->sections[$section][$value];
    }
}

$config = new ConfigReader('online');
$parser = new XML_Parser();
$parser->folding = false;
$parser->setHandlerObj($config);
$parser->setInputFile('XML_Parser-001.xml');
$parser->parse();

printf("Cache folder  : %s\n", $config->getConfigurationOption('paths', 'cache'));
printf("DB connection : %s\n", $config->getConfigurationOption('db', 'dsn'));
?>