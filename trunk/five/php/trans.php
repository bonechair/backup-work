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
 
$sql = "select * from languages where status = 'active'";
$rec = mysql_query($sql) or die(mysql_error());
while($datas=mysql_fetch_array($rec)){
$flag_image=str_replace('..', ''.$siteurl.'',($datas['flag_image']));
echo '<a href="'.$siteurl.'/'.$datas['abb'].'">'.$flag_image.'</a>';

}
?>