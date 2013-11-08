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
<?PHP if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();
if ($act == "view") {
echo '<div class="orders">';

$result2 = mysql_query("SELECT * FROM jobs_sold WHERE `id` = '$id' ");
while($myrec = mysql_fetch_array($result2))
{
$accepted = $myrec['accepted'];
$job_id = $myrec['job_id'];
$confirmed = $myrec['payment_confirmed'];
$feedback_left = $myrec['feedback_left'];
$buyer = $myrec['buyer_username'];
$seller = $myrec['username'];
$completed = $myrec['job_completed'];
$willdo = $myrec['willdo'];
$willdo = stripslashes(nl2br($willdo));
$rejected = $myrec['rejected'];
$date = $myrec['date'];
}
echo "<div class=\"feedback\">
<h2>View Order</h2><p>".$willdo."</p>
<table class=\"sortable\" id=\"tb-1\" width=\"100%\">
<tr>
<th class=\"th-1\">".$lang['JOB_ID']."</th>
<th class=\"th-6\">".$lang['BUYER']."</th>
<th class=\"th-6\">".$lang['ON']."</th>
<th class=\"th-6\">".$lang['ACCEPTED']."</th>
<th class=\"th-6\">".$lang['PAYMENT_CONFIRMED']."</th></tr>";
echo "<tr>
<td class=\"td-1\">$job_id</td>
<td class=\"td-6\">$buyer</td>
<td class=\"td-6\">$date</td>
<td class=\"td-6\">$accepted</td>
<td class=\"td-6\">$confirmed</td></tr></table>";
}
echo '</div>
<div class="feedback">';
echo '<h2>'.$lang['ACC_REJ'].'</h2>';
if ( $confirmed == 'yes' AND ( $accepted == 'no' ) AND ( $rejected == 'no' )) {
echo "<form action=\"sales.php\" method=\"post\">
<input type=\"hidden\" name=\"id\" value=\"$id\">
<input type=\"hidden\" name=\"willdo\" value=\"$willdo\">
<input class=\"Button\" type=\"submit\"  name=\"accept\" value=\"".$lang['ACCEPT']."\" title=\"".$lang['ACCEPT']."\"onClick=\"return confirmAcc()\"/>&nbsp;&nbsp;&nbsp;&nbsp;
<input class=\"textfield\" onfocus=\"value=''\" value=\"".$lang['REJ_REASON'].".....\" size=\"26\"name=\"reason\" type=\"text\" value=\"".$lang['REASON']."\" />
<input class=\"Button\" type=\"submit\"  name=\"reject\" value=\"".$lang['REJECT']."\" title=\"".$lang['REJECT']."\"onClick=\"return confirmRej()\"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</form>";
}elseif ( $confirmed == 'no' AND ( $accepted == 'no' ) AND ( $rejected == 'no' )) {
echo "<p><img src=\"images/succes.png\"> ".$lang['NOT_CONFIRMED']."</p>";
}
elseif ( $rejected == 'yes'){
echo "<p><img src=\"images/succes.png\">".$lang['BUYER_REFUNDED']."</p>";
}elseif ( $accepted == 'yes'){
echo "<p><img src=\"images/succes.png\">".$lang['ACCEPT_JOB']."</p>";
}
if ( $feedback_left == 'no' AND ( $accepted == 'yes' ) AND ( $rejected == 'no' )){
  echo "<p>".$lang['STILL_WAIT_FEED']."</p>";
}
elseif ( $feedback_left == 'yes' AND ( $accepted == 'yes' ) AND ( $rejected == 'no' )){
echo "<p>".$lang['BUYER_LEFT_FEED']."</p>";
echo "<form action=\"mysales.php\" method=\"post\">
<input type=\"hidden\" name=\"id\" value=\"$id\">
<input style=\"margin-left:540px;margin-top:-20px;\" class=\"Button\" type=\"submit\"  name=\"delete\" value=\"".$lang['DELETE']."\" title=\"".$lang['DELETE']."\"onClick=\"return confirmSubmitt()\"/></form></h3>";
}
if(isset($_POST['submit_feed']))
{
if ($_SERVER['REQUEST_METHOD'] != 'POST') exit; // Quit if it is not a form post
// quick way clean up incoming fields
foreach($_POST as $key => $value) $_POST[$key] = urldecode(trim($value));

// get form data into shorter variables
// each $_POST variable is named based on the form field's id value
$job_id = $_POST['job_id'];
$rating = $_POST['rating'];
$username = $_POST['username'];
$text =nl2br($_POST['text']);
$errors  = array(); // array of errors

if ($text == '') {
  $errors[] = "Please enter some feedback";
}
    $query = sprintf("INSERT INTO buyer_feedback (job_id, rating, username, text)
            VALUES( '%s','%s','%s','%s')",

            mysql_real_escape_string($job_id),
            mysql_real_escape_string($rating),
            mysql_real_escape_string($username),
            mysql_real_escape_string($text));
            mysql_query("update jobs_bought set feedback_left = 'yes' where job_id = '".mysql_real_escape_string($job_id)."'");
            if(!mysql_query($query))
{
echo 'Query failed '.mysql_error();
die();
}

if($_POST['rating'] == 'images/positive.png')
{
mysql_query("update members SET pos_feed=pos_feed+1 where username='".mysql_real_escape_string($buyer)."'");

}else
if($_POST['rating'] == 'images/neutral.png')
{
mysql_query("update members SET neut_feed=neut_feed+1 where username='".mysql_real_escape_string($buyer)."'");
}else
if($_POST['rating'] == 'images/negative.png')
{
mysql_query("update members SET neg_feed=neg_feed+1 where username='".mysql_real_escape_string($buyer)."'");
}header( 'Location: thanks.php' ) ;
}
$fback = mysql_query("select * from jobs_bought where username='".mysql_real_escape_string($buyer)."' AND seller_username='".mysql_real_escape_string($username)."' AND job_id='".mysql_real_escape_string($job_id)."' AND feedback_left='no' AND accepted='yes'");
$qrnum = mysql_num_rows($fback);
if($qrnum > 0)
{
?>
<script type="text/javascript">
<!--
function validate_feedform ( )
{
valid = true;
        if ( document.feedback.text.value == "" )
        {
                alert ( "<?PHP echo $lang['FORGOT_FEED']?>" );
                valid = false;
        }
        return valid;
}
//-->
</script>
<div class="feedback">
<h2><?PHP echo $lang['LEAVE_FEED']?> for <? echo $buyer ?></h2>
<div class="feedback_form"><form action="" name="feedback" method="post" onSubmit="return validate_feedform ();">
<div id="allFields">
<div class="fields">
<input type="hidden" name="job_id" value="<? echo $job_id?>">
<input type="hidden" name="username" value="<? echo $seller?>">
<div class="feedrate">
<label><?php echo $lang['RATING'] ?><span class="mandatory">*</span></label>
<select  name="rating"><option value="images/positive.png"><?php echo $lang['POSITIVE'] ?></option>
<option value="images/neutral.png"><?php echo $lang['NEUTRAL'] ?></option>
<option value="images/negative.png"><?php echo $lang['NEGATIVE'] ?></option></select>
<br />
<label><?PHP echo $lang['YOUR_FEED'] ?><span class="mandatory">*</span></label>
</div>
<textarea name="text"></textarea>
 <br />&nbsp;&nbsp;&nbsp;<input type="submit" name="submit_feed" value="<?PHP echo $lang['LEAVE_FEED'] ?>" class="Button"/>
</div>
</div>
</form>
</div>
</div>
<?PHP

}

