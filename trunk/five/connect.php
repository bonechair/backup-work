<?PHP error_reporting(0);

/*
    
    PHPValley Micro Jobs Site Script
    Copyright (C) 2012  Ozgur Zeren (unity100@gmail.com)

    This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see http://www.gnu.org/licenses/gpl.html.
*/

$DB_HOST = "localhost";
$DB_USER  = "root";
$DB_PASSWORD = "dwwwe6e0";
$DB_NAME = "five";
$timeoutseconds = 1200; // length of session, 20 minutes is the standard
$timestamp=time();
$timeout=$timestamp-$timeoutseconds;

$connect = mysql_connect($DB_HOST,$DB_USER,$DB_PASSWORD);
mysql_select_db($DB_NAME) or die("MySQL error: Could not connect to database.\n".mysql_error());
$session = mysql_query("SELECT * FROM members WHERE id = '$_SESSION[id]' AND password = '$_SESSION[password]'");
$session = mysql_fetch_array($session);



parse_str("$QUERY_STRING");

$db = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWORD) or die("Could not connect.");
if(!$db)
	die("no db");
if(!mysql_select_db($DB_NAME,$db))
 	die("No database selected.");
	
// Include common functions
include_once('functions/general.php');


?>