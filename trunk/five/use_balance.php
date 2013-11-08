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


if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}else{
include("connect.php");
if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;
$id = $_POST['id'];
$balance = $_POST['balance'];
$price = $_POST['price'];
$job = $_POST['job'];
$job = stripslashes(nl2br($job));
$seller_id = $_POST['seller_id'];
$buyer_id = $_POST['buyer_id'];
$seller_email = $_POST['seller_email'];
$buyer_email = $_POST['buyer_email'];
$date = date("j, n, Y");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - Buy ".$job." with your balance";
$site_email = $row['site_email'];
$domain = $row['domain'];
$currency_symbol =  $row["currency_symbol"];
}
include("header.php");?>
<div id="use_balance"><div class="use_balance">
<?PHP
echo "<h3>".$lang['JOB'].": $job</h3>
<h3>".$lang['FROM_SELLER'].": $seller_id</h3>
<h3>".$lang['JOB_PRICE'].": $currency_symbol$price</h3>
<h3>".$lang['FROM_BALANCE'].": $currency_symbol$balance</h3>";?>
<form action="bal_pay" method="post" >
<input type="hidden" name="id" value="<? echo $id?>">
<input type="hidden" name="balance" value="<? echo $balance?>">
<input type="hidden" name="postdate" value="<? echo $date?>">
<input type="hidden" name="price" value="<? echo $price?>">
<input type="hidden" name="job" value="<? echo $job?>">
<input type="hidden" name="seller_id" value="<? echo $seller_id?>">
<input type="hidden" name="buyer_id" value="<? echo $buyer_id?>">
<input type="hidden" name="seller_email" value="<? echo $seller_email?>">
<input type="submit" name="submit" class="Button" value="<?PHP echo $lang['CONF_PAYMENT']?>"></form>
</div>
</div>
<?PHP }?>