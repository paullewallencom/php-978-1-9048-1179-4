<?php
/**
 * Post-installation script for the Chiara_Managedb task.
 *
 * This script takes user input on DSNs and sets up DSNs, allowing
 * the addition of one custom DSN per iteration.
 * @version @package_version@
 */
class rolesetup_postinstall
{
    /**
     * object representing package.xml
     * @var PEAR_PackageFile_v2
     * @access private
     */
    var $_pkg;
    /**
     * Frontend object
     * @var PEAR_Frontend
     * @access private
     */
    var $_ui;
    /**
     * @var PEAR_Config
     * @access private
     */
    var $_config;
    /**
     * The actual DSN value as will be saved to the configuration file
     * @var string
     */
    var $dsnvalue;
    /**
     * The actual password value as will be saved to the configuration file
     * @var string
     */
    var $passwordvalue;
    /**
     * The channel to modify configuration values from
     *
     * @var string
     */
    var $channel;
    /**
     * The task object used for dsn serialization/unserialization
     * @var PEAR_Task_Chiara_Managedb
     */
    var $managedb;
    /**
     * An "unserialized" array of DSNs parsed from the chiaramdb2schema
     * configuration variables.
     * @var array
     */
    var $dsns;
    /**
     * The index of the DSN in $this->dsns we will be modifying
     * @var string
     */
    var $choice;

    /**
     * Initialize the post-installation script
     *
     * @param PEAR_Config $config
     * @param PEAR_PackageFile_v2 $pkg
     * @param string|null $lastversion Last installed version.  Not used in
     *                                 this script
     * @return boolean success of initialization
     */
    function init(&$config, &$pkg, $lastversion)
    {
        require_once 'PEAR/Task/Chiara/Managedb.php';
        $this->_config = &$config;
        $this->_ui = &PEAR_Frontend::singleton();
        $this->managedb = new PEAR_Task_Chiara_Managedb($config, $this->_ui,
            PEAR_TASK_INSTALL);
        $this->_pkg = &$pkg;
        if (!in_array('chiaramdb2schema_dsn', $this->_config->getKeys())) {
            // fail: role was not installed?
            return false;
        }
        $this->channel = $this->_config->get('default_channel');
        $this->dsns = PEAR::isError($e = $this->managedb->unserializeDSN($pkg)) ? array() : $e;
        return true;
    }

    /**
     * Set up the prompts properly for the script
     *
     * @param array $prompts
     * @param string $section
     * @return array
     */
    function postProcessPrompts($prompts, $section)
    {
        switch ($section) {
            case 'driver' :
                if ($this->driver) {
                    $prompts[0]['default'] = $this->driver;
                }
            break;
            case 'deletedsn' :
                $count = 1;
                foreach ($this->dsns as $i => $dsn) {
                    $text = ($i ? "(Package $i) " : '') . $dsn;
                    if ($count == $this->choice) {
                        break;
                    }
                    $count++;
                }
                $prompts[0]['prompt'] = sprintf($prompts[0]['prompt'], $text);
            break;
            case 'choosedsn' :
                $text = '';
                $count = 1;
                foreach ($this->dsns as $i => $dsn) {
                    $text .= "[$count] " . ($i ? "(Package $i) " : '') . $dsn . "\n";
                    $count++;
                }
                $prompts[0]['prompt'] = sprintf($prompts[0]['prompt'], $text);
            break;
            case 'modifydsn' :
                $count = 1;
                $found = false;
                foreach ($this->dsns as $i => $dsn) {
                    if ($count == $this->choice) {
                        $found = true;
                        break;
                    }
                    $count++;
                }
                if ($found) {
                    $dsn = MDB2::parseDSN($this->dsns[$i]);
                    // user
                    $prompts[0]['default'] = $dsn['username'];
                    // password
                    if (isset($dsn['password'])) {
                        $prompts[1]['default'] = $dsn['password'];
                    }
                    // host
                    $prompts[2]['default'] = $dsn['hostspec'];
                    if (isset($dsn['port'])) {
                        $prompts[2]['default'] .= ':' . $dsn['port'];
                    }
                    // database
                    $prompts[3]['default'] = $dsn['database'];
                }
            break;
        }
        return $prompts;
    }

