<?php
/**
 * Schedule a movie at a given cinema.
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
require_once 'LiveUser.php';
require_once 'liveuser_config.php';
require_once 'rights.php';


// Start authentication and handle errors
$lu = startAuth($lu, $log_user_out);

responseHeader();
// Check if the user can schedule movies
// i.e.: does he have the SCHEDULE_MOVIE right
if (!$lu->checkRight(SCHEDULE_MOVIE)) {
    echo '<div id="pageErrors">You are not allowed';
    echo ' to schedule movies</div>';
    responseFooter();
    exit();
}

// Process the form and add the movie to the database
if (array_key_exists('posted', $_POST) && htmlspecialchars($_POST['posted']) == 1) {
    MDB2::loadFile('Date');

    $movie_date = MDB2_Date::date2Mdbstamp(
        htmlspecialchars($_POST['schedule_hour']),
        htmlspecialchars($_POST['schedule_minute']),
        0,
        htmlspecialchars($_POST['schedule_month']),
        htmlspecialchars($_POST['schedule_day']),
        htmlspecialchars($_POST['schedule_year'])
    );

    $query  = 'INSERT INTO movie_schedule (movie_id, cinema, scheduled_time)';
    $query .= ' VALUES (' . 
        $dbh->quote(htmlspecialchars($_POST['movie']), 'integer') . ',';
    $query .= $dbh->quote(htmlspecialchars($_POST['cinema']), 'text') . ',';
    $query .= $dbh->quote($movie_date, 'date') . ')';

    $res = $dbh->query($query);

    echo '<p>The movie was successfully scheduled</p>';
    responseFooter();
    exit();
}
?>
<form method="post" id ="schedulemovie" action="schedule_movie.php">
<input type="hidden" name="posted" value="1" />
<fieldset>
    <legend>Movie scheduling</legend>
    <table>
    <tr>
        <td><label for="movie">Movie</label></td>
        <td colspan="4">
        <select name="movie">
        <option>Choose a movie</option>
        <?php
        $query = "SELECT id, name FROM movie ORDER BY name";
        $res = $dbh->query($query);
        while ($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
            echo '<option value="' . htmlspecialchars($row['id']) . '">';
            echo htmlspecialchars($row['name']) . "</option>\n";
        }
        ?>
        </select>
        </td>
    </tr>

    <tr>
        <td><label for="cinema">Cinema</label></td>
        <td colspan="4">
            <select name="cinema">
            <option>Choose a cinema</option>
            <option value="paris">Paris</option>
            <option value="london">London</option>
            <option value="NYC">New York</option>
            </select>
        </td>
    </tr>

    <tr>
        <td><label for="schedule_year">Schedule year</label></td>
        <td>
        <select name="schedule_year">
            <option value="2005" selected="selected">2005</option>
            <option value="2006">2006</option>
        </select>
        </td>
        <td><label for="schedule_month">Schedule month</label></td>
        <td>
        <select name="schedule_month">
            <option value="01" selected="selected">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        </td>
        <td><label for="schedule_day">Schedule day</label></td>
        <td>
        <select name="schedule_day">
            <option value="01" selected="selected">01</option>
            <option value="02">02</option>
            <option value="03">03</option>
            <option value="04">04</option>
            <option value="05">05</option>
            <option value="06">06</option>
            <option value="07">07</option>
            <option value="08">08</option>
            <option value="09">09</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
            <option value="23">23</option>
            <option value="24">24</option>
            <option value="25">25</option>
            <option value="26">26</option>
            <option value="27">27</option>
            <option value="28">28</option>
            <option value="29">29</option>
            <option value="30">30</option>
            <option value="31">31</option>
        </select>
        </td>
        <td><label for="schedule_hour">Schedule hour</label></td>
        <td>
        <select name="schedule_hour">
            <option value="13" selected="selected">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
            <option value="16">16</option>
            <option value="17">17</option>
            <option value="18">18</option>
            <option value="19">19</option>
            <option value="20">20</option>
            <option value="21">21</option>
            <option value="22">22</option>
        </select>
        </td>
        <td><label for="schedule_minute">Schedule minute</label></td>
        <td>
        <select name="schedule_minute">
            <option value="OO" selected="selected">00</option>
            <option value="15">15</option>
            <option value="30">30</option>
            <option value="45">45</option>
        </select>
        </td>
    </tr>
    </table>
</fieldset>

<p>
    <input type="submit" value="Schedule the movie" />
</p>
</form>
<?php
responseFooter();
?>