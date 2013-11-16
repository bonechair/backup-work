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
var agree=confirm("Do you wish to delete the selected users?");
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
    <h1 class="dashboard">Search Members</h1>
    </div>
    <div class="clear">
    </div>
    <div id="portlets">
<?PHP
echo "<form method=\"post\" action=\"\" style=\"margin:auto;\">
<input type=\"text\" name=\"searchterm\"  id=\"search\" class=\"largeInput\"  value=\"".$_POST['searchterm']."\" maxlength=\"25\"/>
<input class=\"submit\" type=\"submit\" name=\"search\"  value=\"Search\"/> Use this to search by email,id or username
</form>";
if(isset($_POST['submit']) || isset($_POST['searchterm']) || isset($_GET['searchterm'])) //if user pressed search
{

if(isset($_GET['searchterm'])) $searchterm = mysql_real_escape_string($_GET['searchterm']);

    $searchterm = mysql_real_escape_string($_POST['searchterm']);
    $sql = "SELECT * FROM members where  username LIKE '%$searchterm%' OR id LIKE '%$searchterm%' OR email LIKE '%$searchterm%' and  status = 'activated' ";
	$result = mysql_query($sql)or die(mysql_error());

if(mysql_num_rows($result) > 0){
echo "<br /><h3>Search Results</h3></br>
<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"box-table-a\">
<tr>
<th class=\"th-1\">ID</th>
<th class=\"th-2\">Username</th>
<th class=\"th-3\">Full Name </th>
<th class=\"th-4\">Email</th>
<th class=\"th-4\">Paypal Email</th>
<th class=\"th-5\">Ip</th>
<th class=\"th-6\">Status </th>
<th class=\"th-7\">Join Date </th>
<th class=\"th-7\">Banned </th>
<th class=\"th-8\">Edit</th>
<th class=\"th-8\">Delete</th></tr>";
while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
echo "<tr>
<td class=\"td-1\">$row[id]</td>
<td class=\"td-2\">$row[username]</td>
<td class=\"td-3\">$row[full_name]</td>
<td class=\"td-4\">$row[email]</td>
<td class=\"td-4\">$row[ppemail]</td>
<td class=\"td-5\">$row[ip]</td>
<td class=\"td-6\">$row[status]</td>
<td class=\"td-7\">$row[joined]</td>
<td class=\"td-7\">$row[isbanned]</td>
<td class=\"td-8\"><a href='view_users.php?act=edituser&id=$row[id]'><img src=\"images/icons/edit.gif\" alt=\"edit\" title=\"Edit Record\"/></a></td>
<td class=\"td-8\"><a href='no-view_users.php?act=deluser&id=$row[id]'  onclick=\"return confirm('Are you sure?')\"><img src=\"images/icons/action_delete.gif\" alt=\"edit\" title=\"Delete Record\"/></a></td></tr>";
}
echo "</table>";
}else{
echo '<p class="info" id="info"><span class="info_inner">There are no users to show!</span></p>';
}
}
?>
<hr></div></div>
<?

$Query = mysql_query("SELECT * FROM members where activationkey != ''") or die(mysql_error());
$memact = mysql_num_rows($Query);
if ($memact > 0)
{ ?>
<div class="grid_16" id="content">
   <div class="grid_9">
    <h1 class="dashboard">Activate Members</h1>
    </div>
    <div class="clear">
    </div>
    <div id="portlets">
<p>The members below have registered but have not activated their accounts.</p>
<?
$sql1 = "SELECT * FROM members where activationkey != ''" or die(mysql_error());
$result = mysql_query($sql1)or die(mysql_error());
echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"box-table-a\">
<tr>
<th class=\"th-1\">ID</th>
<th class=\"th-2\">Username</th>
<th class=\"th-4\">Email</th>
<th class=\"th-5\">Ip</th>
<th class=\"th-6\">Status </th>
<th class=\"th-6\">Activation Key </th>
<th class=\"th-8\" colspan=\"2\">Activate</th>";
while($row = mysql_fetch_array($result)){
$Username =  $row['username'];
echo "<tr>
<td class=\"td-1\">$row[id]</td>
<td class=\"td-2\">$row[username]</td>
<td class=\"td-4\">$row[email]</td>
<td class=\"td-5\">$row[ip]</td>
<td class=\"td-6\">$row[status]</td>
<td class=\"td-6\">$row[activationkey]</td>
<td class=\"td-8\"><a href='view_users.php?act=activate_user&id=$row[id]'><img src=\"images/icons/action_check.gif\" alt=\"activate\" title=\"Activate User\"/></a></td>
</td></tr>";
}
echo "</table>";
?>
</div></div>
<? }
if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();

