<?PHP   session_start();
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

include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - Registration";
}
if ($_POST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["INV_SEC_CODE"]."</div></div>";
} else {
$usrv = 'Enter a username';
$usrt = 'Username already taken';
$usri = 'Invalid characters';
$passv = 'Enter a password';
$passn = 'Passwords dont match';
$emailv = 'Enter a valid email';
$emailt = 'Email already used';
$name = strtolower(mysql_real_escape_string($_POST['username-reg']));
$namecheck = mysql_query("SELECT * FROM `members` WHERE username = '$name'") or die (mysql_error());
$r = mysql_num_rows($namecheck);
$ename = strtolower(mysql_real_escape_string($_POST['email-reg']));
$namecheck = mysql_query("SELECT * FROM `members` WHERE email = '$ename'") or die (mysql_error());
$e = mysql_num_rows($namecheck);
function filename_safe($filename) {
$temp = $filename;
$temp = strtolower($temp);
$temp = str_replace(" ", "_", $temp);
$temp = str_replace("'", "", $temp);
$temp = str_replace("+", "_", $temp);
// Loop through string
$result = '';
for ($i=0; $i<strlen($temp); $i++) {
if (preg_match('([0-9]|[a-z]|_)', $temp[$i])) {
$result = $result . $temp[$i];
}
}
// Return filename
return $result;
}
                        ob_start();
                        $pattern = "/^([a-zA-Z0-9_])+$/";
                        $usrn = $_POST['username-reg'];
                        if(isset($_POST['register'])){
                            if(empty($_POST['username-reg']) || $r > 0 || $e > 0 || empty($_POST['password-reg']) || $_POST['passwordv-reg'] != $_POST['password-reg'] || $_POST['email-reg'] == "" || !preg_match($pattern,$usrn)){
                            }else{
                            $usname = strtolower($_POST['username-reg']);
                            $uspass = $_POST['password-reg'];
                            $uspassv = $_POST['passwordv-reg'];
                            $emai = strtolower($_POST['email-reg']);
                            $sr = "1";
                            $_SESSION['username-reg'] = $usname;
                            $_SESSION['password-reg'] = $uspass;
                            $_SESSION['passwordv-reg'] = $uspassv;
                            $_SESSION['email-reg'] = $emai;
                            $_SESSION['status'] = $sr;
                            echo "<META HTTP-EQUIV = 'Refresh' Content = '0; URL =verify.php'>";
                            }
                        }; ob_flush();

}
if(isset($_POST['register'])){
                              if(empty($_POST['username-reg'])){
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["NO_USERNAME"]."</div>
</div>";
}                             //if($valid == true) {
                              if(!empty($_POST['username-reg'])){
                              if(!preg_match($pattern, $usrn)){
                              echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["INV_CHARS"]."</div>
</div>";
}                              }
                              if($r > 0){
                              echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["USERNAME_USED"]."</div>
</div>";
                              }
                              //}
};

                          if(isset($_POST['register'])){
                              if(empty($_POST['password-reg']))
                              {
                              echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["NO_PASSWORD"]."</div>
</div>";
                              }
                          };

                          if(isset($_POST['register'])){
                              if($_POST['passwordv-reg'] != $_POST['password-reg'])
                              {
                              echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["NO_MATCH_PASSWORD"]."</div>
</div>";
                              }
                          };
                         
                          if(isset($_POST['register'])){
                              if($_POST['email-reg'] == "")
                              {
                              echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["INVAL_EMAIL"]."</div>
</div>";
                              }
                              if($_POST['email-reg'] != ""){
                                  if($e > 0){
                                  echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["EMAIL_TAKEN"]."</div>
</div>";
                                  }
                              }
                          };
?>
<p>&nbsp;</p>
<form action="" method="post" name="myform" id="myform">

        <table border="0" align="left" cellpadding="3" cellspacing="3" class="forms">
        <tr>
            <td> <?PHP echo $lang['USERNAME']?></td>
            <td><input type="text"  name="username-reg" class="textfield" id="u_empty" value="<? echo $_POST['username-reg']; echo $ur ?>" onChange="javascript:this.value=this.value.toLowerCase();"/>
              </td>
          </tr>
          <tr>
            <td><?PHP echo $lang['PASSWORD']?></td>
            <td>
                          <input type="password"  name="password-reg" class="textfield" value="<? echo $_POST['password-reg']; echo $pr; ?>" /></td>
          </tr>
          <tr>
            <td><?PHP echo $lang['VERIFY_PASSWORD']?></td>
            <td>
                          <input type="password"  name="passwordv-reg" class="textfield" value="<? echo $_POST['passwordv-reg']; echo $prv; ?>" />
             </td>
          </tr>
          <tr>
            <td><?PHP echo $lang['EMAIL']?></td>
            <td>
                          <input type="text"  name="email-reg" class="textfield" id="e_empty" value="<? echo $_POST['email-reg']; echo $em; ?>" /></td>
          </tr>
           <tr>
            <td><?PHP echo $lang['SEC_CODE']?></td>
            <td><img src="captcha.php" style="margin-bottom:0px;"> <input type="text" name="vercode" style="width:65px;"/></td></tr>
<tr><td>
<input type="submit" name="register" id="submit" class="fader" value="<?PHP echo $lang['REGISTER']?>"/></td></tr>
</table></form>
</div>
<?PHP include("side.php"); ?>
<?PHP include("footer.php");

?>