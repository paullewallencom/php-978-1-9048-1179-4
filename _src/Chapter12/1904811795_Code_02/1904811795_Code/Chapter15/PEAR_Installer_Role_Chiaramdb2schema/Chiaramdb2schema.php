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
 * @version    Release: 0.2.0
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
 * @version    Release: 0.2.0
 * @link       http://pear.chiaraquartet.net/index.php?package=Role_Chiaramdb2schema
 */
class PEAR_Installer_Role_Chiaramdb2schema extends PEAR_Installer_Role_Data
{
}
?>