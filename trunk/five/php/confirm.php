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
include("header.php");
$ip = $_SERVER['REMOTE_ADDR'];
$twitterObj = new EpiTwitter($consumer_key, $consumer_secret);
$twitterObj->setToken($_GET['oauth_token']);
$token = $twitterObj->getAccessToken();
$twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);
$twitterInfo= $twitterObj->get_accountVerify_credentials();
$twitterInfo->response;
$twit_user = $twitterInfo->screen_name;
$twit_user = strtolower($twit_user);
$tok = file_put_contents('tok', $token->oauth_token);
$sec = file_put_contents('sec', $token->oauth_token_secret);
$joined = date("F j, Y");
$ip = $_SERVER['REMOTE_ADDR'];
$fullhost = gethostbyaddr($ip);
$host = preg_replace("/^[^.]+./", "", $fullhost);
$isp = $host;
$login_query = mysql_query("SELECT * FROM members WHERE username = '$twit_user'") or die(mysql_error());
	$login = mysql_fetch_array($login_query);
	$exists = mysql_num_rows($login_query);
    $user_id = $login['id'];
    if($exists == "0"){
    	mysql_query("INSERT INTO members (username,twit_user,joined,isp,ip,status) VALUES('$twit_user','Yes','$joined','$isp','$ip','activated')");
		$urlf = 'users/'.$twit_user.'';
       $indexfi = 'users/index.php';
       $avatar = 'users/default.png';
       mkdir($urlf,0777);
       chmod($urlf,0777);
       copy("users/admin/index.php",$urlf."/index.php");
       copy($avatar,$urlf."/default.png");
       chmod($urlf,0755);

setcookie("username", $twit_user, time()+60*60*24*100);
setcookie("userid", $user_id, time()+60*60*24*100);
setcookie("ip", md5($ip), time()+60*60*24*100);
mysql_query("update members SET logged_in='yes' where username='".$twit_user."'");
$_SESSION['userName'] = $twit_user;

header( 'Location: ./' );

} else{
$_SESSION['userName'] = $login[username];
if($login['password'] != ""){
$_SESSION['password'] = $login[password];
}

setcookie("username", $twit_user, time()+60*60*24*100);
setcookie("userid", $user_id, time()+60*60*24*100);
setcookie("ip", md5($ip), time()+60*60*24*100);
mysql_query("update members SET logged_in='yes' where username='".$twit_user."'");
$_SESSION['userName'] = $twit_user;
header( 'Location: ./' );
}
echo "</div>";
include("side.php");
include("footer.php");
ob_flush(); ?>