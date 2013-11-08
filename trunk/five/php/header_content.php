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
 
ob_start();

include("connect.php");
function loggedFB(){
	global $session;
	echo($session[fbid]);
}
function loggedId(){
	global $session;
	echo($session[id]);
}
function loggedJoined(){
	global $session;
	echo($session[joined]);
}
function loggedLevel(){
	global $session;
	echo($session[level]);
}
function loggedName(){
	global $session;
	if($session[username] != ""){
		echo($session[username]);
	}
	else{
		echo("<fb:name useyou=\"false\" uid=\"".$session[fbid]."\"></fb:name>");
	}
}
function loggedOnline(){
	global $session;
	$offline = 300;
	$current = time();
	$offline = ($current-$offline);
	if($session[online] >= $offline){
		echo("online");
	}
	else{
		echo("offline");
	}
}
function loggedUpdateOnline(){
	global $session;
	$offline = 300;
	$current = time();
	$offline = ($current-$offline);
	if($session[id]){
        mysql_query("UPDATE members SET online = '$current' WHERE id = '$session[id]'");
	}
}
function loggedSetStatus($status){
	global $session;
	$status = secureInput($status);
	if($session[id]){
		mysql_query("UPDATE members SET status = '$status' WHERE id = '$session[id]'");
	}
}
function loggedStatus(){
	global $session;
	echo($session[status]);
}
function userFB($username){
	$user = mysql_query("SELECT fbid FROM members WHERE username = '$username'") or die(mysql_error());
	$user = mysql_fetch_array($user);
	echo($user[fbid]);
}
function userId($username){
	$user = mysql_query("SELECT id FROM members WHERE username = '$username'") or die(mysql_error());
	$user = mysql_fetch_array($user);
	echo($user[id]);
}
function userJoined($username){
	$user = mysql_query("SELECT joined FROM members WHERE username = '$username'") or die(mysql_error());
	$user = mysql_fetch_array($user);
	echo($user[joined]);
}
function userLevel($username){
	$user = mysql_query("SELECT level FROM members WHERE username = '$username'") or die(mysql_error());
	$user = mysql_fetch_array($user);
	echo($user[level]);
}
function userName($id){
	$user = mysql_query("SELECT username FROM members WHERE id = '$id'") or die(mysql_error());
	$user = mysql_fetch_array($user);
	echo($user[username]);
}
function userOnline($username){
	$offline = 300;
	$current = time();
	$offline = ($current-$offline);
	$user = mysql_query("SELECT online FROM members WHERE username = '$username'") or die(mysql_error());
	$user = mysql_fetch_array($user);
	if($user[online] >= $offline){
		echo("online");
	}
	else{
		echo("offline");
	}
}
function userStatus($username){
	$user = mysql_query("SELECT status FROM members WHERE username = '$username'") or die(mysql_error());
	$user = mysql_fetch_array($user);
	echo($user[status]);
}
function usersList($search){
	if(isset($search)){
		$search = secureInput($search);
		if(strstr($search,":")){
			$search = explode(":",$search,2);
			if($search[0] == "password"){
				echo("Error: Cannot search for users passwords");
			}
			else{
				$list = mysql_query("SELECT * FROM members WHERE $search[0] LIKE '%$search[1]%'") or die("Could not complete the search. If you have reached this out of error, try reducing punctuation in your search.");
				while($row = mysql_fetch_array($list)){
					echo($row['username']);
					echo("<br />");
				}
			}
		}
		elseif($search == ""){
			$list = mysql_query("SELECT * FROM members");
			while($row = mysql_fetch_array($list)){
				echo($row['username']);
				echo("<br />");
			}
		}
		else{
			$list = mysql_query("SELECT * FROM members WHERE username LIKE '%$search%'");
			while($row = mysql_fetch_array($list)){
				echo($row['username']);
				echo("<br />");
			}
		}
	}
}
function loggedTask($online_condition,$offline_condition){
	global $session;
	if($session[id]){
		$condition_explode = explode(":",$online_condition,2);
		if($condition_explode[0] == ""){
			die("Syntax error: No function type specified when userOnline called.");
		}
		else{
			if($condition_explode[0] == "func"){
				if($condition_explode[1] == ""){
					die("Syntax error: No function specified when userOnline called.");
				}
				else{
					stripslashes($condition_explode[1]);
					$do_condition = $condition_explode[1];
					if(strstr($do_condition,"()")){
						str_replace("()","",$do_condition);
					}
					elseif(splitBy2($do_condition,"(",")") != ""){
						$do_subcondition = splitBy2($do_condition,"(",")");
						$count_subcondition = count(explode(",",$do_subcondition));
						$do_condition = explode("(",$do_condition);
						$do_condition = $do_condition[0];
						$do_subcondition = explode(",",$do_subcondition);
						for($x=0;$x<$count_subcondition;$x++){
							$do_subconditions[] = $do_subcondition[$x];
						}
						call_user_func_array($do_condition,$do_subconditions);
					}
					else{
						$do_condition();
					}
				}
			}
			if($condition_explode[0] == "html"){
				stripslashes($condition_explode[1]);
				echo($condition_explode[1]);
			}
		}
	}
	if(!$session[id]){
		$condition_explode = explode(":",$offline_condition,2);
		if($condition_explode[0] == ""){
			die("Syntax error: No function type specified when userOnline called.");
		}
		else{
			if($condition_explode[0] == "func"){
				if($condition_explode[1] == ""){
					die("Syntax error: No function specified when userOnline called.");
				}
				else{
					stripslashes($condition_explode[1]);
					$do_condition = $condition_explode[1];
					if(strstr($do_condition,"()")){
						str_replace("()","",$do_condition);
					}
					elseif(splitBy2($do_condition,"(",")") != ""){
						$do_subcondition = splitBy2($do_condition,"(",")");
						$count_subcondition = count(explode(",",$do_subcondition));
						$do_condition = explode("(",$do_condition);
						$do_condition = $do_condition[0];
						$do_subcondition = explode(",",$do_subcondition);
						for($x=0;$x<$count_subcondition;$x++){
							$do_subconditions[] = $do_subcondition[$x];
						}
						call_user_func_array($do_condition,$do_subconditions);
					}
					else{
						$do_condition();
					}
				}
			}
			if($condition_explode[0] == "html"){
				stripslashes($condition_explode[1]);
				echo($condition_explode[1]);
			}
		}
	}
}
function loggedAdminTask($online_condition,$level){
	global $session;
	if($session[id]){
		if($session[level] >= $level){
			$condition_explode = explode(":",$online_condition,2);
			if($condition_explode[0] == ""){
				die("Syntax error: No function type specified when userOnline called.");
			}
			else{
				if($condition_explode[0] == "func"){
					if($condition_explode[1] == ""){
						die("Syntax error: No function specified when userOnline called.");
					}
					else{
						stripslashes($condition_explode[1]);
						$do_condition = $condition_explode[1];
						if(strstr($do_condition,"()")){
							str_replace("()","",$do_condition);
						}
						elseif(splitBy2($do_condition,"(",")") != ""){
							$do_subcondition = splitBy2($do_condition,"(",")");
							$count_subcondition = count(explode(",",$do_subcondition));
							$do_condition = explode("(",$do_condition);
							$do_condition = $do_condition[0];
							$do_subcondition = explode(",",$do_subcondition);
							for($x=0;$x<$count_subcondition;$x++){
								$do_subconditions[] = $do_subcondition[$x];
							}
							call_user_func_array($do_condition,$do_subconditions);
						}
						else{
							$do_condition();
						}
					}
				}
				if($condition_explode[0] == "html"){
					stripslashes($condition_explode[1]);
					echo($condition_explode[1]);
				}
			}
		}
	}
}

