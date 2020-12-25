<?php
/**
 * package.xml generation script for Role_Chiaramdb2schema package
 * @author Gregory Beaver <cellog@php.net>
 */
require_once 'PEAR/PackageFileManager2.php';
PEAR::setErrorHandling(PEAR_ERROR_DIE);
$pfm = &PEAR_PackageFileManager2::importOptions('package2.xml',
    array(
        // set a subdirectory everything is installed into
        'baseinstalldir' => 'PEAR/Installer/Role',
        // location of files to package
        'packagedirectory' => dirname(__FILE__),
        // what method is used to glob files? cvs, svn, perforce
        // and file are options
        'filelistgenerator' => 'file',
        // what is the package filename?
        'packagefile' => 'package2.xml',
        // don't distribute this script
        'ignore' => array('package.php', 'package2.xml', 'package.xml'),
        // make the output human-friendly
        'simpleoutput' => true,
        ));

$pfm->setPackage('PEAR_Installer_Role_Chiaramdb2schema');
$pfm->setChannel('pear.chiaraquartet.net');
$pfm->setLicense('BSD license', 'http://www.opensource.org/licenses/bsd-license.php');
$pfm->setSummary('Provides the chiaramdb2schema file role for managing ' .
    'databases on installation');
$pfm->setDescription('PEAR_Installer_Role_Chiaramdb2schema provides the chiaramdb2schema file role
to specify that a file is a MDB2_Schema-based database schema file.

This role works in conjunction with the PEAR_Task_Chiara_Managedb file role
(package PEAR_Task_Chiara_Managedb) to create databases used by
a package on installation, and to upgrade the database structure
automatically on upgrade.  To do this, it uses MDB2_Schema\'s
updateDatabase() functionality.');
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

// start over with dependencies
$pfm->clearDeps();
$pfm->setPhpDep('4.2.0');
$pfm->setPearinstallerDep('1.4.0');
$pfm->addPackageDepWithChannel('required', 'PEAR', 'pear.php.net', '1.4.0');
$pfm->addPackageDepWithChannel('required', 'MDB2_Schema', 'pear.php.net', '0.3.0');

// create the <contents> tag
$pfm->generateContents();

// create package.xml 1.0 to gracefully tell PEAR 1.3.x users they have
// to upgrade to use this package
$pfm1 = $pfm->exportCompatiblePackageFile1(array(
        // set a subdirectory everything is installed into
        'baseinstalldir' => 'PEAR/Installer/Role',
        // location of files to package
        'packagedirectory' => dirname(__FILE__),
        // what method is used to glob files? cvs, svn, perforce
        // and file are options
        'filelistgenerator' => 'file',
        // what is the packagefile filename?
        'packagefile' => 'package.xml',
        // don't distribute this script
        'ignore' => array('package.php', 'package.xml', 'package2.xml'),
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