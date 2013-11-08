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

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';
foreach ($_POST as $key => $value) {
$value = urlencode(stripslashes($value));
$req .= "&$key=$value";
}
// post back to PayPal system to validate
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

// If testing on Sandbox use:
//$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);


// assign posted variables to local variables
$item_name = $_POST['item_name'];
$business = $_POST['business'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$mc_gross = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$receiver_id = $_POST['receiver_id'];
$quantity = $_POST['quantity'];
$num_cart_items = $_POST['num_cart_items'];
$payment_date = $_POST['payment_date'];
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$payment_type = $_POST['payment_type'];
$payment_status = $_POST['payment_status'];
$payment_gross = $_POST['payment_gross'];
$payment_fee = $_POST['payment_fee'];
$settle_amount = $_POST['settle_amount'];
$memo = $_POST['memo'];
$payer_email = $_POST['payer_email'];
$txn_type = $_POST['txn_type'];
$payer_status = $_POST['payer_status'];
$address_street = $_POST['address_street'];
$address_city = $_POST['address_city'];
$address_state = $_POST['address_state'];
$address_zip = $_POST['address_zip'];
$address_country = $_POST['address_country'];
$address_status = $_POST['address_status'];
$item_number = $_POST['item_number'];
$tax = $_POST['tax'];
$option_name1 = $_POST['option_name1'];
$option_selection1 = $_POST['option_selection1'];
$option_name2 = $_POST['option_name2'];
$option_selection2 = $_POST['option_selection2'];
$for_auction = $_POST['for_auction'];
$invoice = $_POST['invoice'];
$custom = $_POST['custom'];
$notify_version = $_POST['notify_version'];
$verify_sign = $_POST['verify_sign'];
$payer_business_name = $_POST['payer_business_name'];
$payer_id =$_POST['payer_id'];
$mc_currency = $_POST['mc_currency'];
$mc_fee = $_POST['mc_fee'];
$exchange_rate = $_POST['exchange_rate'];
$settle_currency  = $_POST['settle_currency'];
$parent_txn_id  = $_POST['parent_txn_id'];
$pending_reason = $_POST['pending_reason'];
$reason_code = $_POST['reason_code'];
$os1 = $_POST['os1'];
$on0 = $_POST['on0'];
$on1 = $_POST['on1'];
$os0 = $_POST['os0'];
include("header.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$domain = mysql_real_escape_string($row["domain"]);
$siteurl = mysql_real_escape_string($row["site_url"]);
}
//DB connect creds and email
$notify_email =  "";         //email address to which debug emails are sent to
if (!$fp) {
// HTTP ERROR
} else {
fputs ($fp, $header . $req);
while (!feof($fp)) {
$res = fgets ($fp, 1024);
if (strcmp ($res, "VERIFIED") == 0) {
$fecha = date("j, n, Y");
//check if transaction ID has been processed before
$checkquery = "select txnid from paypal_payment_info where txnid='".$txn_id."'";
$sihay = mysql_query($checkquery) or die("Duplicate txn id check query failed:<br>" . mysql_error() . "<br>" . mysql_errno());
$nm = mysql_num_rows($sihay);
if ($nm == 0){
//execute query
     if ($txn_type == "cart"){
     for ($i = 1; $i <= $num_cart_items; $i++) {
         $itemname = "item_name".$i;
         $itemnumber = "item_number".$i;
         $on0 = "option_name1_".$i;
         $os0 = "option_selection1_".$i;
         $on1 = "option_name2_".$i;
         $os1 = "option_selection2_".$i;
         $quantity = "quantity".$i;
         $struery = "insert into paypal_payment_info(firstname,lastname,txnid,mc_gross,paymentstatus,tax,itemnumber,itemname,seller_username,postdate,buyer_username,quantity) values ('".$first_name."','".$last_name."','".$txn_id."','".$mc_gross."','".$payment_status."','".$tax."','".$_POST[$itemnumber]."','".$_POST[$itemname]."','".$_POST[$on0]."','".$fecha."','".$_POST[$on1]."','".$_POST[$quantity]."')";
         $result = mysql_query($struery) or die("Cart - paypal_cart_info, Query failed:<br>" . mysql_error() . "<br>" . mysql_errno());
         $strQuery = "insert into jobs_bought(job_id,willdo,username,seller_username,feedback_left,date,payment_confirmed) values ('".$_POST[$itemnumber]."','".$_POST[$itemname]."','".$_POST[$on1]."','".$_POST[$on0]."','no','".$fecha."','no')";
         $result = mysql_query("insert into jobs_bought(job_id,willdo,username,seller_username,feedback_left,date,payment_confirmed) values ('".$_POST[$itemnumber]."','".$_POST[$itemname]."','".$_POST[$on1]."','".$_POST[$on0]."','no','".$fecha."','no')") or die(" Query failed:<br>" . mysql_error() . "<br>" . mysql_errno());
         $strQuery = "insert into jobs_sold(job_id,willdo,username,buyer_username,feedback_left,date,payment_confirmed) values ('".$_POST[$itemnumber]."','".$_POST[$itemname]."','".$_POST[$on0]."','".$_POST[$on1]."','no','".$fecha."','no')";
         $result = mysql_query("insert into jobs_sold(job_id,willdo,username,buyer_username,feedback_left,date,payment_confirmed) values ('".$_POST[$itemnumber]."','".$_POST[$itemname]."','".$_POST[$on0]."','".$_POST[$on1]."','no','".$fecha."','no')") or die(" Query failed:<br>" . mysql_error() . "<br>" . mysql_errno());

         mysql_query("UPDATE jobs SET times_bought=times_bought+1 where id='".mysql_real_escape_string($_POST[$itemnumber])."'") or die(mysql_error());
         $job = mysql_real_escape_string($_POST[$itemname]);
$job = stripslashes(nl2br($job));
$time = date('r');
$to      = $custom;
$subject = "".$lang["PP_SUBJECT"].": ".$job."";
$message = "Hi! $_POST[$on0]\n Your job: $job ".$lang["PP_EMAIL1"]." $_POST[$on1] on $time\n".$lang["PP_EMAIL2"].".\n".$lang["PP_EMAIL3"]."\n
The $domain team.";
$headers = 'From: support@triplegood.co.za' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);

$subject = ''.$lang["PP_SUBJECT"].': '.$job.'';
$message =  'Your job: '.$job.' '.$lang["PP_EMAIL1"].' '.$_POST[$on1].'';
$filename = 'none';
$filepath = 'none';
$message_read = 'no';
$query = sprintf("INSERT INTO messages_all (receiver_id, sender_id,subject,message,date)
            VALUES('%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($_POST[$on0]),
            mysql_real_escape_string($_POST[$on1]),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($message),
            mysql_real_escape_string($fecha));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_received (sender_id,receiver_id, subject,message,filename,filepath,date,message_read)
            VALUES( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($_POST[$on1]),
            mysql_real_escape_string($_POST[$on0]),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($message),
            mysql_real_escape_string($filename),
            mysql_real_escape_string($filepath),
            mysql_real_escape_string($fecha),
            mysql_real_escape_string($message_read));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_sent (receiver_id, sender_id,subject,message,date)
            VALUES( '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($_POST[$on0]),
            mysql_real_escape_string($_POST[$on1]),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($message),
            mysql_real_escape_string($fecha));
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
}
}
// send an email in any case
 echo "Verified";
     mail($notify_email, "VERIFIED IPN", "$res\n $req\n $strQuery\n $struery\n  $strQuery2");
}
else {
// send an email
mail($notify_email, "VERIFIED DUPLICATED TRANSACTION", "$res\n $req \n $strQuery\n $struery\n  $strQuery2");
}
}
// if the IPN POST was 'INVALID'...do this
else if (strcmp ($res, "INVALID") == 0) {
// log for manual investigation
mail($notify_email, "INVALID IPN", "$res\n $req");
}
}
fclose ($fp);
}
?>