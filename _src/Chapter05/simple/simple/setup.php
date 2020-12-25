<?php
/**
 * Setup the database and insert relevant information.
 *
 * This page demonstrates how to use the Admin API to control
 * LiveUser data.
 *
 * PHP versions 4 and 5
 *
 * LICENSE:
 * 
 * Copyright (c) 2005, Arnaud Limbourg
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 * 
 *   - Redistributions of source code must retain the above copyright notice,
 *     this list of conditions and the following disclaimer.
 *   - Redistributions in binary form must reproduce the above copyright notice, 
 *     this list of conditions and the following disclaimer in the documentation 
 *     and/or other materials provided with the distribution.
 *   - Neither the name of the Packt Publishing nor the names of its 
 *     contributors may be used to endorse or promote products derived from 
 *     this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE 
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @author     Arnaud Limbourg <arnaud@limbourg.com>
 * @copyright  2005 Packt Publishing
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    @version_number@
 * @link       http://www.limbourg.com/arnaud/pear_book
 */

/**
 * Require needed files to run the application
 */
require_once 'LiveUser/Admin.php';
require_once 'liveuser_config.php';

responseHeader();

$lua = LiveUser_Admin::factory($liveuserConfig);
if ($lua == false) {
    errHandler($lu->getErrors());
    responseFooter();
    exit();
}

// We use the index 0, the first container defined
// instead of an index in the configuration array
// you can use a string and pass it here
$set = $lua->setAdminContainers();
if ($set == false) {
    errHandler($lu->getErrors());
    responseFooter();
    exit();
}

$users = array();

// To define that array you must use the names liveuser expects
// the alias parameter in the configuration array will be used
// to build proper queries
$user_data = array(
    'name'      => 'John Doe',
    'is_active' => 'Y',
    'handle'    => 'johndoe',
    'passwd'    => 'johndoe',
);

if (count($lua->auth->getUsers(array('filters' => array('handle' => $user_data['handle'])))) == 0 ) {
    $perm_user_id = $lua->addUser($user_data);
    if (count($lua->getErrors()) > 0 ) {
        errHandler($lu->getErrors());
        responseFooter();
        exit();
    }

    echo "The user was added successfully with perm user id $perm_user_id\n";
    $users[] = $perm_user_id;
} else {
    echo "The user already exists in the database\n";
}

// add another user
$user_data = array(
    'name'      => 'Jane',
    'is_active' => 'Y',
    'handle'    => 'jane',
    'passwd'    => 'jane',
);

if (count($lua->auth->getUsers(array('filters' => array('handle' => $user_data['handle'])))) == 0 ) {
    $perm_user_id = $lua->addUser($user_data);
    if (count($lua->getErrors()) > 0 ) {
        errHandler($lu->getErrors());
        responseFooter();
        exit();
    }

    echo "The user was added successfully with perm user id $perm_user_id\n";
    $users[] = $perm_user_id;
} else {
    echo "The user already exists in the database\n";
}

// Add the right to the database
// check if the right is already there first
$right = array (
    'area_id'     => 1,
    'right_define_name' => 'ADD_MOVIE'
);

if (count($lua->perm->getRights(array('filters' => $right))) == 0) {
    echo "adding right\n";
    $right_id = $lua->addRight($right);
    if (count($lua->getErrors()) > 0 ) {
        errHandler($lu->getErrors());
        responseFooter();
        exit();
    }

    echo "right added with id $right_id\n";
    $grant_right = array(
        'perm_user_id' => $users[0],
        'right_id'     => $right_id
    );
    // Grant johndoe the right to add movies
    $lua->perm->grantUserRight($grant_right);
} else {
    echo "The right already exists in the database\n";
}

// Add the right to the database
// check if the right is already there first
$right = array (
    'area_id'     => 1,
    'right_define_name' => 'SCHEDULE_MOVIE'
);

if (count($lua->perm->getRights(array('filters' => $right))) == 0) {
    echo "adding right\n";
    $right_id = $lua->addRight($right);
    if (count($lua->getErrors()) > 0 ) {
        errHandler($lu->getErrors());
        responseFooter();
        exit();
    }

    echo "right added with id $right_id\n";
    $grant_right = array(
        'perm_user_id' => $perm_user_id,
        'right_id'     => $right_id
    );
    // Grant Jane the right to schedule movies
    $lua->perm->grantUserRight($grant_right);
} else {
    echo "The right already exists in the database\n";
}

// Generate the rights constants file
// and add a require statement in the config file
$lua->perm->outputRightsConstants('php', array('filename' => 'rights.php'), 'file');

responseFooter();
?>
