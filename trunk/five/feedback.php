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

include("connect.php");
$user = $_GET['user'];
$sender_id = $_POST['sender_id'];
$receiver_id = $_POST['receiver_id'];
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
{
$title = "".$row["domain"]." - ".$user."s Feedback";
}
include("header.php");
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
<?PHP
$result = mysql_query("select * from jobs_bought WHERE `username` = '".$user."'");
while($myrow = mysql_fetch_array($result)){
$seller1= $myrow['seller_username'];
}
$result2 = mysql_query("select * from jobs_sold WHERE `username` = '".$user."'");
while($myrow2 = mysql_fetch_array($result2)){
$buyer= $myrow2['buyer_username'];
}
?>
<div class="orders">
<h2><?PHP echo $user?>'s <?PHP echo $lang['FEEDBACK']?></h2>
<a href="feedback.php?user=<?PHP echo $user ?>&act=seller"><?PHP echo $lang['FEEDBACK_SELLER']?></a> | <a href="feedback.php?user=<?PHP echo $user ?>&act=buyer"><?PHP echo $lang['FEEDBACK_BUYER']?></a>
<div class="feedback">
<?PHP
$sql = "select * from seller_feedback WHERE `username` = '".$buyer."' order by id desc";
$reload = $_SERVER['PHP_SELF'];
$rpp = 20; // results per page
$adjacents = 4;
$page = intval($_GET["page"]);
if(!$page) $page = 1;
if (isset($_GET["act"])) {
$act = $_GET["act"];
if ($act == "seller") {
$sql = "select * from seller_feedback WHERE `username` = '".$buyer."' order by id desc";
echo "<b>".$lang['FEEDBACK_SELLER']."</b>";
}elseif ($act == "buyer") {
$sql = "select * from buyer_feedback WHERE `username` = '".$seller1."' order by id desc";
echo "<b>".$lang['FEEDBACK_BUYER']."</b>";
}
}else{echo "<b>".$lang['FEEDBACK_SELLER']."</b>";}
$result = mysql_query($sql);
$tcount = mysql_num_rows($result);
$tpages = ($tcount) ? ceil($tcount/$rpp) : 1;
$count = 0;
$i = ($page-1)*$rpp;
echo "<table class=\"sortable\" id=\"tb-1\" width=\"100%\">
<tr>
<th class=\"th-6\">".$lang['JOB_ID']."</th>
<th class=\"th-4\">".$lang['FROM']."</th>
<th class=\"th-6\">".$lang['RATING']."</th>
<th class=\"th-2\">".$lang['FEEDBACK']."</th>";
while(($count<$rpp) && ($i<$tcount)) {
mysql_data_seek($result,$i);
$datas=mysql_fetch_array($result);{
if ($datas['rating'] == 'images/positive.png'){
$rating = 'Positive';
}elseif ($datas['rating'] == 'images/neutral.png'){
$rating = 'Neutral';
}elseif ($datas['rating'] == 'images/negative.png'){
$rating = 'Negative';
}
echo "<tr>
<td class=\"td-6\">$datas[job_id]</td>
<td class=\"td-4\">$datas[username]</td>
<td class=\"td-6\"><img src='$datas[rating]'> $rating</td>
<td class=\"td-2\">$datas[text]</td></tr>";
}
$i++;
$count++;
}
echo "</table>";

?>
</div>
<div class="pagination"><? include("pagination3.php");
echo paginate_three($reload, $page, $tpages, $adjacents);?></div>
</div>
<?PHP

echo "</div>";
include("side.php");
include("footer.php");
ob_flush();

?>