<?php
/**
 * Functions used throughout the application
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
 * Displays errors returned by Error_Stack
 *
 * @param  array $errors  the errors returned by Error_Stack::getErrors()
 * @return void
 */
function errHandler($errors)
{
    foreach($errors as $index => $error) {
        echo '<ul>';
        echo "<li>Message for error $index: " . $error['message'];
        echo '<br />Debug info <pre>';
        print_r($error['params']);
        echo '</pre></li>';
        echo '</ul>';
    }
}

/**
 * Outputs the beginning of the HTML page
 *
 * @return void
 */
function responseHeader()
{
    readfile('header.html');
}

/**
 * Outputs the end of the HTML page
 *
 * @return void
 */
function responseFooter()
{
    echo '<ul><li><a href="?login=1" title="Login on this page">Login on this page</a></li>' . "\n";
    echo '<li><a href="?logout=1" title="Logout">Logout</a></li>' . "\n";
    echo '<li><a href="index.php" title="Index">Index</a></li>' . "\n";
    echo '<li><a href="add_movie.php" title="Add movie">Add movie</a></li>' . "\n";
    echo '<li><a href="schedule_movie.php" title="Schedule movie">Schedule movie</a></li>' . "\n";
    echo '</ul></body></html>';
}

function startAuth($lu, $log_user_out)
{
    // Start the authentication process
    // handle errors if any
    $handle = $passwd = '';
    if (array_key_exists('handle', $_POST) && array_key_exists('passwd', $_POST)) {
        $handle = htmlspecialchars($_POST['handle']);
        $passwd = htmlspecialchars($_POST['passwd']);
    }
    $init_status = $lu->init($handle, $passwd, $log_user_out);
    if ($init_status == false) {
        errHandler($lu->getErrors());
        responseFooter();
        exit();
    }

    // Did the authentication succeed?
    if ($lu->getStatus() != LIVEUSER_STATUS_OK) {
        echo 'There was something wrong: ' . $lu->statusMessage($lu->getStatus());
        responseFooter();
        exit;
    }
    return $lu;
}

function handlePEARError(&$err)
{
    echo "<div id=\"pageErrors\">An error occurred\n";
    echo $err->getMessage() . ' ' . $err->getUserInfo() . '</div>';
    responseFooter();
    die();
}
?>
