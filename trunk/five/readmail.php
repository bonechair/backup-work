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

$id = intval($_GET['id']);
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - my messages";
$siteurl =  $row["site_url"];
}
include("header.php");

function filter($arr) {
return array_map('mysql_real_escape_string', $arr);
}
mysql_query("UPDATE messages_received SET `message_read` = 'yes' where id ='$id'") or die(mysql_error());
if(!mysql_query)
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
?>
<script type="text/javascript">
<!--
function validate_messageform ( )
{
valid = true;
        if ( document.message_form.message.value == "" )
        {
                alert ( "<?PHP echo $lang['FORGOT_MESS']?>" );
                valid = false;
        }
        if ( document.message_form.subject.value == "" )
        {
                alert ( "<?PHP echo $lang['FORGOT_SUBJECT']?>" );
                valid = false;
        }
        return valid;
}
//-->
</script>

                              <div class="mailbox">
<table>
                              <tr>
                                <td>
                            <form action="mailbox_inbox" method="post">
                                <input class="Button" type="submit" name="inbox" value="<?PHP echo $lang['INBOX']?>" />
                                <input type="hidden" name="sender_id" value="<? echo $_SESSION['userName']?>">
                                <input type="hidden" name="receiver_id" value="<? echo $username?>">
                                </form></td>
                                <td>
                             <form action="mailbox" method="post">
                                <input class="Button" type="submit" name="sent" value="<?PHP echo $lang['SENT_ITEMS']?>" />
                                <input type="hidden" name="sender_id" value="<? echo $_SESSION['userName']?>">
                                <input type="hidden" name="receiver_id" value="<? echo $username?>">
                                </form></td>
                              </tr>
                            </table>
<?
$sql = "select * from messages_received WHERE `id` = '".mysql_real_escape_string($id)."' AND `receiver_id` = '$_SESSION[userName]' ";
$rec = mysql_query($sql) or die(mysql_error());
while($datas=mysql_fetch_array($rec)){

if($_SESSION['userName']!=''.$username.''){
    header('Location: index.php');
die();
}

$message = stripslashes(nl2br($datas['message']));
$subject = stripslashes(nl2br($datas['subject']));
$filename =  $datas['filename'];
$filepath =  $datas['filepath'];
echo "<h3>".$lang['MESSAGE_SENT_ON'].": $datas[date]</h3>
<h3><b>".$lang['FROM'].":</b> $datas[sender_id]</h3>
<p>".$lang['SUBJECT'].": $subject</p>
<p>".$lang['MESS-AGE'].": $message</p>";
if(($filename) == 'none' AND ($filepath) == 'none'){echo "";}else{
echo "".$filename.": <a href='$filepath'> ".$lang['DOWNLOAD']."</a> (".$lang['R_CLICK'].")";
}
?>
<hr color="#C0C0C0" />
<div class="clear"></div>
<h3><?PHP echo $lang['REPLYTOMESSAGE']?></h3>
<div class="akform1"><form action="" name="message_form" method="post" enctype="multipart/form-data" onSubmit="return validate_messageform ();">
<div id="allFields">
            <div class="fields">
                <div class="field">
                    <input type="hidden" name="id" value="<? echo $id?>">
                    <input type="hidden" name="sender_id" value="<? echo $_SESSION['userName']?>">
                    <input type="hidden" name="receiver_id" value="<? echo $datas['sender_id']?>">
                    <label><?PHP echo $lang['SUBJECT']?><span class="mandatory">*</span></label>
                    <div class="fieldInput" id="name">
                    <input type="text" name="subject" value="<? echo $subject1 ?>" class="textinput" />
                    </div>
                </div>
                <div class="field">
                    <label><?PHP echo $lang['YOUR_REPLY']?><span class="mandatory">*</span></label>
                    <textarea name="message"></textarea>
                </div>
             <div class="field">
                <label><?PHP echo $lang['ADD_ATT']?> <input type="checkbox" name="attatch"/></label>
                <input name="upload" type="file">
                </div>
            </div>
            <input type="submit" name="submit" value="<?PHP echo $lang['REPLY']?>" class="Button"/>
        </div>
        </form>
    </div>
<?}
?>
</div>
<div class="clear"></div>

<?
$allowed = array("jpeg","gif","png","bmp","jpg","txt","zip","rar","pdf");
if(isset($_POST['submit']))
{
$ip = mysql_real_escape_string($_SERVER['REMOTE_ADDR']);
$id = mysql_real_escape_string($_POST['id']);

if ($_SERVER['REQUEST_METHOD'] != 'POST') exit; // Quit if it is not a form post


foreach($_POST as $key => $value) $_POST[$key] = urldecode(trim($value));
$sender_id = eregi_replace("\r\n","<br>",$_POST['sender_id']);
$receiver_id = eregi_replace("\r\n","<br>",$_POST['receiver_id']);
$subject = eregi_replace("\r\n","<br>",$_POST['subject']);
$message = eregi_replace("\r\n","<br>",$_POST['message']);
$date = date("F j, Y");

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
$m_id = stripslashes($message_id);
$s_id = stripslashes($sender_id);
$r_id = stripslashes($receiver_id);
$sub = stripslashes($subject);
$mes = stripslashes($message);


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
$myresult = mysql_query("SELECT email FROM members WHERE username = '$receiver_id'");
while($myrow = mysql_fetch_array($myresult))
{
$email = "".$myrow["email"]."";
}
$your_email = 'noreply@'.$domain.'';
$time = date('r');
$body = <<<EOD
From $domain\n
Hi! $receiver_id\n
You have a new message at $siteurl on $time\n
From User: $sender_id\n
You need to log in to your account to read this message.\n
Yours Sincerely\n
The $domain team.
EOD;
// send email
mail($email, "New Message", $body, "From: $your_email\r\nReply-To: $email\r\nContent-Type: text/plain; charset=ISO-8859-1\r\nMIME-Version: 1.0");

?>
<div class="dialog-box-success">
<div class="dialog-left">
<img src="images/succes.png" class="dialog-ico" alt=""/><?PHP echo $lang['REPLY_SENT']?></div>
</div>
<? } ?>

</div>
<?
include("side.php");
include("footer.php");
}
?>