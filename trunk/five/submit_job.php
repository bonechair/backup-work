<!DOCTYPE html>
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

 include("php/submit_job_content.php");
?>
<div class="ed_profile">
<div class="akform">
<div id="allFields">
<div class="fields">
<form name="willdo" method="post" action="" ENCTYPE = "multipart/form-data" onsubmit="return checkform(this);">
<div class="field"><label><?PHP echo $lang['JOB_TITLE']?>:<span class="mandatory">*</span><br><h2><?PHP echo $lang['I_WILL']?>: <input class="textfield" name="willdo" type="text" value="<? echo $_POST['willdo']?>"/></h2> </label>
<div class="Limit"><div id='willdo-status'></div></div></div>
<div class="field"><label><?PHP echo $lang['CATEGORY']?>:<span class="mandatory">*</span> <?PHP echo $lang['CHOOSE_CAT']?>.</label>
<div class="fieldInput" id="email">
<?PHP
$sql = mysql_query("SELECT * FROM `categories` order by catname asc");
print "<select class=\"textfield\"  name=\"category\">\n";
$catname = $_POST['catname'];
while ($row = mysql_fetch_assoc($sql)){
$catname = $row['catname'];
print "<option value=\"$catname\">$catname\n</option>";
}
print "</select>\n";
?>
</div></div>
<div class="field"><label><?PHP echo $lang['MAKE_FEATURED']?>: <?PHP echo $lang['WE_CHARGE']?> <?PHP echo $featured_fee ?>% <?PHP echo $lang['FOR_FEATURED']?><span class="mandatory">*</span></label>
<div class="fieldInput" id="featured">
<select class="textfield" name="featured">
<option value="no"><?PHP echo $lang['NO']?></option>
<option value="yes"><?PHP echo $lang['YES']?></option>
</select>
</div>
</div>
<div class="field"><label><?PHP echo $lang['JOB_PRICE']?>:<span class="mandatory">*</span></label>
<div class="fieldInput" id="email">
<select class="textfield"  name="job_cost">
<?PHP
$price_range = htmlentities($price_range, ENT_QUOTES);
$kws = explode(",",$price_range);
foreach ($kws AS $a_kw) {
echo "<option value='".$a_kw."' >".$currency_symbol." ".$a_kw."</option> ";
}
?>
</select>
</div>
</div>
<div class="field">
<label><?PHP echo $lang['LINK']?>:<span class="mandatory">*</span> <?PHP echo $lang['LINK_TO_WEB']?> http://www.example.com.</label>
<div class="fieldInput" id="phone">
<input class="textfield"  name="link" type="text" />
</div></div>
<div class="field">
<label><?PHP echo $lang['VIDEO']?> <?PHP echo $lang['LINK']?>:<span class="mandatory">*</span> <?PHP echo $lang['LINK_TO_VIDEO']?> http://www.youtube.com/v/OVNZ3rX4a54</label>
<div class="fieldInput" id="phone">
<input class="textfield" name="video_link" type="text" />
</div></div>
<div class="field">
<label><?PHP echo $lang['DESCRIPTION']?>:<span class="mandatory">*</span> <?PHP echo $lang['BE_DESC']?></label>
<div class="fieldInput" id="phone">
<textarea name="job_description" class="textarea" rows="10" cols="75"></textarea><div class="Limit"><div id='job_description-status'></div></div>
</div></div>
<div class="field">
<label><?PHP echo $lang['KEYWORDS']?>:<span class="mandatory">*</span> <?PHP echo $lang['ENTER_KEYS']?></label>
<div class="fieldInput" id="phone">
<input class="textfield" name="keywords" type="text" />
</div></div>
<div class="field">
<label><?PHP echo $lang['MAX_DAYS']?>:<span class="mandatory">*</span> <?PHP echo $lang['MAX_TIME']?></label><input class="textfield" name="time_span" type="text" />
<div class="fieldInput" id="phone">
</div></div>
<div class="field">
<label><?PHP echo $lang['JOB_IMG']?>:<span class="mandatory">*</span> <?PHP echo $lang['IMG_RULES']?>,
<?PHP echo $lang['IMG_SIZE']?></label>
<div class="fieldInput" id="phone"><input name="img_path" type="file" class="textfield" size="35"/></div>
<input type="hidden" name="username" value="<? echo $username?>" />
<?PHP $settings = mysql_query("select * from members where username='".$_SESSION['userName']."'");
while ($rows = mysql_fetch_array($settings)){
$email = mysql_real_escape_string($rows['email']);
$ppemail = mysql_real_escape_string($rows['ppemail']);
}
if((!$ppemail) == 1 OR (!$email) == 1){
?>
<div align="right"><img src="images/disabled.jpg" onClick="return confirmSubmitt()"/></div>
<?PHP } else {?>
<div align="right"><input type="submit" class="Button" name="Submit_job" value="<?PHP echo $lang['SUB_JOB']?>" /></div>
<?PHP }?>
</div>
</form>
</div></div></div>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmitt()
{
var agree=confirm("<?PHP echo $lang[FILL_PROFILE] ?>");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<script language="JavaScript" type="text/javascript">
<!--
function checkform ( form )
{
  if (form.willdo.value == "") {
    alert( "Please enter a job title." );
    form.willdo.focus();
    return false ;
  }
  if (form.job_description.value == "") {
    alert( "Please enter a job description." );
    form.job_description.focus();
    return false ;
  }
  if (form.keywords.value == "") {
    alert( "Please enter at least one keyword." );
    form.keywords.focus();
    return false ;
  }
  if (form.time_span.value == "") {
    alert( "Please enter a time span." );
    form.time_span.focus();
    return false ;
  }
  if (form.img_path.value == "") {
    alert( "You need to upload a job image." );
    form.img_path.focus();
    return false ;
  }
return true ;
}
//-->
</script>
</div></div>
<?PHP
include("side.php");
include("footer.php");
?>