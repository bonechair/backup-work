<?PHP  session_start(); 
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
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$domain = $row["domain"];
$title = "".$row["domain"]." - Thank You";
}
include("header.php");?>

<div id="pay">
<?
$id = intval( $_POST['id']);
$balance = $_POST['balance'];
$date = $_POST['postdate'];
$price = $_POST['price'];
$job = $_POST['job'];
$job = stripslashes(nl2br($job));
$seller_id = $_POST['seller_id'];
$buyer_id = $_POST['buyer_id'];
$seller_email = $_POST['seller_email'];

$query = sprintf("insert into jobs_bought(job_id,willdo,username,seller_username,feedback_left,date,payment_confirmed)
         VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($id),
            mysql_real_escape_string($job),
            mysql_real_escape_string($buyer_id),
            mysql_real_escape_string($seller_id),
            mysql_real_escape_string(no),
            mysql_real_escape_string($date),
            mysql_real_escape_string(yes));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }

$query = sprintf("insert into jobs_sold(job_id,willdo,username,buyer_username,feedback_left,date,payment_confirmed)
         VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($id),
            mysql_real_escape_string($job),
            mysql_real_escape_string($seller_id),
            mysql_real_escape_string($buyer_id),
            mysql_real_escape_string(no),
            mysql_real_escape_string($date),
            mysql_real_escape_string(yes));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }

mysql_query("UPDATE jobs SET times_bought=times_bought+1 where id='$id'") or die(mysql_error());
mysql_query("UPDATE members SET balance=balance- ".$price." where username='$buyer_id'") or die(mysql_error());
$subject = 'Job Sold-Job: '.$job.'';
$message =  'Your job: '.$job.' has been bought by '.$buyer_id.'';
$filename = 'none';
$filepath = 'none';
$message_read = 'no';
$query = sprintf("INSERT INTO messages_all (receiver_id, sender_id,subject,message,date)
            VALUES('%s', '%s', '%s', '%s', '%s')",

            mysql_real_escape_string($seller_id),
            mysql_real_escape_string($buyer_id),
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


            mysql_real_escape_string($buyer_id),
            mysql_real_escape_string($seller_id),
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

            mysql_real_escape_string($seller_id),
            mysql_real_escape_string($buyer_id),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($message),
            mysql_real_escape_string($date));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
if(!mysql_query)
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
      else
            {
echo "<div class=\"clear\"></div><div class=\"dialog-box-success2\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang["THANKS_PAYMENT"]." ".$lang["ORDERS"]." ".$lang["PAGE"]."</div>
</div><div class=\"clear\"></div>";
}
$time = date('r');
$to      = $seller_email;
$subject = "".$lang["JOB_SOLD_SUBJECT"]."";
$message = "Hi! $seller_id\n Your job: $job ".$lang["PP_EMAIL1"]." $buyer_id on $time\n".$lang["PP_EMAIL2"].".\n".$lang["PP_EMAIL3"]."\n
The $domain team.";
$headers = 'From: support@triplegood.co.za' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);

?>
</div>
</div>
<? include("side.php");
include("footer.php");?>

