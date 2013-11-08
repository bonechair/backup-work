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
$domain = mysql_real_escape_string($row["domain"]);
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
var agree=confirm("Do you wish to confirm the selected sales?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("Do you wish to delete the selected sale?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<!--| CONTENT/MID |-->
<div class="grid_16" id="content">
    <!--  TITLE START  -->
    <div class="grid_9">
    <h1 class="dashboard">Confirm Sales</h1>
    </div>
    <div class="clear">
    </div>
    <div id="portlets">
<?PHP
if($_POST['confirm']=="Confirm Selected"){
$seller_username = $_POST['seller_username'];
$buyer_username = $_POST['buyer_username'];
$job_id = $_POST['job_id'];
$willdo = $_POST['willdo'];
$confirm = $_REQUEST['confirm'];
$checkbox = $_REQUEST['myCheckbox'];
$count = count($_REQUEST['myCheckbox']);
if($confirm){
for($i=0;$i<$count;$i++){
$con_id = $checkbox[$i];
mysql_query("update jobs_sold set payment_confirmed='yes' where  id='$con_id'");
mysql_query("update jobs_bought set payment_confirmed='yes' where  id='$con_id'");

$Email = "SELECT email FROM members where `username` = '$buyer_username' ";
$e_result = mysql_query($Email)or die(mysql_error());
while($e_data=mysql_fetch_array($e_result)){
$email = $e_data['email'];
$time = date('r');
$body = <<<EOD
Hi $buyer_username\n
Your payment for job id: $job_id has been confirmed \n
Job Title: $willdo
EOD;
// send email
mail($email, "Job payment Confirmation", $body, "From: $domain\r\nReply-To: $email\r\nContent-Type: text/plain; charset=ISO-8859-1\r\nMIME-Version: 1.0");
}
$e_mail = "SELECT email FROM members where `username` = '$seller_username' ";
$se_result = mysql_query($e_mail)or die(mysql_error());
while($se_data=mysql_fetch_array($se_result)){
$s_email = $se_data['email'];
$time = date('r');
$body = <<<EOD
Hi $seller_username\n
The payment for job id: $job_id has been confirmed \n
On: $time\n
Buyer Username: $buyer_username\n
Job Title: $willdo\n
You may now login to accept this job.
EOD;
// send email
mail($s_email, "Job payment Confirmation", $body, "From: $domain\r\nReply-To: $email\r\nContent-Type: text/plain; charset=ISO-8859-1\r\nMIME-Version: 1.0");

}
$result = mysql_query($sql);
}
}
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Record could not be confirmed</span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Confirmed Successfully</span></p>";
}
}
if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();
if ($act == "deletesale") {
$sql = "DELETE FROM jobs_sold where  id='$id' " or die(mysql_error());
$result = mysql_query($sql);
}if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Sale could not be deleted
</span>
</p><META HTTP-EQUIV = 'Refresh' Content = '0; URL =confirm_sales.php'>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Sale was deleted succssfully
</span>
</p><META HTTP-EQUIV = 'Refresh' Content = '0; URL =confirm_sales.php'>";
}
}
?>
<h3>This is where you verify any payments for jobs. Only click 'confirm' once the respective payment has cleared into your paypal account!</h3><br /><br />

<h2>Confirm Payment</h2>

<?
$tbl_name="jobs_sold";		//your table name
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
	$targetpage = "confirm_sales.php"; 	//your file name  (the name of this file)
	$limit = 40; 								//how many items to show per page
	$page = $_GET['page'];
	if($page)
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

	/* Get data. */


    $sql = "SELECT * FROM $tbl_name where `payment_confirmed` = 'no' order by id desc LIMIT $start, $limit";
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
<th class=\"th-1\">ID</th>
<th class=\"th-2\">Username</th>
<th class=\"th-3\">Job</th>
<th class=\"th-4\">Postdate</th>
<th class=\"th-1\">Delete</th>
<th class=\"th-1\">Confirm</th></tr>";
while($datas=mysql_fetch_array($result)){
echo "<tr>
<td class=\"td-1\">$datas[job_id]</td>
<td class=\"td-2\">$datas[username]</td>
<td class=\"td-3\">$datas[willdo]</td>
<td class=\"td-4\">$datas[date]</td>
<td class=\"td-1\"><a href='confirm_sales.php?act=deletesale&id=$datas[id]'><img src=\"images/icons/action_delete.gif\" class=\"tb-1-action-edit\" alt=\"delete\" title=\"Delete Sale\"onClick=\"return confirmSubmit()\"/></a></td>
<td class=\"td-1\"><form action=\"\" method=\"post\" name=\"myForm\"><input type=\"checkbox\" name=\"myCheckbox[]\" value=\"$datas[id]\" id=\"myCheckbox$datas[id]\"/></td></tr>";
$username = $datas['username'];
$buyer_username = $datas['buyer_username'];
$job_id = $datas['job_id'];
$willdo = $datas['willdo'];
}
echo "</table>"; ?>
<div align="right"><input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', true);" value="Check all!">
&nbsp;
<input type="button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', false);" value="Uncheck all!">
<input type="hidden" name="seller_username" value="<?php echo $username ?>">
<input type="hidden" name="buyer_username" value="<?php echo $buyer_username ?>">
<input type="hidden" name="job_id" value="<?php echo $job_id ?>">
<input type="hidden" name="willdo" value="<?php echo $willdo ?>">
<input type="submit" name="confirm" value="Confirm Selected" onClick="return confirmSubmitt()"></form></div>
<?}else{
echo '<p class="info" id="info"><span class="info_inner">There are no sales awaiting payment confirmation!</span></p>';
}

?>
</div>

<?=$pagination?>
</div><!--| end col-left-780 |-->

<?} else{header( 'Location: index.php' ) ;}
 include("footer.php"); ob_flush(); ?>