if ($act == "deluser") {
$sql5 = mysql_query("SELECT * FROM members where id = '$id'") or die(mysql_error());
$myrow = mysql_fetch_array($sql5);
$username = $myrow['username'];

$query = "DELETE FROM jobs WHERE username = ('$username')";
$result = mysql_query($query);


$sql = "DELETE FROM members where  id='".$id."' " or die(mysql_error());
$result = mysql_query($sql);

if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">User could not be deleted</span></p>";
}else{ header( 'Location: view_users.php' ) ;
}
}

if ($act == "activate_user") {
$sql="UPDATE members SET activationkey = '', status='activated' WHERE (id = $id)";
       $urlf = '../users/' . strtolower($Username);
       $indexfi = '../users/index.php';
       $avatar = '../users/default.png';
       mkdir($urlf,0777);
       chmod($urlf,0777);
       copy("../users/admin/index.php",$urlf."/index.php");
       copy($avatar,$urlf."/default.png");
       chmod($urlf,0755);
       echo "<META HTTP-EQUIV = 'Refresh' Content = '3; URL =view_users.php'>";


       if (!mysql_query($sql))
{
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">User could not be activated</span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">User activated Successfully</span></p>";
}
}

if ($act == "edituser") {



?>
<div class="grid_16" id="content">
   <div class="grid_9">
    <h1 class="dashboard">Edit Members Details</h1>
    </div>
    <div class="clear">
    </div>
    <div id="portlets"><div class="column" id="left">
<?PHP
if (isset($_POST["submitedit"])) {
$fbid=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['fbid']));
$username=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['username']));
$email=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['email']));
$ppemail=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['ppemail']));
$full_name=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['full_name']));
$country=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['country']));
$ip=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['ip']));
$status=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['status']));
$isbanned=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['isbanned']));
$balance=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['balance']));
$edit1 = "UPDATE members SET fbid='$fbid' WHERE id = '$id'";
mysql_query($edit1) or die("could not edit");
$edit2 = "UPDATE members SET username='$username' WHERE id = '$id'";
mysql_query($edit2) or die("could not edit");
$edit3 = "UPDATE members SET email='$email' WHERE id = '$id'";
mysql_query($edit3) or die("could not edit");
$edit3 = "UPDATE members SET ppemail='$ppemail' WHERE id = '$id'";
mysql_query($edit3) or die("could not edit");
$edit5 = "UPDATE members SET full_name='$full_name' WHERE id = '$id'";
mysql_query($edit5) or die("could not edit");
$edit6 = "UPDATE members SET country='$country' WHERE id = '$id'";
mysql_query($edit6) or die("could not edit");
$edit7 = "UPDATE members SET ip='$ip' WHERE id = '$id'";
mysql_query($edit7) or die("could not edit");
$edit8 = "UPDATE members SET status='$status' WHERE id = '$id'";
mysql_query($edit8) or die("could not edit");
$edit9 = "UPDATE members SET balance='$balance' WHERE id = '$id'";
mysql_query($edit9) or die("could not edit");
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">User could not be edited</span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">User edited Successfully</span></p>";
}
}
$rec = mysql_query("SELECT * FROM members where id = '$id'") or die(mysql_error());
$datas = mysql_fetch_array($rec); ?>
<div class="portlet">
		<div class="portlet-header">Edit Details</div>
		<div class="portlet-content">
<form action='' method='post'>
                <input type="hidden" name="id" value="<?php echo $id?>" >

                <label>Facebook ID:</label><input name='fbid' type='text' class="largeInput" value='<?php echo $datas[fbid]?>' />

                <label>Username:</label><input name='username' type='text' class="largeInput" value='<?php echo $datas[username]?>' />

                <label>Email:</label><input name='email' type='text' class="largeInput" value='<?php echo $datas[email]?>' />

                <label>Paypal Email:</label><input name='ppemail' type='text' class="largeInput"value='<?php echo $datas[ppemail]?>' />

                <label>Join Date: <b><?php echo $datas[joined]?></b></label>

                <label>Full Name:</label><input name='full_name' type='text' class="largeInput" value='<?php echo $datas[full_name]?>' />

                <label>Country:</label><input name='country' type='text' class="largeInput" value='<?php echo $datas[country]?>' />

                <label>IP:</label><input name='ip' type='text' class="largeInput" value='<?php echo $datas[ip]?>' />

                <label>Status:</label><input name='status' type='text' class="largeInput" value='<?php echo $datas[status]?>' />

                <label>Banned: <b><?php echo $datas[isbanned]?></b></label>

<?

