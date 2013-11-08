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

session_start();     include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." -Forgot Password";
$template = $row["template"];
}
$name = mysql_real_escape_string(strtolower($us));
$emailc = mysql_real_escape_string(strtolower($_POST['emailc']));
$namecheck = mysql_query("SELECT * FROM `members` WHERE username = '$name'") or die (mysql_error());
$emailcheck = mysql_query("SELECT * FROM `members` WHERE email = '$emailc'") or die (mysql_error());
$r = mysql_num_rows($namecheck);
$e = mysql_num_rows($emailcheck);
$us = $_SESSION['username-reg'];
$pr = $_SESSION['password-reg'];
$prv = $_SESSION['passwordv-reg'];
$em = $_SESSION['email-reg'];
$st = $_SESSION['status'];
$emails = mysql_real_escape_string(strtolower($_POST['emails']));
include("header.php");
?>
<div class="feedback">
<p><?PHP echo $lang['PASS_RESET']?>.</p>
             <form id="form2" name="form2" method="post" action="" style="float:none;clear:left;margin-left:auto;margin-right:auto;width:545px;">

             <?PHP
             ob_start();
             if(isset($_POST['forgotpassword'])){
             if($e > 0){
             echo"<META HTTP-EQUIV = 'Refresh' Content = '0; URL =fp_process.php'>";
             session_start();
             $_SESSION['forgotpassword'] = $emailc;
             }else{
             ?>
             <p><font color="#FF0000"><?PHP echo $lang['EMAIL_NOT_FOUND']?></font></p>
             <?PHP
             }
             }
             ob_flush();
             ?>
             <input type="text" name="emailc" class="textfield" /> <input type="submit" name="forgotpassword" class="Button" value="<?PHP echo $lang['SEND_NOW']?>"/>
             </form>
</div></div>
<?PHP
include("side.php");
include("footer.php");
?>