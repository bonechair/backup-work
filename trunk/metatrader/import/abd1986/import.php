<?php
echo "Processing";
   date_default_timezone_set('Africa/Johannesburg'); 
$con = mysql_connect("localhost","bonechair","editer888");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db('mysignals', $con) or die('Could not select database.');
$traderfile = 'abd1986';

$json = file_get_contents("https://openbook.etoro.com/API/Users/Positions/abd1986/real/current/");
$json2 = file_get_contents("https://openbook.etoro.com/API/Users/Positions/abd1986/real/history/");

include("../etoro.php");
?>