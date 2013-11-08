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
var agree=confirm("Are you sure you want to permanantly delete this record?");
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
<h1 class="dashboard">Payment Requests</h1>
    </div>
    <div class="clear">
    </div>
<div class="lang">
    
    <h3>This is where you can see all the payment requests made by your site members.<br />Use the Paypal button to pay the members request,
    when you return from the paypal payment page make sure to click the "update" button to mark the request as Paid.</h3></div>
    <div class="clear">
    </div>
    <div id="portlets">

<?
$my_result = mysql_query("SELECT * FROM sitesettings");
while($setts = mysql_fetch_array($my_result))
{
$currency_symbol = $setts['currency_symbol'];
$currency = $setts['currency'];
$siteurl = $setts['site_url'];
$domain = $setts['domain'];
}

$tbl_name="payment_request";		//your table name
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
	$targetpage = "payment_requests.php"; 	//your file name  (the name of this file)
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
?>

<h3>The members below have requested payment.</h3>

<?echo "<table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" id=\"box-table-a\">
<tr>
<th class=\"th-1\">ID</th>
<th class=\"th-2\">Username</th>
<th class=\"th-3\">Amount Requested</th>
<th class=\"th-3\">Paypal Email</th>
<th class=\"th-1\">Status</th>
<th class=\"th-3\">Pay Member with Paypal</th>
<th class=\"th-3\">Update Status/Delete</th></tr>";
while($mem_row = mysql_fetch_array($result, MYSQL_ASSOC)){
echo "<tr>
<td class=\"td-1\">$mem_row[id]</td>
<td class=\"td-2\">$mem_row[username]</td>
<td class=\"td-3\">$currency_symbol$mem_row[amount]</td>
<td class=\"td-3\">$mem_row[email]</td>
<td class=\"td-1\">$mem_row[status]</td>
<td class=\"td-8\">";
$email = $mem_row['email'];
$amount = $mem_row['amount'];
$username = $mem_row['username'];
if ($mem_row['status'] == 'unpaid'){?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="<?php echo $email?>">
<input type="hidden" name="item_name" value="Members Payment to user: <?php echo $mem_row['username']?> on <?php echo $siteurl?>">
<input type="hidden" name="item_number" value="1">
<input type="hidden" name="amount" value="<?PHP echo $amount?>">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="custom" value="<?PHP echo $currency_symbol ?>">
<input type="hidden" name="on1"  value="<?PHP echo $mem_row['username']?>">
<input type="hidden" name="on0"  value="<?PHP echo $mem_row['id']?>">
<input type="hidden" name="return" value="<?php echo $siteurl?>/admin/view_users.php">
<input type="hidden" name="cancel_return" value="<?php echo $siteurl?>/admin/view_users.php">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="<?PHP echo $currency ?>">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="bn" value="PP-BuyNowBF">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_paynow_LG.gif" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
<?PHP }elseif ($mem_row['status'] == 'paid'){
echo "Paid ~ ".$mem_row['date_paid']."";
}
echo "</td><td class=\"td-3\">";
$sql1 = "SELECT * FROM members WHERE `username` = '$username' ";
$rs1 = mysql_query($sql1)or die(mysql_error());
while($row1 = mysql_fetch_assoc($rs1)) {
$email1 = $row1['email'];
}
if (isset($_POST['send'])){
$date_paid = date("j-n-Y");
mysql_query("UPDATE payment_request SET status = 'paid', date_paid = '".$date_paid."' where id='".$_POST['id']."'") or die(mysql_error());
$to      = $email1;
$subject = "Payment Sent";
$message = "We have paid your amount requested $currency_symbol$amount into your paypal account\n\n\nThanks for using $domain\n\nRegards the $domain team!\n\n\n\nPlease do not reply to this email.";
$headers = 'From: noreply@'.$domain.'' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);


header( 'Location: payment_requests.php' ) ;
}
if ($mem_row['status'] == 'unpaid'){
?>
<form action="" method="post">
<input type="hidden" name="id" value="<?PHP echo $mem_row['id']?>">
<input type="submit" name="send" value="Update">
</form>
<?PHP }elseif ($mem_row['status'] == 'paid'){
echo "<form action=\"\" method=\"post\" name=\"myForm\"><input type=\"hidden\" name=\"id\" value=\"$mem_row[id]\"/><input type=\"submit\" name=\"delete\" value=\"Delete\" onClick=\"return confirmSubmitt()\"/></form>";
}
if($_POST['delete']=="Delete"){
$id = intval( $_POST['id']);
$sql1 = "DELETE FROM payment_request where  id='$id' " or die(mysql_error());
$result1 = mysql_query($sql1);
if(!mysql_query) {
echo "<p class=\"info\" id=\"error\"><span class=\"info_inner\">Record could not be deleted</span></p>";
}else{ echo "<p class=\"info\" id=\"success\"><span class=\"info_inner\">Deleted Successfully</span></p>
<META HTTP-EQUIV = 'Refresh' Content = '0; URL =payment_requests.php'>";
}
}
echo"</td></tr>";
}
echo "</table>"; ?>
<?}else{
echo '<p class="info" id="info"><span class="info_inner">There are no records to show!</span></p>';
}
?>
</div>
<div align="center"><?=$pagination?></div>
</div><!--| end col-left-780 |-->
<?} else{header( 'Location: index.php' ) ;}
 include("footer.php"); ob_flush(); ?>