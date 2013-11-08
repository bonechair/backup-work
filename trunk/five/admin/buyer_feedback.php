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
$page = 'feedback';
if(!empty($_SESSION['user_name'])) {
  include("header.php"); ?>
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
var agree=confirm("Do you wish to delete the selected feedback?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<!--| CONTENT/MID |-->
<div class="grid_16" id="content">
    <div class="clear">
    </div>
    <div id="portlets">
<? if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();
if ($act == "editcom") {
?>
<div class="grid_9">
    <h1 class="dashboard">Edit Buyer Feedback</h1>
    </div><div class="clear">
    </div><div id="portlets">
<?
$id = mysql_real_escape_string($_GET['id']);
$rec = mysql_query("SELECT * FROM buyer_feedback where id = '$id'") or die(mysql_error());
$dats = mysql_fetch_array($rec);
echo "<form method='post' action=''>
	<input type='hidden' name='id' value='$id'>
	<textarea name=\"text\" class=\"smallInput wide\" rows=\"5\" cols=\"20\" >".$text = stripslashes($dats['text'])."</textarea>
    <input type = 'submit' name='submitedit' value='Update Feedback'></td>
	</form></div>";
}
?>

<? if (isset($_POST["submitedit"])) {
$text=addslashes(str_replace('\r\n', '<br>',$_POST['text']));
$query = sprintf("UPDATE buyer_feedback SET text='$text' WHERE id = '$id'");
if(!mysql_query($query)) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Feedback could not be edited</span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Feedback edited successfully!</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '0; URL =buyer_feedback.php'>";
}
}
}
if($_POST['delete']=="Delete Selected"){
$delete = $_REQUEST['delete'];
$checkbox = $_REQUEST['myCheckbox'];
$count = count($_REQUEST['myCheckbox']);
if($delete){
for($i=0;$i<$count;$i++){
$del_id = $checkbox[$i];
$sql = "DELETE FROM buyer_feedback where  id='$del_id' " or die(mysql_error());
$result = mysql_query($sql);
}
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Feedback could not be deleted</span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Feedback deleted successfully!</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '1; URL =buyer_feedback.php'>";
}
}


?>
</div>
<div class="grid_9">

    </div>
  <div class="lang">
    <h1 class="dashboard">Buyers Feedback</h1>
    <h3>This is where you can see all the feedback left by members that have purchased jobs.</h3></div>
<div class="clear">
    </div>
    <!--  TITLE END  -->
    <!-- #PORTLETS START -->
    <div id="portlets">
<?PHP
$tbl_name="buyer_feedback";		//your table name
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
	$targetpage = "buyer_feedback.php"; 	//your file name  (the name of this file)
	$limit = 40; 								//how many items to show per page
	$page = $_GET['page'];
	if($page)
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

	/* Get data. */


    $sql = "SELECT * FROM $tbl_name order by id desc LIMIT $start, $limit";
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
<th class=\"th-1\">Job ID</th>
<th class=\"th-2\">Username</th>
<th class=\"th-3\">Feedback</th>
<th class=\"th-8\">Edit</th>
<th class=\"th-8\">Delete</th></tr>";
while($datas=mysql_fetch_array($result)){
echo "<tr>
<td class=\"td-1\">$datas[job_id]</td>
<td class=\"td-2\">$datas[username]</td>
<td class=\"td-3\">$datas[text]</td>
<td class=\"td-8\"><a href='buyer_feedback.php?act=editcom&id=$datas[id]'><img src=\"images/icons/edit.gif\" alt=\"edit\" title=\"Edit Feedback\"/></a></td>
<td class=\"td-8\"><form action=\"\" method=\"post\" name=\"myForm\"><input type=\"checkbox\" name=\"myCheckbox[]\" value=\"$datas[id]\" id=\"myCheckbox$datas[id]\"/></td></tr>";
}
echo "</table>"; ?>
<div align="right"><input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', true);" value="Check all!">
&nbsp;
<input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', false);" value="Uncheck all!">
<input type="submit" name="delete" value="Delete Selected" onClick="return confirmSubmitt()"></form></div>
<?}else{
echo '<p class="info" id="info"><span class="info_inner">There is no feedback to show!</span></p>';
}
?>
</div>
<div align="center"><?=$pagination?></div>
</div><!--| end container |-->
<?} else{header( 'Location: index.php' ) ;}
 include("footer.php"); ob_flush(); ?>