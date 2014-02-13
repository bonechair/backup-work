<?php
echo "Processing";
date_default_timezone_set('Africa/Johannesburg'); 
$con = mysql_connect("localhost","bonechair","editer888");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db('mysignals', $con) or die('Could not select database.');


$theSignals = array(
"1" => "logo600", 
"2"=> "malsolo",
"3"=> "rowaihy",
"4"=> "lospaccone76",
"5"=> "lorenoem",
"6"=> "ykforex",
"7"=> "gerdollarman",
"8"=> "dellos",
"9"=> "abd1986",
"10"=> "anassleiman",
"11"=> "caraj51",
);

foreach($theSignals as $key=>$value){

$number  = $key;
$traderfile = $value;

$json = file_get_contents("https://openbook.etoro.com/API/Users/Positions/" . $value . "/real/current/?_=1391625176166");
$json2 = file_get_contents("https://openbook.etoro.com/API/Users/Positions/" . $value . "/real/history/?_=1391625265758");

$objects = json_decode($json);
    
foreach($objects->Positions as $object) {

	foreach($object as $obj) {
	
	     $op = $obj->OpenRate;
	     if(!is_numeric($op))continue;
    
	    $opentime=preg_replace("/[^0-9]/", '', $obj->OriginalOpenDate);
	    preg_match('/[0-9]+/', $opentime, $matches);
	    
	    if($obj->IsBuy == 1)$trade="Buy";  else $trade = 'Sell';  
	    $symbol=str_replace("-", "", $obj->Market->Symbol->Name);
	    $symbol=strtoupper($symbol);	    
	    $sl =$obj->StopLoss;
	    $tp =$obj->TakeProfit;
	    $cp=$obj->CloseRate;	        
 
	        $dateago = date('d', $matches[0]/1000);
		if($dateago != date('d'))continue;

 		$date1 = date('Y-m-d H:i:s');
		$sql = sprintf( "SELECT id FROM signals WHERE author = '%s' AND op = '%s' ",  $traderfile, $op);
		$result = mysql_query( $sql ) or die( mysql_error() );
		$row = mysql_fetch_array($result);
		$id= $row['id'];
		
		if($id)
		{
		
		   $data = "UPDATE signals SET tp='" . $tp . "' , st='" . $sl . "'   WHERE id=" . $id; 
		
		}
		else {
		  
		  $data = "INSERT INTO signals (opendate, op, tp, st, trade, symbol, stock, source, author) 
						VALUES ('" . $date1 . "', '" . $op . "', '" . $tp . "', 
						'" . $sl. "', '" . $trade . "', '" . $symbol. "', 'forex', 'etoro.com', '" . $traderfile  . "'
							)"; 
		}
		
		  mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  
		}

}

$objects = json_decode($json2);

foreach($objects->Positions as $object) {

	foreach($object as $obj) {

	     $op = $obj->OpenRate;
            if(!is_numeric($op))continue;
    
	    //$opentime=preg_replace("/[^0-9]/", '', $obj->OriginalOpenDate);
	    //preg_match('/[0-9]+/', $opentime, $matches);
	    
	    if($obj->IsBuy == 1)$trade="Buy";  else $trade = 'Sell';  
	    $symbol=str_replace("-", "", $obj->Market->Symbol->Name);
	    $symbol=strtoupper($symbol);	    
	    $sl =$obj->StopLoss;
	    $tp =$obj->TakeProfit;
	    $closetime=$obj->CloseDate;   
	    $cp=$obj->CloseRate;	        


	       //$sql = sprintf( "DELETE FROM signals WHERE  cp!=0 AND op = '%s' AND symbol='%s'", $op, $symbol);
	      //mysql_query($sql) or die( mysql_error() ); 
		    
		$sql = sprintf( "SELECT id FROM signals WHERE author = '%s' AND op = '%s'  AND (closedate IS NULL || cp=0) ORDER by opendate DESC LIMIT 1", $traderfile, $op);
		$result = mysql_query( $sql ) or die( mysql_error() );
		$row = mysql_fetch_array($result);
		$id= $row['id'];

		if(empty($id))continue;
		
		if($cp > 0)
		{
		   $date2=date('Y-m-d H:i:s', time());		
		   $data = "UPDATE signals SET cp='". $cp ."', closedate='". $date2."'  WHERE id=" . $id; 
		   mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	
		}
		else {
		  /**
		   $data = "INSERT INTO signals (opendate, closedate, cp, op, tp, st, trade, symbol, stock, source, author) 
						VALUES ('" . $date1 . "', '" . $date2 . "', '" . $cp . "','" . $op . "', '" . $tp . "', 
						'" . $sl. "', '" . $trade . "', '" . $symbol. "', 'forex', 'etoro.com', '" . $traderfile  . "'
							)"; 
									  mysql_query($data);
		  **/
		}

		}
}
}


function get_numerics ($str) {
        preg_match_all('/\d+/', $str, $matches);
        return $matches[0];
    }
?>