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


include("connect.php");
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." -".$lang['CONTACT']."";
}
include("header.php");
?>
<h2><?PHP echo $lang['CONTACT']?></h2>
<div class="close_gap"></div>
<div class="akform1">
        <h3><?PHP echo $lang['USE_FORM']?>.</h3>
        <div id="allFields">
            <div class="fields">
                <div class="field">
                    <label><?PHP echo $lang['YOUR_NAME']?><span class="mandatory">*</span></label>
                    <div class="fieldInput" id="name">
                        <input type="text" name="name" id="inputName" value="" class="textfield" onblur="checkFieldInput(this);" />
                    </div>
                </div>

                <div class="field">
                    <label><?PHP echo $lang['EMAIL']?><span class="mandatory">*</span></label>
                    <div class="fieldInput" id="email">
                        <input type="text" name="email" id="inputMail" value="" class="textfield" onblur="checkFieldInput(this);" />
                    </div>
                </div>

                <div class="field">
                    <label><?PHP echo $lang['MESSAGE']?><span class="mandatory">*</span></label>
                    <textarea id="inputMessage" onkeyup="checkFieldInput(this,true)" name="message" class="textarea"></textarea>
                </div>
            </div>
            <input type="button" id="submitButton" onclick="sendContactForm();" value="<?PHP echo $lang['SEND_MESSAGE']?>" disabled="disabled" />
        </div>

        <div id="confirm" style="display: none">
            <?PHP echo $lang['MESSAGE_SENT']?>!
        </div>
</div></div>
<?PHP
include("side.php");
include("footer.php");?>

