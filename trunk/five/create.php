<?PHP   session_start(); 
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
$title = "Create Username";
include("header.php");
echo '<div class="feedback">';
if(isset($_GET['new'])){
if($session[userName] == ""){
if(isset($_GET['create'])){
registerFBUser($_POST['username'],$_POST['status']);
}
?>
<p><?PHP echo $lang['FB_CONTINUE']?>.</p>
<form action="create.php?new&create" method="post">
<input type="text" name="username" class="textfield" id="username-field" onfocus="value=''" value="Username" onChange="javascript:this.value=this.value.toLowerCase();"/><br /><br />
<input type="hidden" name="status" value="activated">
<input type="submit" class="submit" value="<?PHP echo $lang['SUBMIT']?>" /></form>
<?PHP
}
}
echo '</div>';
FBConnectionReceive($apikey,"normal");
echo '</div>';
include("side.php");
include("footer.php");
ob_flush(); ?>