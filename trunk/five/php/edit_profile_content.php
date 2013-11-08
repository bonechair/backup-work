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
 
ob_start();
if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}
include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - ".$_SESSION['userName']." Edit my profile";
$fee = mysql_real_escape_string($row["fee"]);
$min_balance = mysql_real_escape_string($row["min_balance"]);
$currency_symbol = mysql_real_escape_string($row["currency_symbol"]);
}
include("header.php");
$name = strtolower($us);
$namecheck = mysql_query("SELECT * FROM `members` WHERE username = '$name'") or die (mysql_error());
$r = mysql_num_rows($namecheck);
$us = $_SESSION['username-reg'];
$pr = $_SESSION['password-reg'];
$prv = $_SESSION['passwordv-reg'];
$em = $_SESSION['email-reg'];
$st = $_SESSION['status'];
$emails = $_SESSION['forgotpassword'];
if(!empty($_SESSION['userName'])) {
$sql = "select * from members where userName='".mysql_escape_string($_SESSION[userName])."'";
$sql2=mysql_query($sql);
$myrow=mysql_fetch_array($sql2);
$abalance = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'balance')));
$afull_name = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'full_name')));
$acountry = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'country')));
$aemail = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'email')));
$appemail = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'ppemail')));
$aabout = stripslashes(str_replace('\r\n', '<br>',mysql_result($sql2,0,'about')));
if(isset($_POST['doSave']))
{
        $full_name=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['full_name']));
        $country=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['country']));
        $email=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['email']));
        $ppemail=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['ppemail']));
        $about=mysql_real_escape_string(str_replace('\r\n', '<br>',$_POST['about']));

        $edit1 = "UPDATE members SET full_name='$full_name' WHERE userName='$_SESSION[userName]'";
		mysql_query($edit1) or die("could not edit");
        $edit2 = "UPDATE members SET country='$country' WHERE userName='$_SESSION[userName]'";
		mysql_query($edit2) or die("could not edit");
        $edit3 = "UPDATE members SET email='$email' WHERE userName='$_SESSION[userName]'";
		mysql_query($edit3) or die("could not edit");
        $edit4 = "UPDATE members SET ppemail='$ppemail' WHERE userName='$_SESSION[userName]'";
		mysql_query($edit4) or die("could not edit");
        $edit5 = "UPDATE members SET about='$about' WHERE userName='$_SESSION[userName]'";
		mysql_query($edit5) or die("could not edit");


echo "<div class=\"dialog-box-success\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['DETAILS_UPDATED']."</div>
</div><META HTTP-EQUIV = 'Refresh' Content = '0; URL =edit_profile.php'>";
}
$path_thumbs = "users/".$_SESSION['userName']."";
$path_big = "users/".$_SESSION['userName']."";
//the new width of the resized image.
$img_thumb_width = 130; // in pixcel
$extlimit = "yes"; //Do you want to limit the extensions of files uploaded (yes/no)
//allowed Extensions
$limitedext = array(".jpg",".jpeg",".png",".gif",);
if($_POST['upload'] == 'Upload!')
{
$pathInfo = pathinfo($_FILES["img_path"]["name"]);
$extension = $pathInfo['extension'];
//choose directory/foolder to place the file in
$dir = "users/".strtolower($_SESSION['userName'])."";
       $file_type = $_FILES['img_path']['type'];
       $file_name = $_FILES['img_path']['name'];
       $file_size = $_FILES['img_path']['size'];
       $file_tmp = $_FILES['img_path']['tmp_name'];

       //check if you have selected a file.
       if(!is_uploaded_file($file_tmp)){
          die (header( 'Location: invalid?noimage' ));
          exit(); //exit the script and don't do anything else.
       }
       //check file extension
       $ext = strrchr($file_name,'.');
       $ext = strtolower($ext);
       if (($extlimit == "yes") && (!in_array($ext,$limitedext))) {
          die (header( 'Location: invalid?wrong' ));
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

        }
if(!move_uploaded_file($_FILES['img_path']['tmp_name'], "$dir/".$_FILES['img_path']['name'])) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['PIC_NOT_UPLOADED']."</div>
</div><META HTTP-EQUIV = 'Refresh' Content = '0; URL =edit_profile.php'>";
}else{
echo "<div class=\"dialog-box-success\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['PIC_UPLOAD']."</div>
</div><META HTTP-EQUIV = 'Refresh' Content = '0; URL =edit_profile.php'>";

}
function filter($arr) {
    return array_map('mysql_real_escape_string', $arr);
}

$img_path = "$rand_name.$file_ext";

mysql_query("UPDATE members SET
            `img_path` = '$img_path'
            WHERE userName='$_SESSION[userName]'
			") or die(mysql_error());
mysql_query("UPDATE job_communication SET
            `img_path` = '$img_path'
            WHERE username='$_SESSION[userName]'
			") or die(mysql_error());
}
}else{
echo '<div class="dialog-box-information">
<div class="dialog-left">
<img src="images/information.png" class="dialog-ico" alt=""/>'.$lang['NEED_LOGIN'].'</div>
</div></div>';
}
?>