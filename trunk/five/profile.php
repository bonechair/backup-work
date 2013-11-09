<?PHP  session_start();
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

$page_name = 'profile';
include("connect.php");
$user = $_GET[username];
$sql5 = mysql_query("SELECT * FROM members where username = '$user'") or die(mysql_error());
$myrow = mysql_fetch_array($sql5);
$username = $myrow['username'];
if((!$username) == 1){header('Location: index.php');}
$result = mysql_query("SELECT * FROM sitesettings");
while($myrow = mysql_fetch_array($result))
{
$title = "".$myrow["domain"]." - Profile: $user";
$rpp = 10; // results per page
$adjacents = 4;
$page = intval($_GET["page"]);
if(!$page) $page = 1;
$siteurl = $myrow["site_url"];
$reload = "".$myrow["site_url"]."/profile-".$user."";
}
include("header.php");
$settings = mysql_query("select * from members where username='".mysql_escape_string($user)."'");
while ($rows = mysql_fetch_array($settings)){
$pos_feed = $rows['pos_feed'];
$neut_feed = $rows['neut_feed'];
$neg_feed = $rows['neg_feed'];
$fbid = $rows['fbid'];
$about=stripslashes(nl2br($rows['about']));
$img_path = $rows['img_path'];
$username=$rows['username'];
}

