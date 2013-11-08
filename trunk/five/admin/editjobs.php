<? /*
    
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
if(!empty($_SESSION['user_name'])) {
include("header.php"); 
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$currency_symbol =  $row["currency_symbol"];
$price_range =  $row["price_range"];
$lang =  $row["lang"];
}
$result1 = mysql_query("SELECT * FROM `languages` where `abb` = '$lang'");
while($row = mysql_fetch_array($result1))
{
$language1 =  $row["language"];
}
?>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}
/*]]>*/
</script>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmitt()
{
var agree=confirm("Do you wish to delete the selected jobs?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<!--| CONTENT/MID |-->
<div class="grid_16" id="content">
   <div class="grid_9">
    <h1 class="dashboard">Search Jobs</h1>
    </div>
    <div class="clear">
    </div>
    <div id="portlets">
<?
echo "<form method=\"post\" action=\"editjobs.php\">
<p><input type=\"text\" name=\"searchterm\"   class=\"largeInput\"  value=\"".$_POST['searchterm']."\"/>
<input class=\"submit\" type=\"submit\" name=\"search\"  value=\"Search\"/></p>
</form>";

if(isset($_POST['submit']) || isset($_POST['searchterm']) || isset($_GET['searchterm'])) //if user pressed search
{

if(isset($_GET['searchterm'])) $searchterm = mysql_real_escape_string($_GET['searchterm']);

    $searchterm = mysql_real_escape_string($_POST['searchterm']);
    $sql = "SELECT * FROM jobs where `approved` = 'Yes'  AND category LIKE '%$searchterm%' OR job_description LIKE '%$searchterm%' OR username LIKE '%$searchterm%'";
	$result = mysql_query($sql)or die(mysql_error());

if(mysql_num_rows($result) > 0){
echo "<br /><h3>Search Results</h3></br>
<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"box-table-a\">
<tr>
<th class=\"th-4\">Job</th>
<th class=\"th-4\">Username</th>
<th class=\"th-4\">Category</th>
<th class=\"th-4a\">Description</th>
<th class=\"th-4\">Keywords</th>
<th class=\"th-4\">Time Span</th>
<th class=\"th-4\">Postdate</th>
<th class=\"th-8\">Times Bought</th>
<th class=\"th-8\">Featured</th>
<th class=\"th-8\">Edit</th>
<th class=\"th-8\">Delete</th></tr>";
while($datas=mysql_fetch_array($result)){
echo "<tr>
<td class=\"td-4\">$datas[willdo]</td>
<td class=\"td-2\">$datas[username]</td>
<td class=\"td-3\">$datas[category]</td>
<td class=\"td-4a\">".$job_description=stripslashes(str_replace('\r\n', '<br>',($datas['job_description'])))."</td>
<td class=\"td-4\">$datas[keywords]</td>
<td class=\"td-6\">$datas[time_span]</td>
<td class=\"td-7\">$datas[postdate]</td>
<td class=\"td-8\">$datas[times_bought]</td>
<td class=\"td-8\">$datas[featured]</td>
<td class=\"td-8\"><a href='editjobs.php?act=editjob&id=$datas[id]'><img src=\"images/icons/edit.gif\" class=\"tb-1-action-edit\" alt=\"edit\" title=\"Edit Job\"/></a></td>
<td class=\"td-8\"><form action=\"\" method=\"post\" name=\"myForm\"><input type=\"checkbox\" name=\"myCheckbox[]\" value=\"$datas[id]\" id=\"myCheckbox$datas[id]\"/></td></tr>";
}
echo "</table>";
}else{
echo "<p class=\"info\" id=\"info\"><span class=\"info_inner\">There are no Jobs to show!</span></p>";
}
?>
<div align="right"><input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', true);" value="Check all!">
&nbsp;
<input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', false);" value="Uncheck all!">
<input type="submit" name="delete" value="Delete Selected" onClick="return confirmSubmitt()"></form></div>
<?PHP }?>
</div>
<?PHP if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();
if ($act == "editjob") {
?></div>
   <div class="grid_16" id="content">
   <div class="grid_9">
    <h1 class="dashboard">Edit Job</h1>
    </div>
    <div class="clear">
    </div>
    <div class="lang">
    <h3>Edit this jobs details.</h3></div>
    <div class="clear">
    </div>
    <div id="portlets">
    <div class="column" >
    <div class="portlet">
		<div class="portlet-header">Edit Job Details</div>
        <div class="portlet-content">
<?PHP

if (isset($_POST["submitedit"])) {
$willdo=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['willdo']));
$username=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['username']));
$category=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['category']));
$job_description=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['job_description']));
$part_description=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['job_description']));
$job_cost=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['job_cost']));
$link=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['link']));
$video_link=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['video_link']));
$keywords=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['keywords']));
$time_span=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['time_span']));
$postdate=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['postdate']));
$times_bought=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['times_bought']));
$featured=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['featured']));

        $edit1 = "UPDATE jobs SET willdo='$willdo' WHERE id = '$id'";
		mysql_query($edit1) or die("could not edit");
        $edit2 = "UPDATE jobs SET username='$username' WHERE id = '$id'";
		mysql_query($edit2) or die("could not edit");
        $edit3 = "UPDATE jobs SET category='$category' WHERE id = '$id'";
		mysql_query($edit3) or die("could not edit");
        $edit4 = "UPDATE jobs SET job_description='$job_description' WHERE id = '$id'";
		mysql_query($edit4) or die("could not edit");
        $edit5 = "UPDATE jobs SET part_description='$job_description' WHERE id = '$id'";
		mysql_query($edit5) or die("could not edit");
        $edit6 = "UPDATE jobs SET job_cost='$job_cost' WHERE id = '$id'";
		mysql_query($edit6) or die("could not edit");
        $edit7 = "UPDATE jobs SET link='$link' WHERE id = '$id'";
		mysql_query($edit7) or die("could not edit");
        $edit8 = "UPDATE jobs SET video_link='$video_link' WHERE id = '$id'";
		mysql_query($edit8) or die("could not edit");
        $edit9 = "UPDATE jobs SET keywords='$keywords' WHERE id = '$id'";
		mysql_query($edit9) or die("could not edit");
        $edit10 = "UPDATE jobs SET time_span='$time_span' WHERE id = '$id'";
		mysql_query($edit10) or die("could not edit");
        $edit11 = "UPDATE jobs SET postdate='$postdate' WHERE id = '$id'";
		mysql_query($edit11) or die("could not edit");
        $edit12 = "UPDATE jobs SET times_bought='$times_bought' WHERE id = '$id'";
		mysql_query($edit12) or die("could not edit");
        $edit13 = "UPDATE jobs SET featured='$featured' WHERE id = '$id'";
		mysql_query($edit13) or die("could not edit");
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Job could not be updated/span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Job was updated successfully</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '1; URL =editjobs.php'>";
}
}
$rec = mysql_query("SELECT * FROM jobs where id = '$id'") or die(mysql_error());
$datas = mysql_fetch_array($rec); ?>
<form action='' method='post'>
                <input type="hidden" name="id" value="<?php echo $id?>" >
                <label>Job:</label><input name='willdo' type='text' class="largeInput" value='<?php echo $datas[willdo]?>' />
                <label>Username:</label><input name='username' type='text' class="largeInput" value='<?php echo $datas[username]?>' />
                <label>Category:</label>
