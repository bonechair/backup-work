<?php
echo "Processing";
date_default_timezone_set('Africa/Johannesburg'); 
$con = mysql_connect("localhost","bonechair","editer888");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db('mysignals', $con) or die('Could not select database.');

require('simple_html_dom.php');

$theSignals = array(
"816032180" => "savasava", 
"816026508"=> "savasavaC",
"816034822"=> "konstantinFX",
"816035644"=> "dvejn",
"816027838"=> "RoboTraderPro6C",
"816033784"=> "StartraderW",
"816033283"=> "golden4xB",
"816036703"=> "margincallP",
"816036703"=> "margincallQ",
"816036755"=> "margincallR",
);

foreach($theSignals as $key=>$value){

$traderfile =$value;
$number  = $key;

$postdata = http_build_query(
    array(
        'accountID' => $number ,
        'stat' => 'closed'
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$result2 = file_get_contents('https://www.fxjunction.com/signals/', false, $context);

$postdata = http_build_query(
    array(
        'accountID' => $number ,
        'stat' => 'open'
    )
);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);

$context  = stream_context_create($opts);

$result1 = file_get_contents('https://www.fxjunction.com/signals/', false, $context);

$html = str_get_html($result1);

foreach($html->find('tr') as $row) {
    echo $traderfile;
    echo $op;
    $op = $row->find('td',2)->plaintext;
     if(!is_numeric($op))continue;
    
    $opentime = $row->find('td',9)->plaintext;
    $symbol = $row->find('td',1)->plaintext;    $symbol = substr($symbol, 0, 6); 
    $trade = $row->find('td',0)->plaintext;   
    $trade = ucfirst(strtolower($trade));
    $sl = $row->find('td',3)->plaintext;    
    $tp= $row->find('td',4)->plaintext;      

	$date1 = convert($opentime);
	 
	 //$sql = sprintf( "DELETE FROM signals WHERE  cp!=0 AND op = '%s' AND symbol='%s'", $op, $symbol);
	 //mysql_query($sql) or die( mysql_error() ); 
	 
	$sql = sprintf( "SELECT id FROM signals WHERE  author = '%s' AND op = '%s'  ORDER by opendate DESC LIMIT 40", $traderfile, $op);
	$result = mysql_query($sql) or die( mysql_error() );
	$row = mysql_fetch_array($result);
	$id= $row['id'];
	
	if($id)
	{
	
	   $data = "UPDATE signals SET tp='" . $tp . "' , st='" . $sl . "'   WHERE id=" . $id; 

	}
	else {
	  
	  $data = "INSERT INTO signals (opendate, op, tp, st, trade, symbol, stock, source, author) 
					VALUES ('" . $date1 . "', '" . $op . "', '" . $tp . "', 
					'" . $sl. "', '" . $trade . "', '" . $symbol. "', 'forex', 'fxjunction.com', '" . $traderfile  . "'
        					)"; 
	}

	 mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  
    
}


$html = str_get_html($result2);

foreach($html->find('tr') as $row) {
    
    $op = $row->find('td',2)->plaintext;
     if(!is_numeric($op))continue;
    
       //$opentime= $row->find('td',0)->plaintext;
       $trade = $row->find('td',0)->plaintext;       
       $trade = ucfirst(strtolower($trade));    
       $symbol = $row->find('td',1)->plaintext;    $symbol = substr($symbol, 0, 6); 
       $sl = $row->find('td',3)->plaintext;    
       $tp = $row->find('td',4)->plaintext;      
       $closetime= $row->find('td',10)->plaintext; 	   
       $cp= $row->find('td',5)->plaintext; 	        
	$pips= $row->find('td',6)->plaintext; 	    
	//$date1 = convert($opentime);
	$date2 = convert($closetime);	 
	
	$sql = sprintf( "SELECT id FROM signals WHERE author = '%s' AND op = '%s'  AND (closedate IS NULL || cp=0)  ORDER by opendate DESC LIMIT 1", $traderfile, $op);
	$result = mysql_query( $sql ) or die( mysql_error() );
	$row = mysql_fetch_array($result);
	$id= $row['id'];
	
	if($id)
	{
	
	   $data = "UPDATE signals SET tp='" . $tp . "' , st='" . $sl . "' , cp='". $cp ."',  pips='" . $pips . "',closedate='". $date2."'  WHERE id=" . $id; 

	   
	}
	else {

	   $data = "INSERT INTO signals (opendate, closedate, cp, op, tp, st, trade, symbol, stock, source, author, pips) 
					VALUES ('" . $date1 . "', '" . $date2 . "', '" . $cp . "','" . $op . "', '" . $tp . "', 
					'" . $sl. "', '" . $trade . "', '" . $symbol. "', 'forex', 'fxjunction.com', '" . $traderfile  . "', '" . $pips . "'
        					)"; 
				
	}
	   mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  

    
}

}

function convert($date) {
   date_default_timezone_set('Africa/Johannesburg'); 
   $date = str_replace(".","/",$date);
   $d = date('Y-m-d H:i:s', strtotime($date));
  return $d;
}

?>
