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
echo "<ul class=\"sb_menu\"> ";
$i = 0;
$tqr = mysql_query("SELECT * FROM categories order by `catname` asc");
$qrnum = mysql_num_rows($tqr);
if($qrnum == 0) {
				print "No categories!";
         } else {
					while ($tarray = mysql_fetch_array($tqr)) {
					$xcat = mysql_result($tqr, $i, 'catname');
			
		print " <li><a href=\"".$siteurl."/category-".seo_link_pv($xcat)."-".$tarray[0]."\" >" . $xcat = stripslashes(str_replace('-', ' ',($xcat))) . "</a></li>";
		$i++;
	}
}
echo "</ul>";
//header('Cache-control: private');
if(isSet($_GET['lang']))
{
	$lang = $_GET['lang'];
	$_SESSION['lang'] = $lang;
	setcookie("language", $lang, time() + (3600 * 24 * 30));
}
else if(isSet($_SESSION['lang']))
{
	$lang = $_SESSION['lang'];
}
else if(isSet($_COOKIE['language']))
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
?>