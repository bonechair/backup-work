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
 
session_start();
if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}
include("connect.php");

$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - Change Password";
}
include("header.php");
//code for changing password
$passchangemsg ='';
if (isset($_POST['changepass']))
{
	$cpass=md5($_POST['cpass']);
	$npass=trim($_POST['npass']);
	$npassc=trim($_POST['npassc']);
	$username=trim(strtolower($_POST['auser']));
	if($npass == $npassc && !empty($npass)){
		$query = "UPDATE members SET username='".$username."', password='".md5(strtolower($npass))."' where username='".$_SESSION['userName']."' and password='$cpass'";
		$result=mysql_query($query) or die("Could not Query");
		if(mysql_affected_rows() > 0){
			$_SESSION['username'] = $username;
			$passchangemsg = '<div class="dialog-box-success">
<div class="dialog-left">
<img src="images/succes.png" class="dialog-ico" alt=""/>'.$lang['PASS_CHANGED'].'.
</div></div>';
		}elseif (md5(strtolower($npass)) == $cpass){
			$passchangemsg = '<div class="dialog-box-error">
<div class="dialog-left">
<img src="images/error.png" class="dialog-ico" alt=""/>The new password is the same as the old password.</div></div>';
		}else{
			$passchangemsg ='<div class="dialog-box-error">
<div class="dialog-left">
<img src="images/error.png" class="dialog-ico" alt=""/>You have entered a wrong current password.</div></div>';
		}
	}else{
		$passchangemsg ='<div class="dialog-box-error">
<div class="dialog-left">
<img src="images/error.png" class="dialog-ico" alt=""/>Password and Confirm Password is not same or you entered a blank password.</div></div>';
	}
}
?>