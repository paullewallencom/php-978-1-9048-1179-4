<?php
/**
 * package.xml generation script for Task_Chiara_Managedb package
 * @author Gregory Beaver <cellog@php.net>
 */
require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = &PEAR_PackageFileManager2::importOptions('package.xml',
    array(
        // set a subdirectory everything is installed into
        'baseinstalldir' => 'PEAR/Task/Chiara',
        // location of files to package
        'packagedirectory' => dirname(__FILE__),
        // what method is used to glob files? cvs, svn, perforce
        // and file are options
        'filelistgenerator' => 'file',
        
        // don't distribute this script
        'ignore' => array('package.php', 'package2.xml', 'package.xml'),
        // put the post-installation script in a
        // different location from the task itself
        'installexceptions' =>
            array(
                'rolesetup.php' => 'Chiara/Task/Managedb',
            ),
        // make the output human-friendly
        'simpleoutput' => true,
        ));

$pfm->setPackage('PEAR_Task_Chiara_Managedb');
$pfm->setChannel('pear.chiaraquartet.net');
$pfm->setLicense('BSD license', 'http://www.opensource.org/licenses/bsd-license.php');
$pfm->setSummary('Provides the <tasks:chiara_managedb/> file task for managing ' .
    'databases on installation');
$pfm->setDescription('Task_Chiara_Managedb provides the code to implement the
<tasks:chiara_managedb/> task, as well as a post-installation script
to manage the configuration variables it needs.

This task works in conjunction with the chiaramdb2schema file role
(package Chiara_Role_chiaramdb2schema) to create databases used by
a package on installation, and to upgrade the database structure
automatically on upgrade.  To do this, it uses MDB2_Schema\'s
updateDatabase() functionality.

The post-install script must be run with "pear run-scripts"
to initialize configuration variables');
// initial release version should be 0.1.0
$pfm->addMaintainer('lead', 'cellog', 'Greg Beaver', 'cellog@php.net', 'yes');
$pfm->setAPIVersion('0.1.0');
$pfm->setReleaseVersion('0.1.0');
// our API is reasonably stable, but may need tweaking
$pfm->setAPIStability('beta');
// the code is very new, and may change dramatically
$pfm->setReleaseStability('alpha');
// release notes
$pfm->setNotes('initial release');
// this is a PHP script, not a PECL extension source/binary or a bundle package
$pfm->setPackageType('php');
$pfm->addRelease();

// set up special file properties
$pfm->addGlobalReplacement('package-info', '@package_version@', 'version');
$script = &$pfm->initPostinstallScript('rolesetup.php');

// add paramgroups to the post-install script
$script->addParamGroup(
    'setup',
    $script->getParam('channel', 'Choose a channel to modify configuration values from',
        'string', 'pear.php.net'));
$script->addParamGroup(
    'driver',
    $script->getParam('driver', 'Database driver?'),
        'In order to set up the database, please choose a database driver.
This should be a MDB2-compatible driver name, such as mysql, mysqli,
Pgsql, oci8, etc.');
$script->addParamGroup(
    'choosedsn',
    $script->getParam('dsnchoice', '%sChoose a DSN to modify, or to add a' .
        ' new dsn, type "new".  To remove a DSN prepend with "!"'));
$script->addParamGroup(
    'deletedsn',
    $script->getParam('confirm', 'Really delete "%s" DSN? (yes to delete)',
        'string', 'no'));
$script->addConditionTypeGroup(
    'modifydsn',
    'choosedsn', 'dsnchoice', 'new', '!=',
    array(
        $script->getParam('user', 'User name', 'string', 'root'),
        $script->getParam('password', 'Database password', 'password'),
        $script->getParam('host', 'Database host', 'string', 'localhost'),
        $script->getParam('database', 'Database name'),
    ));
$script->addParamGroup(
    'newpackagedsn',
    array(
        $script->getParam('package', 'Package name'),
        $script->getParam('user', 'User name', 'string', 'root'),
        $script->getParam('password', 'Database password', 'password'),
        $script->getParam('host', 'Database host', 'string', 'localhost'),
        $script->getParam('database', 'Database name'),
    ));
$script->addParamGroup(
    'newdefaultdsn',
    array(
        $script->getParam('user', 'User name', 'string', 'root'),
        $script->getParam('password', 'Database password', 'password'),
        $script->getParam('host', 'Database host', 'string', 'localhost'),
        $script->getParam('database', 'Database name'),
    ));

$pfm->addPostinstallTask($script, 'rolesetup.php');

// start over with dependencies
$pfm->clearDeps();
$pfm->setPhpDep('4.2.0');
// we use post-install script features fixed in PEAR 1.4.3
$pfm->setPearinstallerDep('1.4.3');
$pfm->addPackageDepWithChannel('required', 'PEAR', 'pear.php.net', '1.4.3');
$pfm->addPackageDepWithChannel('required', 'MDB2_Schema', 'pear.php.net', '0.3.0');

// create the <contents> tag
$pfm->generateContents();

// create package.xml 1.0 to gracefully tell PEAR 1.3.x users they have
// to upgrade to use this package
$pfm1 = $pfm->exportCompatiblePackageFile1(array(
        // set a subdirectory everything is installed into
        'baseinstalldir' => 'PEAR/Task/Chiara',
        // location of files to package
        'packagedirectory' => dirname(__FILE__),
        // what method is used to glob files? cvs, svn, perforce
        // and file are options
        'filelistgenerator' => 'file',
        
        // don't distribute this script
        'ignore' => array('package.php', 'package.xml', 'package2.xml', 'rolesetup.php'),
        // put the post-installation script in a
        // different location from the task itself
        // make the output human-friendly
        'simpleoutput' => true,
        ));

// display the package.xml by default to allow "debugging" by eye, and then
// create it if explicitly asked to
if (isset($_GET['make']) || (isset($_SERVER['argv']) && @$_SERVER['argv'][1] == 'make')) {
    $pfm1->writePackageFile();
    $pfm->writePackageFile();
} else {
    $pfm1->debugPackageFile();
    $pfm->debugPackageFile();
}
?>