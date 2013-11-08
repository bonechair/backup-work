<?PHP
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

session_start(); ob_start();
include("connect.php");
// If no first_name session variable exists, redirect the user:
if (!isset($_SESSION['userName'])) {
	$url = BASE_URL . 'index.php'; // Define the URL.
	ob_end_clean(); // Delete the buffer.
	header( 'Location: index.php' );
	exit(); // Quit the script.
} else { // Log out the user.
mysql_query("update members SET logged_in='no' where username='".$_SESSION['userName']."'");
$_SESSION = array(); // Destroy the variables.
	session_destroy(); // Destroy the session itself.
    setcookie("username", $myusername, time()-60*60*24*100);
    setcookie("code", $encrypted_password, time()-60*60*24*100);
    setcookie("userid", $user_id, time()-60*60*24*100);


    //setcookie("id", "", time()-60*60*24*100);// Destroy the cookies.
} header( 'Location: index.php' ) ;
ob_flush();
?>