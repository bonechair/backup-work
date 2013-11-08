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


$user = $_GET['username'];
include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - Send a Message";
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
                alert ( "You forgot to type in a message" );
                valid = false;
        }
        if ( document.message_form.subject.value == "" )
        {
                alert ( "You forgot to type in a subject" );
                valid = false;
        }
        return valid;
}
//-->
</script>
                    <div class="message">
                    <h2><?PHP echo $lang['SEND_MESS_TO']?>: <?PHP echo $user ?></h2>
                    <div class="akform1"><form action="messageform" id="upload" name="message_form" method="post" enctype="multipart/form-data" onSubmit="return validate_messageform ();">
                    <div id="allFields">
                    <div class="fields">
                    <div class="field">
                    <input type="hidden" name="sender_id" value="<?PHP echo $_SESSION['userName']?>">
                    <input type="hidden" name="receiver_id" value="<?PHP echo $_POST['username']?>">
                    <label><?PHP echo $lang['SUBJECT']?><span class="mandatory">*</span></label>
                    <div class="fieldInput" id="name">
                    <input type="text" name="subject" value="" class="textinput" />
                    </div>
                    </div>
                    <div class="field">
                    <label><?PHP echo $lang['YOUR_MESSAGE']?><span class="mandatory">*</span></label>
                    <textarea name="message"></textarea>
                    </div><div class="field">
                    <label><?PHP echo $lang['ADD_ATT']?> <input type="checkbox" name="attatch"/></label>
                    <input name="upload" type="file">
                    </div>
                    <input type="submit" name="submit" value="<?PHP echo $lang['SEND_MESSAGE']?>" class="Button"/>
                    </div></div>
                    </form>
                    </div>
                    </div>
                    </div>
<?PHP
include("side.php");
include("footer.php");


?>