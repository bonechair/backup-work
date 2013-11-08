<?php
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
 
session_start();
include('../connect.php');
$ip = $_SERVER['REMOTE_ADDR'];
function add_vote($article_id, $ip){
	$ip_query = mysql_query("SELECT * FROM `votes` WHERE `ip`='".mysql_real_escape_string($ip)."'");
 	$ip_array = mysql_fetch_array($ip_query);

 	if (mysql_num_rows($ip_query) == 0){

 		mysql_query("INSERT INTO `votes` (`ip`,`article_id`) VALUES ('$ip', '$article_id')");

 	}
 	else {

 		$new_comp_id = ''.$ip_array['article_id'].','.$article_id.'';
 		mysql_query("UPDATE `votes` SET `article_id`='$new_comp_id' WHERE `ip`='".mysql_real_escape_string($ip)."'");

 	}

}




$id = ($_POST['id']);
$action = $_POST['action'];
 $idref = explode(":", $id);
 $idref = $idref[0];




if ($action=='vote_up'){

	$q = "update jobs set voteup=voteup+1 where id='".mysql_real_escape_string($idref)."'";
	add_vote($id, $ip);
}
elseif ($action=='vote_down'){
	$q = "update jobs set votedown=votedown+1 where id='".mysql_real_escape_string($idref)."'";
	add_vote($id, $ip);
}

$r = mysql_query($q);


?>