function loginUserFB(){
    global $fbid;

	$login_query = mysql_query("SELECT * FROM members WHERE fbid = '$fbid'") or die(mysql_error());
	$login = mysql_fetch_array($login_query);
	$exists = mysql_num_rows($login_query);

$user_id = $login['id'];
$username = $login['username'];
    if($exists == 0){

		echo '<meta http-equiv="REFRESH" content="0;url=create.php?new">';
	}
	else{

setcookie("username", $username, time()+60*60*24*100);
setcookie("userid", $user_id, time()+60*60*24*100);
setcookie("ip", md5($ip), time()+60*60*24*100);
mysql_query("update members SET logged_in='yes' where username='".$username."'");
$_SESSION['userName'] = $login[username];
		if($login['password'] != ""){
			$_SESSION['password'] = $login[password];

        }
			echo '<meta http-equiv="REFRESH" content="0;url=.//">';
	}
}


function logoutUser(){
	unset($_SESSION['id']);
	unset($_SESSION['password']);
}



function registerFBUser($username,$status){
	global $fbid;
    $joined = date("F j, Y");
    $username = mysql_real_escape_string($username);

    $status = mysql_real_escape_string($status);

    $ip = $_SERVER['REMOTE_ADDR'];
$fullhost = gethostbyaddr($ip);
$host = preg_replace("/^[^.]+./", "", $fullhost);
$isp = $host;
    $query = mysql_query("SELECT * FROM members WHERE username = '$username'");
	$check = mysql_num_rows($query);
	if($check>0){
		echo("<img src=\"images/error.png\" alt=\"\"/>&nbsp;<b><font color=\"#CC0000\">Username already taken, please choose again</font></b><br />");
	}
	else{

        $create = mysql_query("INSERT INTO members (fbid,username,status,isp,ip,joined) VALUES('$fbid','$username','activated','$isp','$ip','$joined')");
        $urlf = 'users/' . strtolower($username);
       $indexfi = 'users/index.php';
       $avatar = 'users/default.png';
       mkdir($urlf,0777);
       chmod($urlf,0777);
       copy("users/admin/index.php",$urlf."/index.php");
       copy($avatar,$urlf."/default.png");
       chmod($urlf,0755);
            echo("<img src=\"images/succes.png\" alt=\"\"/>&nbsp;Username successfully created. Logging In...<META HTTP-EQUIV = 'Refresh' Content = '0; URL =./?task=register'><br />");

	}
}



