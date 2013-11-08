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

$query = mysql_query("SELECT * FROM messages_received where message_read='".mysql_real_escape_string(no)."' and receiver_id = '".mysql_real_escape_string($_SESSION['userName'])."'");
$number=mysql_num_rows($query);
if ($number < 1) {
  echo '<div class="newmail_box">'.$lang['YOU_HAVE'].'<a href="mailbox_inbox"> 0 '.$lang['NEW_MESSAGES'].'</a></div>';
  } elseif ($number==1) {
  echo '<div class="newmail_box">'.$lang['YOU_HAVE'].'<a href="mailbox_inbox"> '.$number.' '.$lang['NEW_MESSAGE'].'</a></div>';
  } else {
    echo '<div class="newmail_box">'.$lang['YOU_HAVE'].'<a href="mailbox_inbox"> '.$number.' '.$lang['NEW_MESSAGES'].'</a></div>';}
?>
