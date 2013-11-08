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
$page_name = 'sales.php';
if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}else{
include("connect.php");
$ip = $_SERVER['REMOTE_ADDR'];
$username = $_SESSION['userName'];

$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - ".$username." My Sales";
$domain = mysql_real_escape_string($row["domain"]);
$price = mysql_real_escape_string($row["price"]);
$siteurl = mysql_real_escape_string($row["site_url"]);
$email = mysql_real_escape_string($row["site_email"]);
}
include("header.php");?>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmitt()
{
var agree=confirm("<?PHP echo $lang['DELETE_YES']?>?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<script LANGUAGE="JavaScript">
<!--
function confirmAcc()
{
var agree=confirm("<?PHP echo $lang['ACCEPT_YES']?>?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<script LANGUAGE="JavaScript">
<!--
function confirmRej()
{
var agree=confirm("<?PHP echo $lang['REJECT_YES']?>?");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<script LANGUAGE="JavaScript">
<!--
function confirmSub()
{
alert("<?PHP echo $lang['NOT_CONFIRMED']?>");
}
// -->
</script>
<div class="display"><?PHP echo $lang['SHOW']?>:<a href="sales_pending"><?PHP echo $lang['PEND_ACC']?></a> |
<a href="sales_ar"><?PHP echo $lang['WAIT_REVIEW']?></a> |
<a href="sales_completed"><?PHP echo $lang['COMPLETED']?></a> |
<a href="sales_rejected"><?PHP echo $lang['REJECTED']?></a>
</div><div class="clear"></div>
<div class="sales">
<h2><? echo $username ?>'s <?PHP echo $lang['SALES']?></h2>
<?PHP
$sql = "select * from jobs_sold WHERE `username` = '".mysql_real_escape_string($username)."' order by id desc";
$rec = mysql_query($sql) or die(mysql_error());
$result = mysql_query($sql);
if(mysql_num_rows($result) > 0){
echo "<table class=\"sortable\" id=\"tb-1\" width=\"100%\">
<tr>
<th class=\"th-1\">".$lang['JOB_ID']."</th>
<th class=\"th-4\">".$lang['JOB_TITLE']."</th>
<th class=\"th-6\">".$lang['BUYER']."</th>
<th class=\"th-6\">".$lang['ON']."</th>
<th class=\"th-4\" colspan=\"2\">Action</th></tr>";
while($datas=mysql_fetch_array($rec)){
echo "<tr>
<td class=\"td-1\">$datas[job_id]</td>
<td class=\"td-4\">$datas[willdo]</td>
<td class=\"td-6\">$datas[buyer_username]</td>
<td class=\"td-7\">$datas[date]</td>
<td class=\"td-4\"><a href='mysales.php?act=view&id=$datas[id]'>".$lang['VIEW_DETAILS']."</a></td></tr>";
$job_id= mysql_real_escape_string($datas['job_id']);
$id= mysql_real_escape_string($datas['id']);
$accepted = mysql_real_escape_string($datas['accepted']);
$confirmed = mysql_real_escape_string($datas['payment_confirmed']);
$buyer = mysql_real_escape_string($datas['buyer_username']);
$seller = mysql_real_escape_string($datas['seller_username']);
$completed = mysql_real_escape_string($datas['job_completed']);
$willdo = mysql_real_escape_string($datas['willdo']);
$date = mysql_real_escape_string($datas['date']);
}
echo "</table>";
}else{
echo "<br /><br /><div class=\"dialog-box-information\">
<div class=\"dialog-left\">
<img src=\"images/information.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['NO_SALES']."</div>
</div><br />";
}?>

<?PHP    
$id = $_POST['id'];
$subject = 'Job accepted-Job: '.$willdo.'';
$receiver_id = $buyer;
$message =  'Thank you for your order i will notify you when work is completed';
$filename = 'none';
$filepath = 'none';
$message_read = 'no';
if(isset($_POST['accept'])){
$query = sprintf("INSERT INTO messages_all (receiver_id, sender_id,subject,message,date)
            VALUES('%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($receiver_id),
            mysql_real_escape_string($username),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($message),
            mysql_real_escape_string($date));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_received (sender_id,receiver_id, subject,message,filename,filepath,date,message_read)
            VALUES( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($receiver_id),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($message),
            mysql_real_escape_string($filename),
            mysql_real_escape_string($filepath),
            mysql_real_escape_string($date),
            mysql_real_escape_string($message_read));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_sent (receiver_id, sender_id,subject,message,date)
            VALUES( '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($receiver_id),
            mysql_real_escape_string($username),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($message),
            mysql_real_escape_string($date));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
mysql_query("update jobs_sold set accepted = 'yes' where id = '$id'");
mysql_query("update jobs_bought set accepted = 'yes' where id = '$id'");

$to      = $buyer_email;
$subject = ''.$lang["ACC_SUBJECT"].' '.$willdo.'';
$message = "Hi! $receiver_id\n ".$lang["ACC_EMAIL1"]." $siteurl on $time\n ".$lang["ACC_EMAIL2"].": $username\n ".$lang["ACC_EMAIL3"]."\n
".$lang["ACC_EMAIL4"]."
".$lang["ACC_EMAIL5"]."
The $domain team.";
$headers = 'From: support@triplegood.co.za' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);

if(!mysql_query) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['JOB_NOT_ACC']."
</div>
<div class=\"dialog-right\">
<img src=\"images/error-delete.jpg\" class=\"del-x\" alt=\"\"/>
</div>
</div>";
}else{header( 'Location: sales.php' );
}
}
$myresult = mysql_query("SELECT * FROM members WHERE username = '$receiver_id'");
while($mailrow = mysql_fetch_array($myresult))
{
$mail_to = mysql_real_escape_string($mailrow["email"]);
}
$mycost = mysql_query("SELECT * FROM jobs WHERE id = '$job_id'");
while($row_cost = mysql_fetch_array($mycost))
{
$cost = mysql_real_escape_string($row_cost["job_cost"]);
}
if(isset($_POST['reject'])){
$reason = $_POST['reason'];
$to      = $mail_to;
$subject = "".$lang["RE_SUBJECT"]."";
$message = "Hi! $receiver_id\n ".$lang["REJECT_EMAIL1"]." $siteurl on $time\n From User: $username\n ".$lang["REJECT_EMAIL2"]." $reason\n
".$lang["REJECT_EMAIL3"]."
".$lang["REJECT_EMAIL4"]."
The $domain team.";
$headers = 'From: support@triplegood.co.za' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
$title = ''.$lang["RE_SUBJECT"].'';
$mess =  ''.$lang["REJECT_EMAIL2"].' '.$reason.'';
$date = date("F j, Y");
$query = sprintf("INSERT INTO messages_all (receiver_id, sender_id,subject,message,date)
            VALUES('%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($receiver_id),
            mysql_real_escape_string($username),
            mysql_real_escape_string($title),
            mysql_real_escape_string($mess),
            mysql_real_escape_string($date));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_received (sender_id,receiver_id, subject,message,filename,filepath,date,message_read)
            VALUES( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($receiver_id),
            mysql_real_escape_string($title),
            mysql_real_escape_string($mess),
            mysql_real_escape_string($filename),
            mysql_real_escape_string($filepath),
            mysql_real_escape_string($date),
            mysql_real_escape_string($message_read));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_sent (receiver_id, sender_id,subject,message,date)
            VALUES( '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($receiver_id),
            mysql_real_escape_string($username),
            mysql_real_escape_string($title),
            mysql_real_escape_string($mess),
            mysql_real_escape_string($date));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }

mysql_query("update jobs_sold set rejected = 'yes' where id = '$id'");
mysql_query("update jobs_bought set rejected = 'yes' where id = '$id'");
mysql_query("UPDATE members SET balance=balance+ '".$cost."' where username = '$receiver_id'");
if(!mysql_query) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['JOB_NOT_REJ']."
</div>
<div class=\"dialog-right\">
<img src=\"images/error-delete.jpg\" class=\"del-x\" alt=\"\"/>
</div>
</div>";
} else{
header("Location: mysales.php?act=view&id=$id");
}
}
if(isset($_POST['delete'])){
$sql = "DELETE FROM jobs_sold where id='$_POST[id]' " or die(mysql_error());
$result = mysql_query($sql);
if(!mysql_query) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['ORD_NOT_DEL']."
</div></div>";
}else{ echo "<div class=\"dialog-box-success\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['ORD_DELETED']."!! <img src=\"images/rating_loading.gif\" width=\"220\" height=\"19\" alt=\"\" />
</div></div><META HTTP-EQUIV = 'Refresh' Content = '2; URL =mysales'>";
}
}
?>
</div></div>
<? include("side.php");
include("footer.php");
ob_flush();
}
?>