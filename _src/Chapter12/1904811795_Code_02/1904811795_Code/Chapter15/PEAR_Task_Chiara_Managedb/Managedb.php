<?php
/**
 * <tasks:chiara_managedb>
 *
 * PHP versions 4 and 5
 *
 * @package    PEAR_Task_Chiara_Managedb
 * @author     Gregory Beaver <cellog@php.net>
 * @copyright  2005 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    File revision: 0.1
 * @link       http://pear.chiaraquartet.net/index.php?package=PEAR_Task_Chiara_Managedb
 */
/**
 * Base class
 */
require_once 'PEAR/Task/Common.php';
/**
 * Implements the chiara_managedb file task.
 * 
 * This task must be run on a file with role="chiaramdb2schema", as it uses the
 * chiaramdb2schema_dsn configuration variable to access the proper database.
 * 
 * A unique database may be requested by setting attribute unique to 1 as in:
 * 
 * <pre><tasks:chiara_managedb unique="1"/></pre>
 * 
 * This will search for a package-specific DSN and fail if none is present.
 * @package    PEAR_Task_Chiara_Managedb
 * @author     Gregory Beaver <cellog@php.net>
 * @copyright  2005 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Release: @package_version@
 * @link       http://pear.chiaraquartet.net/index.php?package=PEAR_Task_Chiara_Managedb
 */
class PEAR_Task_Chiara_Managedb extends PEAR_Task_Common
{
    var $type = 'single';
    var $phase = PEAR_TASK_INSTALL;
    /**
     * Determines whether the task should use its own unique package-specific DSN
     * @var boolean
     * @access private
     */
    var $_unique;
    /**
     * file name that contains this task
     * @var string
     * @access private
     */
    var $_file;

    /**
     * Validate the raw xml at parsing-time.
     * @param PEAR_PackageFile_v2
     * @param array raw, parsed xml
     * @param PEAR_Config
     * @static
     */
    function validateXml($pkg, $xml, &$config, $fileXml)
    {
        if ($fileXml['attribs']['role'] != 'chiaramdb2schema') {
            return array(PEAR_TASK_ERROR_INVALID, 'chiara_managedb task can only be ' .
                'used with files whose role is chiaramdb2schema.  File is role "' .
                $fileXml['attribs']['role'] . '"');
        }
        if (isset($xml['attribs'])) {
            if (!isset($xml['attribs']['unique'])) {
                return array(PEAR_TASK_ERROR_MISSING_ATTRIB, 'unique');
            }
            if (!in_array($xml['attribs']['unique'], array('0', '1'))) {
                return array(PEAR_TASK_ERROR_WRONG_ATTRIB_VALUE, 'unique',
                    $xml['attribs']['unique'], array('0', '1'));
            }
        }
        if (isset($xml['defaultdatabase'])) {
            if (!is_string($xml['defaultdatabase'])) {
                return array(PEAR_TASK_ERROR_INVALID, 'default database must be ' .
                    'a simple string');
            }
        }
        return true;
    }

    /**
     * Initialize a task instance with the parameters
     * @param array raw, parsed xml
     * @param unused
     */
    function init($xml, $attribs)
    {
        if (isset($attribs['unique']) && $attribs['unique']) {
            $this->_unique = true;
        } else {
            $this->_unique = false;
        }
    }