function extendDisplay($extension){
	$extension = ucwords($extension);
	$extend = "extend".$extension;
	global ${$extend};
	echo(${$extend});
}

function FBConnectionReceive($api,$type){
	if($type == "normal"){
		echo("<script type=\"text/javascript\">
			  function initFB(){
			  FB_RequireFeatures([\"XFBML\"], function(){
			  FB.init(\"".$api."\", \"xd_receiver.htm\");
			  });
			  }
			  window.onload = initFB;
			  </script>");
	}
	elseif($type == "login"){
		echo("<script type=\"text/javascript\">
			  function initFB() {
			  	FB.init(\"".$api."\", \"xd_receiver.htm\",{\"reloadIfSessionStateChanged\":true});
			  }
			  window.onload = initFB;
			  </script>");
	}
	else{
		echo("Wrong type specified in FBConnectionReceive");
	}
}
function FBFeatureLoader(){
	echo("<script src=\"http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US\" type=\"text/javascript\"></script>");
}
function splitBy2($content,$start,$end){
	$r = explode($start, $content);
	if (isset($r[1])){
		$r = explode($end, $r[1]);
		return $r[0];
	}
	return '';
}
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$apikey = ''.$row['apikey'].'';
$apisecret = ''.$row['apisecret'].'';
}
require_once 'facebook/facebook.php';
$facebook = new Facebook($apikey, $apisecret);
$fbid = $facebook->get_loggedin_user();
function checkDuplicate()
{
$mysql = mysql_query("SELECT * FROM members WHERE username='".$_COOKIE["username"]."'") or die(mysql_error());
	while($row = mysql_fetch_assoc($mysql))
	{
	if($row['fbid'] != 0)
		{
			$query = mysql_query("SELECT * FROM members WHERE fbid='".$fbid."'") or die(mysql_error());
			$getCount = mysql_num_rows($query);
			return $getCount;
		}
		    else
	{
			$getCount = 0;
			return $getCount;
	}
}
}
if($fbid && $_GET['runfb'] == 1)
{
if(isset($_COOKIE["username"]))
	{
	if(checkDuplicate() == 0)
		{
		mysql_query("UPDATE members SET fbid='".$fbid."' WHERE username='".$_COOKIE["username"]."'") or die(mysql_error());
		loginUserFB();

        }
		else
		{
			if($_GET['isuser'] == 1)
			{
				echo '<script type="text/javascript">alert("Sorry, you are already connected to Facebook with another account.");</script>';
			}
		}
	}
	else
	{
		$mysql = mysql_query("SELECT * FROM members WHERE fbid='".$fbid."'") or die(mysql_error());
		$userExist = false;
		while($row = mysql_fetch_assoc($mysql))
		{
			$userExist = true;
		}
		if($userExist == false)
		{
			if(!isset($_GET['fb']))
			{

            echo '<meta http-equiv="REFRESH" content="0;url='.$siteurl.'/?task=register">';
			}
		}
		else
		{
            $mysql = mysql_query("SELECT * FROM members WHERE fbid='".$fbid."'") or die(mysql_error());
			while($row = mysql_fetch_assoc($mysql))
			{
				setcookie("username", $row['username']);

                loginUserFB();
            }

		}
	}
}
 if (isset($_GET['task'])) {
		if ($_GET['task'] == 'register') {
			loginUserFB();
		}
	}
include 'twitter/EpiCurl.php';
include 'twitter/EpiOAuth.php';
include 'twitter/EpiTwitter.php';
$result = mysql_query("SELECT * FROM sitesettings,alert");
while($row = mysql_fetch_array($result))
{
$siteurl = $row['site_url'];
$domain = $row['domain'];
$site_email = $row['site_email'];
$consumer_key = $row['twitter_key'];
$consumer_secret = $row['twitter_sec'];
$oAuthToken = $row['oauthkey'];
$oAuthSecret = $row['oauthsecret'];
$description = $row['description'];
$keywords = $row['keywords'];
$currency = $row['currency'];
$feat_num = $row['feat_num'];
$tagline = $row['tagline'];
$currency_symbol =  $row["currency_symbol"];
$minbalance = $row['min_balance'];
$price_range =  $row["price_range"];
$dropdown =  $row["dropdown"];
$alert =  $row["alert"];
$show_alert =  $row["show_alert"];
$text = stripslashes(nl2br($row['text']));
$url = str_replace('http://www.','',($siteurl));
}
$ip = $_SERVER['REMOTE_ADDR'];
$query = mysql_query("select * from members WHERE`ip`='$ip' ");
while ($row = mysql_fetch_array($query)){
$logged_in = $row['logged_in'];
$logged_in_user = $row['username'];
$twit_user = $row['twit_user'];
}
if($row['isbanned'] == 'Yes'){
echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
<html><head>
<title>403 Forbidden</title>
</head><body>
<h1>Forbidden</h1>
<p>You don\'t have permission to access '.$domain.'
on this server.</p>
<hr>
<address>Apache/2.2.8 Server at www.'.$domain.' Port 80</address>
</body></html>';
die;
}
if(isset($_COOKIE['ip']))
{
$ipa = $_COOKIE['ip'];
}
if($logged_in == 'yes'){
$_SESSION['userName'] = $logged_in_user;
}//endif;
$username = $_SESSION['userName'];
//header('Cache-control: private');
if(isset($_GET['lang']))
{
$lang = $_GET['lang'];
$_SESSION['lang'] = $lang;
setcookie("language", $lang, time() + (3600 * 24 * 30));
}
else if(isset($_SESSION['lang']))
{
$lang = $_SESSION['lang'];
}
else if(isset($_COOKIE['language']))
{
$lang = $_COOKIE['language'];
}
else
{
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$lang = $row['lang'];
}
}
$sql = "select * from languages";
$rec = mysql_query($sql) or die(mysql_error());
while($datas=mysql_fetch_array($rec)){
$abb = $datas['abb'];
$language = $datas['language'];
switch ($lang) {
  case "$abb":
  $lang_file = "$language";
  break;
}
}
//$lang_file = 'english';
include 'languages/'.$lang_file.'/'.$lang_file.'.php';

if(isset($_POST['searchterm']) || isset($_POST['searchterm']) || isset($_GET['searchterm'])) //if user pressed search
{
if(isset($_GET['searchterm'])) $searchterm = mysql_real_escape_string($_GET['searchterm']);
function filter($arr) {
return array_map('mysql_real_escape_string', $arr);
}
mysql_query("UPDATE searches SET `searchterm` = '".mysql_real_escape_string($_POST['searchterm'])."' WHERE id='1' ") or die(mysql_error());
if(!mysql_query)
            {
            echo 'Query failed '.mysql_error();
            exit();
            }header( 'Location: search' ) ;
}
?>