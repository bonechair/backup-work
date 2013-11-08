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

$title = "Process payment request";
include("header.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$currency_symbol =  $row["currency_symbol"];
$domain =  $row["domain"];
$site_email =  $row["site_email"];
}
if(isset($_POST['request'])){
$date_requested = date("j-n-Y");
$username=$_POST['username'];
$amount = $_POST['amount'];
$balance = $_POST['balance'];
$email = $_POST['email'];
if ($amount > $balance) {
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
echo"</div>";
include("side.php");
include("footer.php");
?>