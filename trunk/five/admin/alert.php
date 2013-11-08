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
    <h1 class="dashboard">Edit Notification Box</h1>
    </div>
    <div class="clear"></div>
    <div class="lang">
    <h3>This is where you edit and activate/de-activate the notification box, use this to make important announcements etc.</h3></div>
    <div class="clear">
    </div>
    <div id="portlets">
<?PHP
$date = date("j, n, Y");
$text = mysql_real_escape_string($_POST['text']);
$show_alert = mysql_real_escape_string($_POST['show_alert']);
$text = nl2br($text);
if (isset($_POST["submit"])){
mysql_query("update alert set `text` = '".$text."'") or die(mysql_error());
mysql_query("update alert set `show_alert` = '".$show_alert."' ") or die(mysql_error());
mysql_query("update alert set `date_set` = '".$date."' ") or die(mysql_error());
if(!mysql_query){
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Alert box could not be edited</span></p>";
}else{
echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Alert box edited successfully!</span></p>";
}
}
$query = mysql_query("select * from alert ");
while ($row = mysql_fetch_array($query)){
$text = stripslashes($row['text']);
$show_alert = $row['show_alert'];
$date_set = $row['date_set'];
}
print "<form action=\"\" method=\"POST\"> ";?>
<label>Show Message alert:(If you have something to notify your site visitors about)</label>
<p><input name="show_alert" type="radio" value="yes" <?php if($show_alert == 'yes') {?>checked="checked"<? }?> /> Yes
<input name="show_alert" type="radio" value="no" <?php if($show_alert == 'no') {?>checked="checked"<? }?> /> No&nbsp;&nbsp;&nbsp;&nbsp;
<?PHP if($show_alert == 'yes'){echo "<b><font color=\"#339966\">Alert is activated</font></b>";}
else{echo "<b><font color=\"#FF0000\">Alert is NOT active</font></b>";} echo "&nbsp;&nbsp;&nbsp;&nbsp;Date Set: ".$date_set."</p>";
print "<textarea id=\"\" class=\"smallInput wide\" rows=\"8\" cols=\"20\" name=\"text\">".$text."</textarea>";
print "<input type=\"submit\" name=\"submit\" value=\"Submit\" />";
?>
</div>
</div>
<?PHP } else{
  header( 'Location: index.php' ) ;}
 include("footer.php");
ob_flush();
?>