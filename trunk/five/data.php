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

include("connect.php");

$per_page = 20;
$sqlc = "show columns from suggestions  ";
$rsdc = mysql_query($sqlc);
$cols = mysql_num_rows($rsdc);
$page = $_REQUEST['page'];

$start = ($page-1)*$per_page;
$sql = "select * from suggestions order by id desc limit $start,$per_page";
$rsd = mysql_query($sql);
?>
<?php
while ($row = mysql_fetch_assoc($rsd))
{?>
<div class="suggestions">
<div class="user_name"><span id="usermsg"><img src="images/BlockContentBullets.png" alt="" />&nbsp;<a href="profile-<? echo $row['username']?>"><span class="user_name"><? echo $row['username']?></span></a> ~ Wants: </span></div>
<div class="wants"><span id="Usermsg"><? echo $text = stripslashes(nl2br($row['text']));?></span></div>
</div>
<?php
}?>
