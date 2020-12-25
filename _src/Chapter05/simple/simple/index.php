<?php
// +----------------------------------------------------------------------+
// | PHP versions 4 and 5                                                 |
// +----------------------------------------------------------------------+
// | Copyright (c) 1998-2004 Manuel Lemos, Tomas V.V.Cox,                 |
// | Stig. S. Bakken, Lukas Smith                                         |
// | All rights reserved.                                                 |
// +----------------------------------------------------------------------+
// | MDB2 is a merge of PEAR DB and Metabases that provides a unified DB  |
// | API as well as database abstraction for PHP applications.            |
// | This LICENSE is in the BSD license style.                            |
// |                                                                      |
// | Redistribution and use in source and binary forms, with or without   |
// | modification, are permitted provided that the following conditions   |
// | are met:                                                             |
// |                                                                      |
// | Redistributions of source code must retain the above copyright       |
// | notice, this list of conditions and the following disclaimer.        |
// |                                                                      |
// | Redistributions in binary form must reproduce the above copyright    |
// | notice, this list of conditions and the following disclaimer in the  |
// | documentation and/or other materials provided with the distribution. |
// |                                                                      |
// | Neither the name of Manuel Lemos, Tomas V.V.Cox, Stig. S. Bakken,    |
// | Lukas Smith nor the names of his contributors may be used to endorse |
// | or promote products derived from this software without specific prior|
// | written permission.                                                  |
// |                                                                      |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS  |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT    |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS    |
// | FOR A PARTICULAR PURPOSE ARE DISCLAIMED.  IN NO EVENT SHALL THE      |
// | REGENTS OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,          |
// | INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, |
// | BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS|
// |  OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED  |
// | AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT          |
// | LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY|
// | WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE          |
// | POSSIBILITY OF SUCH DAMAGE.                                          |
// +----------------------------------------------------------------------+
// | Author: Lukas Smith <smith@pooteeweet.org>                           |
// +----------------------------------------------------------------------+
//
// $Id: example.php,v 1.11 2005/11/20 17:07:13 arnaud Exp $
//

/**
 * MDB2 reverse engineering of xml schemas script.
 *
 * @package MDB2
 * @category Database
 * @author  Lukas Smith <smith@pooteeweet.org>
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
      <html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
      <head><title>LiveUser: simple complexity layer</title></head>
<body>

<h3>This is the example demonstrating how to use the simple complexity layer of LiveUser</h3>

<ul>
    <li>Create an empty database</li>
    <li>Fill-in the form at the bottom of this page</li>
    <li>Edit liveuser_config.php and modify the dsn with your database parameters</li>
    <li>Click <a href="movie_list.php" title="see the movies list">here</a> to play with the example
    (username johndoe or jane, password is the same as the username)</li>
</ul>

<?php
@include_once 'Var_Dump.php';
if (class_exists('Var_Dump')) {
    $var_dump = array('Var_Dump', 'display');
} else {
    $var_dump = 'var_dump';
}

$databases = array(
    'mysql'  => 'MySQL',
    'mysqli' => 'MySQLi',
    'pgsql'  => 'PostGreSQL',
    'sqlite' => 'SQLite',
);

if (isset($_GET['submit']) && $_GET['file'] != '') {
    require_once 'MDB2/Schema.php';
    $dsn = $_GET['type'].'://'.$_GET['user'].':'.$_GET['pass'].'@'.$_GET['host'].'/'.$_GET['name'];

    $schema =& MDB2_Schema::factory($dsn, array('debug' => true, 'log_line_break' => '<br>'));
    if (PEAR::isError($schema)) {
        $error = $schema->getMessage() . ' ' . $schema->getUserInfo();
    } else {
        if (array_key_exists('action', $_GET)) {
            set_time_limit(0);
        }
        if (array_key_exists('action', $_GET) && $_GET['action'] == 'create') {
            $operation = $schema->updateDatabase($_GET['file'], 'old_'.$_GET['file']);
            if (PEAR::isError($operation)) {
                echo $operation->getMessage() . ' ' . $operation->getUserInfo();
                call_user_func($var_dump, $operation);
            } else {
                call_user_func($var_dump, $operation);
            }
        } else {
            $error = 'no action selected';
        }
        $warnings = $schema->getWarnings();
        if (count($warnings) > 0) {
            echo('Warnings<br>');
            call_user_func($var_dump, $operation);
        }
        if ($schema->db->getOption('debug')) {
            echo('Debug messages<br>');
            echo($schema->db->debugOutput().'<br>');
        }
        echo('Database structure<br>');
        call_user_func($var_dump, $operation);
        $schema->disconnect();
    }
}

if (!isset($_GET['submit']) || isset($error)) {
    if (isset($error) && $error) {
        echo '<div id="errors"><ul>';
        echo '<li>' . $error . '</li>';
        echo '</ul></div>';
    }
?>
    <form action="<?php echo strip_tags($_SERVER['PHP_SELF']); ?>" method="get">
    <fieldset>
    <legend>Database information</legend>

    <table>
    <tr>
    <td><label for="type">Database Type:</label></td>
        <td>
        <select name="type" id="type">
        <?php
            foreach ($databases as $key => $name) {
                echo '<option value="' . $key . '"';
                if (isset($_GET['type']) && $_GET['type'] == $key) {
                    echo ' selected="selected"';
                }
                echo '>' . $name . '</option>' . "\n";
            }
            ?>
        </select>
        </td>
    </tr>
    <tr>
        <td><label for="user">Username:</label></td>
        <td><input type="text" name="user" id="user" value="<?php echo (isset($_GET['user']) ? $_GET['user'] : '') ?>" /></td>
    </tr>
    <tr>
        <td><label for="pass">Password:</label></td>
        <td><input type="text" name="pass" id="pass" value="<?php echo (isset($_GET['pass']) ? $_GET['pass'] : '') ?>" /></td>
    </tr>
    <tr>
        <td><label for="host">Host:</label></td>
        <td><input type="text" name="host" id="host" value="<?php echo (isset($_GET['host']) ? $_GET['host'] : '') ?>" /></td>
    </tr>
    <tr>
        <td><label for="name">Databasename:</label></td>
        <td><input type="text" name="name" id="name" value="<?php echo (isset($_GET['name']) ? $_GET['name'] : '') ?>" /></td>
    </tr>
    <tr>
        <td><label for="file">Filename:</label></td>
        <td><input type="text" name="file" id="file" value="<?php echo (isset($_GET['file']) ? $_GET['file'] : 'dump.xml') ?>" /></td>
    </tr>
    <tr>
        <td><label for="create">Create:</label></td>
        <td><input type="radio" name="action" id="create" value="create" checked="checked" /></td>
    </tr>
    </table>
    <p><input type="submit" name="submit" value="Populate database" /></p>
    </fieldset>
<?php } ?>
</form>
</body>
</html>
