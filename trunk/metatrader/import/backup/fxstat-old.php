<?php
require('simple_html_dom.php');
$html = file_get_html($file1);

foreach($html->find('tr') as $row) {
    $op = $row->find('td',2)->plaintext;
     if(!is_numeric($op))continue;
    
    $opentime= $row->find('td',1)->plaintext;

    $symbol = $row->find('td',3)->plaintext;
    $trade = $row->find('td',4)->plaintext;   
    $sl= $row->find('td',6)->plaintext;    
    $tp= $row->find('td',7)->plaintext;      
    
    	 if(strlen($trade) > 4)continue;
    
	$date1 = convert($opentime);
	 
	$sql = sprintf( "SELECT id FROM signals WHERE opendate= '%s' AND author = '%s' AND op = '%s' ", $date1,  $traderfile, $op);
	$result = mysql_query( $sql ) or die( mysql_error() );
	$row = mysql_fetch_array($result);
	$id= $row['id'];
	
	if($id)
	{
	
	   $data = "UPDATE signals SET tp='" . $tp . "' , st='" . $sl . "'  WHERE id=" . $id;
	
	}
	else {
	  
	  $data = "INSERT INTO signals (opendate, op, tp, st, trade, symbol, stock, source, author) 
					VALUES ('" . $date1 . "', '" . $op . "', '" . $tp . "', 
					'" . $sl. "', '" . $trade . "', '" . $symbol. "', 'forex', 'fxstat.com', '" . $traderfile  . "'
        					)"; 
	}
	
	  mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  
    
    
    
}


$html = file_get_html($file2);

foreach($html->find('tr') as $row) {
    
    $op = $row->find('td',5)->plaintext;
     if(!is_numeric($op))continue;
    
      $opentime= $row->find('td',0)->plaintext;
      $trade = $row->find('td',2)->plaintext;       
      $symbol = $row->find('td',4)->plaintext;
      $sl = $row->find('td',6)->plaintext;    
      $tp = $row->find('td',7)->plaintext;      
      $closetime= $row->find('td',8)->plaintext; 	   
      $cp= $row->find('td',9)->plaintext; 	        
 
	$date1 = convert($opentime);
	$date2 = convert($closetime);	 
	
	$sql = sprintf( "SELECT id FROM signals WHERE opendate= '%s' AND author = '%s' AND op = '%s' ", $date1,  $traderfile, $op);
	$result = mysql_query( $sql ) or die( mysql_error() );
	$row = mysql_fetch_array($result);
	$id= $row['id'];
	
	if($id)
	{
	
	   $data = "UPDATE signals SET tp='" . $tp . "' , st='" . $sl . "' , cp='". $cp ."', closedate='". $date2."'  WHERE id=" . $id; 
	
	}
	else {
	  
	   $data = "INSERT INTO signals (opendate, closedate, cp, op, tp, st, trade, symbol, stock, source, author) 
					VALUES ('" . $date1 . "', '" . $date2 . "', '" . $cp . "','" . $op . "', '" . $tp . "', 
					'" . $sl. "', '" . $trade . "', '" . $symbol. "', 'forex', 'fxstat.com', '" . $traderfile  . "'
        					)"; 
	}
	
	  mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  
    
}

function convert($date) {
   date_default_timezone_set('Africa/Johannesburg'); 
   $date = str_replace(".","/",$date);
   $d = date('Y-m-d H:i:s', strtotime($date));
  return $d;
}

?>
