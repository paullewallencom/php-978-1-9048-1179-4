<?php
/**
 * Add a movie to the database.
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
require_once 'liveuser_config.php';
require_once 'rights.php';

// Start authentication and handle errors
$lu = startAuth($lu, $log_user_out);

responseHeader();

// Check if the user can add the movie to the queue
// i.e.: does he have the ADD_MOVIE right
if (!$lu->checkRight(ADD_MOVIE)) {
    echo '<div id="pageErrors">You are not allowed';
    echo ' to add movies to the queue</div>';
    responseFooter();
    exit();
}

// The user is allowed to add a movie
// so we show him the form to do that or process the form

// Process the form and add the movie to the database
if (array_key_exists('posted', $_POST) && htmlspecialchars($_POST['posted']) == 1) {
    $movie_name = htmlspecialchars($_POST['movie_name']);

    $res = $dbh->query('INSERT INTO movie (id, name) VALUES ('
        . $dbh->nextID('movie') . ', '
        . $dbh->quote($movie_name, 'text') . ')');

    echo "<p>The movie '$movie_name' was successfully added to the database!</p>";
    responseFooter();
    exit();
}

?>
<form method="post" id ="addmovie" action="add_movie.php">
<input type="hidden" name="posted" value="1" />
<fieldset>
    <legend>Movie information</legend>
    <table>
    <tr>
        <td><label for="movie_name">Movie title</label></td>
        <td><input type="text" name="movie_name" id="movie_name" size="20" maxlength="30" /></td>
    </tr>

    <tr>
        <td><label for="cinemas">Cinema</label></td>
        <td>
            <select name="cinemas" id="cinemas">
            <option>Choose a cinema</option>
            <option value="paris">Paris</option>
            <option value="london">London</option>
            <option value="NYC">New York</option>
            </select>
        </td>
    </tr>
    </table>
</fieldset>

<p>
    <input type="submit" value="Add movie to the queue" />
</p>
</form>
<?php
responseFooter();
?>
