<? 
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
$page = 'categories';
if(!empty($_SESSION['user_name'])) {
  include("header.php");
?>
<!--| CONTENT/MID |-->
<div class="grid_16" id="content">
    <div class="grid_9">
<h1 class="dashboard">Category Admin</h1>
    </div>
    <div class="clear">
    </div>
<div class="lang">
     
    <h3>This shows you all the categories in the database.<br />In the left hand column you can delete categories, in the right hand column you can add a new category.</h3></div>
    <div class="clear">
    </div>
    <div id="portlets">
    <div class="column" id="left">
    <div class="portlet">
		<div class="portlet-header">List of Categories</div>
		<div class="portlet-content">
<?PHP
$sql = "select * from categories order by ".mysql_real_escape_string('catid')."";
$rec = mysql_query($sql) or die(mysql_error());
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"box-table-a\">
<tr>
<th class=\"th-1\">ID</th>
<th class=\"th-2\">Category Name</th>
<th class=\"th-2\">Edit</th>
<th class=\"th-2\">Delete</th></tr>";
while($datas=mysql_fetch_array($rec)){
echo "<tr>
<td class=\"td-1\">$datas[catid]</td>
<td class=\"td-2\">$datas[catname]</td>
<td class=\"td-2\"><a href='managecategory.php?act=editcat&id=$datas[catid]'><img src=\"images/icons/edit.gif\" class=\"tb-1-action-edit\" alt=\"edit\" title=\"Edit Category\"/></a></td>
<td class=\"td-2\"><a href='managecategory.php?act=deletecat&id=$datas[catid]'><img src=\"images/icons/action_delete.gif\" alt=\"delete\" title=\"Delete Category\"/></a></td></tr>";
}
echo "</table>";?>
</div></div></div></div>
<div class="column">
 <div class="portlet">
		<div class="portlet-header">Add new category</div>
		<div class="portlet-content">
         <form method="post"> <input type="text" name="catname" class="largeInput">
<input type ="submit" name="submit" class="submit" value="Save Category"></form>
        </div></div>
<? if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();

if ($act == "deletecat") {
?>
<div class="portlet">
		<div class="portlet-header">Delete category</div>
		<div class="portlet-content">
<form method='post' action = ''>
<p class="info" id="info"><span class="info_inner">Are you sure you want to delete this category?</span></p>
<input type='hidden' name='id' value='<? echo $id ?>'>
<input type = 'submit' name='deletecat' value='Yes'>&nbsp;<input type = 'submit' name='deletecat' value='No'>
</form>
<?
$id = mysql_real_escape_string($_GET['id']);
if($_POST['deletecat']=="Yes"){
mysql_query("DELETE FROM categories where catid = '".mysql_real_escape_string($_POST['id'])."'") or die(mysql_error());
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Category could not be deleted</span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Category deleted Successfully</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '0; URL =managecategory.php'>";
}
}
if($_POST['deletecat']=="No"){
header( 'Location: managecategory.php' ) ;
}
}
if ($act == "editcat") { ?>
<div class="portlet">
		<div class="portlet-header">Edit category</div>
		<div class="portlet-content">
<?PHP
$rec = mysql_query("SELECT * FROM categories where catid = '".mysql_real_escape_string($id)."'") or die(mysql_error());
$dats = mysql_fetch_array($rec);
$cat_name = $dats['catname'];
echo "<form method='post' action=''>
<input type='hidden' name='catid' value='$id'>
<input type ='text' name='category' size='50' class='largeInput' value='$dats[catname]'></select>
<input type = 'submit' name='submitedit' class='submit' value='Update category'></form>";
echo "<h3>Please note: This will also assign the new category name to any jobs in the existing category.</h3>";
echo "</div></div>";
}
}?>

<?PHP
$rec = mysql_query("SELECT * FROM jobs where category = '".$cat_name."'") or die(mysql_error());
if (isset($_POST["submitedit"])) {
$catid = mysql_real_escape_string($_POST['catid']);
$catname=addslashes(str_replace('\r\n', '<br>',$_POST['category']));
$query1 = sprintf("UPDATE categories SET catname='$catname' WHERE catid = '$catid'");

if(!mysql_query($query1)) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/icons/error.png\" class=\"dialog-ico\" alt=\"\"/>Category could not be edited
</div>
<div class=\"dialog-right\">
<img src=\"images/icons/error-delete.jpg\" class=\"del-x\" alt=\"\"/>
</div>
</div>";  header( 'Location: managecategory.php' ) ;
}else{ echo "<div class=\"dialog-box-succes\">
<div class=\"dialog-left\">
<img src=\"images/icons/succes.png\" class=\"dialog-ico\" alt=\"\"/>Category edited successfully!</div>
<div class=\"dialog-right\">
<img src=\"images/icons/succes-delete.jpg\" class=\"del-x\" alt=\"\"/>
</div></div>"; header( 'Location: managecategory.php' ) ;
}
$query = sprintf("UPDATE jobs SET category='$catname' WHERE category = '$cat_name'");
if(!mysql_query($query)) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/icons/error.png\" class=\"dialog-ico\" alt=\"\"/>Category could not be edited
</div>
<div class=\"dialog-right\">
<img src=\"images/icons/error-delete.jpg\" class=\"del-x\" alt=\"\"/>
</div>
</div>";  header( 'Location: managecategory.php' ) ;
}else{ echo "<div class=\"dialog-box-succes\">
<div class=\"dialog-left\">
<img src=\"images/icons/succes.png\" class=\"dialog-ico\" alt=\"\"/>Category edited successfully!</div>
<div class=\"dialog-right\">
<img src=\"images/icons/succes-delete.jpg\" class=\"del-x\" alt=\"\"/>
</div></div>"; header( 'Location: managecategory.php' ) ;
}
}

if(isset($_POST['submit']))
{
$catname = $_POST['catname'];
if($_POST['catname'] == ""  ){
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">You did not enter a category. Please try again.</span></p>";
}else{
$sql = "SELECT * FROM categories WHERE catname = '".mysql_real_escape_string($catname)."' ";
////////////////////if found set message////////////
if(!$sql) {
die('Could not connect: ' . mysql_error());
}
$result = mysql_query($sql,$db )or die("Error ".mysql_errno().": ".mysql_error()."\nQuery: $query");
$num = mysql_numrows($result);
if ($num != 0 ) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Category already exists in the database</span></p>";
}else{
$query = sprintf("INSERT INTO categories (catname)VALUES( '%s')",mysql_real_escape_string($catname));
if(!mysql_query($query))
{
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Category could not be added</span></p>";
}else{
echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Category added successfully!</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '0; URL =managecategory.php'>";
}
}
}
} ?>
</div>
</div>
<?PHP } else{header( 'Location: index.php' ) ;}
include("footer.php"); ob_flush();?>