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

 ob_start();
if(!isset($_SESSION['userName'])){
    header('Location: index.php');
}else{
include("connect.php");
$id = $_GET['id'];
$username = $_POST['username'];
$willdo = $_POST['willdo'];
$email = $_POST['email'];
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - Send a Message";
}
include("header.php");
?>
<div class="dialog-box-success">
<div class="dialog-left">
<img src="images/succes.png" class="dialog-ico" alt=""/><?PHP echo $lang['MESSAGE_SENT']?><img src="images/rating_loading.gif" width="220" height="19" alt="" /></div>
</div><?PHP echo $id ?>
                            <form action="" method="post">
                                <input class="submit" type="submit" name="inbox" value="Inbox" /> <input class="submit" type="submit" name="sent" value="Sent Items" />
                                </form>
                                <h6></h6>

                                <div class="akform"><form action="message_Form" method="post">
                                <div id="allFields">
            <div class="fields">
                <div class="field">
                    <label><?PHP echo $lang['SUBJECT']?><span class="mandatory">*</span></label>
                    <div class="fieldInput" id="name">
                    <input type="hidden" name="email" value="<? echo $email?>">
                    <input type="text" name="name" value="" class="textinput" />
                    </div>
                </div>
                <div class="field">
                    <label><?PHP echo $lang['YOUR_MESSAGE']?><span class="mandatory">*</span></label>
                    <textarea name="message"></textarea>
                </div>
            </div>
            <input type="submit" name="submit" value="Send Message" class="submit"/>
        </div>
        </form>
    </div>
</div>
<?PHP
include("side.php");
include("footer.php");
ob_flush();
}
?>