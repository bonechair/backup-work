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
 

if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}
include("connect.php");

$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - submit a job";
$site_email = $row['site_email'];
$domain = $row["domain"];
$siteurl =  $row["site_url"];
$tweet = $row["tweet"];
$mod_job = $row["mod_job"];
$currency_symbol =  $row["currency_symbol"];
$featured_fee = $row['featured_fee'];
$price_range = $row['price_range'];
$dropdown =  $row["dropdown"];
$lang1 =  $row["lang"];
}
include("header.php");
$path_thumbs = "users/".$_SESSION['userName']."";
$path_big = "users/".$_SESSION['userName']."";
//the new width of the resized image.
$img_thumb_width = 300; // in pixcel
$extlimit = "yes"; //Do you want to limit the extensions of files uploaded (yes/no)
//allowed Extensions
$limitedext = array(".jpg",".jpeg",".gif",".png",);
if(isset($_POST['Submit_job'])){
$username=$_POST['username'];
$postdate = date("j-n-Y");
$willdo = $_POST['willdo'];
$willdo = str_replace('/', '\\',($willdo));
$link = $_POST['link'];
$video_link = $_POST['video_link'];
$video_link = str_replace('watch?v=', 'v/',($video_link));
$job_description = nl2br($_POST['job_description']);
$part_description = nl2br($_POST['job_description']);
$keywords = $_POST['keywords'];
$time_span = $_POST['time_span'];
$category = $_POST["category"];
$job_cost = $_POST["job_cost"];
$featured = $_POST["featured"];
$file_type = $_FILES['img_path']['type'];
       $file_name = $_FILES['img_path']['name'];
       $file_size = $_FILES['img_path']['size'];
       $file_tmp = $_FILES['img_path']['tmp_name'];

       //check if you have selected a file.
       if(!is_uploaded_file($file_tmp)){
          die ('You need to select an image');
          exit(); //exit the script and don't do anything else.
       }
       //check file extension
       $ext = strrchr($file_name,'.');
       $ext = strtolower($ext);
       if (($extlimit == "yes") && (!in_array($ext,$limitedext))) {
          die ('File extension not allowed');
          exit();
       }
       //get the file extension.
       $getExt = explode ('.', $file_name);
       $file_ext = $getExt[count($getExt)-1];

       //create a random file name
       $rand_name = md5(time());
       $rand_name= rand(0,999999999);
       //get the new width variable.
       $ThumbWidth = $img_thumb_width;

       //keep image type
       if($file_size){
          if($file_type == "image/pjpeg" || $file_type == "image/jpeg"){
               $new_img = imagecreatefromjpeg($file_tmp);
           }elseif($file_type == "image/x-png" || $file_type == "image/png"){
               $new_img = imagecreatefrompng($file_tmp);
           }elseif($file_type == "image/gif"){
               $new_img = imagecreatefromgif($file_tmp);
           }
           //list width and height and keep height ratio.
           list($width, $height) = getimagesize($file_tmp);
           $imgratio=$width/$height;
           if ($imgratio>1){
              $newwidth = $ThumbWidth;
              $newheight = $ThumbWidth/$imgratio;
           }else{
                 $newheight = $ThumbWidth;
                 $newwidth = $ThumbWidth*$imgratio;
           }
           //function for resize image.
           if (function_exists(imagecreatetruecolor)){
           $resized_img = imagecreatetruecolor($newwidth,$newheight);
           }else{
                 die("Error: Please make sure you have GD library ver 2+");
           }
           imagecopyresized($resized_img, $new_img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
           //save image
           ImageJpeg ($resized_img,"$path_thumbs/$rand_name.$file_ext");
           ImageDestroy ($resized_img);
           ImageDestroy ($new_img);
           $img_path = "$path_thumbs/$rand_name.$file_ext";


        }
if($mod_job == 'Yes') {
    $query = sprintf("INSERT INTO jobs (willdo, username, postdate, category, job_cost, link, video_link, job_description, part_description, keywords, time_span, featured, img_path)
            VALUES( '%s', '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
            mysql_real_escape_string($willdo),
            mysql_real_escape_string($username),
            mysql_real_escape_string($postdate),
            mysql_real_escape_string($category),
            mysql_real_escape_string($job_cost),
            mysql_real_escape_string($link),
            mysql_real_escape_string($video_link),
            mysql_real_escape_string($job_description),
            mysql_real_escape_string($part_description),
            mysql_real_escape_string($keywords),
            mysql_real_escape_string($time_span),
            mysql_real_escape_string($featured),
            mysql_real_escape_string($img_path));
// run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
      else
            {
header( 'Location: /profile-' . $_SESSION['userName'] ) ;				
echo "<div class=\"dialog-box-success5\">
<div class=\"dialog-left\">
<h3 align=\"center\"><img src=\"images/succes.png\" alt=\"\"/>Thank you!</h3><h3 align=\"center\">Your Job has been submitted for moderation</h3></div>
</div>";
$to      = $site_email;
$subject = "New job submission";
$message = "".$lang["JS_EMAIL1"]." $time\n".$lang["JS_EMAIL2"]."\n";
$headers = 'From: support@triplegood.co.za' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
}
}elseif($mod_job == 'No') {
    $query = sprintf("INSERT INTO jobs (willdo, username, postdate, category, job_cost, link, video_link, job_description, part_description, keywords, time_span, featured, img_path,approved)
            VALUES( '%s', '%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')",
            mysql_real_escape_string($willdo),
            mysql_real_escape_string($username),
            mysql_real_escape_string($postdate),
            mysql_real_escape_string($category),
            mysql_real_escape_string($job_cost),
            mysql_real_escape_string($link),
            mysql_real_escape_string($video_link),
            mysql_real_escape_string($job_description),
            mysql_real_escape_string($part_description),
            mysql_real_escape_string($keywords),
            mysql_real_escape_string($time_span),
            mysql_real_escape_string($featured),
            mysql_real_escape_string($img_path),
            mysql_real_escape_string('yes'));
// run the query
    if(!mysql_query($query))
            {
            echo 'Query failed '.mysql_error();
            exit();
            }
      else
            {
header( 'Location: /profile-' . $_SESSION['userName'] ) ;					
echo "<div class=\"dialog-box-success5\">
<div class=\"dialog-left\">
<h3 align=\"center\"><img src=\"images/succes.png\" alt=\"\"/>Thank you!</h3><h3 align=\"center\">Your Job has been submitted and auto approved</h3></div>
</div>";
$to      = $site_email;
$subject = "New job submission";
$message = "Hi Admin\nA new job has been submitted by $username on $time\nYou need to log in to your admin panel to moderate this job.\n";
$headers = 'From: louis@lightsites.co.za' . "\r\n" .
'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);
 if ( $tweet == yes ) {
include("autotweet.php");
}
}
}
}
$result1 = mysql_query("SELECT * FROM `languages` where `abb` = '$lang1'");
while($row3 = mysql_fetch_array($result1))
{
$language1 =  $row3["language"];
}
$settings = mysql_query("select * from members where username='".$_SESSION['userName']."'");
while ($rows = mysql_fetch_array($settings)){
$email = mysql_real_escape_string($rows['email']);
$ppemail = mysql_real_escape_string($rows['ppemail']);
}
if((!$ppemail) == 1 OR (!$email) == 1){

echo '<div style="border:1px solid red;color:red;">'.$lang["FILL_PROFILE"].'</div>';
}?>