echo '</div>';
$result = mysql_query("SELECT * FROM members WHERE `username` = '$buyer' ");
while($my_rec = mysql_fetch_array($result))
{
$buyer_email = mysql_real_escape_string($my_rec['email']);
}
if (isset($_POST['upload'])) {
$to      = $buyer_email;
$from    = $seller;
$subject = $_POST['subject'];
$message =  "From: $seller\n
Job Title: $willdo\n
".$_POST['message'].";\n
Yours Sincerely\n
The $domain team.";
// Obtain file upload vars
$fileatt      = $_FILES['fileatt']['tmp_name'];
$fileatt_type = $_FILES['fileatt']['type'];
$fileatt_name = $_FILES['fileatt']['name'];
$headers = "From: $from@$domain.com";
if (is_uploaded_file($fileatt)) {
  $file = fopen($fileatt,'rb');
  $data = fread($file,filesize($fileatt));
  fclose($file);
  $semi_rand = md5(time());
  $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
  $headers .= "\nMIME-Version: 1.0\n" .
              "Content-Type: multipart/mixed;\n" .
              " boundary=\"{$mime_boundary}\"";
  $message = "This is a multi-part message in MIME format.\n\n" .
             "--{$mime_boundary}\n" .
             "Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
             "Content-Transfer-Encoding: 7bit\n\n" .
             $message . "\n\n";
  $data = chunk_split(base64_encode($data));
  $message .= "--{$mime_boundary}\n" .
              "Content-Type: {$fileatt_type};\n" .
              " name=\"{$fileatt_name}\"\n" .
              //"Content-Disposition: attachment;\n" .
              //" filename=\"{$fileatt_name}\"\n" .
              "Content-Transfer-Encoding: base64\n\n" .
              $data . "\n\n" .
              "--{$mime_boundary}--\n";
}
$ok = @mail($to, $subject, $message, $headers);
if ($ok) {
$users = 'users/'.$buyer.'/'.$fileatt_name.'';
$filename = $fileatt_name;
$filepath =  $users;
$message_read = 'no';
$my_message = "From: $seller\n
Job Title: $willdo\n
".$_POST['message'].";\n.";
$postdate = date("j-n-Y");
$query = sprintf("INSERT INTO attatchments (sender_id, receiver_id,filename,filepath,date,ip)
            VALUES('%s', '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($buyer),
            mysql_real_escape_string($filename),
            mysql_real_escape_string($filepath),
            mysql_real_escape_string($postdate),
            mysql_real_escape_string($ip));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_all (receiver_id, sender_id,subject,message,date)
            VALUES('%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($buyer),
            mysql_real_escape_string($username),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($my_message),
            mysql_real_escape_string($postdate));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_received (sender_id,receiver_id, subject,message,filename,filepath,date,message_read)
            VALUES( '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($username),
            mysql_real_escape_string($buyer),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($my_message),
            mysql_real_escape_string($filename),
            mysql_real_escape_string($filepath),
            mysql_real_escape_string($postdate),
            mysql_real_escape_string($message_read));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
$query = sprintf("INSERT INTO messages_sent (receiver_id, sender_id,subject,message,date)
            VALUES( '%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($buyer),
            mysql_real_escape_string($username),
            mysql_real_escape_string($subject),
            mysql_real_escape_string($my_message),
            mysql_real_escape_string($postdate));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
if(isset($_POST['attatch']))
{
$allowed = array("jpeg","gif","png","bmp","jpg","txt","zip","rar","pdf");
$pathInfo = pathinfo($_FILES["fileatt"]["name"]);
$extension = $pathInfo['extension'];
//choose directory/foolder to place the file in
$dir = "users/".$buyer."";
if(!in_array($extension, $allowed)) {die (header( 'Location: invalid?ext' ));}
if(move_uploaded_file($_FILES['fileatt']['tmp_name'], "$dir/".$_FILES['fileatt']['name'])) {}
$filename = htmlentities($_FILES['fileatt']['name']);
$filepath = mysql_real_escape_string("$dir/".$_FILES['fileatt']['name']);
}
echo '  <div class="dialog-box-success">
<div class="dialog-left">
<img src="images/succes.png" class="dialog-ico" alt=""/>
'.$lang['JOB_DELIVERED'].'
</div></div>';
} else {
echo '<div class="dialog-box-error">
<div class="dialog-left">
<img src="images/error.png" class="dialog-ico" alt=""/>
'.$lang['JOB_NOT_DELIVERED'].'
</div></div>';
}
}
?>

<link type="text/css" href="css/base.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="js/ui.core.js"></script>
<script type="text/javascript" src="js/ui.tabs.js"></script>
<script type="text/javascript">
			$(document).ready( function(){
				// Tabs
				$('#tabs').tabs({
					fx: { opacity: 'toggle' }
				});
			});
		</script>
<div class="feedback">
<div id="tabs">
<ul>
<li><a href="#tabs-1"><?PHP echo $lang['BUY_SELL_COMM']?></a></li>
<li><a href="#tabs-2"><?PHP echo $lang['DELIVER_WORK']?></a></li>
</ul>
<div id="tabs-1">
<p><?PHP echo $lang['COMM_SEND']?> </p>
<div class="clear"></div>
<?PHP
if(isset($_POST['comment']))
{
foreach($_POST as $key => $value) $_POST[$key] = urldecode(trim($value));
$id = intval($_POST['id']);
$job_id = intval($_POST['job_id']);
$img_path = $_POST['img_path'];
$username = $_POST['username'];
$text = $_POST['text'];
$postdate = date("j-n-Y");
$query = sprintf("INSERT INTO job_communication (job_id, img_path, username, text, postdate)
            VALUES('%s', '%s', '%s', '%s', '%s')",
            mysql_real_escape_string($job_id),
            mysql_real_escape_string($img_path),
            mysql_real_escape_string($username),
            mysql_real_escape_string($text),
            mysql_real_escape_string($postdate));
// run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }die(header("Location: mysales.php?act=view&id=$id"));
}
$result = mysql_query("SELECT * from job_communication where `username` = '".$seller."' AND `job_id` ='".$job_id."' OR `username` = '".$buyer."' AND `job_id` ='".$job_id."'  order by id desc");
while($myrow = mysql_fetch_array($result)){
$text = stripslashes(str_replace('\r\n', '<br>',($myrow['text'])));
print "<div align=\"left\" ><img src=\"$siteurl/users/$myrow[img_path]\" height=\"45px\" width=\"45px\" alt=\"profile image\"></div><div align=\"left\" style=\"margin-left:60px;margin-top:-50px\"><p>".$text."</p></div><div class=\"cleared1\"></div><div align= \"right\">".$lang['ON']." $myrow[postdate] ".$lang['BY']." $myrow[username]";
echo "<hr size=\"1\" color=\"#E0E9F8\" /></div>";
}
$mem_result = mysql_query("SELECT * FROM members WHERE `username` = '$username' ");
while($my_mem = mysql_fetch_array($mem_result))
{
$imagepath = mysql_real_escape_string($my_mem['img_path']);
}

if(isset($_SESSION['userName'])){ ?>
<form action="" name="comment" id="comment" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?PHP echo $id?>">
<input type="hidden" name="job_id" value="<?PHP echo $job_id?>">
<input type="hidden" name="img_path" value="<?PHP echo $username?>/<?PHP echo $imagepath?>">
<input type="hidden" name="username" value="<?PHP echo $username?>">
<fieldset>
<legend><?PHP echo $lang['CONT_BUYER']?></legend><br />
<label><?PHP echo $lang['MESSAGE']?><span class="mandatory">*</span></label>
<textarea name="text" id="text" rows="6" cols="80"></textarea>
<input type="submit" name="comment" value="<?PHP echo $lang['SUBMIT']?>" class="Button"/>
</fieldset>
</form>
<?PHP }?>
</div>
<div id="tabs-2">
<form method='post' action='' enctype='multipart/form-data' id="file_upload">
<fieldset>
<legend><?PHP echo $lang['DELIVER_WORK']?></legend><br />
<label><?PHP echo $lang['SUBJECT']?>: </label> <input type="text" name="subject" value="Job Purchase"/><br />
<label><?PHP echo $lang['YOUR_MESSAGE']?>: </label>
<textarea name="message" rows="6" cols="80"></textarea><br />
<label><?PHP echo $lang['ADD_ATT']?> </label><input type="checkbox" name="attatch" onclick="doInputs(this)"/>
<div id="appear_div"><input type="file" name="fileatt" /></div></br>
<input type="submit" name='upload' class="Button" value="<?PHP echo $lang['SUBMIT']?>" />
</fieldset>
</form>
<?php //pr($upload); ?>
</div>
</div>
</div></div></div>
<? include("side.php");
include("footer.php");

}
}
?>
<script type="text/javascript">
 function doInputs(obj){
 var checkboxs = $("input[type=checkbox]:checked");
 var i =0, box;
 $('#appear_div').fadeOut('fast');
     while(box = checkboxs[i++]){
     if(!box.checked)continue;
     $('#appear_div').fadeIn('fast');
     break;
     }
   }
 </script>