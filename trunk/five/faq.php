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
$title = "".$row["domain"]." - FAQ's";
}
include("header.php");?>
<div class="feedback">
<h2><?PHP echo $lang['FAQ']?></h2>
<?PHP
$result = mysql_query("SELECT * from faq");
while($myrow = mysql_fetch_array($result)){
$faqs =  stripslashes(nl2br($myrow['faqs']));
}
echo "".$faqs."";?>
</div></div>
<?PHP include("side.php");
include("footer.php");?>

