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
if(!empty($_SESSION['user_name'])) {
include("header.php"); ?>

<div class="grid_16" id="content">
    <!--  TITLE START  -->
    <div class="grid_9">
    <h1 class="dashboard">Edit help page</h1>
    </div>
    <div class="clear">
    </div>
    <!--  TITLE END  -->
    <!-- #PORTLETS START -->
    <div id="portlets">
<?PHP
$help = mysql_real_escape_string($_POST['help']);
$help = nl2br($help);
if (isset($_POST["submit"])){
mysql_query("update help set `help` = '".$help."' ") or die(mysql_error());
if(!mysql_query){
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Help page could not be edited</span></p>";
}else{
echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Help page edited successfully!</span></p>";
}
}

$query  = "select * from help";
$result = mysql_query($query,$db) or die("Error: " . mysql_error());
$myrow = mysql_fetch_array($result);
$result = mysql_query("SELECT * from help");
while($myrow = mysql_fetch_array($result)){
print "<form action=\"\" method=\"POST\"> ";
print "<textarea id=\"\" class=\"smallInput wide\" rows=\"17\" cols=\"30\"  name=\"help\">".$help = stripslashes($myrow['help'])."</textarea>";
print "<input type=\"submit\" name=\"submit\" value=\"Submit\" />";
}?>
</div>
</div><!--| end container |-->
<?} else{header( 'Location: index.php' ) ;}
 include("footer.php"); ob_flush(); ?>