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
 
$sql2 = mysql_query("SELECT * FROM jobs_bought where `seller_username` = '$my_user' AND `job_completed` = 'no' AND `rejected` = 'no'");
$number=mysql_num_rows($sql2);
if ($number==1) {
  echo ''.$username.' has 1 '.$lang['JOB_IN_Q'].'';
  } else {
    echo ''.$username.' has '.$number.' '.$lang['JOBS_IN_Q'].'';}
?>
