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

 include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$consumer_key = $row['twitter_key'];
$consumer_secret = $row['twitter_sec'];
$oAuthToken = $row['oauthkey'];
$oAuthSecret = $row['oauthsecret'];
}
function TinyURL($u){
return file_get_contents('http://tinyurl.com/api-create.php?url='.$u);
}
$sql = "SELECT * FROM jobs WHERE `willdo` = '$willdo' ";
$rs = mysql_query($sql)or die(mysql_error());
while($row = mysql_fetch_assoc($rs)) {
$id = $row['id'];
$p_desc = $row['part_description'];
}
// seo_link_pv function below is in functions/general.php - change that function if you want to change how seo urls are formatted
$seo=seo_link_pv($willdo);
$willdo = ''.$siteurl.'/'.$seo.'-'.$id.'.html';
$url = $willdo;
$tiny = TinyURL($url);
require_once('twitter/twitteroauth.php');

// create a new instance
$tweet = new TwitterOAuth($consumer_key, $consumer_secret, $oAuthToken, $oAuthSecret);

//send a tweet
$tweet->post('statuses/update', array('status' => 'New job: '.$tiny.'&nbsp;&nbsp;'.$p_desc.''));
?>