<!DOCTYPE html>
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

 include("php/header_content.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?php echo "<title>".(isset($title)?$title:"Default title")."</title>\n";?>

<meta name="description" content="<? echo $description = stripslashes(str_replace(array('\r\n', '<br>'), array(' ',' '), ($description))); ?>"/>
<meta name="keywords" content="<? echo $keywords = stripslashes(str_replace(array('\r\n', '<br>'), array(' ',' '), ($keywords)));?>"/>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/modal.css" rel="stylesheet" type="text/css"/>
<link href="css/buttons.css" rel="stylesheet" type="text/css"/>
<link href="css/nyroModal.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
<script src="js/jquery.modal.js" type="text/javascript"></script>
<script src="js/jquery.nyroModal-1.6.2.min.js" type="text/javascript"></script>
<script src="js/jquery-lander.js" type="text/javascript"></script>
<script type="text/javascript" src="js/cont_form.js"></script>
<script type="text/javascript" src="js/voting.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/jQuery Cycle.js"></script>
<script language="JavaScript" type="text/javascript">
<!--
var cookieText = "<?PHP echo md5($ip)?>";
var cookiePrefix = "";
var myPage = location.href;

var cookieName = cookiePrefix + "iphash";
function cookieSet() {
if (document.cookie != document.cookie) {
index = document.cookie.indexOf(cookieName);
} else {
index = -1;
}
if (index == -1) {
document.cookie=cookieName+"="+cookieText+"; ";
}
}
//-->
</script>
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="css/all-ie-only.css" />

<![endif]-->
<!--[if IE ]>
<style type="text/css">
.Button, input.Button , .header, .menu_nav, .content_resize, .sidebar, .article, .sidebar h2,  .footer p.lf, .head_button, .queue, div  {
    behavior: url(PIE/PIE.htc);
}
</style>
<![endif]-->

</head>

<body>
<div class="main">
<div class="content">
<div class="content_resize">

    <div class="translate">
    <?PHP include("php/trans.php"); ?>
    </div>
    <div class="search">
<form name="search" method="post" action="search.php"/>
<input name="searchterm" type="text" onfocus="value=''" value="<?PHP echo $lang['SEARCH']?>....." class="searchfield"/>
<input type="submit" name="search" value="<?PHP echo $lang['SEARCH']?>" class='Button'/>
</form>
</div>

<div class="logo">

    <a href="/"><img src="images/logo.png" width="279" height="51" alt="" /></a>
    </div>
    <?PHP if (!isset($username)) {?>
    <div class="nav">
    <a class='Button' href='./'><?PHP echo $lang['HOME']?></a>
    <a class='Button' href="#" id="trigger_register"><?PHP echo $lang['REGISTER']?></a>
    <a class='Button' href="#" id="trigger_login"><?PHP echo $lang['LOGIN']?></a>
    <a class='Button' href='contact.php'><?PHP echo $lang['HELP']?></a>
    </div>

    <div class="mainbar">
    <div class="header">
    <?PHP if($show_alert == 'yes' && ($_COOKIE['iphash'] !== md5($ip))) {?>
    <div class="alertbox">
<div class="dialog-box-warning">
              <div class="dialog-left">
                  <img src="images/alert.png" class="dialog-warning-ico" alt=""/>
                  <?PHP echo $text ?>
              </div>
              <div class="dialog-right">
                  <img src="images/warning-delete.jpg" class="del-x" alt="" onclick='return cookieSet(this);'/>
              </div>
          </div>
<div class="alert_shadow"><img src="images/shadow.png" width="689" height="5" alt="" /></div></div><?PHP } ?>
<?PHP if($page_name == 'profile' OR ($page_name == 'jobs')){echo "";}else{?>
<img src="images/header3.png" width="690" height="170" alt=""/>
    <h2><?PHP echo $tagline = htmlentities($tagline, ENT_QUOTES)?></h2>
    <?PHP } ?></div>
    <?PHP }else{ ?>
    <div class="nav">
    <a class='Button'href='./' ><?PHP echo $lang['HOME']?></a>
    <a class='Button' href="submit_job.php"><?PHP echo $lang['POST_A_JOB']?></a>
    <a class='Button' href="profile-<?PHP echo $username ?>"><?PHP echo $lang["MY_PROFILE"]?></a>
    <a class='Button' href="logout.php"><?PHP echo $lang['LOGOUT']?></a>
    <a class='Button' href='contact.php'><?PHP echo $lang['HELP']?></a>
    </div>
    <div class="mainbar">
    <div class="header">
    <?PHP if($show_alert == 'yes' && ($_COOKIE['iphash'] !== md5($ip))) {?>
    <div class="alertbox">
<div class="dialog-box-warning">
              <div class="dialog-left">
                  <img src="images/alert.png" class="dialog-warning-ico" alt=""/>
                  <?PHP echo $text ?>
              </div>
              <div class="dialog-right">
                  <img src="images/warning-delete.jpg" class="del-x" alt="" onclick='return cookieSet(this);'/>
              </div>
          </div>
<div class="alert_shadow"><img src="images/shadow.png" width="689" height="5" alt="" /></div></div><div class="clr"></div><?PHP } ?>
<?PHP if($page_name == 'bookmarks.php' OR
         $page_name == 'index.php' OR
         $page_name == 'category-'.$cat.'' OR
         $page_name == 'tags?keyword='.$keyword.'' OR
         $page_name == 'search.php' OR
         $page_name == 'featured.php' OR
         $page_name == 'h_rated.php' OR
         $page_name == 'latest.php' OR
         $page_name == 'buy_now.php' OR
         $page_name == 'mostpopular.php'){?>
<div class="willdo_box">
    <div class="welc"><?PHP echo $lang['WELCOME']?>: <?PHP echo $username ?>.
<?PHP include("new_messages.php"); ?>
</div>
<div class="head_form">
<form name="myform" method="post" action="submit_job.php" onsubmit="return validate_FOrm ( );"/>
<h2><?PHP echo $lang['I_WILL']?> <input class="head_input" name="willdo" type="text"/>  <input type="submit" class="head_button" name="submit" value="<?PHP echo $lang['SUBMIT']?>" /></h2>
</form></div></div><div class="box_shadow"><img src="images/shadow.png" width="690" height="5" alt="" /></div>
<?PHP } ?>
</div>
    <?PHP } ?>
    <? if(isset($_POST['register'])){
           include("register.php");
           }?>
  <?PHP if (!isset($username)) {?>
<!-- Register modal -->
	<div class="modal_window" id="register">
		<div class="modal_top"><a href="#" class="jqmClose" title="Close">Close</a></div>
		<div class="modal_content">
			<div class="headline"><?PHP echo $lang['REGISTER']?></div>
			<p>Register with us here, five dollar micro jobs.</p>

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
            <td><img src="captcha.php" style="margin-bottom:0px;"> <input type="text" name="vercode" style="width:65px;"/>
</td></tr>
<tr><td>
<input type="submit" name="register" id="submit" class="fader" value="<?PHP echo $lang['REGISTER']?>"/></td></tr>
</table></form>
<?PHP
// $twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
//echo '<fb:login-button length="long" onlogin="window.location=\''.$siteurl.'/?runfb=1&isuser=1\';"><fb:intl>Connect with Facebook</fb:intl></fb:login-button>&nbsp;&nbsp;';
//echo '<a href="' . $twitterObj->getAuthorizationUrl() . '"><img src="images/twt.gif" alt="sign in with twitter" height="25px" width="190px" border="0"/></a>';
?>
</div>
		<div class="modal_bott"></div>
	</div>
	<!-- login modal -->
	<div class="modal_window" id="login">
		<div class="modal_top"><a href="#" class="jqmClose" title="Close"><?PHP echo $lang['CLOSE']?></a></div>
		<div class="modal_content">
			<div class="headline"><?PHP echo $lang['LOGIN']?></div>
            <?PHP  if($page == 'jobs'){
            echo '<form action="login.php?act=jobs" method="post">';
            echo '<input type="hidden" name="refer" value="'.$siteurl.'/'.$seo.'-'.$id.'.html">';
            }else{echo '<form action="login.php" method="post">';} ?>
<table border="0" align="left" cellpadding="3" cellspacing="3" class="forms">
<tr>
<td><?PHP echo $lang['USERNAME']?>:</td>
<td><input type="text" name="myusername" class="textfield" size="40" onChange="javascript:this.value=this.value.toLowerCase();"/></td>
</tr>
<tr>
<td><?PHP echo $lang['PASSWORD']?>:</td>
<td><input type="password" name="mypassword" size="40" class="textfield"/></td>
</tr><input type="hidden" name="login" value="TRUE" />
<tr><td><a href="forgot_pass.php"><?PHP echo $lang['FORGOT_PASS']?></a></td></tr>
<tr><td><input type="checkbox" name="remember" <?php if(md5($ip) == $ipa) {?>checked="checked"<? }?>value="remember" /> <?php echo $lang['REMEMBER_ME']?></td>
<td><input class="fader" type="submit" id="submit" name="submit" value="<?PHP echo $lang['LOGIN']?>" /></td>
</tr></table>
</form>
<?PHP 
//$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
//echo '<fb:login-button length="long" onlogin="window.location=\''.$siteurl.'/?runfb=1&isuser=1\';"><fb:intl>Connect with Facebook</fb:intl></fb:login-button>&nbsp;&nbsp;';
//echo '<a href="' . $twitterObj->getAuthorizationUrl() . '"><img src="images/twt.gif" alt="sign in with twitter" height="25px" width="190px" border="0"/></a>';
?>
		</div>
		<div class="modal_bott"></div>
	</div>
    <?PHP } 