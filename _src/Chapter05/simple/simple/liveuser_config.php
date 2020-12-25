<?php
/**
 * Configuration to run the application using 'simple' complexity
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
 * Require generic files
 */
require_once 'LiveUser.php';
require_once 'Log.php';
require_once 'MDB2.php';
require_once 'functions.lib.php';

PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handlePEARError');

// Configure the DSN according to your host
$dsn = 'mysqli://root:@localhost/movies';

/**
 * Create a custom logger to save all errors to a text file
 */
$conf = array('mode' => 0600, 'timeFormat' => '%X %x');
$logger = Log::singleton('file', 'out.log', 'ident', $conf);
$dbh = MDB2::connect($dsn);

/**
 * Configuration array
    'session_cookie_params' => array(
        'lifetime' => 86400,
        'path'     => '/',
        'domain'   => 'localhost',
        'secure'   => 0
    ),
 */
$liveuserConfig = array(
    'debug' => $logger,
    'session' => array(
        'name'        => 'movies',
        'varname'     => 'custom',
        'force_start' => true,
    ),
    'logout' => array(
        'destroy'  => true
    ),
    'authContainers' => array(
        0 => array(
            'loginTimeout' => 0,
            'expireTime'   => 3600,
            'idleTime'     => 1800,
            'allowDuplicateHandles'  => false,
            'passwordEncryptionMode' => 'MD5',
            'allowEmptyPasswords' => false,
            'type' => 'MDB2',
            'storage' => array(
                'connection' => $dbh,
                'alias' => array(
                    'users'        => 'people',
                    'auth_user_id' => 'authuserid',
                    'passwd'       => 'passwd',
                    'lastlogin'    => 'lastLogin',
                    'is_active'    => 'isactive',
                    'owner_user_id' => 'owner_user_id',
                    'owner_group_id' => 'owner_group_id',
                    'name'           => 'name',
                ),
                'fields' => array(
                    'lastlogin'      => 'timestamp',
                    'name'           => 'text',
                    'is_active'      => 'boolean',
                    'owner_user_id'  => 'integer',
                    'owner_group_id' => 'integer',
                ),
                'tables' => array(
                    'users' => array(
                        'fields' => array(
                            'lastlogin'      => false,
                            'is_active'      => true,
                            'owner_user_id'  => false,
                            'owner_group_id' => false,
                            'handle'         => 'unique',
                            'passwd'         => 'true',
                        )
                    )
                )
            )
        )
    ),
    'permContainer' => array(
        'type' => 'Simple',
        'storage' => array(
            'MDB2' => array(
                'connection' => $dbh,
                'prefix' => 'liveuser_',
                'alias' => array(
                    'perm_users' => 'perm_people'
                )
            )
        )
    )
);
 
 // Create a liveuser object to use in the example application
$lu = LiveUser::factory($liveuserConfig);

$log_user_out = false;

if (array_key_exists('logout', $_GET) && htmlspecialchars($_GET['logout']) == 1) {
    $log_user_out = true;
}

if (array_key_exists('login', $_GET) && htmlspecialchars($_GET['login']) == 1) {
    // show the login form
    $calling_page = htmlspecialchars(end(explode('/', $_SERVER['SCRIPT_NAME'])));
    responseHeader();
    include './login_form.html';
    responseFooter();
    exit();
}
?>