    /**
     * Update the database.
     * 
     * First, determine which DSN to use from the chiaramdb2schema_dsn config variable
     * with {@link _parseDSN()}, then determine whether the database already exists based
     * on the contents of a previous installation, and finally use
     * {@link MDB2_Schema::updateDatabase()} to update the database itself
     * 
     * PEAR_Error is returned on any problem.
     * See validateXml() source for the complete list of allowed fields
     * @param PEAR_PackageFile_v2
     * @param string file contents
     * @param string the eventual final file location (informational only)
     * @return string|false|PEAR_Error false to skip this file, PEAR_Error to fail
     *         (use $this->throwError), otherwise return the new contents
     */
    function startSession($pkg, $contents, $dest)
    {
        $this->_file = basename($dest);
        $dsn = $this->_parseDSN($pkg);
        if (PEAR::isError($dsn)) {
            return $dsn;
        }
        require_once 'MDB2/Schema.php';
        require_once 'System.php';
        $tmp = System::mktemp(array('foo.xml'));
        if (PEAR::isError($tmp)) {
            return $tmp;
        }
        fopen($tmp, 'wb');
        fwrite($tmp, $contents);
        fclose($tmp);
        $schema = &MDB2_Schema::factory($dsn);
        $reg = &$this->config->getRegistry();
        if ($installed && file_exists($dest)) {
            // update existing database
            $res = $schema->updateDatabase($tmp, $dest);
            if (PEAR::isError($res)) {
                return $res;
            }
        } else {
            // create new database
            $schema->updateDatabase($tmp);
            if (PEAR::isError($res)) {
                return $res;
            }
        }
        // unmodified
        return $contents;
    }

    /**
     * Take an array of DSNs and convert it back into the PEAR_Config
     * values, and save it.
     *
     * @param array $dsn
     * @param string|null $channel
     */
    function serializeDSN($dsns, $channel = null)
    {
        $finaldsn = '';
        $finalpasswords = '';
        foreach ($dsns as $i => $dsn) {
            $dsn = str_replace($this->config->get('chiaramdb2schema_driver', null, $channel)
                . '://', '', $dsn);

            if (strpos($dsn, '@')) {
                // strip password
                $a = explode('@', $dsn); // extract user:password
                $b = explode(':', $a[0]); // extract password
                if (strlen($finalpasswords)) {
                    $finalpasswords .= ':';
                }
                $finalpasswords .= $b[1];
                $dsn = $b[0] . '@' . $a[1];
            } else {
                $finalpasswords .= ':';
            }
            if (strlen($finaldsn)) {
                $finaldsn .= ';';
            }
            if ($i) {
                $dsn = $i . '::' . $dsn;
            }
            $finaldsn .= $dsn;
        }
        $this->config->set('chiaramdb2schema_dsn', $finaldsn, 'user', $channel);
        $this->config->set('chiaramdb2schema_password', $finalpasswords, 'user', $channel);
        $this->config->writeConfigFile();
    }

    /**
     * Utility function for external scripts (such as the post-installation script)
     *
     * Takes the chiaramdb2schema_dsn and chiaramdb2schema_password configuration
     * variables, and constructs an array of DSNs, indexed by package.  the 0
     * index (zero) is the default DSN.
     * @param PEAR_PackageFile_v2 $pkg
     * @return array
     */
    function unserializeDSN($pkg)
    {
        // get channel-specific configuration for this variable
        $driver = $this->config->get('chiaramdb2schema_driver', null, $pkg->getChannel());
        if (!$driver) {
            return PEAR::raiseError('Error: no driver set.  use "config-set ' .
                'chiaramdb2schema_driver <drivertype>" before installing');
        }
        $allDSN = $this->config->get('chiaramdb2schema_dsn', null, $pkg->getChannel());
        if (!$allDSN) {
            return array();
        }
        $allPasswords = $this->config->get('chiaramdb2schema_password', null,
            $pkg->getChannel());
        $allDSN = explode(';', $allDSN);
        $badDSN = array();
        $allPasswords = explode(':', $allPasswords);
        for ($i = 0; $i < count($allDSN); $i++) {
            if ($i && strpos($allDSN[$i], '::')) {
                $allDSN[$i] = explode('::', $allDSN[$i]);
                $password = (isset($allPasswords[$i]) && $allPasswords[$i]) ?
                    $allPasswords[$i] : '';
                if (!strpos($allDSN[$i][1], '@')) {
                    $password = '';
                } elseif ($password) {
                    // insert password into DSN
                    $a = explode('@', $allDSN[$i][1]);
                    $allDSN[$i][1] = $a[0] . ':' . $password . '@';
                    unset($a[0]);
                    $allDSN[$i][1] .= implode('@', $a);
                }
            } elseif (!$i && !strpos($allDSN[0], '::')) {
                $password = (isset($allPasswords[0]) && $allPasswords[0]) ?
                    $allPasswords[0] : '';
                if (!strpos($allDSN[0], '@')) {
                    $password = '';
                } elseif ($password) {
                    // insert password into DSN
                    $a = explode('@', $allDSN[0]);
                    $allDSN[0] = $a[0] . ':' . $password . '@';
                    unset($a[0]);
                    $allDSN[0] .= implode('@', $a);
                }
            } else {
                // invalid DSN
                $badDSN[$i] = $allDSN[$i];
                $allDSN[$i] = false;
            }
        }
        $ret = array();
        foreach ($allDSN as $i => $dsn) {
            if (!$dsn) {
                continue; // bad DSN is skipped
            }
            if ($i) {
                $i = $dsn[0];
                $dsn = $dsn[1];
            }
            $ret[$i] = $driver . '://' . $dsn;
        }
        return $ret;
    }

