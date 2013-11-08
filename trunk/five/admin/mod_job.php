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
if(!empty($_SESSION['user_name'])) {
include("header.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$autotweet =  $row["tweet"];
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
var agree=confirm("Do you wish to Approve the selected jobs?");
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
    <h1 class="dashboard">Moderate Jobs</h1>
    </div>

    <div class="clear">
    </div>
    <div id="portlets">
<?PHP
if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();
if ($act == "approve") {
$sql = "UPDATE jobs set approved='yes' where  id='$id' " or die(mysql_error());
$result = mysql_query($sql);

$sql = "SELECT * FROM jobs WHERE `id` = '$id' ";
$rs = mysql_query($sql)or die(mysql_error());
while($row = mysql_fetch_assoc($rs)) {
$id = $row['id'];
$title = $row['willdo'];
$username = $row['username'];
$p_desc = str_replace('<br />', ' ', ($row['part_description']));
// seo_link_pv function below is in functions/general.php - change that function if you want to change how seo urls are formatted
$seo=seo_link_pv($row['willdo']);
}
$willdo = ''.$siteurl.'/'.$seo.'-'.$id.'.html';
if($autotweet == 'yes') {

function TinyURL($u){
return file_get_contents('http://tinyurl.com/api-create.php?url='.$u);
}
$url = $willdo;
$tiny = TinyURL($url);
require_once('../twitter/twitteroauth.php');
$tweet = new TwitterOAuth($consumer_key, $consumer_secret, $oAuthToken, $oAuthSecret);
$tweet->post('statuses/update', array('status' => 'New job: '.$tiny.'&nbsp;&nbsp;'.$p_desc.''));

}
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Job could not be approved</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '1; URL =mod_job.php'>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Job was approved successfuly</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '1; URL =mod_job.php'>";
}
$sql1 = "SELECT * FROM members WHERE `username` = '$username' ";
$rs1 = mysql_query($sql1)or die(mysql_error());
while($row1 = mysql_fetch_assoc($rs1)) {
$email = $row1['email'];
}
$to      = $email;
$subject = "Job Approved!";
$message = "Hi $username\n\n\nYour job $title has been approved and is now live on $domain\n\nYour job can be found here: $willdo\n\nThanks for using $domain\n\nRegards the $domain team!\n\n\n\nPlease do not reply to this email.";
$headers = 'From: noreply@'.$domain.'' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
}
if ($act == "deletejob") {
$sql3 = "SELECT * FROM jobs WHERE `id` = '$id' ";
$rs3 = mysql_query($sql3)or die(mysql_error());
while($row3 = mysql_fetch_assoc($rs3)) {
$username = $row3['username'];
}


$sql = "DELETE FROM jobs where  id='$id' " or die(mysql_error());
$result = mysql_query($sql);
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Job could not be deleted</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '1; URL =mod_job.php'>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Job was deleted succssfully
</span></p><META HTTP-EQUIV = 'Refresh' Content = '1; URL =mod_job.php'>";
}
$sql2 = "SELECT * FROM members WHERE `username` = '$username' ";
$rs2 = mysql_query($sql2)or die(mysql_error());
while($row2 = mysql_fetch_assoc($rs2)) {
$email2 = $row2['email'];
}
$to      = $email2;
$subject = "Job Rejected!";
$message = "Hi $username\n\n\nUnfortunately your job $title did not meet our high standards and was rejected on $domain\n\nThanks for using $domain\n\nRegards the $domain team!\n\n\n\nPlease do not reply to this email.";
$headers = 'From: noreply@'.$domain.'' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
}
}
?>
</div>

    <!--  TITLE END  -->
    <!-- #PORTLETS START -->
    <div id="portlets">
<h3>This is where you approve or reject jobs that are submitted</h3>
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
	$targetpage = "mod_job.php"; 	//your file name  (the name of this file)
	$limit = 40; 								//how many items to show per page
	$page = $_GET['page'];
	if($page)
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

	/* Get data. */


    $sql = "select * from $tbl_name WHERE `approved` = 'no' order by id asc LIMIT $start, $limit";
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
<th class=\"th-4\">Reject and Delete</th>
<th class=\"th-4\">Approve</th></tr>";
while($datas=mysql_fetch_array($result)){
echo "<tr>
<td class=\"td-4\">$datas[willdo]</td>
<td class=\"td-2\">$datas[username]</td>
<td class=\"td-3\">$datas[category]</td>
<td class=\"td-4a\">$datas[job_description]</td>
<td class=\"td-5\">$datas[keywords]</td>
<td class=\"td-6\">$datas[time_span]</td>
<td class=\"th-7\">$datas[postdate]</td>
<td class=\"th-8\">$datas[times_bought]</td>
<td class=\"td-4\"><a href='mod_job.php?act=deletejob&id=$datas[id]'><img src=\"images/icons/action_delete.gif\" class=\"tb-1-action-edit\" alt=\"delete\" title=\"Reject and delete Job\"/></a></td>
<td class=\"td-4\"><a href='mod_job.php?act=approve&id=$datas[id]'><img src=\"images/icons/action_check.gif\" class=\"tb-1-action-edit\" alt=\"Approve Job\" title=\"Approve and post to twitter\"/></a></td></tr>";
}
echo "</table>";
?>
<!--<div align="right"><input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', true);" value="Check all!">
&nbsp;
<input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', false);" value="Uncheck all!">
<input type="submit" name="approve" value="Approve Selected" onClick="return confirmSubmitt()"></form></div>-->
<? }else{
echo '<p class="info" id="info"><span class="info_inner">There are no Jobs to show!</span></p>';
} ?>
</div>
<div align="center"><?=$pagination?></div>
</div><!--| end container |-->
<?} else{header( 'Location: index.php' ) ;}
 include("footer.php"); ob_flush(); ?>