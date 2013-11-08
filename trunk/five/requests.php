<?PHP session_start(); 
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

ob_start();
if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}else{
include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - ".$_SESSION['userName']."s ".$lang['P_REQUESTS']."";
$siteurl = $row["site_url"];
$domain =  $row["domain"];
$fee = $row["fee"];
$featured_fee = $row["featured_fee"];
$price = $row["price"];
$min_balance = $row["min_balance"];
$site_email  = $row["site_email"];
$currency_symbol  = $row["currency_symbol"];
}include("header.php");
$username = $_SESSION['userName'];
if(isset($_POST['request'])){
$date_requested = date("j-n-Y");
$username=$_POST['username'];
$amount = intval($_POST['amount']);
$balance = $_POST['balance'];
$email = $_POST['email'];
if($_SESSION['userName']!=''.$username.''){
    header('Location: index.php');
}
if (!$amount > $balance) {
echo"<div class=\"clear2\"></div><div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" alt=\"\"/>".$lang['WITHDRAW_DENIED']."</div>
</div>
</div>";
include("side.php");
include("footer.php");
exit();
}
$query = sprintf("INSERT INTO payment_request (username, date_requested, amount,email)
            VALUES( '%s', '%s','%s','%s')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($date_requested),
            mysql_real_escape_string($amount),
            mysql_real_escape_string($email));
// run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
      else
            {
$time = date('r');
$to      = $site_email;
$subject = " ".$lang["PR_SUBJECT"]."";
$message = "".$lang["PR_EMAIL1"]." $username on $time\n ".$lang["PR_EMAIL2"].": $currency_symbol$amount\n";
$headers = 'From: noreply@'.$domain.'' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
mysql_query("UPDATE members SET balance=balance- '".$amount."' where username='$username'") or die(mysql_error());
if(!mysql_query)
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
echo "<div class=\"clear2\"></div><div class=\"dialog-box-success\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" alt=\"\"/>".$lang['THANK_YOU']." $username, ".$lang['REQUEST_SUB']."</div>
</div>";
}
}
?>
<div class="display"></div>
<div class="orders">
<div class="feedback">
<h2><?PHP echo $_SESSION['userName'];?>'s <?PHP echo $lang['P_REQUESTS']?></h2>
<?PHP  echo "<p>".$lang['YOUR_REQUESTS']."</p>";
 $query = "SELECT COUNT(*) as num FROM payment_request WHERE `username` = '".$username."'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	/* Setup vars for query. */
	$targetpage = "orders"; 	//your file name  (the name of this file)
	$limit = 40; 								//how many items to show per page
	$page = $_GET['page'];
	if($page)
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;


$sql = "select * from payment_request WHERE `username` = '".$username."' order by id desc LIMIT $start, $limit";
$rec = mysql_query($sql) or die(mysql_error());
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

echo "<table class=\"sortable\" id=\"tb-1\" width=\"100%\">
<tr>
<th class=\"th-1\">ID</th>
<th class=\"th-4\">".$lang['AMOUNT']."</th>
<th class=\"th-1\">".$lang['ON']."</th>
<th class=\"th-4\">".$lang['STATUS']."</th>";
while($datas=mysql_fetch_array($rec)){
echo "<tr>
<td class=\"td-1\">$datas[id]</td>
<td class=\"td-4\">$currency_symbol$datas[amount]</td>
<td class=\"td-1\">$datas[date_requested]</td>
<td class=\"td-1\">$datas[status]  $datas[date_paid]</td>

</tr>";
}
echo "</table>";
}else{
echo "<br /><div class=\"dialog-box-information\">
<div class=\"dialog-left\">
<img src=\"images/information.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['NO_REQUESTS']."</div>
</div><br />";
}
 ?>
</div></div>
<div class="pag"><?PHP echo $pagination?></div>
</div>
<?PHP include("side.php");
include("footer.php");
}
?>