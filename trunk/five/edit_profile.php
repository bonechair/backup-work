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

include("php/edit_profile_content.php");
?>
<script language="JavaScript" type="text/javascript">
<!--
function checkForm ( form )
{
  if (form.full_name.value == "") {
    alert( "<?PHP echo $lang['ENTER_FULL_NAME']?>." );
    form.full_name.focus();
    return false ;
  }
  if (form.country.value == "") {
    alert( "<?PHP echo $lang['ENTER_COUNTRY']?>." );
    form.country.focus();
    return false ;
  }
  if (form.email.value == "") {
    alert( "<?PHP echo $lang['ENTER_EMAIL']?>." );
    form.email.focus();
    return false ;
  }
  if (form.ppemail.value == "") {
    alert( "<?PHP echo $lang['ENTER_PPEMAIL']?>." );
    form.ppemail.focus();
    return false ;
  }
  if (form.about.value == "") {
    alert( "<?PHP echo $lang['ADD_SELF']?>." );
    form.about.focus();
    return false ;
  }
return true ;
}
//-->
</script>
<script language="JavaScript" type="text/javascript">
<!--
function CheckForm ( form )
{
  if (form.img_path.value == "") {
    alert( "<?PHP echo $lang['ADD_IMAGE']?>." );
    form.img_path.focus();
    return false ;
  }
return true ;
}
//-->
</script>
<div class="ed_profile">
<form action="" method="post" name="myform" id="myform" enctype="multipart/form-data" onsubmit="return checkForm(this);">

<div class="akform">
<h2><?PHP echo $lang['EDIT_PROFILE']?></h2>
<div id="allFields">
<div class="fields">
                <div class="field">
                    <label><?PHP echo $lang['USERNAME']?>: (<?PHP echo $lang['CANNOT_CHANGE']?>)<span class="mandatory"></span></label>
                    <div class="fieldInput" id="name">
                         <input type="text" class="textfield" value="<? echo $myrow['username']; ?>"disabled="disabled"/>
                    </div>
                </div>
                <div class="field">
                    <label><?PHP echo $lang['YOUR_NAME']?>:<span class="mandatory">*</span></label>
                    <div class="fieldInput" id="email">
                        <input name="full_name" type="text" id="full_name"  class="textfield" value="<?php echo $afull_name ?>">
                    </div>
                </div>
                <div class="field">
                    <label><?PHP echo $lang['COUNTRY']?>:<span class="mandatory">*</span></label>
                    <div class="fieldInput" id="phone">
                        <input name="country" class="textfield" type="text" id="country" value="<? echo $acountry ?>">
                    </div>
                </div>
                <div class="field">
                    <label><?PHP echo $lang['EMAIL']?>:<span class="mandatory">*</span></label>
                    <input name="email" type="text" id="email" class="textfield" value="<? echo $aemail ?>">
                </div>
             <div class="field">
                    <label><?PHP echo $lang['PPEMAIL']?>:<span class="mandatory">*</span></label>
                    <div class="fieldInput" id="phone">
                         <input name="ppemail" type="text" id="ppemail" class="textfield" value="<? echo $appemail ?>">
                    </div>
                </div>
          <div class="field">
                    <label><?PHP echo $lang['ABOUT_ME']?>:<span class="mandatory">*</span></label>
                    <textarea name="about" id="inputMessage" class="textarea" rows="10" cols="45"><? echo $about=(str_replace('rn', ' ',$aabout)); ?></textarea>
        </div>
            <input name="doSave" class="Button" type="submit" id="doSave" value="<?PHP echo $lang['UPDATE_PROF']?>">
        </div>
    </div><hr color="#333333" /><form action="" method="post" name="myform" id="myform" enctype="multipart/form-data" onsubmit="return CheckForm(this);">
       <div class="field">
       <table width="100%">
         <tr>
           <td>
       <label><?PHP echo $lang['PROF_PIC']?><br />100px x 100px <span class="mandatory">(<?PHP echo $lang['OPTIONAL']?>)</span></label>
         <img src="users/<? echo $myrow['username']; ?>/<? echo $myrow['img_path']; ?>" width="100px" height="100px" alt="an image" style="float: left;padding-right:0px" />
        </td>
           <td>
       <div class="fieldInput" id="phone">
      <input name="img_path" type="file" class="willdo" size="30"/><input name="upload" class="Button" type="submit" id="upload" value="<?PHP echo $lang['UPLOAD']?>!"></div></td>
         </tr>
       </table>
      </div></form></div>
          </form>
        </div>
</div>
<?PHP
include("side.php");
include("footer.php");
ob_flush();

?>