<?php
/**
 * Class to provide access to the configuration
 */
class configuration
{
   /**
    * Will store the section
    */
    private $sections = null;
    
   /**
    * selected environment
    */
    private $environment = 'online';
    
   /**
    * Setter method for the section tag
    */
    public function setSection($section)
    {
        $this->sections = $section;
    }
    
   /**
    * Set the environment for the configuration
    *
    * Will not be called by XML_Unserialiazer, but
    * the user.
    */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
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
        foreach ($this->sections as $currentSection) {
        	if ($currentSection->getName() !== $section) {
        		continue;
        	}
        	if (!$currentSection->isEnvironment($this->environment)) {
        		continue;
        	}
        	return $currentSection->getValue($value);
        }
        return null;
    }
}

/**
 * Class to store information about one section
 */
class section
{
   /**
    * stores meta information
    */
    private $meta = null;
    
   /**
    * setter for the meta information
    */
    public function setMeta($meta)
    {
        if (!isset($meta['name'])) {
        	throw new Exception('Sections require a name.');
        }
        $this->meta = $meta;
    }

   /**
    * Get the name of the section
    */
    public function getName()    
    {
        return $this->meta['name'];
    }

   /**
    * check for the sepcified environment
    */
    public function isEnvironment($environment)
    {
        if (!isset($this->meta['environment'])) {
            return true;
        }
        return ($environment === $this->meta['environment']);
    }
    
   /**
    * Get a value from the section
    */
    public function getValue($name)
    {
        if (isset($this->$name)) {
        	return $this->$name;
        }
        return null;
    }
}

require_once 'XML/Unserializer.php';
$unserializer = new XML_Unserializer();

// parse attributes as well
$unserializer->setOption(XML_UNSERIALIZER_OPTION_ATTRIBUTES_PARSE, true);
// store attributes in a separate array
$unserializer->setOption(XML_UNSERIALIZER_OPTION_ATTRIBUTES_ARRAYKEY, 'meta');
// use objects instead of arrays
$unserializer->setOption(XML_UNSERIALIZER_OPTION_COMPLEXTYPE, 'object');
$unserializer->setOption(XML_UNSERIALIZER_OPTION_TAG_AS_CLASSNAME, true);
// Always create a numbered array for <section/>
$unserializer->setOption(XML_UNSERIALIZER_OPTION_FORCE_ENUM, array('section'));

$unserializer->unserialize('XML_Parser-001.xml', true);
$config = $unserializer->getUnserializedData();

printf("Cache folder  : %s\n", $config->getConfigurationOption('paths', 'cache'));
printf("DB connection : %s\n", $config->getConfigurationOption('db', 'dsn'));

$config->setEnvironment('stage');
print "\nChanged the environment:\n";
printf("Cache folder  : %s\n", $config->getConfigurationOption('paths', 'cache'));
printf("DB connection : %s\n", $config->getConfigurationOption('db', 'dsn'));
?>