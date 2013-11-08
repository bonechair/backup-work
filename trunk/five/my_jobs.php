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
$date = date("F j, Y");
$username = $_SESSION['userName'];
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - ".$username." My Sales";
$domain = mysql_real_escape_string($row["domain"]);
$price = mysql_real_escape_string($row["price"]);
$currency_symbol = mysql_real_escape_string($row["currency_symbol"]);
}

include("header.php");?>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmitt()
{
var agree=confirm("<?PHP echo $lang['DELETE_ORDERS']?>");
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
var agree=confirm("<?PHP echo $lang['ACCEPT_YES']?>");
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
<script language="JavaScript" type="text/javascript">
/*<![CDATA[*/
function SetAllCheckBoxes(FormName, FieldName, CheckValue)
{
	if(!document.forms[FormName])
		return;
	var objCheckBoxes = document.forms[FormName].elements[FieldName];
	if(!objCheckBoxes)
		return;
	var countCheckBoxes = objCheckBoxes.length;
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		// set the check value for all check boxes
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
}
/*]]>*/
</script>
<?PHP if (isset($_GET["act"])) {
$act = $_GET["act"];
if (isset($_GET["id"]))
$id= mysql_real_escape_string($_GET['id']);
else
die();
if ($act == "edit") {
$rec = mysql_query("SELECT * FROM jobs where id = '$id'") or die(mysql_error());
$datas = mysql_fetch_array($rec);
$username = $datas['username'];
$job_description = html_entity_decode($datas['job_description'], ENT_QUOTES);
$willdo = html_entity_decode($datas['willdo'], ENT_QUOTES);
$jobdescription=stripslashes(str_replace('\r\n', '<br>',($job_description)));
$willdo=stripslashes(str_replace('\r\n', '<br>',($willdo)));
$category = $datas['category'];
$job_cost = $datas['job_cost'];
$link = $datas['link'];
$video_link = $datas['video_link'];
$video_link = str_replace('watch?v=', 'v/',($video_link));
$keywords = $datas['keywords'];
$time_span = $datas['time_span'];
$postdate = $datas['postdate'];
$img_path = $datas['img_path'];
if($_SESSION['userName']!=''.$username.''){
    header('Location: index.php');
}
if(isset($_POST['submitedit']))
{
function filter($arr) {
return array_map('mysql_real_escape_string', $arr);
}
mysql_query("UPDATE jobs SET
            `willdo` = '$_POST[willdo]',
            `category` = '$_POST[category]',
            `job_cost` = '$_POST[job_cost]',
            `video_link` = '$_POST[video_link]',
            `link` = '$_POST[link]',
            `job_description` = '$_POST[job_description]',
            `part_description` = '$_POST[job_description]',
            `keywords` = '$_POST[keywords]',
            `time_span` = '$_POST[time_span]'
             WHERE id='$id'
			") or die(mysql_error());
            if(mysql_query)
            {
echo "<div class=\"dialog-box-success5\">
<div class=\"dialog-left\">
<h3 align=\"center\"><img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['JOB_UPDATED']."</div></h3>
</div><META HTTP-EQUIV = 'Refresh' Content = '1; URL =my_jobs.php?act=edit&id=$id'";}
}
?><div class="ed_profile">
<form action='' method='post' ENCTYPE = "multipart/form-data">
<input type="hidden" name="id" value="<?PHP echo $id?>" >
<div class="akform"><?PHP echo "<h2>".$lang['EDIT_JOB']." ".$willdo."</h2>";?>
<div id="allFields">
<div class="fields">
<div class="field">
<label><?PHP echo $lang['JOB']?>:</label>
<div class="fieldInput" id="name">
<input name='willdo' class="textfield" type='text'value="<?PHP echo $willdo?> ">
</div>
</div>
<div class="field"><label><?PHP echo $lang['CATEGORY']?>:<span class="mandatory">*</span> <?PHP echo $lang['CHOOSE_CAT']?></label>
<div class="fieldInput" id="email">
<?PHP
$sql = mysql_query("SELECT * FROM `categories` order by catname asc");
print "<select class=\"textfield\" name=\"category\">\n";$catname = $category;
print "<option value=\"$category\">$category\n</option>";
while ($row = mysql_fetch_assoc($sql)){
$catname = mysql_real_escape_string($row['catname']);
print '<option value="'.$catname = stripslashes(str_replace(' ', '-',($catname))).'">'.$catname = stripslashes(str_replace(' ', '-',($catname))).'</option>';
}
print "</select>\n";
?>
</div>
</div>
<div class="field"><label><?PHP echo $lang['JOB_PRICE']?>:<span class="mandatory">*</span></label>
<div class="fieldInput" id="email">
<select class="textfield" name="job_cost">
<option value="<?PHP echo $job_cost?>"><?PHP echo $currency_symbol ?><?PHP echo $job_cost?></option>
<?PHP
$price_range = htmlentities($price_range, ENT_QUOTES);
$prc = explode(",",$price_range);
foreach ($prc AS $p_rc) {
echo "<option value='".$p_rc."' >".$currency_symbol." ".$p_rc."</option> ";
}
?>
</select>
</div>
</div>
                    <div class="field">
                    <label><?PHP echo $lang['LINK']?>:<span class="mandatory">*</span> <?PHP echo $lang['LINK_TO_WEB']?> http://www.example.com</label>
                    <div class="fieldInput" id="phone">
                    <input class="textfield" name="link" type="text" value='<?PHP echo $link?>'/>
                    </div></div>
                    <div class="field">
                    <label><?PHP echo $lang['VIDEO']?><?PHP echo $lang['LINK']?>:<span class="mandatory">*</span> <?PHP echo $lang['LINK_TO_VIDEO']?> http://www.youtube.com/v/OVNZ3rX4a54</label>
                    <div class="fieldInput" id="phone">
                    <input class="textfield" name="video_link" type="text" value='<?PHP echo $video_link?>'/>
                    </div></div>
                    <div class="field">
                    <label><?PHP echo $lang['DESCRIPTION']?>:</label>
                    <textarea name="job_description" cols="" rows="" class="textarea" id="field8" ><?PHP echo $jobdescription?></textarea>
                    </div>
                    <div class="field">
                    <label><?PHP echo $lang['KEYWORDS']?>:</label>
                    <input name="keywords" class="textfield" type='text' value='<?PHP echo htmlentities($keywords, ENT_QUOTES)?>' />
                    </div>
                    <div class="field">
                    <label><?PHP echo $lang['TIME_SPAN']?>:</label>
                    <div class="fieldInput" id="phone">
                    <input name="time_span" class="textfield" type='text' value='<?PHP echo $time_span?>' />
                    </div>
                    </div>
                    <div class="field">
                    <label><?PHP echo $lang['POSTDATE']?>:</label>
                    <div class="fieldInput" id="phone">
                    <input name="postdate" type='text' class="textfield" value='<?PHP echo $postdate?>' disabled="disabled"/>
                    </div>
                </div>
            <input type='submit' name='submitedit' value='<?PHP echo $lang['UPDATE_JOB']?>' class="Button"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='reset' class="Button" name='submit' value='<?PHP echo $lang['RESET_FORM']?>' />
        </div>
    </div></div></form>
<form action='' method='post' ENCTYPE = "multipart/form-data">
<div class="akform2">
<div id="allFields">
<div class="fields">
<div class="field">
<label><?PHP echo $lang['CH_JOB_IMAGE']?></label><div class="clear"></div>
<img src="<?PHP echo $img_path?>" alt="an image"  style="float: left; padding-right:10px;"/><div class="clr"></div>
<div class="fieldInput" id="phone"><input name="img_path" type="file" class="textfield" size="35"/><div class="clear"></div>
<input type='submit' name='Upload' value='<?PHP echo $lang['CHANGE_IMAGE']?>' class="Button"/></div></div></div></div></div></form>
<?PHP
}
if ($act == "delete"){
$sql = "DELETE FROM jobs where  id='$id' " or die(mysql_error());
$result = mysql_query($sql);
if(!mysql_query) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['JOB_NOT_DEL']."
</div>
<div class=\"dialog-right\">
<img src=\"images/error-delete.jpg\" class=\"del-x\" alt=\"\"/>
</div>
</div>";
}else{ header( 'Location: profile-'.$username.'' ) ;
}
}
$path_thumbs = "users/".$_SESSION['userName']."";
$path_big = "users/".$_SESSION['userName']."";
//the new width of the resized image.
$img_thumb_width = 380; // in pixcel
$extlimit = "yes"; //Do you want to limit the extensions of files uploaded (yes/no)
//allowed Extensions
$limitedext = array(".jpg",".jpeg",".gif",".png",);
if(isset($_POST['Upload']))
{
$file_type = $_FILES['img_path']['type'];
       $file_name = $_FILES['img_path']['name'];
       $file_size = $_FILES['img_path']['size'];
       $file_tmp = $_FILES['img_path']['tmp_name'];
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
mysql_query("UPDATE jobs SET
            `img_path` = '$path_thumbs/$rand_name.$file_ext'
            WHERE id='$id'
			") or die(mysql_error());
echo "<div class=\"dialog-box-success\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['JOB_UPDATED']."</div>
</div>";header( 'Location: my_jobs.php?act=edit&id='.$id.'' ) ;
}
}
?>
</div></div>
<?PHP include("side.php");
include("footer.php");
ob_flush();
}
?>