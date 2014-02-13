<?php
$state = 0;
$file = fopen($traderfile , 'r');
while (($line = fgetcsv($file)) !== FALSE) {

	//echo "<pre>";
	//print_r($line);
	//echo "<pre>";

   if(!isset($line[3]))continue;
   if($line[3] == 'Buy') {
     $trade = 'Buy';
   }  
   else if($line[3] == 'Sell') {
     $trade = 'Sell';
   }
   else {
     continue;
   }

 $date1 = convert($line[0]);
 $date2 = convert($line[1]);
 
 if(substr($date1, 0, 4) < 2013)continue;
  
 if ($line[0] == 'Open Trades')$state = 1;
 if ($line[0] == 'Open Orders')$state = 2; 
 

  if($state == 1) 
 {
  
        if(empty($line[4]))continue;
	$sql = sprintf( "SELECT opendate, symbol FROM signals WHERE opendate= '%s' AND author = '%s' AND op = '%s' ", $date1,  $traderfile, $line[4] );
	$result = mysql_query( $sql ) or die( mysql_error() );
	$row = mysql_fetch_array($result);
	$opendate =$row['opendate'];
	$symbol = $row['symbol']; 
	
	if($symbol)
	{
	
	 $data = "UPDATE signals SET tp='" . $line[4] . "' , st='" . $line[5] . "' , pips='" . $line[6] . "'   WHERE op='" . $line[4] . "' AND opendate='".$opendate."' AND symbol='".$symbol."' and author = '" . $traderfile  ."'"; 
	
	}
	else {
	  
	  //$sql = sprintf( "DELETE FROM signals WHERE  cp!=0 AND op = '%s' AND symbol='%s'", $line[4] , $line[1]);
	  //mysql_query($sql) or die( mysql_error() ); 
	  
	   $data = "INSERT INTO signals (opendate, lots, op, tp, st, pips, trade, symbol, stock, source, author) 
					VALUES ('" . $date1 . "', '" . $line[3] . "', '" . $line[4] . "', 
					'" . $line[5] . "', '" . $line[6] . "', '" . $line[7] . "', '" . $trade . "'
					, '" . $line[1] . "', 'forex', 'myfxbook', '" . $traderfile  . "'
        					)"; 
	}
	
	  mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  
 }
 else if($state==2) {
 }
 else {
        if(empty($line[7]))continue;
	$sql = sprintf( "SELECT id FROM signals WHERE  opendate= '%s' AND author = '%s' AND op = '%s' ", $date1,  $traderfile, $line[7] );
	$result = mysql_query( $sql ) or die( mysql_error() );
	$row = mysql_fetch_array($result);
	$id =$row['id'];
	
	if($symbol)
	{
	  	 $data = "UPDATE signals SET closedate='" . $date2 . "' , cp='" . $line[8] . "'   WHERE id=" . $id;
	}
	else 
	{
	  $data = "INSERT INTO signals (opendate, closedate, lots, op, cp, tp, st, pips, trade, symbol, stock, source, author) 
					VALUES ('" . $date1 . "', '" . $date2 . "', '" . $line[4] . "', '" . $line[7] . "', 
					'" . $line[8] . "', '" . $line[6] . "', '" . $line[5] . "','" . $line[11] . "', '" . $trade . "'
					, '" . $line[2] . "', 'forex', 'myfxbook', '" . $traderfile  . "'
					)";
	}	
	
	  mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  

  }				


}

fclose($file);
mysql_close($con);

function convert($date) {
date_default_timezone_set('Africa/Johannesburg'); 
   $d = date('Y-m-d H:i:s', strtotime($date));
  return $d;
}
?>
