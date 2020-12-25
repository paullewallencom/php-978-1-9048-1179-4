<?php
/**
 * Custom file role for MDB2_Schema-based database setup files
 *
 * This file contains the PEAR_Installer_Role_Chiaramdb2schema file role
 *
 * PHP versions 4 and 5
 *
 * @package    Role_Chiaramdb2schema
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  2005 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Release: 0.1
 * @link       http://pear.chiaraquartet.net/index.php?package=Role_Chiaramdb2schema
 */
/**
 * Contains the PEAR_Installer_Role_Data class
 */
require_once 'PEAR/Installer/Role/Data.php';
/**
 * chiaramdb2schema Custom file role for MDB2_Schema-based database setup files
 *
 * This file role provides the <var>chiaramdb2schema_driver</var>,
 * <var>chiaramdb2schema_dsn</var>, and <var>chiaramdb2schema_password</var>
 * configuration variables for use by the chiara_managedb custom task to
 * set up and initialize database files
 *
 * PHP versions 4 and 5
 *
 * @package    Role_Chiaramdb2schema
 * @author     Greg Beaver <cellog@php.net>
 * @copyright  2005 Gregory Beaver
 * @license    http://www.opensource.org/licenses/bsd-license.php BSD License
 * @version    Release: 0.1
 * @link       http://pear.chiaraquartet.net/index.php?package=Role_Chiaramdb2schema
 */
class PEAR_Installer_Role_Chiarasql extends PEAR_Installer_Role_Data
{
    /**
     * This method is called upon instantiating a PEAR_Config object.
     *
     * This method MUST an array of information for all new configuration
     * variables required by the file role.  addConfigVar() expects an
     * array of configuration information that is identical to what is
     * used internally in PEAR_Config
     * @access protected
     * @param PEAR_Config unused parameter in this custom role
     */
    function getSupportingConfigVars()
    {
        return array(
         'chiaramdb2schema_driver' => array(
            'type' => 'string',
            'default' => false,
            'doc' => 'MDB2 database driver used to connect to the database',
            'prompt' => 'Database driver type.  This must be a valid MDB2 driver.
Example drivers are mysql, mysqli, pgsql, sqlite, and so on',
            'group' => 'Database',
            ),
         'chiaramdb2schema_dsn' => array(
            'type' => 'string',
            'default' => false,
            'doc' => 'PEAR::MDB2 dsn string[s] for database connection, separated by ;.
This must be of format: [user@]host/dbname[;[Package[#schemafile]::]dsn2...]
One default database connection must be specified, and package-specific databases
may be specified.  The driver type and password should be excluded.  Passwords
are set with the chiaramdb2schema_password config variable
',
            'prompt' => 'Database connection DSN[s] (no driver/password)',
            'group' => 'Database',
            ),
         'chiaramdb2schema_password' => array(
            'type' => 'string',
            'default' => false,
            'doc' => 'PEAR::MDB2 dsn password[s] for database connection.
This must be of format: password[:password...]
Each DSN in chiaramdb2schema_dsn must match with a password in this list, or
none will be used.  To use no password, simply put another :: like ::::
',
            'prompt' => 'Database connection password[s]',
            'group' => 'Database',
            ),
        );
    }

}
?>