<?PHP
$sql = mysql_query("SELECT * FROM `categories` order by catname asc");
print "<select class=\"largeInput\" name=\"category\">\n";$catname = mysql_real_escape_string($datas['category']);
print "<option value=\"$datas[category]\">$datas[category]\n</option>";
while ($row = mysql_fetch_assoc($sql)){
        $catname = mysql_real_escape_string($row['catname']);
       print '<option value="'.$catname = stripslashes(str_replace(' ', '-',($catname))).'">'.$catname = stripslashes(str_replace(' ', '-',($catname))).'</option>';
}
print "</select>\n";
?>
<label>Description:</label> <textarea name="job_description" cols="45" rows="3" class="largeInput" id="textarea"><?php echo $job_description=stripslashes(str_replace('\r\n', '<br>',($datas['job_description'])));?></textarea>
<label>Job Cost:</label>
<select class="smallInput" name="job_cost">
<option value="<?php echo $datas[job_cost]?>">$<?php echo $datas[job_cost]?></option>
<?PHP
$price_range = htmlentities($price_range, ENT_QUOTES);
$kws = explode(",",$price_range);
foreach ($kws AS $a_kw) {
echo "<option value='".$a_kw."' >".$currency_symbol." ".$a_kw."</option> ";
}
?>
</select>
                	<label>Link:</label> <input name="link" type='text' class="largeInput" value='<?php echo $datas[link]?>' />
                	<label>Video Link:</label> <input name="video_link" type='text' class="largeInput" value='<?php echo $datas[video_link]?>' />
                	<label>Keywords:</label> <input name="keywords" type='text' class="largeInput" value='<?php echo $datas[keywords]?>' />
                	<label>Time Span:</label> <input name="time_span" type='text' class="smallInput" value='<?php echo $datas[time_span]?>' />
                	<label>Postdate:</label> <input name="postdate" type='text' class="smallInput" value='<?php echo $datas[postdate]?>' />
                	<label>Times Bought:</label> <input name="times_bought" type='text' class="smallInput" value='<?php echo $datas[times_bought]?>' />
                    <label>Featured:</label>
    <input name="featured" type="radio" value="yes" <?php if($datas['featured'] == 'yes') {?>checked="checked"<? }?> /> yes&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input name="featured" type="radio" value="no" <?php if($datas['featured'] == 'no') {?>checked="checked"<? }?> /> no
    <p>&nbsp;</p>
    <input type='submit' name='submitedit' value='Update Job' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='submit' value='Reset Form' />
    </form>
