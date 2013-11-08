<?PHP error_reporting(0); session_start();
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
$id = $_POST['id'];
$job = html_entity_decode($_POST['willdo']);
$myjob = stripslashes(nl2br($job));
//$myjob = htmlentities($myjob, ENT_QUOTES);

// seo_link_pv function below is in functions/general.php - change that function if you want to change how seo urls are formatted
$seo=seo_link_pv($myjob);
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

                             <div class="clear"></div>
                            <div class="mailbox">
                            <h2><?PHP echo $lang['SEND_MESSAGE']?></h2>
                            <form action="mailbox" method="post" >
                                <input class="Button" type="submit" name="inbox" value="Inbox" /> <input class="Button" type="submit" name="sent" value="Sent Items" />
                                <input type="hidden" name="sender_id" value="<? echo $_SESSION['userName']?>">
                                <input type="hidden" name="receiver_id" value="<? echo $_POST['username']?>">
                                </form>
                                <h3><b><?PHP echo $lang['SEND_MESS_TO']?>:</b> <? echo $_POST['username'] ?></h3>
                                <h3><b><?PHP echo $lang['JOB']?>:</b><a href="<? echo $siteurl?>/<?PHP echo $seo?>-<? echo $id ?>.html"><?PHP echo $lang['I_WILL']?> <? echo $myjob ?></a></h3>
                                <h3><b><?PHP echo $lang['FROM']?>:</b> <? echo $_SESSION['userName']?></h3></div>
                                <div class="no_pad"></div>
                                <div class="akform1"><form action="message_Form" name="message_form" method="post" enctype="multipart/form-data" onSubmit="return validate_messageform ();">
                                <div id="allFields">
            <div class="fields">
                <div class="field">
                    <input type="hidden" name="id" value="<? echo $id?>">
                    <input type="hidden" name="sender_id" value="<? echo $_SESSION['userName']?>">
                    <input type="hidden" name="receiver_id" value="<? echo $_POST['username']?>">
                    <input type="hidden" name="job" value="<? echo $siteurl?>/<?PHP echo $seo?>-<? echo $id ?>.html">
                    <label><?PHP echo $lang['SUBJECT']?><span class="mandatory">*</span></label>
                    <div class="fieldInput" id="name">
                    <input type="text" name="subject" value="" class="textfield" />
                    </div>
                </div>
                <div class="field">
                    <label><?PHP echo $lang['YOUR_MESSAGE']?><span class="mandatory">*</span></label>
                    <textarea name="message" class="textarea"></textarea>
                </div>
                <div class="field">
                <label><?PHP echo $lang['ADD_ATT']?> <input type="checkbox" name="attatch"/></label>
                <input name="upload" type="file">
                </div>
            </div>
            <input type="submit" name="submit" value="<?PHP echo $lang['SEND_MESSAGE']?>" class="Button" />
        </div>
        </form>
    </div>
</div>
<?PHP
include("side.php");
include("footer.php");
ob_flush();
}
?>