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
 
$page_name = 'index.php';
include("connect.php");
$page_no = $_GET['page'];
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$tagline = stripslashes($row["tagline"]);
$title = "".$row["domain"]." - ".$tagline."";
$siteurl =  $row["site_url"];
$feat_num =  $row["feat_num"];
$currency_symbol =  $row["currency_symbol"];
$google_ads =  $row["google_ads"];
$price_range =  $row["price_range"];
$dropdown =  $row["dropdown"];
}

include("header.php");
include("filter.php");
echo '';
if($google_ads == 'yes') { echo '<div class="clear"></div><div align="center">';
include("google_ads/google_468x60.php"); echo '</div><div class="clear"></div>'; }

if ($page_no != ''){}else{
$job_cost = mysql_real_escape_string($_POST['job_cost']);
$sql = "SELECT * FROM jobs,sitesettings WHERE `approved` = 'Yes' AND `featured` = 'Yes' ORDER BY rand() LIMIT $feat_num";
if($job_cost){
$sql = "SELECT * FROM jobs,sitesettings WHERE `approved` = 'Yes' AND `featured` = 'Yes' AND `job_cost` = '$job_cost' ORDER BY id desc ";
}
$rs = mysql_query($sql)or die(mysql_error());
while($row = mysql_fetch_assoc($rs)) {
$currency = $row['currency'];
$featured = $row['featured'];
$category = $row['category'];
$jobcost = $row['job_cost'];
$willdo=stripslashes(nl2br($row['willdo']));
$part_description=stripslashes($row['part_description']);
$job_description=stripslashes($row['job_description']);
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
include 'languages/'.$lang_file.'/'.$lang_file.'.php'; ?>
<div class="art_img"><a href="<?PHP echo $seo?>-<?PHP echo $id?>.html"><img src="<?PHP echo $img_path ?>" width="127" height="98" alt="img" class="" /></a></div>
<div class="article">
<div class="featured"><img class="job_img" src="images/featured.png" width="71" height="71" alt="" border="0"/></div>
<h3><a href="<?PHP echo $seo?>-<?PHP echo $id ?>.html"><?PHP echo $lang['I_WILL']?> <?PHP echo $willdo ?></a></h3>
<div class="p_desc"><?PHP echo $part_description ?>...<a class="p_des" href="<?PHP echo $seo?>-<?PHP echo $id ?>.html"><?PHP echo $lang['MORE']?></a></div>
<div class="crumbs"><?PHP echo $lang['BY']?>~<a href="profile-<?PHP echo $username ?>"><?PHP echo $username ?></a> <?PHP echo $lang['IN']?>~<a href="category-<?PHP echo $category ?>"><?PHP echo $category ?></a> <?PHP echo $lang['ON']?>~<?PHP echo $postdate ?>
<a href="<?PHP echo $seo?>-<?PHP echo $id ?>.html" title="Click to buy this job"><span class="jobcost"><?PHP echo $currency_symbol ?><?php echo $jobcost?></span></a>
<div class="fbook"><?PHP if(!$compvotearray1[$id]){?><div class="vote">
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
<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?PHP echo $siteurl?>/<?PHP echo $seo?>-<?PHP echo $id ?>.html" data-count="horizontal" data-via="<?PHP echo $siteurl?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script><iframe src="http://www.facebook.com/plugins/like.php?href=<?PHP echo $siteurl?>/<?PHP echo $seo?>-<?PHP echo $id ?>.html&amp;layout=button_count&amp;show_faces=false&amp;width=120&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px;margin-bottom:-1px;margin-left:-12px;" allowTransparency="true"></iframe></div>
</div>
</div><div class="shadow"><img src="images/shadow.png" width="692" height="5" alt="" /></div>
<?PHP
}
}
$reload = $_SERVER['PHP_SELF'];
$rpp = 15; // results per page
$adjacents = 4;
$page = intval($_GET["page"]);
if(!$page) $page = 1;
$sql2 = "SELECT * FROM jobs,sitesettings WHERE `approved` = 'Yes' AND `featured` = 'No' ORDER BY id desc";
if($job_cost){
$sql2 = "SELECT * FROM jobs,sitesettings WHERE `approved` = 'Yes' AND `featured` = 'No' AND `job_cost` = '$job_cost' ORDER BY id desc ";
}
$result2 = mysql_query($sql2)or die(mysql_error());
$tcount = mysql_num_rows($result2);
$tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
$count = 0;
$i = ($page-1)*$rpp;
while(($count<$rpp) && ($i<$tcount)) {
mysql_data_seek($result2,$i);
$row2 = mysql_fetch_array($result2);
$featured = $row2['featured'];
$Category = $row2['category'];
$job_cost = $row2['job_cost'];
$will_do=stripslashes(nl2br($row2['willdo']));
$partdescription=stripslashes($row2['part_description']);
$jobdescription=stripslashes($row2['job_description']);
$user_name = $row2['username'];
$Id = $row2['id'];
$imgpath = $row2['img_path'];
$post_date = $row2['postdate'];
$timesviewed = $row2['times_viewed'];
$voteup = $row2['voteup'];
$votedown = $row2['votedown'];
// seo_link_pv function below is in functions/general.php - change that function if you want to change how seo urls are formatted
$seo1=seo_link_pv($will_do);
$voting_array = mysql_fetch_array(mysql_query("SELECT * FROM `votes` WHERE `ip`='".mysql_real_escape_string($ip)."'"));
$vote_explode = explode(',', $voting_array['article_id']);
foreach($vote_explode as $vote_ex){
$vote_ex = explode(":", $vote_ex);
$compnum = $vote_ex[0];
$compvote = $vote_ex[1];
$compvotearray[$compnum] = $compvote;
    }
include 'languages/'.$lang_file.'/'.$lang_file.'.php';?>
<div class="art_img"><a href="<?PHP echo $seo1?>-<?PHP echo $Id?>.html"><img src="<?PHP echo $imgpath ?>" width="127" height="98" alt="img" class="" /></a></div>
<div class="article">
<h3><a href="<?PHP echo $seo1?>-<?PHP echo $Id ?>.html"><?PHP echo $lang['I_WILL']?> <?PHP echo $will_do ?></a></h3>
<div class="p_desc"><?PHP echo $partdescription ?>...<a class="p_des" href="<?PHP echo $seo1?>-<?PHP echo $Id ?>.html"><?PHP echo $lang['MORE']?></a></div>
<div class="crumbs"><?PHP echo $lang['BY']?>~<a href="profile-<?PHP echo $user_name ?>"><?PHP echo $user_name ?></a> In~<a href="category-<?PHP echo $Category ?>"><?PHP echo $Category ?></a> On~<?PHP echo $post_date ?>
<a href="<?PHP echo $seo1?>-<?PHP echo $Id ?>.html" title="Click to buy this job"><span class="jobcost"><?PHP echo $currency_symbol ?><?php echo $job_cost?></span></a>
<div class="fbook"><?PHP if(!$compvotearray[$Id]){?><div class="vote">
<span id="vote_buttons<?PHP echo $Id ?>" class="vote_buttons"></span><span id="vote_buttons<?PHP echo $Id ?>" class="vote_buttons"></span>
                <span id="a1votes_count<?PHP echo $Id ?>">
                <a id=":<?PHP echo $Id ?>:1:<?PHP echo $voteup ?>:<?PHP echo $votedown ?>:" class="vote_up" href="javascript:;">
                <img src="images/positive.png" width="16" height="16" alt="Up" border="0"title="Vote Up :)"/><?PHP echo $voteup ?></a></span>&nbsp;&nbsp;<span id="a2votes_count<?PHP echo $Id ?>">
                <a id=":<?PHP echo $Id ?>:2:<?PHP echo $voteup ?>:<?PHP echo $votedown ?>:" class="vote_down" href="javascript:;">
                <img src="images/negative.png" width="16" height="16" alt="Down" border="0" title="Vote Down :("/><?PHP echo $votedown ?></a>
                </span></div><?PHP }else{?><div class="vote">
<span id="vote_buttons<?PHP echo $Id ?>" class="vote_buttons"></span><span id="vote_buttons<?PHP echo $Id ?>" class="vote_buttons"></span>
                <span id="vote_buttons<?PHP echo $Id ?>" class="vote_buttons voted"></span>
                <span id="votes_count<?PHP echo $Id ?>">
                <img src="images/voted.png" width="16" height="16" alt="Up" border="0" title="You have already voted for this job"/><a><?PHP echo $voteup ?></a></span>&nbsp;&nbsp;<span id="a2votes_count<?PHP echo $Id ?>" class="vote_buttons voted">
                <img src="images/voted_neg.png" width="16" height="16" alt="Down" border="0" title="You have already voted for this job"/><a><?PHP echo $votedown ?></a>
                </span></div><?PHP } ?>
<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?PHP echo $siteurl?>/<?PHP echo $seo1?>-<?PHP echo $Id ?>.html" data-text="<?PHP echo $seo1?>"data-count="horizontal" data-via="<?PHP echo $siteurl?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script><iframe src="http://www.facebook.com/plugins/like.php?href=<?PHP echo $siteurl?>/<?PHP echo $seo1?>-<?PHP echo $Id ?>.html&amp;layout=button_count&amp;show_faces=false&amp;width=120&amp;action=like&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:120px; height:21px;margin-bottom:-1px;margin-left:-12px;" allowTransparency="true"></iframe></div></div>
</div><div class="shadow"><img src="images/shadow.png" width="692" height="5" alt="" /></div>
<?PHP
$i++;
$count++;
}
?>
<div class="clear"></div>
<?PHP if($google_ads == 'yes') { echo '<div align="center">';
include("google_ads/google_468x60.php"); echo '</div>'; }
echo '<div class="clear"></div>';?>
<div class="pagination"><?PHP include("php/pagination3.php");
echo paginate_three($reload, $page, $tpages, $adjacents);?></div>
</div>
<?PHP include("side.php");
include("footer.php"); ?>