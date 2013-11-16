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


$page_name = 'featured.php';
include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - ".$row["tagline"]."";
$siteurl =  $row["site_url"];
}
include("header.php");
include("filter.php");
echo "<h3>".$lang['FEATURED_JOBS']."</h3>";
$reload = $_SERVER['PHP_SELF'];
$rpp = 15; // results per page
$adjacents = 4;
$page = intval($_GET["page"]);
if(!$page) $page = 1;
$job_cost = mysql_real_escape_string($_POST['job_cost']);
$sql = "SELECT * FROM jobs,sitesettings WHERE `approved` = 'Yes' AND `featured` = 'yes' ORDER BY id desc";
if($job_cost){
$sql = "SELECT * FROM jobs,sitesettings WHERE `approved` = 'Yes' AND  `featured` = 'yes' AND `job_cost` = '$job_cost' ORDER BY id desc ";
}
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
?>

<div class="article">

<?PHP if ( $featured == yes ) { ?><div class="featured"><img class="job_img" src="images/featured.png" width="71" height="71" alt="" border="0"/></div><?PHP }?>
<div class="clr"></div>
<div class="art_img"><a href="<?PHP echo $seo?>-<?PHP echo $id?>.html"><img src="<?PHP echo $img_path ?>" width="127" height="98" alt="img" class="" /></a></div>
<div class="clr"></div>

<a href="profile-<?PHP echo $username ?>"><?PHP echo $username ?></a>~<a href="category-<?PHP echo $category ?>"><?PHP echo $category ?></a>
<div class="clr"></div>
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
	<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?PHP echo $siteurl?>/<?PHP echo $seo?>-<?PHP echo $id ?>.html" data-count="horizontal" data-via="<?PHP echo $siteurl?>">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<div class="clr"></div>	
</div>
<?PHP
$i++;
$count++;
}
?>
	<div class="clr"></div>	
<div class="pagination"><? include("php/pagination3.php");
echo paginate_three($reload, $page, $tpages, $adjacents);?></div>
</div>
<?PHP include("side.php"); ?>
<?PHP include("footer.php"); ?>