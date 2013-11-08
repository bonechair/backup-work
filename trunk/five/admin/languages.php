<?PHP /*
    
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
$page = 'languages';
if(!empty($_SESSION['user_name'])) {
include("header.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($data = mysql_fetch_array($result)){
$siteurl = $data['site_url'];
}
?>
<!--| CONTENT/MID |-->
<div class="grid_16" id="content">
    <div class="grid_9">
    <h1 class="dashboard">Languages Admin</h1>
    </div>
     <div class="clear"></div>
    <div class="lang">
    <h3>This is where you add any new languages to your site. You can also activate and de-activate languages here also.<br />Just add the name of the language and a 2 letter abbreviation code i:e: en for english, fr for french etc,in the "Add new languge" box on the right hand side, <br />
    Click the "Save Language" button and your language file will automatically be created and you will find it in the languages folder on your server.<br />
    Just download the language file to your computer and open it in a text editor to translate the file. Then just re-upload it into its correct language folder on your server.<br />
    In the left hand column you can de-activate and activate and also delete installed languages.</h3></div>
    <div class="clear">
    </div>
    <div id="portlets">
    <div class="column" id="left">
<?PHP
 if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();

if ($act == "deletelang") {
?>
<div class="portlet">
		<div class="portlet-header">Delete Language</div>
		<div class="portlet-content">
<form method='post' action = ''>
<p class="info" id="info"><span class="info_inner">Are you sure you want to delete this language?</span></p>
<input type='hidden' name='id' value='<? echo $id ?>'>
<input type = 'submit' name='deletelang' value='Yes'>&nbsp;<input type = 'submit' name='deletelang' value='No'>
</form></div></div><div class="clear">
    </div>
<?
//$id = mysql_real_escape_string($_GET['id']);
if($_POST['deletelang']=="Yes"){
mysql_query("DELETE FROM languages where id = '".mysql_real_escape_string($_POST['id'])."'") or die(mysql_error());
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Language could not be deleted</span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Language deleted Successfully</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '0; URL =languages.php'>";
}
}
if($_POST['deletelang']=="No"){
header( 'Location: languages.php' ) ;
}
}
if ($act == "editlang") {
$sql = "select * from languages where id= '$id'";
$rec = mysql_query($sql) or die(mysql_error());
while($row = mysql_fetch_array($rec)) {
$lang = $row['language'];
$filename = "../languages/$lang/$lang.php";
}
$newdata = $_POST['newd'];
if ($newdata != '') {
$fw = fopen($filename, 'w') or die('Could not open file!');
$newdata = mb_convert_encoding($newdata, 'UTF-8');
$fb = fwrite($fw,$newdata) or die('Could not write
to file');
fclose($fw);
}
$fh = fopen($filename, "r") or die("Could not open file!");
$data = fread($fh, filesize($filename)) or die("Could not read file!");
fclose($fh);
echo "<div class=\"portlet\">
		<div class=\"portlet-header\">Edit Language</div>
		<div class=\"portlet-content\"><h1>Edit File: $lang.php</h1>
<form action='$_SERVER[php_self]' method= 'post' >
<textarea name='newd' cols='70' rows='50'>$data</textarea>
<input type='submit' value='Change'>
</form></div></div>";
}
if ($act == "de_act_lang") {
mysql_query("update languages set status = 'inactive' where id = '$id'") or die(mysql_error());
header( 'Location: languages.php' ) ;
}
if ($act == "activelang") {
mysql_query("update languages set status = 'active' where id = '$id'") or die(mysql_error());
header( 'Location: languages.php' ) ;
}
}
?>
    <div class="portlet">
		<div class="portlet-header">List of Active Languages</div>
		<div class="portlet-content">
<?PHP

$sql = "select * from languages where status= 'active' order by 'id desc'";
$rec = mysql_query($sql) or die(mysql_error());
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"box-table-a\">
<tr>
<th class=\"th-1\">ID</th>
<th class=\"th-2\">Language</th>
<th class=\"th-2\">Abb</th>
<th class=\"th-2\">Flag</th>
<th class=\"th-7\">Action</th></tr>";
while($datas=mysql_fetch_array($rec)){

echo "<tr>
<td class=\"td-1\">$datas[id]</td>
<td class=\"td-2\">$datas[language]</td>
<td class=\"td-1\">$datas[abb]</td>
<td class=\"td-2\">$datas[flag_image]</td>
<td class=\"td-7\"><a href='languages.php?act=de_act_lang&id=$datas[id]'><img src=\"images/icons/exclamation.gif\" alt=\"de-activate\" title=\"Set language inactive\"/></a>&nbsp;
<a href='languages.php?act=deletelang&id=$datas[id]'><img src=\"images/icons/action_delete.gif\" alt=\"delete\" title=\"Delete Language\"/></a></td></tr>";
}
echo "</table>";?>
</div></div>
<div class="clear"></div>
<?PHP
$sql = "select * from languages where status= 'inactive' order by 'id desc'";
$rec = mysql_query($sql) or die(mysql_error());
$rows = mysql_num_rows($rec);
if ($rows > 0) {
?>
<div class="portlet">
<div class="portlet-header">List of Inactive Languages</div>
<div class="portlet-content">
<?PHP
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"box-table-a\">
<tr>
<th class=\"th-1\">ID</th>
<th class=\"th-2\">Language</th>
<th class=\"th-2\">Abb</th>
<th class=\"th-2\">Flag</th>
<th class=\"th-7\">Action</th></tr>";
while($datas=mysql_fetch_array($rec)){

echo "<tr>
<td class=\"td-1\">$datas[id]</td>
<td class=\"td-2\">$datas[language]</td>
<td class=\"td-1\">$datas[abb]</td>
<td class=\"td-2\">$datas[flag_image] </td>
<td class=\"td-7\"><a href='languages.php?act=activelang&id=$datas[id]'><img src=\"images/icons/action_check.gif\" alt=\"de-activate\" title=\"Set language Active\"/></a>&nbsp;
<a href='languages.php?act=deletelang&id=$datas[id]'><img src=\"images/icons/action_delete.gif\" alt=\"delete\" title=\"Delete Language\"/></a></td></tr>";
}
echo "</table>";?>
</div></div><?PHP }?>
<div class="clear">
    </div>
</div>
</div>
<div class="column">
 <div class="portlet">
		<div class="portlet-header">Add new Language</div>
		<div class="portlet-content">
         <form id="upload" action="<?php echo $_SERVER['PHP_SELF']; ?>" name="upload" enctype="multipart/form-data" method="post">
         <label>Language</label><input type="text" name="language" class="largeInput">
         <label>Abbreviation (2 letters only, i:e 'en' for english)</label><input type="text" name="abb" class="smallInput">
         <label>Flag Image</label><input name="pic" type="file" class="largeInput"/>
         <input type ="submit" name="submit" class="submit" value="Save Language"></form><h3></h3>
        </div></div>
<?PHP

if(isset($_POST['submit']))
{
$language = $_POST['language'];
$abb = $_POST['abb'];
$ImageName = $_FILES[pic][name];
if(!empty($ImageName))
{
$t = time();
$NewImageName = "$t$ImageName";
copy($_FILES[pic][tmp_name], "../flags/$NewImageName");
}
$img_path = "<img src='$siteurl/flags/$NewImageName' alt='$language' title='$language' border='0'>&nbsp;";
if($_POST['language'] == ""  ){
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">You did not enter a language. Please try again.</span></p>";
}else{
$sql = "SELECT * FROM languages WHERE language = '".mysql_real_escape_string($language)."' ";
if(!$sql) {
die('Could not connect: ' . mysql_error());
}
$result = mysql_query($sql,$db )or die("Error ".mysql_errno().": ".mysql_error()."\nQuery: $query");
$num = mysql_numrows($result);
if ($num != 0 ) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Language already exists in the database</span></p>";
}else{
$query = sprintf("INSERT INTO languages (language,abb,flag_image)VALUES( '%s','%s','%s')",
mysql_real_escape_string($language),
mysql_real_escape_string($abb),
mysql_real_escape_string($img_path));
if(!mysql_query($query))
{
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Language could not be added</span></p>";
}else{
$urlf = '../languages/' . strtolower($language);
$language = mb_convert_encoding($language, 'UTF-8');
       $indexfi = '../languages/english/english.php';
       mkdir($urlf,0755);
       //chmod($urlf,0777);
       copy("../languages/english/english.php",$urlf."/".$language.".php");

       //chmod(''.$urlf.'/'.$language.'.php',0777);
echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Language added successfully!</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '0; URL =languages.php'>";
}
}
}
}
?>
</div>
</div>
<?PHP } else{header( 'Location: index.php' ) ;}
include("footer.php"); ob_flush();?>