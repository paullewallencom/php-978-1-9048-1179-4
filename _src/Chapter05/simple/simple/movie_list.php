<?php
/**
 * Display a list of movies, cinema and schedule time
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
 *  Require needed files
 */
require_once 'liveuser_config.php';

/**
 * begin output the page
 */
responseHeader();

echo "<h1>Movie management application</h1>\n";

echo '<h2>Movies list</h2>';

$query = '
    SELECT name, cinema, scheduled_time FROM
    movie_schedule INNER JOIN movie m ON movie_id=m.id
    ORDER BY cinema, name';

$res = $dbh->query($query);

MDB2::loadFile('Date');

echo '<table>';
echo '<tr><th>Cinema</th><th>Movie</th><th>Plays on</th></tr>';
while ($row = $res->fetchRow(MDB2_FETCHMODE_ASSOC)) {
    echo '<tr><td>' . ucfirst(htmlspecialchars($row['cinema']));
    echo '</td><td>' . htmlspecialchars($row['name']) . '</td><td>';
    $date = MDB2_Date::mdbstamp2Unix(htmlspecialchars($row['scheduled_time']));
    echo date('l jS M Y \a\t H:i', $date);
    echo '</td></tr>';
}
echo '</table>';

responseFooter();
?>
