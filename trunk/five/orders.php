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
$page_name = 'orders.php';
if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}else{
include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - ".$_SESSION['userName']."s Orders";
$rpp = 25; // results per page
$adjacents = 4;
$page = intval($_GET["page"]);
if(!$page) $page = 1;
$siteurl = mysql_real_escape_string($row["site_url"]);
$fee = mysql_real_escape_string($row["fee"]);
$featured_fee = mysql_real_escape_string($row["featured_fee"]);
$price = mysql_real_escape_string($row["price"]);
$min_balance = mysql_real_escape_string($row["min_balance"]);
$site_email  = mysql_real_escape_string($row["site_email"]);
$currency_symbol  = mysql_real_escape_string($row["currency_symbol"]);
}
$username = $_SESSION['userName'];
include("header.php");
$result = mysql_query("SELECT * FROM members WHERE `username` = '$username'");
while($data_row = mysql_fetch_array($result))
{
$balance = mysql_real_escape_string($data_row['balance']);
$img_path = mysql_real_escape_string($data_row['img_path']);
}
?>
<div class="orders">
<div class="display"><?PHP echo $lang['DISPLAY']?>:
<a href="orders_pending.php"><?PHP echo $lang['PEND_ACC']?></a> |
<a href="orders_ar.php"><?PHP echo $lang['WAIT_REVIEW']?></a> |
<a href="orders_completed.php"><?PHP echo $lang['COMPLETED']?></a>
</div><div class="clear"></div>
<?PHP if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();
if ($act == "view") {
$result = mysql_query("SELECT * FROM jobs_bought WHERE `id` = '$id' ");
while($myrec = mysql_fetch_array($result))
{
$accepted = mysql_real_escape_string($myrec['accepted']);
$job_id = mysql_real_escape_string($myrec['job_id']);
$willdo = mysql_real_escape_string($myrec['willdo']);
$date = mysql_real_escape_string($myrec['date']);
$confirmed = mysql_real_escape_string($myrec['payment_confirmed']);
$seller = mysql_real_escape_string($myrec['seller_username']);
$buyer = mysql_real_escape_string($myrec['username']);
$completed = mysql_real_escape_string($myrec['job_completed']);
$feedback_left = mysql_real_escape_string($myrec['feedback_left']);
if($_SESSION['userName']!=''.$buyer.''){
    header('Location: index.php');
}
$result = mysql_query("SELECT * FROM jobs WHERE `id` = '$job_id' ");
while($res = mysql_fetch_array($result))
{
$featured = mysql_real_escape_string($res["featured"]);
$job_cost = mysql_real_escape_string($res["job_cost"]);
}
$will_do = stripslashes(nl2br($willdo));
echo '<div class="orders">
<div class="feedback">
<h2>'.$lang['VIEW_ORDERS'].':</h2><p>'.$will_do.'</p>';
echo "<table class=\"sortable\" id=\"tb-1\" width=\"100%\">
<tr>
<th class=\"th-1\">".$lang['JOB_ID']."</th>
<th class=\"th-6\">".$lang['JOB_PRICE']."</th>
<th class=\"th-6\">".$lang['SELLER']."</th>
<th class=\"th-1\">".$lang['ON']."</th>
<th class=\"th-6\">".$lang['ACCEPTED']."</th>
<th class=\"th-6\">".$lang['PAYMENT_CONFIRMED']."</th>
<th class=\"th-6\">".$lang['COMPLETED']."</th></tr>";
echo "<tr>
<td class=\"td-1\">$job_id</td>
<td class=\"td-4\">$currency_symbol$job_cost</td>
<td class=\"td-6\">$seller</td>
<td class=\"td-1\">$date</td>
<td class=\"td-6\">$accepted</td>
<td class=\"td-6\">$confirmed</td>
<td class=\"td-6\">$completed</td></tr></table>";
echo" </div>";
if(($accepted) == 'yes' AND ($confirmed) == 'yes' AND ($completed) == 'yes' AND ($feedback_left) == 'yes'){
echo '<div class="feedback">
<h2>'.$lang['DELETE_ORDER_RECORD'] .'.</h2>';
echo "<form action=\"orders.php\" method=\"post\">
<input type=\"hidden\" name=\"id\" value=\"$id\">
<input  class=\"Button\" type=\"submit\"  name=\"delete\" value=\"".$lang['DELETE_RECORD'] ."\" title=\"Delete this job\"onClick=\"return confirmSubmitt()\"/></form></h3>";
echo '</div>';
}
if(($accepted) == 'yes' AND ($confirmed) == 'yes' AND ($completed) == 'no'){
echo '<div class="feedback">
<h2>'.$lang['CONFIRM_JOB_COMP'].'.</h2>';
echo "<h3>".$lang['CLICK_CONFIRM_JOB_COMP']."</h3><h3> ".$lang['TO_YOUR_SAT'].".</h3>";
if(($featured) == 'yes'){
$percent = $featured_fee;
$total = $job_cost;
$tmppercent=100-$percent;
$equals=($total / 100 * $tmppercent);
echo '<form action="" method="post">';
echo '<input type="hidden" name="id" value="'.$id.'">';
echo '<input type="submit" class="submit" name="submit_comp" value="'.$lang['CONFIRM_JOB_COMP'].'"> ('.$lang['CLICK_DEL_JOB'].')';
}
if(isset($_POST['submit_comp']))
{
mysql_query("UPDATE members SET balance=balance+ '".$equals."' where username='$seller'") or die(mysql_error());
mysql_query("UPDATE jobs_bought SET job_completed='yes' where id='$id'") or die(mysql_error());
if(!mysql_query)
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
      else
            {
echo "<div class=\"cleared1\"></div><div class=\"dialog-box-success2\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['THANKS_JOB_COMP']."</div>
</div><div class=\"cleared1\"></div>";
}
echo "<META HTTP-EQUIV = 'Refresh' Content = '0; URL =orders.php?act=view&id=".$id."'>";
}
elseif(($featured) == 'no'){
$percent = $fee;
$total = $job_cost;
$tmppercent=100-$percent;
$equals=($total / 100 * $tmppercent);
if(($accepted) == 'yes' AND ($confirmed) == 'yes' AND ($completed) == 'no'){
echo '<form action="" method="post">';
echo '<input type="hidden" name="id" value="'.$id.'">';
echo '<input type="submit" class="submit" name="submit_end" value="'.$lang['CONFIRM_JOB_COMP'].'"> ('.$lang['CLICK_DEL_JOB'].')';
}
}
if(isset($_POST['submit_end']))
{
mysql_query("UPDATE members SET balance=balance+ '".$equals."' where username='$seller'") or die(mysql_error());
mysql_query("UPDATE jobs_bought SET job_completed='yes' where id='$id'") or die(mysql_error());
if(!mysql_query)
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
      else
            {
echo "<div class=\"cleared1\"></div><div class=\"dialog-box-success2\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['THANKS_JOB_COMP']."</div>
</div><div class=\"cleared1\"></div>";
}
echo "<META HTTP-EQUIV = 'Refresh' Content = '0; URL =orders.php?act=view&id=".$id."'>";
}
echo '</div>';
}
}
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
    $query = sprintf("INSERT INTO seller_feedback (job_id, rating, username, text)
            VALUES( '%s','%s','%s','%s')",
            mysql_real_escape_string($job_id),
            mysql_real_escape_string($rating),
            mysql_real_escape_string($username),
            mysql_real_escape_string($text));
            mysql_query("update jobs_sold set feedback_left = 'yes' where job_id = '".mysql_real_escape_string($job_id)."'");
            if(!mysql_query($query))
{
echo 'Query failed '.mysql_error();
die();
}
if($_POST['rating'] == 'images/positive.png')
{
mysql_query("update members SET pos_feed=pos_feed+1 where username='".mysql_real_escape_string($seller)."'");

}else
if($_POST['rating'] == 'images/neutral.png')
{
mysql_query("update members SET neut_feed=neut_feed+1 where username='".mysql_real_escape_string($seller)."'");
}else
if($_POST['rating'] == 'images/negative.png')
{
mysql_query("update members SET neg_feed=neg_feed+1 where username='".mysql_real_escape_string($seller)."'");
}header( 'Location: thanks.php' ) ;
}
$fback = mysql_query("select * from jobs_sold where username='".mysql_real_escape_string($seller)."' AND buyer_username='".mysql_real_escape_string($buyer)."' AND job_id='".mysql_real_escape_string($job_id)."' AND feedback_left='no' AND accepted='yes' AND rejected='no'");
$qrnum = mysql_num_rows($fback);
if($qrnum > 0) {
?>
<div class="feedback">
<h2><?PHP echo $lang['LEAVE_FEED']?> for <? echo $seller ?></h2>
<div class="feedback_form"><form action="" name="feedback" method="post" onSubmit="return validate_feedform ();">
<div id="allFields">
<div class="fields">
<input type="hidden" name="job_id" value="<? echo $job_id?>">
<input type="hidden" name="username" value="<? echo $buyer?>">
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
<?
}
echo '<div class="feedback">
<h2>';
if(($username) == ''.$seller.'')
{ echo $lang['COMM_BUYER'];}
else{
echo $lang['COMM_SELLER'];}
echo '</h2>';
if(isset($_POST['comment']))
{
foreach($_POST as $key => $value) $_POST[$key] = urldecode(trim($value));
$job_id = intval($_POST['job_id']);
$img_path = $_POST['img_path'];
$username = $_POST['username'];
$text = $_POST['text'];
$postdate = date("F j, Y");
$query = sprintf("INSERT INTO job_communication (job_id, img_path, username, text, postdate)
            VALUES( '%s', '%s', '%s', '%s', '%s')",
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
            }
 header("Location: orders.php?act=view&id=$id");
}
$result = mysql_query("SELECT * from job_communication where `username` = '".$seller."' AND `job_id` ='".$job_id."' OR `username` = '".$buyer."' AND `job_id` ='".$job_id."'  order by id desc");
while($myrow = mysql_fetch_array($result)){
$text = stripslashes(nl2br($myrow['text']));
print "<div align=\"left\" ><img src=\"$siteurl/users/$myrow[img_path]\" height=\"45px\" width=\"45px\" alt=\"profile image\"></div><div align=\"left\" style=\"margin-left:60px;margin-top:-50px\"><p>".$text."</p></div><div class=\"clear\"></div><div align= \"right\">On $myrow[postdate]  by $myrow[username]";
echo "<hr size=\"1\" color=\"#81DCEF\" /></div>";
}
if(isset($_SESSION['userName'])){
echo '<div class="akform1"><form action="" name="comment" id="comment" method="post" enctype="multipart/form-data">
<div id="allFields">
<div class="fields">
<input type="hidden" name="id" value="'.$id.'">
<input type="hidden" name="job_id" value="'.$job_id.'">
<input type="hidden" name="img_path" value="'.$username.'/'.$img_path.'">
<input type="hidden" name="username" value="'.$username.'">
<div class="field">
<label>Your Message<span class="mandatory">*</span></label>
<textarea name="text" id="text"></textarea>
</div>
<div class="cleared2"></div>
</div>
<input type="submit" name="comment" value="'.$lang['SUBMIT'].'" class="Button"/>
</div>
</form>
</div>';
}
echo '</div>';
}
if(isset($_POST['delete'])){
$sql = "DELETE FROM jobs_bought where id='$_POST[id]' " or die(mysql_error());
$result = mysql_query($sql);
if(!mysql_query) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['ORD_NOT_DEL']."
</div></div>";
}else{ echo "<div class=\"dialog-box-success\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['ORD_DELETED']."<img src=\"images/rating_loading.gif\" width=\"220\" height=\"19\" alt=\"\" />
</div></div><META HTTP-EQUIV = 'Refresh' Content = '2; URL =orders'>";
}
}
?>
</div>
</div></div>
<? include("side.php");
include("footer.php");
ob_flush();
}
?>
<script language="JavaScript" type="text/javascript">
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
function confirmSubmitt()
{
var agree=confirm("<?PHP echo $lang['SURE_DEL_ORD']?>? ");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>