<?PHP
}
?>
</div></div></div></div>
<?PHP
}

if($_POST['delete']=="Delete Selected"){
$delete = $_REQUEST['delete'];
$checkbox = $_REQUEST['myCheckbox'];
$count = count($_REQUEST['myCheckbox']);
if($delete){
for($i=0;$i<$count;$i++){
$del_id = $checkbox[$i];
$sql = "DELETE FROM jobs where  id='$del_id' " or die(mysql_error());
$result = mysql_query($sql);
}
}
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Job could not be deleted</span></p>";
}else{echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Job was deleted successfully</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '1; URL =editjobs.php'>";
}
}
?></div>
   <div class="grid_16" id="content">
   <div class="grid_9">
<h1 class="dashboard">Edit Jobs</h1>
    </div>
    <div class="clear">
    </div>
    <div class="lang">
    <h3>This is where you can edit the jobs/gigs if you need.</h3></div>
    <div class="clear">
    </div>
    <div id="portlets">
<?
$tbl_name="jobs";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;

	/*
	   First get total number of rows in data table.
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/

    $query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];

	/* Setup vars for query. */
	$targetpage = "editjobs.php"; 	//your file name  (the name of this file)
	$limit = 40; 								//how many items to show per page
	$page = $_GET['page'];
	if($page)
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

	/* Get data. */


    $sql = "select * from $tbl_name WHERE `approved` = 'yes' order by id desc LIMIT $start, $limit";
	$result = mysql_query($sql)or die(mysql_error());

	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1

	/*
		Now we apply our rules and draw the pagination object.
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1)
			$pagination.= "<a href=\"$targetpage?page=$prev\"> previous</a>";
		else
			$pagination.= "<span class=\"disabled\"> previous</span>";

		//pages
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";
				}
			}
		}

		//next button
		if ($page < $counter - 1)
			$pagination.= "<a href=\"$targetpage?page=$next\">next </a>";
		else
			$pagination.= "<span class=\"disabled\">next </span>";
		$pagination.= "</div>\n";
	}
$result = mysql_query($sql);
if(mysql_num_rows($result) > 0){

echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"box-table-a\">
<tr>
<th class=\"th-4\">Job</th>
<th class=\"th-2\">Username</th>
<th class=\"th-3\">Category</th>
<th class=\"th-4a\">Description</th>
<th class=\"th-5\">Keywords</th>
<th class=\"th-6\">Time Span</th>
<th class=\"th-7\">Postdate</th>
<th class=\"th-8\">Times Bought</th>
<th class=\"th-8\">Featured</th>
<th class=\"th-4\">Edit</th>
<th class=\"th-4\">Delete</th></tr>";
while($datas=mysql_fetch_array($result)){
echo "<tr>
<td class=\"td-4\">$datas[willdo]</td>
<td class=\"td-2\">$datas[username]</td>
<td class=\"td-3\">$datas[category]</td>
<td class=\"td-4a\">".$job_description=stripslashes(str_replace('\r\n', '<br>',($datas['job_description'])))."</td>
<td class=\"td-5\">$datas[keywords]</td>
<td class=\"td-6\">$datas[time_span]</td>
<td class=\"td-7\">$datas[postdate]</td>
<td class=\"td-8\">$datas[times_bought]</td>
<td class=\"td-8\">$datas[featured]</td>
<td class=\"td-4\"><a href='editjobs.php?act=editjob&id=$datas[id]'><img src=\"images/icons/edit.gif\" alt=\"edit\" title=\"Edit Job\"/></a></td>
<td class=\"td-4\"><form action=\"\" method=\"post\" name=\"myForm\"><input type=\"checkbox\" name=\"myCheckbox[]\" value=\"$datas[id]\" id=\"myCheckbox$datas[id]\"/></td></tr>";
}
echo "</table>";
?>
<div align="right"><input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', true);" value="Check all!">
&nbsp;
<input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', false);" value="Uncheck all!">
<input type="submit" name="delete" value="Delete Selected" onClick="return confirmSubmitt()"></form></div>
<? }else{
echo "<br /><br /><div class=\"dialog-box-information\">
<div class=\"dialog-left\">
<img src=\"images/icons/information.png\" class=\"dialog-ico\" alt=\"\"/>There are no Jobs to show!</div>
</div><br />";
} ?>
</div>

<?=$pagination?>

</div><!--| end col-left-780 |-->

<?} else{header( 'Location: index.php' ) ;}
 include("footer.php"); ob_flush(); ?>
