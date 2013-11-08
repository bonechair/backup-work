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
$title = "".$row["domain"]." - ".$lang["THANK_YOU"]."";
$domain =  $row["domain"];
$siteurl =  $row["site_url"];
}
include("header.php");
$ip = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
$id = mysql_real_escape_string($_POST['id']);
$Job = mysql_real_escape_string($_POST['job']);
$date = date("F j, Y");
$allowed = array("jpeg","gif","png","bmp","jpg","txt","zip","rar","pdf");
if ($_SERVER['REQUEST_METHOD'] != 'POST') exit; // Quit if it is not a form post
function sanityCheck($string, $type, $length){
  $type = 'is_'.$type;
  if(!$type($string))
    {
    return FALSE;
    }
  elseif(empty($string))
    {
    return FALSE;
    }
  elseif(strlen($string) > $length)
    {
    return FALSE;
    }
  else
    {
    return TRUE;
    }
}
function checkNumber($num, $length){
  if($num > 0 && strlen($num) == $length)
        {
        return TRUE;
        }
}
function checkSet(){
return isset($_POST['sender_id'], $_POST['receiver_id'], $_POST['subject'], $_POST['message']);
}


if(isset($_POST['attatch']))
{
$pathInfo = pathinfo($_FILES["upload"]["name"]);
$extension = $pathInfo['extension'];
//choose directory/foolder to place the file in
$dir = "users/".$_POST['receiver_id']."";
if(!in_array($extension, $allowed)) {die (header( 'Location: invalid?ext' ));}
if(move_uploaded_file($_FILES['upload']['tmp_name'], "$dir/".$_FILES['upload']['name'])) {}
$filename = htmlentities($_FILES['upload']['name']);
$filepath = mysql_real_escape_string("$dir/".$_FILES['upload']['name']);
}
if(checkSet() != FALSE)
        {
        if(sanityCheck($_POST['sender_id'], 'string', 100) != FALSE)
                {
               $s_id = $_POST['sender_id'];
                }
        else
                {
             echo 'Sender id is not set';
                exit();
                }
        if(sanityCheck($_POST['receiver_id'], 'string', 100) != FALSE)
                {
               $r_id = $_POST['receiver_id'];
                }
        else
                {
               echo 'Receiver id is not set';
                exit();
                }
       if(sanityCheck($_POST['subject'], 'string', 250) != FALSE)
                {
                $sub = $_POST['subject'];
                }
        else
                {
                echo 'Subject is missing';
                exit();
                }
        if(sanityCheck($_POST['message'], 'string', 2000) != FALSE)
                {
               $mes = $_POST['message'];
                }
        else
                {
                echo 'Message is missing';
                exit();
                }
$query = sprintf("INSERT INTO messages_all (sender_id, receiver_id, subject, message, date)
            VALUES( '%s','%s','%s','%s','%s')",
            mysql_real_escape_string($s_id),
            mysql_real_escape_string($r_id),
            mysql_real_escape_string($sub),
            mysql_real_escape_string($mes),
            mysql_real_escape_string($date));
// run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
if(isset($_POST['attatch']))
{
$query1 = sprintf("INSERT INTO attatchments (sender_id, receiver_id, filename, filepath, date, ip)
            VALUES('%s','%s','%s','%s','%s','%s')",
            mysql_real_escape_string($s_id),
            mysql_real_escape_string($r_id),
            mysql_real_escape_string($filename),
            mysql_real_escape_string($filepath),
            mysql_real_escape_string($date),
            mysql_real_escape_string($ip));
// run the query
    if(!mysql_query($query1))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query2 = sprintf("INSERT INTO messages_received (sender_id, receiver_id, subject, message, filename, filepath, date, message_read)
            VALUES('%s','%s','%s','%s','%s','%s','%s','%s')",
            mysql_real_escape_string($s_id),
            mysql_real_escape_string($r_id),
            mysql_real_escape_string($sub),
            mysql_real_escape_string($mes),
            mysql_real_escape_string($filename),
            mysql_real_escape_string($filepath),
            mysql_real_escape_string($date),
            mysql_real_escape_string(no));
// run the query
    if(!mysql_query($query2))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
}else{
$query3 = sprintf("INSERT INTO messages_received (sender_id, receiver_id, subject, message, filename, filepath, date, message_read)
            VALUES('%s','%s','%s','%s','%s','%s','%s','%s')",
            mysql_real_escape_string($s_id),
            mysql_real_escape_string($r_id),
            mysql_real_escape_string($sub),
            mysql_real_escape_string($mes),
            mysql_real_escape_string(none),
            mysql_real_escape_string(none),
            mysql_real_escape_string($date),
            mysql_real_escape_string(no));
// run the query
    if(!mysql_query($query3))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
}
$query4 = sprintf("INSERT INTO messages_sent (sender_id, receiver_id, subject, message, date)
            VALUES('%s','%s','%s','%s','%s')",
            mysql_real_escape_string($s_id),
            mysql_real_escape_string($r_id),
            mysql_real_escape_string($sub),
            mysql_real_escape_string($mes),
            mysql_real_escape_string($date));
// run the query
    if(!mysql_query($query4))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$myresult = mysql_query("SELECT email FROM members WHERE username = '$r_id'");
while($myrow = mysql_fetch_array($myresult))
{
$email = "".$myrow["email"]."";
}
$time = date('r');
$to      = $email;
$subject = "".$lang["ME_SUBJECT"]."";
$message = "Hi! $r_id\n".$lang["ME_EMAIL1"]." $siteurl on $time\n".$lang["ME_EMAIL2"].": $s_id\n".$lang["ME_EMAIL3"]."\n\n".$lang["ME_EMAIL4"]."\n$domain";
$headers = 'From: noreply@'.$domain.'' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);}

?>
<div class="clear"> </div>
<div class="dialog-box-success">
<div class="dialog-left">
<img src="images/succes.png" class="dialog-ico" alt=""/><?PHP echo $lang['MESSAGE_SENT']?><h4>&larr; <?PHP echo $lang['BACK_TO_JOB']?>: &nbsp;<a href="<?PHP echo $Job ?>"><?PHP echo $Job ?></a></h4></div>
</div><p> </p>

</div>
<?PHP include("side.php");
include("footer.php");
ob_flush();
}
?>