$balance = $datas['balance']; ?>

                <label>Balance: <?PHP echo $currency ?></label><input name='balance' type='text' class="smallInput" value='<?php echo $balance?>' />

                <p>&nbsp;</p><input type='submit' name='submitedit' value='Update User' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' name='submit' value='Reset Form' />

</form></div></div></div></div></div>
<? $result = mysql_query("SELECT * FROM sitesettings");
while($my_row = mysql_fetch_array($result))
{
$siteurl = $my_row['site_url'];
}
?>
<div class="grid_16" id="content">
   <div class="grid_9">
    <h1 class="dashboard">Check Members IP Address</h1>
    </div>
    <div class="clear">
    </div>
    <div id="portlets">
    <div class="column" id="left">
    <div class="portlet">
		<div class="portlet-header">Check ip Details</div>
		<div class="portlet-content">
<form method="post" action="">

<label>Check IP:</label><input type="text" class="smallInput" name="checkip" value="<? echo $datas['ip']; ?>">
<input name="ip" type="hidden" id="ip" value="<? echo $datas['ip']; ?>">
<input type="submit" name="check" value="Check it!">
<?
if($datas['isbanned'] == 'No'){
echo '<input name="banip" type="submit" id="banip" value="Ban It!!">';
}else{ echo '<input name="unbanip" type="submit" id="unbanip" value="Unban This IP!!">';
}?>

</form>
<?
if($_POST['check']=='Check it!')include('ip_information.php');
if($_POST['banip'] == 'Ban It!!')
{
function filter($arr) {
return array_map('mysql_real_escape_string', $arr);
}
mysql_query("UPDATE members SET `isbanned` = 'Yes' where id= '$id'") or die(mysql_error());
header( 'Location: view_users.php?act=edituser&id='.$id.'' ) ;
 }
if($_POST['unbanip'] == 'Unban This IP!!')
{
function filter($arr) {
return array_map('mysql_real_escape_string', $arr);
}
mysql_query("UPDATE members SET `isbanned` = 'No' where id= '$id'") or die(mysql_error());
header( 'Location: view_users.php?act=edituser&id='.$id.'' ) ;
}
}

?>
</div>
</div></div></div></div>
<?
}
?>
<div class="grid_16" id="content">
   <div class="grid_9">

    </div>
    <div class="lang">
    <h1 class="dashboard">Users Admin</h1>
    <h3>This is where you can check and edit your site members details.<br />Use the search form above to search for a particular user by email,id or username. <br />
    Click the "pencil" icon to edit a members details and click the "red cross" icon to PERMANENTLY delete a user.</h3></div>
    <div class="clear">
    </div>
    <div id="portlets">
<?

$tbl_name="members";		//your table name
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
	$targetpage = "view_users.php"; 	//your file name  (the name of this file)
	$limit = 40; 								//how many items to show per page
	$page = $_GET['page'];
	if($page)
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0

	/* Get data. */


    $sql = "SELECT * FROM $tbl_name where status = 'activated' order by id desc LIMIT $start, $limit";
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
<th class=\"th-3\">Full Name </th>
<th class=\"th-4\">Email</th>
<th class=\"th-4\">Paypal Email</th>
<th class=\"th-5\">Ip</th>
<th class=\"th-6\">Status </th>
<th class=\"th-7\">Join Date </th>
<th class=\"th-7\">Banned </th>
<th class=\"th-8\">Edit</th>
<th class=\"th-8\">Delete</th></tr>";
while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
echo "<tr>
<td class=\"td-1\">$row[id]</td>
<td class=\"td-2\">$row[username]</td>
<td class=\"td-3\">$row[full_name]</td>
<td class=\"td-4\">$row[email]</td>
<td class=\"td-4\">$row[ppemail]</td>
<td class=\"td-5\">$row[ip]</td>
<td class=\"td-6\">$row[status]</td>
<td class=\"td-7\">$row[joined]</td>
<td class=\"td-7\">$row[isbanned]</td>
<td class=\"td-8\"><a href='view_users.php?act=edituser&id=$row[id]'><img src=\"images/icons/edit.gif\" alt=\"edit\" title=\"Edit Record\"/></a></td>
<td class=\"td-8\"><a href='no-view_users.php?act=deluser&id=$row[id]' onclick=\"return confirm('Are you sure?')\"><img src=\"images/icons/action_delete.gif\" alt=\"edit\" title=\"Delete Record\"/></a></td></tr>";
}
echo "</table>"; ?>

<?}else{
echo '<p class="info" id="info"><span class="info_inner">There are no users to show!</span></p>';
}

?>
</div>
<div align="center"><?=$pagination?></div>
</div><!--| end col-left-780 |-->
<? } else{header( 'Location: index.php' ) ;}
 include("footer.php"); ob_flush(); ?>