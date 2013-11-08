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
}
include("header.php");
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
<?PHP
$sql = "select * from messages_sent WHERE `id` = '".mysql_real_escape_string($id)."' AND `sender_id` = '$_SESSION[userName]'";
$rec = mysql_query($sql) or die(mysql_error());
while($datas=mysql_fetch_array($rec)){

if($_SESSION['userName']!=''.$datas['receiver_id'].''){
    header('Location: index.php');
}


$message = stripslashes(nl2br($datas['message']));
$subject = stripslashes(nl2br($datas['subject']));
echo "<h3>".$lang['MESSAGE_SENT_ON'].": $datas[date]</h3>
<p>".$lang['TO'].": $datas[receiver_id]</p>
<p>".$lang['SUBJECT'].": $subject</p>
<p>".$lang['MESS-AGE'].": $message</p>";
?><div class="clear"></div>
<form action="" method="post">
<input type="hidden" name="id" Value="<? echo $id?>">
<input type="submit" name="delete" class="Button" value="<?PHP echo $lang['DELETE_MESSAGE']?>">
</form>
<?PHP if(isset($_POST['delete'])){
$sql = "DELETE FROM messages_sent WHERE `id` = '".mysql_real_escape_string($id)."' " or die(mysql_error());
$result = mysql_query($sql);
if(!mysql_query) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['MESS_NOT_DEL']."
</div>
<div class=\"dialog-right\">
<img src=\"images/error-delete.jpg\" class=\"del-x\" alt=\"\"/>
</div>
</div>";
}else{ header( 'Location: mailbox' ) ;
}
}
}
?>
</div>
</div>
<?PHP
include("side.php");
include("footer.php");
}
?>