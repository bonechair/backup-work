<?PHP session_start();
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

 ob_start();    include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$domain = $row["domain"];
$siteurl = $row["site_url"];
}
$title = "".$domain." -Forgot password";
$name = strtolower($us);
$namecheck = mysql_query("SELECT * FROM `members` WHERE username = '$name'") or die (mysql_error());
$r = mysql_num_rows($namecheck);
$us = $_SESSION['username-reg'];
$pr = $_SESSION['password-reg'];
$prv = $_SESSION['passwordv-reg'];
$em = $_SESSION['email-reg'];
$st = $_SESSION['status'];
$emails = $_SESSION['forgotpassword'];
include("header.php");
if(isset($_SESSION['forgotpassword'])){
$passKey =  mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();
$email = mysql_real_escape_string($emails);
mysql_query("");
$sql="UPDATE members SET passkey = '$passKey' WHERE (email = '$emails')";
if (!mysql_query($sql))
{
die('Error: ' . mysql_error());
}
echo '<div class="dialog-box-success1">
<div class="dialog-left">
<img src="images/succes.png" class="dialog-ico" alt=""/>'.$lang['EMAIL_SENT_TO'].' '.$emails.' '.$lang['RESET_LINK'].'
</div></div>';
##Send activation Email
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$to      = $emails;
$subject = " ".$domain." ".$lang["FP_SUBJECT"]."";
$message = "".$lang["FORGOT_PASS1"]." ".$domain.". ".$lang["FORGOT_PASS2"]." ".$siteurl."/fp_process.php?$passKey ".$lang["FORGOT_PASS3"]."";
$headers = 'From: noreply@'.$domain.'' . "\r\n" .

    'Reply-To: noreply@'.$domain.'' . "\r\n" .

    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers);
session_destroy();
}
}else{
##User isn't registering, check verify code and change activation code to null, status to activated on success

$queryString = $_SERVER['QUERY_STRING'];

$query = "SELECT * FROM members";

$result = mysql_query($query) or die(mysql_error());
$newpass = md5(mysql_real_escape_string($_POST['newpass']));

  while($row = mysql_fetch_array($result)){
  if ($queryString == $row["passkey"]){
  if($row['passkey'] != ''){
  if($_POST['newpassword']){
    if(empty($_POST['newpass']) || $_POST['vernewpass'] != $_POST['newpass']){
    session_start();
    $_SESSION['id'] = "no";
    }else{
    session_start();
        $_SESSION['id'] = "yes";
    }
}
session_start();
if($_SESSION['id'] == "no" or $_SESSION['id'] == ""){
?>
<div class="feedback">
<form id="form2" name="form2" method="post" action="">
             <span class="pfp"><?PHP echo $lang['ENTER_NEW']?>:<br />
             <?
             if(isset($_POST['newpassword'])){
             if(empty($_POST['newpass'])){
             ?>
             <span style="color:#ff0000;"><?PHP echo $lang['ENTER_A_PASS']?></span>
             <?
             }
             }
             ?>
             </span>
             <input type="text" name="newpass" class="textfield" value="<? echo $_POST['newpass']; ?>" />
              <div class="clear"></div>
             <span class="pfp"><?PHP echo $lang['VERIFY_PASS']?>:<br />
             <?
             if(isset($_POST['newpassword'])){
             if($_POST['vernewpass'] != $_POST['newpass']){
             ?>
             <span style="color:#ff0000;"><?PHP echo $lang['DONT_MATCH']?></span>
             <?
             }
             }
             ?>
             </span>
             <input type="text" name="vernewpass" class="textfield" value="<? echo $_POST['vernewpassword']; ?>" />
             <div class="cleared1"></div>
             <input type="submit" name="newpassword" class="Button" value="Submit Now"/>
</form></div>
<?PHP
  }
  }else{
      header( 'Location: index.php' ) ;
  }
  }
if ($queryString == $row["passkey"]){
if(isset($_POST['newpassword'])){
if(empty($_POST['newpass']) || $_POST['vernewpass'] != $_POST['newpass']){
}else{
        if($row['passkey'] != ''){

        echo '<div class="dialog-box-success">
<div class="dialog-left">
<img src="images/succes.png" class="dialog-ico" alt=""/>Congratulations! '.$row["username"].' '.$lang['NEW_PASS_SET'].'
</div></div>';
$sql="UPDATE members SET passkey = '', password='$newpass' WHERE (id = $row[id])";
       header('Refresh: 3; url=index.php');
       if (!mysql_query($sql))
  {
        die('Error: ' . mysql_error());

  }

    }else{
        header( 'Location: index.php' ) ;
}
}
}
}
}
}
echo '</div>';
include("side.php");
include("footer.php");
ob_flush();
?>