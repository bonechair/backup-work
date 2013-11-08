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
$user = $_SESSION['userName'];
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - ".$user."s Inbox";
}
include("header.php");
if(!empty($_SESSION['userName'])) {

?>
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
<script LANGUAGE="JavaScript">
<!--
function confirmSubmit()
{
var agree=confirm("<?PHP echo $lang['PERM_DELETE']?>");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>
<script LANGUAGE="JavaScript">
<!--
function confirmSubmitt()
{
var agree=confirm("<?PHP echo $lang['WISH_DELETE']?>");
if (agree)
	return true ;
else
	return false ;
}
// -->
</script>

<div class="orders">
<form action="mailbox" method="post">
<input type="submit" name="sent" class="Button" value="Sent Items" />
<input type="hidden" name="sender_id" value="<? echo $user?>"></form>


<h2><?PHP echo $user?>'s <?PHP echo $lang['MAILBOX_INBOX']?></h2>

<div class="feedback">
<?PHP

$reload = $_SERVER['PHP_SELF'];
$rpp = 20; // results per page
$adjacents = 4;
$page = intval($_GET["page"]);
if(!$page) $page = 1;
$sql = "select * from messages_received WHERE `receiver_id` = '".$user."' order by id desc";
$result = mysql_query($sql);
$tcount = mysql_num_rows($result);
$tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
$count = 0;
$i = ($page-1)*$rpp;
echo "<table class=\"sortable\" id=\"tb-1\" width=\"100%\">
<tr>
<th class=\"th-4\">".$lang['FROM']."</th>
<th class=\"th-2\">".$lang['SUBJECT']."</th>
<th class=\"th-6\">".$lang['ON']."</th>
<th class=\"th-1\">".$lang['DELETE']."</th>
<th class=\"th-1\">".$lang['READ']."</th></tr>";
while(($count<$rpp) && ($i<$tcount)) {
mysql_data_seek($result,$i);
$datas=mysql_fetch_array($result);{
$subject = stripslashes(str_replace('\r\n', '<br>',($datas['subject'])));
echo "<tr>
<td class=\"td-4\"><a href='profile-$datas[sender_id]'>$datas[sender_id]</td>
<td class=\"td-2\"><a href='readmail.php?id=$datas[id]'>$subject</a></td>
<td class=\"td-6\">$datas[date]</td>
<form action=\"\" method=\"post\" name=\"myForm\">
<td class=\"td-1\"><input type=\"checkbox\" name=\"myCheckbox[]\" value=\"$datas[id]\" id=\"myCheckbox$datas[id]\"/></td>
<td class=\"td-1\">";
if($datas['message_read'] == 'yes') {echo "<img src=\"images/succes.png\" width=\"16\" height=\"16\" alt=\"\" title=\"".$lang['MESSAGE_READ']."\"/>";}
else{echo "<img src=\"images/information.png\" width=\"16\" height=\"16\" alt=\"\" title=\"".$lang['MESSAGE_NOT_READ']."\"/>";}";
echo </td></tr>";
}
$i++;
$count++;
}
echo "</table>";
?>
</div>
<div class="feedback"><input type="button" class="Button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', true);" value="Check all!">
&nbsp;
<input type="button" class="Button" onclick="SetAllCheckBoxes('myForm', 'myCheckbox[]', false);" value="Uncheck all!">
<input type="submit" name="delete" class="Button" value="<?PHP echo $lang['DELETE_SELECTED']?>" onClick="return confirmSubmitt()"></form>
<div class="pagination"><? include("pagination3.php");
echo paginate_three($reload, $page, $tpages, $adjacents);?></div></div>
</div>
<? if(isset($_POST['delete'])){
$delete = $_REQUEST['delete'];
$checkbox = $_REQUEST['myCheckbox'];
$count = count($_REQUEST['myCheckbox']);
if($delete){
for($i=0;$i<$count;$i++){
$del_id = $checkbox[$i];

$sql = "DELETE FROM messages_received where id='$del_id' " or die(mysql_error());
$result = mysql_query($sql);
}
}
if(!mysql_query) {
echo "<div class=\"dialog-box-error\">
<div class=\"dialog-left\">
<img src=\"images/error.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['DEL_FAIL']."
</div></div>";
}else{ echo "<div class=\"dialog-box-success\">
<div class=\"dialog-left\">
<img src=\"images/succes.png\" class=\"dialog-ico\" alt=\"\"/>".$lang['DEL_SUCCESS']."....<img src=\"images/rating_loading.gif\" width=\"220\" height=\"19\" alt=\"\" />
</div></div><META HTTP-EQUIV = 'Refresh' Content = '2; URL =mailbox_inbox'>";
}
}

}else{
echo '</div></div>
<div class="dialog-box-error">
<div class="dialog-left">
<img src="images/error.png" class="dialog-ico" alt=""/>'.$lang['NEED_TO_LOGIN'].'!
</div></div></div>';  }
echo "</div>";
include("side.php");
include("footer.php");
ob_flush();
}
?>