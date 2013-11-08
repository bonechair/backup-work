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

  include("connect.php");
if ($_SERVER['REQUEST_METHOD'] != 'POST') exit;
if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}else{

include("header.php");
$ppemail = $_POST['ppemail'];
$willdo = $_POST['willdo'];
$username = $_POST['username'];
$user = $_POST['user'];
$id = $_POST['id'];
$willdo = stripslashes(nl2br($willdo));
$willdo = htmlentities($willdo, ENT_QUOTES);
$buyer_email = $_POST['buyer_email'];
$price = $_POST['price'];
$postdate = date("j, n, Y");
$myresult = mysql_query("SELECT * FROM members where username = '".mysql_escape_string($user)."'");
while($mydata = mysql_fetch_array($myresult)){
$seller_email = $mydata['email'];
}
$result = mysql_query("SELECT * FROM sitesettings");
while($data = mysql_fetch_array($result)){
$site_url = $data['site_url'];
$domain = $data['domain'];
$currency_symbol = $data['currency_symbol'];
$currency = $data['currency'];
?>
<div id="buy_now"><div class="buy_now">
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
function confirmSubmitt()
{
var agree=confirm("<?PHP echo $lang['NO_FUNDS']?>.");
if (agree)
	return true ;
else
	return false ;
}
/*]]>*/
</script>
<center>
<p><?PHP echo $lang["THANKS_FOR_BUY"]?> <?PHP echo $lang["CHOOSE_OPTIONS"]?>.</p>
<table>
<tr>
<td align="center">
<div class="clear"></div>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_cart">
<input type="hidden" name="business" value="<?PHP echo $ppemail?>">
<input type="hidden" name="item_name" value="<?PHP echo $willdo?>">
<input type="hidden" name="item_number" value="<?PHP echo $id ?>">
<input type="hidden" name="no_shipping" value="1">
<input type="hidden" name="return" value="<?PHP echo $site_url ?>">
<input type="hidden" name="cancel_return" value="<?PHP echo $site_url ?>">
<input type="hidden" name="notify_url" value="<?PHP echo $site_url ?>/pp_ipn.php">
<input type="hidden" name="add" value="1">
<input type="hidden" name="rm" value="2">
<input type="hidden" name="no_note" value="1">
<input type="hidden" name="currency_code" value="<?PHP echo $currency ?>">
<input type="hidden" name="on1"  value="<?PHP echo $username?>">
<input type="hidden" name="on0" value="<?PHP echo $user ?>">
<input type="hidden" name="custom" value="<?PHP echo $seller_email ?>">
<input type="hidden" name="os1" value="<?PHP echo $postdate ?>">
<input type="hidden" name="amount" value="<?PHP echo $price ?>">
<input type="image" src="images/paypal.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">
</form>
</td>
<td align="center"><div class="clear"></div>
<?PHP $rs_settings = mysql_query("select * from members where userName='".mysql_escape_string($_SESSION[userName])."'");
while ($row_settings = mysql_fetch_array($rs_settings)) {
$balance = mysql_real_escape_string($row_settings['balance']);
}
if(($balance) > $price OR ($balance) == $price) {
echo '<form action="use_balance#use_balance" method="post" class="nyroModal">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="balance" value="'.$balance.'">
<input type="hidden" name="postdate" value="'.$postdate.'">
<input type="hidden" name="price" value="'.$price.'">
<input type="hidden" name="job" value="'.$willdo.'">
<input type="hidden" name="seller_id" value="'.$user.'">
<input type="hidden" name="buyer_id" value="'.$username.'">
<input type="hidden" name="seller_email" value="'.$seller_email.'">
<input type="submit" class="Button" value="'.$lang["USE_FROM_BAL"].' '.$currency_symbol.''.$balance.'"></form>';
}else{ ?>
<input type="submit" class="Button" value="Use my balance" onClick="return confirmSubmitt()"/>
<?PHP }
?>
</td>
</tr>
</table></center>
<a class="nyroModalClose" href="#">Close Window</a>
</div></div>
<?PHP
}
}
?>