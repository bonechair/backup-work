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
 
if(!empty($_SESSION['userName'])) {
echo "<div class='clear'></div>";
$sql1 = "SELECT username FROM likes WHERE `job_id` = '".$id."' AND `username` = '".$_SESSION['userName']."'  ";
$my_result = mysql_query($sql1)or die(mysql_error());
$my_row = mysql_fetch_array($my_result);
if ( $my_row['username'] == $_SESSION['userName'] ) {
echo '<a href="jobs.php?enter=no&id='.$id.'" title="Click to Unlike"><div class="bookmark"><img src="images/heart.png" alt="UnBookmark" border="0">'.$lang['UN_BOOK'].'</div></a>';}else{
echo '<a href="jobs.php?enter=go&id='.$id.'" title="Click to Like"><div class="bookmark"><img src="images/heart.png" alt="Bookmark" border="0"> '.$lang['BOOK_THIS'].'</div></a>';
}
}
?>
