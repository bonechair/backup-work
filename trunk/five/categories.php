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

echo "<ul class=\"sb_menu\"> ";
$i = 0;
$tqr = mysql_query("SELECT * FROM cats order by `catname` asc");
$qrnum = mysql_num_rows($tqr);
if($qrnum == 0) {
            print "No categories!";
         } else {
            while ($tarray = mysql_fetch_array($tqr)) {
               $xcat = mysql_result($tqr, $i, 'catname');
$result = mysql_query("SELECT * FROM sitesettings");
while($row = mysql_fetch_array($result))
print " <li><a href=\"".$row["site_url"]."/category-".seo_link_pv($xcat)."\" >" . $xcat = stripslashes(str_replace('-', ' ',($xcat))) . "</a></li>";

               $i++;
            }
        }
echo "</ul>";
?>