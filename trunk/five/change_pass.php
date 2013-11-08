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

include("php/change_pass_content.php");
?>

<div class="feedback">
 <h2><?PHP echo $lang['CHANGE_PASS']?></h2>
<form method='POST'>
    <input type="hidden" name="auser" value="<?php echo $_SESSION['userName']?>" >
	<p><?PHP echo $lang['CURR_PASS']?>:<br /> <input type="password" name="cpass" class="textfield"> </p>
	<p><?PHP echo $lang['NEW_PASS']?>:<br /> <input type="password" name="npass" class="textfield"></p>
	<p><?PHP echo $lang['CONFIRM_PASS']?>:<br /> <input type="password" name="npassc" class="textfield"></p>
	<input type="submit" name="changepass" class="Button" value="<?PHP echo $lang['UPDATE']?>">
    </form>
</div><?PHP echo $passchangemsg;?></div>
<?PHP
include("side.php");
include("footer.php");
?>