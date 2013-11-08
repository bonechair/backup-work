<?PHP  session_start(); ob_start();
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

include("header.php");

if (isset($_GET["act"])) {
        $act = $_GET["act"];
if ($act == "jobs") {
$ip = $_SERVER['REMOTE_ADDR'];
// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$remember = stripslashes($remember);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$encrypted_mypassword=md5($mypassword);
$refer=$_POST['refer'];
$sql="SELECT * FROM members WHERE username='$myusername'and password='$encrypted_mypassword'";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$counts=mysql_fetch_array($result);
if($count==1){
if($counts['status'] == "verify"){
header( 'Location: index.php' );
}elseif($counts['status'] == "activated"){
if(isset($_POST['remember'])){

setcookie("ip", md5($ip), time()+60*60*24*100);
mysql_query("update members SET logged_in='yes' where username='".$myusername."'");
}else {

setcookie("ip", md5($ip));

}  session_start();

if(!isset($_SESSION['userName'])){
$username = $myusername;
$_SESSION['userName'] = $username;
}
header( 'Location: '.$refer.'' ); 
}
}else {
echo "<div class=\"clear2\"></div><div class=\"dialog-box-error2\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['LOGIN_FAILED'].".</div>
</div>";
}
echo"</div>";
include("side.php");
include("footer.php");
}
}
else{

$ip = $_SERVER['REMOTE_ADDR'];
// username and password sent from form
$myusername=$_POST['myusername'];
$mypassword=$_POST['mypassword'];
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$remember = stripslashes($remember);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$encrypted_mypassword=md5($mypassword);
$refer=$_POST['refer'];
$sql="SELECT * FROM members WHERE username='$myusername'and password='$encrypted_mypassword'";
$result=mysql_query($sql);
$count=mysql_num_rows($result);
$counts=mysql_fetch_array($result);
if($count==1){
if($counts['status'] == "verify"){
header( 'Location: index.php' );
}elseif($counts['status'] == "activated"){
if(isset($_POST['remember'])){

setcookie("ip", md5($ip), time()+60*60*24*100);
mysql_query("update members SET logged_in='yes' where username='".$myusername."'");
}else {

setcookie("ip", md5($ip));

}  session_start();
header( 'Location: index.php' );
if(!isset($_SESSION['userName'])){
$username = $myusername;
$_SESSION['userName'] = $username;
}
}
}else {
echo "<div class=\"clear2\"></div><div class=\"dialog-box-error2\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['LOGIN_FAILED'].".</div>
</div>";
}
echo"</div>";
include("side.php");
include("footer.php");
ob_flush();
}
?>