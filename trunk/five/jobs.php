<?PHP session_start();  $page='jobs';
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

include("php/jobs_content.php");
?>
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
function confirmSubmitt()
{
var agree=confirm("<?PHP echo $lang['NO_FUNDS']?>.");
if (agree)
	return true ;
else
	return false ;
}
/*]]>*/
</script>
<script type="text/javascript">
$(function() {
  $('.nyroModal').nyroModal();
});
</script>
<div class="ratings">
<div class="owner"><h2><a href="profile-<?PHP echo $my_user ?>"><?PHP echo $my_user ?>:</a></h2><img src="users/<?PHP echo $my_user ?>/<?PHP echo $img_pth ?>" alt="<?PHP echo $my_user ?>'s profile pic" title="<?PHP echo $my_user ?>'s profile pic"/>
<p><?PHP echo $lang['I_WILL']?> <?PHP echo $will_do ?> <?PHP echo $lang['FOR']?>:<span class="cost"><?PHP echo $currency_symbol?><?PHP echo $job_cost ?></span><br>
<?PHP echo $lang['IN']?> <a href="category-<?PHP echo seo_link_pv($category)."-".$category_id_pv; ?>"><b><?PHP echo $category ?></b></a><br><?PHP echo $lang['WORK_DURATION']?>: ~<?PHP echo $time_span ?> <?PHP echo $lang['DAYS']?></p>
</div>
<div class="queue">
<?PHP  include("php/queue.php");?>
</div>
<p class="viewed"><?PHP echo $lang['VIEWED']?> <?PHP echo "".$times_viewed.""?> Times.</p>
<div align="center" class="ratings_inner"><?PHP if(($pos_feed) == 0 AND ($neut_feed) == 0 AND ($neg_feed) == 0) {
echo "<img src=\"images/star.png\" alt=\"\" />$my_user ".$lang['NO_FEEDBACK']."";
}else{
$allPoints = $pos_feed + $neut_feed + $neg_feed;
$percent = round(($pos_feed) / $allPoints * 100);
?>
<img src="images/star.png"alt="" /> <a href="feedback.php?user=<?PHP echo $my_user?>"><b><?PHP echo $percent ?>% <?PHP echo $lang['POSITIVE_FEED']?></b></a>
<?PHP }?>
<div class="clr"></div>
<?PHP
if($username !== $_SESSION['userName']){ 
if(!empty($_SESSION['userName'])) { ?>
<form action="buy_now#buy_now" class="nyroModal" method="post" accept-charset="UTF-8">
<input type="hidden" name="ppemail" value="<?PHP echo $ppemail ?>"/>
<input type="hidden" name="willdo" value="<?PHP echo $my_job ?>"/>
<input type="hidden" name="user" value="<?PHP echo $username?>"/>
<input type="hidden" name="username" value="<?PHP echo $_SESSION['userName'] ?>"/>
<input type="hidden" name="id" value="<?PHP echo $id ?>"/>
<input type="hidden" name="price" value="<?PHP echo $job_cost ?>"/>
<input type="image" src="images/buy_now.png" border="0" width="100px" height="34px" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"></form>
<?PHP }else{ ?>
<a href="#" id="trigger_login"><img src="images/buy_now.png" border="0" width="100px" height="34px" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"></a></form>
<?PHP
}

if(!empty($_SESSION['userName'])) { ?>
<div class="clear"></div>
<form action="messages.php" method="post">
<input type="hidden" name="id" value="<?PHP echo $id ?>">
<input type="hidden" name="username" value="<?PHP echo $my_user ?>">
<input type="hidden" name="willdo" value="<?PHP echo $my_job ?>">
<input type="submit" name="contact" class="Button" value="Contact <?PHP echo $my_user?>" />
</form><?PHP }else{ ?><div class="clear"></div>
<a class='Button' href="#" id="trigger_login"><?PHP echo $lang['CONT']?> <?PHP echo $my_user?></a>
<?PHP
}
}
?>
</div>
</div><div class="clear"></div>

