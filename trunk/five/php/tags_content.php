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
 
$keywords = htmlspecialchars_decode($keywords, ENT_QUOTES);
$kws = explode(",",$keywords);
foreach ($kws AS $a_kw) {
echo "<span><a href='tags-".$a_kw = str_replace(' ', '-', trim($a_kw))."'>".trim($a_kw)."</a></span> ";
} //htmlspecialchars_decode()
?>