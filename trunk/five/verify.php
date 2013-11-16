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

include "header.php";
$name = strtolower($us);
$namecheck = mysql_query("SELECT * FROM `members` WHERE username = '$name'") or die (mysql_error());
$r = mysql_num_rows($namecheck);
$us = $_SESSION['username-reg'];
$pr = $_SESSION['password-reg'];
$prv = $_SESSION['passwordv-reg'];
$em = $_SESSION['email-reg'];
$st = $_SESSION['status'];
$ip = $_SERVER['REMOTE_ADDR'];
$fullhost = gethostbyaddr($ip);
$host = preg_replace("/^[^.]+./", "", $fullhost);
$isp = $host;
$result = mysql_query("SELECT * FROM sitesettings");
while($myrow = mysql_fetch_array($result))
{
$domain =  mysql_real_escape_string($myrow["domain"]);
$site_url =  mysql_real_escape_string($myrow["site_url"]);
if($_SESSION['status'] = $st){
$activationKey =  mt_rand() . mt_rand() . mt_rand() . mt_rand() . mt_rand();
$username = mysql_real_escape_string($us);
$password = md5(mysql_real_escape_string($pr));
$joined = date("F j, Y");
$email = mysql_real_escape_string($em);
$sql="INSERT INTO members (username, password, email, joined, isp, ip, activationkey, status) VALUES ('$username', '$password', '$email', '$joined', '$isp', '$ip', '$activationKey', 'activated')";
if (!mysql_query($sql))
  {
  die('Error: ' . mysql_error());
  }
//echo "<div class=\"dialog-box-success1\">
//<div class=\"dialog-left\">
//<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>Please check your spam folder. ".$lang["SIGN_UP_EMAIL_SENT"]." ".$em." ".$lang["ACT_KEY"].".</div>
//</div>";
echo "<div class=\"dialog-box-success1\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>Thank you for signing up, you can login now.</div>
</div>";
$to      = $em;
$subject = " ".$domain." ".$lang["SU_SUBJECT"]."";
$message = "".$lang["SIGN_UP_EMAIL1"]." ".$site_url.". ".$lang["SIGN_UP_EMAIL2"]." ".$site_url."/verify.php?$activationKey\r\r"."".$lang["SIGN_UP_EMAIL3"]." ".$site_url." Team";
$headers = 'From: support@triplegood.co.za' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
session_destroy();
}else{
$queryString = $_SERVER['QUERY_STRING'];
$query = "SELECT * FROM members";
$result = mysql_query($query) or die(mysql_error());
  while($row = mysql_fetch_array($result)){
    if ($queryString == $row["activationkey"]){
        if($row['activationkey'] != ''){
        ?>
       <h2> <? echo "".$lang['CONGRATS']." " . " " . ucfirst(strtolower($row["username"]));?>,</h2>
       <h2><?PHP echo $lang['ACC_ACTIVATED']?></h2>
       <br/>
       <h3><?PHP echo $lang['NOW_LOGIN']?></h3>
       <?
       $sql="UPDATE members SET activationkey = '', status='activated' WHERE (id = $row[id])";
       $urlf = 'users/' . strtolower($row['username']);
       $indexfi = 'users/index.php';
       $avatar = 'users/default.png';
       mkdir($urlf,0777);
       chmod($urlf,0777);
       copy("users/admin/index.php",$urlf."/index.php");
       copy($avatar,$urlf."/default.png");
       chmod($urlf,0755);
       if (!mysql_query($sql))
{
       die('Error: ' . mysql_error());
}
}
else
{
echo "<META HTTP-EQUIV = 'Refresh' Content = '3; URL =index.php'>";
}
}
}
}
ob_flush();
?>
</div>
<?PHP include("side.php");
include("footer.php");
}
?>