    /**
     * Run the script itself
     *
     * @param array $answers
     * @param string $phase
     */
    function run($answers, $phase)
    {
        switch ($phase) {
            case 'setup' :
                return $this->_doSetup($answers);
            break;
            case 'driver' :
                require_once 'MDB2.php';
                PEAR::pushErrorHandling(PEAR_ERROR_RETURN);
                if (PEAR::isError($err = MDB2::loadFile('Driver' . DIRECTORY_SEPARATOR .
                      $answers['driver']))) {
                    PEAR::popErrorHandling();
                    $this->_ui->outputData('ERROR: Unknown MDB2 driver "' .
                        $answers['driver'] . '": ' .
                        $err->getUserInfo() . '. Be sure you have installed ' .
                        'MDB2_Driver_' . $answers['driver']);
                    return false;
                }
                PEAR::popErrorHandling();
                $ret = $this->_config->set('chiaramdb2schema_driver', $answers['driver'],
                    'user', $this->channel);
                return $ret && $this->_config->writeConfigFile();
            break;
            case 'choosedsn' :
                if ($answers['dsnchoice'] && $answers['dsnchoice']{0} == '!') {
                    // delete a DSN
                    $answers['dsnchoice'] = substr($answers['dsnchoice'], 1);
                } else {
                    $this->_ui->skipParamgroup('deletedsn');
                }
                if ($answers['dsnchoice'] > count($this->dsns)) {
                    $this->_ui->outputData('ERROR: No such dsn "' . $answers['dsnchoice'] .
                        '"');
                    return false;
                }
                $this->choice = $answers['dsnchoice'];
            break;
            case 'deletedsn' :
                $this->_ui->skipParamgroup('modifydsn');
                $this->_ui->skipParamgroup('newpackagedsn');
                $this->_ui->skipParamgroup('newdefaultdsn');
                if ($answers['confirm'] == 'yes') {
                    $count = 1;
                    foreach ($this->dsns as $i => $dsn) {
                        if ($count == $this->choice) {
                            unset($this->dsns[$i]);
                            break;
                        }
                        $count++;
                    }
                    $this->_ui->outputData('DSN deleted');
                    $this->managedb->serializeDSN($this->dsns, $this->channel);
                    return true;
                } else {
                    $this->_ui->outputData('No changes performed');
                }
            break;
            case 'modifydsn' :
                $count = 1;
                $found = false;
                foreach ($this->dsns as $i => $dsn) {
                    if ($count == $this->choice) {
                        $found = true;
                        break;
                    }
                    $count++;
                }
                if (!$found) {
                    $this->_ui->outputData('ERROR: DSN "' . $this->choice . '" not found!');
                    return false;
                }
                $dsn = $answers['user'] . ':' . $answers['password'] . '@' .
                    $answers['host'] . '/' . $answers['database'];
                $this->dsns[$i] = $dsn;
                $this->managedb->serializeDSN($this->dsns, $this->channel);
                $this->_ui->skipParamgroup('newpackagedsn');
                $this->_ui->skipParamgroup('newdefaultdsn');
            break;
            case 'newpackagedsn' :
                $dsn = $answers['user'] . ':' . $answers['password'] . '@' .
                    $answers['host'] . '/' . $answers['database'];
                $this->dsns[$answers['package']] = $dsn;
                $this->managedb->serializeDSN($this->dsns, $this->channel);
                $this->_ui->skipParamgroup('newdefaultdsn');
            break;
            case 'newdefaultdsn' :
                $dsn = $answers['user'] . ':' . $answers['password'] . '@' .
                    $answers['host'] . '/' . $answers['database'];
                $this->dsns[0] = $dsn;
                $this->managedb->serializeDSN($this->dsns, $this->channel);
            break;
            case '_undoOnError' :
                // answers contains paramgroups that succeeded in reverse order
                foreach ($answers as $group) {
                }
            break;
        }
        return true;
    }

    /**
     * Run the setup paramgroup
     *
     * @param array $answers
     * @return boolean
     * @access private
     */
    function _doSetup($answers)
    {
        $reg = &$this->_config->getRegistry();
        if (!$reg->channelExists($answers['channel'])) {
            $this->_ui->outputData('ERROR: channel "' . $answers['channel'] .
                '" is not registered, use the channel-discover command');
            return false;
        }
        $this->channel = $answers['channel'];
        $this->driver = $this->_config->get('chiaramdb2schema_driver', null,
            $this->channel);
        $this->dsnvalue = $this->_config->get('chiaramdb2schema_dsn', null,
            $this->channel);
        $this->passwordvalue = $this->_config->get('chiaramdb2schema_dsn', null,
            $this->channel);
        if (!$this->dsnvalue) {
            // magically skip the "choosedsn", "deleteDSN" and "modifydsn" <paramgroup>s,
            // and only create a new, default DSN
            $this->_ui->skipParamgroup('choosedsn');
            $this->_ui->skipParamgroup('deletedsn');
            $this->_ui->skipParamgroup('modifydsn');
            $this->_ui->skipParamgroup('newpackagedsn');
        }
        return true;
    }
}
?>