if(!empty($_SESSION['userName'])) {
echo '<div class="close_gap"></div>';
}
echo'<div class="feed">';
echo'<h2>'.$user.'\'s '.$lang["PUBLIC_PROFILE"].'</h2>';
if(($pos_feed) == 0 AND ($neut_feed) == 0 AND ($neg_feed) == 0) {echo "<img src=\"images/star.png\" alt=\"\" />".$user." ".$lang["NO_FEEDBACK"]."<div class=\"clear\"></div>";}else{
$allPoints = $pos_feed + $neut_feed + $neg_feed;
$percent = round(($pos_feed) / $allPoints * 100);
echo '<img src="images/star.png" alt="" />'.$percent.'% '.$lang["POS_FEEDBACK"].' <a href="feedback.php?user='.$user.'"> - <i>'.$lang["VIEW_FEEDBACK"].'</i></a><div class="clear"></div>'; }
if($user !== $_SESSION['userName']){
if(empty($_SESSION['userName'])) {
echo'<div class="contact" id="trigger_login">'.$lang["CONTACT_USER"].' '.$user.'</div>';
}else{
echo'<div class="contact">'.$lang["CONTACT_USER"].' '.$user.'</div><div class="cont_user">'.$lang["CONTACT_USER"].' '.$user.'<br />
<form action="messageform.php" id="upload" name="message_form" method="post" enctype="multipart/form-data" onSubmit="return validate_messageform ();">
<input type="hidden" name="sender_id" value="'.$_SESSION['userName'].'">
<input type="hidden" name="receiver_id" value="'.$user.'">
<input type="text" name="subject" onfocus="value=\'\'" value="'.$lang['SUBJECT'].'" class="textfield" /><br />
<textarea name="message" class="textarea_small" onfocus="value=\'\'">'.$lang['YOUR_MESSAGE'].'</textarea><br />
<label>'.$lang['ADD_ATT'].' <input type="checkbox" name="attatch" onclick="doInputs(this)"/></label>
<div id="appear_div"><input name="upload" type="file"></div><br />';
echo '<input name="submit" type="submit" class="Button" value="'.$lang["SEND_MESSAGE"].'"/>';
echo '</form></div>';
}
}
echo '<div class="profile_box">
<img src="users/'.$user.'/'.$img_path.'" width="100px" height="100px" alt="'.$user.'s '.$lang["PROF_PIC"].'" style="float: left;margin-right:10px;" />
'.$about.'
<div class="clear"></div>';
echo '</div>';
$fback = mysql_query("select * from jobs_bought where username='".$_SESSION['userName']."'  AND `feedback_left`='no' AND `accepted`='yes' ORDER BY id DESC");
$qrnum = mysql_num_rows($fback);
if($qrnum > 0) { echo '<div class="fback_box"><div class="clr"></div><h2>'.$lang["NEED_LEAVE_FEED"].' '.$qrnum.' sale(s)!</h2>';

echo "<table class=\"sortable\" id=\"cont\" width=\"100%\">
<tr>
<th class=\"th-2\">". $lang['JOB_ID']."</th>
<th class=\"th-4\">".$lang['JOB_TITLE']."</th>
<th class=\"th-6\">".$lang['SELLER']."</th>
<th class=\"th-1\">".$lang['DATE']."</th></tr>";
while($fresult = mysql_fetch_array($fback)){
$job = str_replace(' ', '-', trim($fresult['willdo']));
echo '<tr>
<td class=\"td-2\">'.$fresult['job_id'].'</td>
<td class=\"td-4\"><a href="'.$job.'-'.$fresult['job_id'].'.html">'.$fresult['willdo'].'</a></td>
<td class=\"td-6\"><a href="profile-'.$fresult['seller_username'].'">'.$fresult['seller_username'].'</a></td>
<td class=\"td-1\">'.$fresult['date'].'</td>';
}
echo '</table>';
echo '</div>';
}
echo "<div class=\"clr\"></div></div><div class=\"clr\"></div><h2> ". $lang['JOBSBY']." ".$user." </h2>";
$sql = "SELECT * FROM jobs,sitesettings WHERE username='".mysql_escape_string($user)."'AND  `approved` = 'yes' ORDER BY id DESC";
$result2 = mysql_query($sql)or die(mysql_error());
$tcount = mysql_num_rows($result2);
$tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
$count = 0;
$i = ($page-1)*$rpp;
while(($count<$rpp) && ($i<$tcount)) {
mysql_data_seek($result2,$i);
$row = mysql_fetch_array($result2);
$featured = $row['featured'];
$category = $row['category'];
$jobcost = $row['job_cost'];
$willdo=stripslashes(nl2br($row['willdo']));
$part_description=stripslashes(nl2br($row['part_description']));
$job_description=stripslashes(nl2br($row['job_description']));
$username = $row['username'];
$id = $row['id'];
$img_path = $row['img_path'];
$postdate = $row['postdate'];
$times_viewed = $row['times_viewed'];
// seo_link_pv function below is in functions/general.php - change that function if you want to change how seo urls are formatted
$seo=seo_link_pv($willdo);
$voteup1 = $row['voteup'];
$votedown1 = $row['votedown'];
$voting_array1 = mysql_fetch_array(mysql_query("SELECT * FROM `votes` WHERE `ip`='".mysql_real_escape_string($ip)."'"));
$vote_explode1 = explode(',', $voting_array1['article_id']);
foreach($vote_explode1 as $vote_ex1){
$vote_ex1 = explode(":", $vote_ex1);
$compnum1 = $vote_ex1[0];
$compvote1 = $vote_ex1[1];
$compvotearray1[$compnum1] = $compvote1;
}
?>
<div class="article">
<?PHP if ( $featured == yes ) { ?><div class="featured"><img class="job_img" src="images/featured.png" width="71" height="71" alt="" border="0"/></div><?PHP }?>
<div class="art_img"><a href="<?PHP echo $seo?>-<?PHP echo $id?>.html"><img src="<?PHP echo $img_path ?>" width="127" height="98" alt="img" class="" /></a>


<h3><a href="<?PHP echo $seo?>-<?PHP echo $id ?>.html"><?PHP echo $lang['I_WILL']?> <?PHP echo $willdo ?></a></h3>
<div class="clr"></div>
<?PHP if(!$compvotearray1[$id]){?><div class="vote">
<span id="vote_buttons<?PHP echo $id ?>" class="vote_buttons"></span><span id="vote_buttons<?PHP echo $id ?>" class="vote_buttons"></span>
                <span id="a1votes_count<?PHP echo $id ?>">
                <a id=":<?PHP echo $id ?>:1:<?PHP echo $voteup1 ?>:<?PHP echo $votedown1 ?>:" class="vote_up" href="javascript:;">
                <img src="images/positive.png" width="16" height="16" alt="Up" border="0"title="Vote Up :)"/><?PHP echo $voteup1 ?></a></span>&nbsp;&nbsp;<span id="a2votes_count<?PHP echo $id ?>">
                <a id=":<?PHP echo $id ?>:2:<?PHP echo $voteup1 ?>:<?PHP echo $votedown1 ?>:" class="vote_down" href="javascript:;">
                <img src="images/negative.png" width="16" height="16" alt="Down" border="0" title="Vote Down :("/><?PHP echo $votedown1 ?></a>
                </span></div><?PHP }else{?><div class="vote">
<span id="vote_buttons<?PHP echo $id ?>" class="vote_buttons"></span><span id="vote_buttons<?PHP echo $id ?>" class="vote_buttons"></span>
                <span id="vote_buttons<?PHP echo $id ?>" class="vote_buttons voted"></span>
                <span id="votes_count<?PHP echo $id ?>">
                <img src="images/voted.png" width="16" height="16" alt="Up" border="0" title="You have already voted for this job"/><a><?PHP echo $voteup1 ?></a></span>&nbsp;&nbsp;<span id="a2votes_count<?PHP echo $id ?>" class="vote_buttons voted">
                <img src="images/voted_neg.png" width="16" height="16" alt="Down" border="0" title="You have already voted for this job"/><a><?PHP echo $votedown1 ?></a>
                </span></div><?PHP } ?>
	<div class="clr"></div>				
				<? if ( $username == $_SESSION['userName'] ) {echo $times_viewed.' '.$lang['VIEWS'].' | <a href="my_jobs.php?act=edit&id='.$id.'" >'.$lang['EDIT_JOB'].'</a><br><br><a href="my_jobs.php?act=delete&id='.$id.'" onClick="return confirmSubmitt()">'.$lang['DELETE_JOB'].'</a>';}else {?><a class="Button" href="<? echo $seo?>-<? echo $id ?>.html"><?PHP echo $lang['ORDER_NOW']?></a><?}?>

<div class="clr"></div>			
</div>
</div>

<?PHP
$i++;
$count++;
}
?>
<?PHP  ?>
<div class="clr"></div>
<div class="pagination"><? include("php/pagination_cat.php");
echo paginate_three($reload, $page, $tpages, $adjacents);?></div>
</div>
<?PHP include("side.php"); ?>
<?PHP include("footer.php"); ?>
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
 <script>
    $("div.contact").click(function () {
      $("div.cont_user").slideToggle("slow");
    });
</script>