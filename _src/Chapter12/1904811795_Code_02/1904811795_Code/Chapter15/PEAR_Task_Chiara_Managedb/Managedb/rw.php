<?php
/**
 * <tasks:chiara_managedb> - read/write version
 *
 * PHP versions 4 and 5
 *
 * PHP versions 4 and 5
 *
 * @package    PEAR
 * @author     Gregory Beaver <cellog@php.net>
 * @copyright  2005 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Release: 0.1
 * @link       http://pear.chiaraquartet.net/index.php?package=Task_Chiara_Managedb
 */
/**
 * Base class
 */
require_once 'PEAR/Task/Chiara/Managedb.php';
/**
 * PHP versions 4 and 5
 *
 * @package    PEAR
 * @author     Gregory Beaver <cellog@php.net>
 * @copyright  2005 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Release: 0.1
 * @link       http://pear.chiaraquartet.net/index.php?package=Task_Chiara_Managedb
 */
class PEAR_Task_Chiara_Managedb_rw extends PEAR_Task_Chiara_Managedb
{
    /**
     * xml content to return
     * @var array
     * @access private
     */
    var $_params = array();
    /**
     * @param PEAR_PackageFile_v2_rw $pkg
     * @param PEAR_Config $config
     * @param PEAR_Common $logger
     * @param array $fileXml
     * @return PEAR_Task_Chiara_Managedb_rw
     */
    function PEAR_Task_Chiara_Managedb_rw(&$pkg, &$config, &$logger, $fileXml)
    {
        parent::PEAR_Task_Common($config, $logger, PEAR_TASK_PACKAGE);
        $this->_contents = $fileXml;
        $this->_pkg = &$pkg;
    }

    /**
     * Validate the task - ensure that its xml makes sense and that it is valid
     * logically.
     * 
     * This is a required method.
     * @return boolean
     */
    function validate()
    {
        return $this->validateXml($this->_pkg, $this->_params, $this->config,
            $this->_contents);
    }

    /**
     * Return the name of the task as it should appear in package.xml.
     *
     * This method is required.
     * @return string
     */
    function getName()
    {
        return 'chiara_managedb';
    }

    /**
     * Return a ready-to-serialize array-based representation of xml.
     *
     * Use '' for an empty tag, 'something' for a tag containing text, and
     * an array for any other content.
     * 
     * This method is required.
     * @return array|string
     */
    function getXml()
    {
        return $this->_params ? '' : $this->_params;
    }

    /**
     * Use this method to set the unique property of this task.
     * 
     * A chiara_managedb task is unique if it requires a unique
     * database be created for this package
     */
    function setUnique()
    {
        $this->_params['attribs'] = array('unique' => '1'); 
    }

    /**
     * Set the default database name that should be available to the user
     * for this particular package.
     *
     * This only affects the post-install script default values
     * @param string $dbname
     */
    function setDefaultDatabase($dbname)
    {
        $this->_params['default'] = (string) $dbname;
    }
}
?>