    /**
     * parse the chiaramdb2schema_dsn config variable and the password variable to
     * determine an actual DSN that should be used for this task.
     * @return string|PEAR_Error
     * @access private
     */
    function _parseDSN($pkg)
    {
        // get channel-specific configuration for this variable
        $driver = $this->config->get('chiaramdb2schema_driver', null, $pkg->getChannel());
        if (!$driver) {
            return PEAR::raiseError('Error: no driver set.  use "config-set ' .
                'chiaramdb2schema_driver <drivertype>" before installing');
        }
        $allDSN = $this->config->get('chiaramdb2schema_dsn', null, $pkg->getChannel());
        if (!$allDSN) {
            return $this->throwError('Error: no dsn set.  use "config-set ' .
                'chiaramdb2schema_dsn <dsn>" before installing');
        }
        $allPasswords = $this->config->get('chiaramdb2schema_password', null,
            $pkg->getChannel());
        $allDSN = explode(';', $allDSN);
        $badDSN = array();
        $allPasswords = explode(':', $allPasswords);
        for ($i = 0; $i < count($allDSN); $i++) {
            if ($i && strpos($allDSN[$i], '::')) {
                $allDSN[$i] = explode('::', $allDSN[$i]);
                $password = (isset($allPasswords[$i]) && $allPasswords[$i]) ?
                    $allPasswords[$i] : '';
                if (!strpos($allDSN[$i][1], '@')) {
                    $password = '';
                } elseif ($password) {
                    // insert password into DSN
                    $a = explode('@', $allDSN[$i][1]);
                    $allDSN[$i][1] = $a[0] . ':' . $password . '@';
                    unset($a[0]);
                    $allDSN[$i][1] .= implode('@', $a);
                }
            } elseif (!$i && !strpos($allDSN[0], '::')) {
                $password = (isset($allPasswords[0]) && $allPasswords[0]) ?
                    $allPasswords[0] : '';
                if (!strpos($allDSN[0], '@')) {
                    $password = '';
                } elseif ($password) {
                    // insert password into DSN
                    $a = explode('@', $allDSN[0]);
                    $allDSN[0] = $a[0] . ':' . $password . '@';
                    unset($a[0]);
                    $allDSN[0] .= implode('@', $a);
                }
            } else {
                // invalid DSN
                $badDSN[$i] = $allDSN[$i];
                $allDSN[$i] = false;
            }
        }
        if ($this->_unique) {
            $lookfor = array($pkg->getPackage(), $pkg->getPackage() . '#' . $this->_file);
            foreach ($allDSN as $i => $dsn) {
                if (!$i) {
                    continue;
                }
                if (strcasecmp($dsn[0], $lookfor[0]) === 0) {
                    return $driver . '://' . $dsn[1];
                }
                if (strcasecmp($dsn[0], $lookfor[1]) === 0) {
                    return $driver . '://' . $dsn[1];
                }
            }
            return $this->throwError('No valid DSNs for package "' . $pkg->getPackage() .
                '" were found in config variable chiaramdb2schema_dsn');
        } else {
            if (!$allDSN[0]) {
                return $this->throwError('invalid default DSN "' . $badDSN[0] .
                    '" in config variable chiaramdb2schema_dsn');
            }
            return $driver . '://' . $allDSN[0];
        }
    }
}
?>