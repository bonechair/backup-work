<?php
echo "Processing";
$con = mysql_connect("localhost","bonechair","editer888");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('mysignals', $con) or die('Could not select database.');
// Check connection
 
$traderfile = 'johnpaul77.csv';

include("../myfxbook.php");

?>