<?PHP
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
 
$page_name = 'jobs';
include("connect.php");
$id = intval($_GET['id']);
$username = $_SESSION['userName'];
$rs_settings = mysql_query("select * from members where username='".$_SESSION['userName']."'");
while ($data = mysql_fetch_array($rs_settings)) {
$email = stripslashes(nl2br($data['email']));
$full_name = stripslashes(nl2br($data['full_name']));
$country = stripslashes(nl2br($data['country']));
$about = stripslashes(nl2br($data['about']));
}
$result = mysql_query("SELECT * FROM sitesettings,jobs where id = '".$id."' AND `approved` = 'Yes'");
while($row = mysql_fetch_array($result))
{
$domain = stripslashes(nl2br($row['domain']));
$siteurl = stripslashes(nl2br($row['site_url']));
$ppemail = stripslashes(nl2br($row['ppemail']));
$featured = stripslashes(nl2br($row['featured']));
$currency = stripslashes(nl2br($row['currency']));
$currency_symbol = stripslashes(nl2br($row['currency_symbol']));
$part_description=stripslashes(str_replace('<br />', ' ',($row['part_description'])));

$title = "".$domain." - ".$part_description." ";
}

if($_GET['enter']=="go"){
$id = intval($_GET['id']);
$username = $_SESSION['userName'];
$query = sprintf("INSERT INTO likes (job_id, username)
            VALUES( '%s', '%s')",
            mysql_real_escape_string($id),
            mysql_real_escape_string($username));
            // run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
}
if($_GET['enter']=="no"){
$id = intval($_GET['id']);
$sql = "DELETE FROM likes where  job_id='$id' AND `username` = '".$_SESSION['userName']."'" or die(mysql_error());
$result = mysql_query($sql);
}
$sql  = "SELECT * from jobs where id = '".mysql_real_escape_string($id)."' AND `approved` = 'Yes' ";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
// seo_link_pv function below is in functions/general.php - change that function if you want to change how seo urls are formatted
$seo=seo_link_pv($row['willdo']);
}
include("header.php");
$sql  = "SELECT * from jobs where id = '".mysql_real_escape_string($id)."' AND `approved` = 'Yes' ";
$result = mysql_query($sql);
while($row = mysql_fetch_array($result, MYSQL_ASSOC)){
$username=$row['username'];
$category=$row['category'];
// Ozgur - get the category id from category name here
$category_id_query_pv=@mysql_query("SELECT catid FROM categories WHERE catname = '".$category."'");
$category_id_fetch_pv=@mysql_fetch_assoc($category_id_query_pv);
$category_id_pv=$category_id_fetch_pv['catid'];

$job_cost=$row['job_cost'];
$time_span=$row['time_span'];
$times_viewed = $row['times_viewed'];

$link=$row['link'];
$video_link=$row['video_link'];
$image_path = $row['img_path'];

$job_description=stripslashes($row['job_description']);
$part_description=stripslashes($row['part_description']);
$keywords=$row['keywords'];
// seo_link_pv function below is in functions/general.php - change that function if you want to change how seo urls are formatted
$seo=seo_link_pv($row['willdo']);
$will_do = stripslashes(nl2br($row['willdo']));
$my_job = htmlentities($will_do, ENT_QUOTES);

}

$settings = mysql_query("select * from members where username='".mysql_real_escape_string($username)."'");
while ($m_row = mysql_fetch_array($settings)) {
$email1 = $m_row['email'];
$pos_feed = $m_row['pos_feed'];
$neut_feed = $m_row['neut_feed'];
$neg_feed = $m_row['neg_feed'];
$my_user = $m_row['username'];
$img_pth = $m_row['img_path'];
}
mysql_query("update jobs SET times_viewed=times_viewed+1 where id='".mysql_real_escape_string($id)."'");
?>