<div class="tags">
<?PHP
include("php/tags_content.php");
?></div>
<div class="art-image"><img src="<?PHP echo $image_path ?>"  alt="an image"/></div>
<h2><?PHP echo $lang['JOB_DESC']?></h2>
<?PHP if ($link==''){echo"";}else{ ?>
<p><?PHP echo $lang['LINK']?>: <a href="<?PHP echo $link ?>"><?PHP echo $link ?></a></p>
<?PHP }
if ($video_link==''){echo"";}else{ ?>
<p><?PHP echo $lang['VIDEO']?>: <a href="<?PHP echo $video_link ?>" class="nyroModal"><?PHP echo $video_link ?></a></p>
<?PHP } ?>
<p><?PHP echo $job_description?></p>
<div class="share">
<u><?PHP echo $lang['SHARE_THIS']?>:</u><div class="clear"></div>
<a href="http://www.facebook.com/share.php?u=<?PHP echo $siteurl?>/<?PHP echo $seo?>-<?PHP echo $id?>.html" target="_blank"><img src="images/facebook-button.png" width="16" height="16" alt="send-to-facebook" border="0"/> Facebook</a><div class="clear"></div>
<a href="http://twitter.com/home?status= <?PHP echo $willdo?>...<?PHP echo $siteurl?>/<?PHP echo $seo?>-<?PHP echo $id?>.html" title="Click to send this page to Twitter!" target="_blank"><img src="images/twitter-button.png" width="16" height="16" alt="send-to-Twitter" border="0"/> Twitter</a><div class="clear"></div>
<a href="mailto:?subject=<?PHP echo $lang['I_FOUND']?>: <?PHP echo $job_description=str_replace('"','\'',($job_description)) ?> &body=<?PHP echo $lang['CHECK_THIS_OUT']?>: <?PHP echo $siteurl?>/<?PHP echo $seo?>-<?PHP echo $id?>.html"  target="_blank"><img src="images/email-button.png" width="16" height="16" alt="Email-This" border="0"/> Email</a><div class="clear"></div>
<!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4c3edd902ccd9673"><img src="http://s7.addthis.com/static/btn/sm-share-en.gif" width="83" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript">
var addthis_config = {
services_exclude: 'email, facebook, twitter, print'
}
</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4c3edd902ccd9673"></script>
<!-- AddThis Button END --><div class="clear"></div>
<iframe src="http://www.facebook.com/plugins/like.php?href=<?PHP echo $siteurl?>/<?PHP echo $seo?>-<?PHP echo $id?>.html>&amp;layout=button_count&amp;show_faces=false&amp;width=90&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:90px; height:21px;" allowTransparency="true"></iframe>
<g:plusone size="medium"></g:plusone>
<!-- Place this tag after the last plusone tag -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
<?PHP
include("php/bookmark_job.php");
?></div>
<div id="Feedback">
<h2><?PHP echo $lang['BUYERS_FEEDBACK']?></h2>
<?PHP
include("php/feedback.php");
?>
</div>
<div id="rel_oth">
<div class="other"><h2><?PHP echo $lang['OTHER_JOBS']?> <a href="profile-<?PHP echo $username?>"> <?PHP echo $username?></a></h2>
<?PHP $sql  = "SELECT * from jobs where username = '".$username."' AND `approved` = 'Yes' AND `id`!='$id'";
$result = mysql_query($sql);
while($rows = mysql_fetch_array($result, MYSQL_ASSOC)){
$id = $rows['id'];
$category = $rows['category'];
$img_path = $rows['img_path']; 
// seo_link_pv function below is in functions/general.php - change that function if you want to change how seo urls are formatted
$seo = seo_link_pv($rows['willdo']);


?>
<div class="Other"><a href='<?PHP echo $seo?>-<?PHP echo $id ?>.html'>
<img src='<?PHP echo $img_path ?>'></a><a href='<?PHP echo $seo?>-<?PHP echo $id ?>.html'>
<p><?PHP echo $lang['I_WILL']?> <?PHP echo $rows['willdo'] ?></p></a><div class='incat'><a href='category-<?PHP echo $category?>'><?PHP echo $category?></a>
</div></div>
<?PHP }?>
</div>
<div class="related"><h2><?PHP echo $lang['RELATED_JOBS']?>.</h2>
<?PHP $sql  = "SELECT * from jobs where category = '".$category."' AND `approved` = 'Yes'";
$result = mysql_query($sql);
while($rows = mysql_fetch_array($result, MYSQL_ASSOC)){
$id = mysql_real_escape_string($rows['id']);
$category = $rows['category'];
$img_path = $rows['img_path'];
$seo = str_replace(' ', '-', trim($rows[willdo]));
$seo = stripslashes(nl2br($seo));
$seo1 = str_replace('-', ' ', trim($seo));?>
<div class="Related"><a href='<?PHP echo $seo?>-<?PHP echo $id ?>.html'>
<img src='<?PHP echo $img_path ?>'></a><a href='<?PHP echo $seo?>-<?PHP echo $id ?>.html'>
<p><?PHP echo $lang['I_WILL']?> <?PHP echo $seo1 ?></p></a><div class='incat'><a href='category-<?PHP echo $category?>'><?PHP echo $category?></a>
</div></div>
<?PHP }?>
</div>
</div></div>
<?PHP
include("side.php");
include("footer.php");
?>