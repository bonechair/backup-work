<?php
echo "Processing";
date_default_timezone_set('Africa/Johannesburg'); 
$con = mysql_connect("localhost","bonechair","editer888");
if (!$con) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db('mysignals', $con) or die('Could not select database.');

require('simple_html_dom.php');

$loginUrl = 'https://login.mql5.com/en/auth_login'; //action from the login form
$loginFields = array('Login'=>'bonechair', 'Password'=>'lager888', 'RedirectAfterLoginUrl' => 'http://www.mql5.com/en/signals/26410/export/trading', 'RememberMe' => 'true'); //login form field names and values

$login = getUrl($loginUrl, 'post', $loginFields); //login to the site

$theSignals = array(
"26410" => "Art03-Nano", 
"20937" => "FBZTRADEXAGUSD", 
"3913" => "VICTORY", 
);

foreach($theSignals as $key=>$value){

$traderfile =$value;
$number  = $key;

$remotePageUrl = 'http://www.mql5.com/en/signals/' . $number . '/export/trading'; //url of the page you want to save  
$remotePage = getUrl($remotePageUrl); //get the remote page
$remotePage= str_replace('Price;Commission;', 'Price2;Commission;', $remotePage);

$open = csv_to_array($remotePage, $delimiter = ';', '', '\\', "\n");

foreach($open as $row) {

    $op = $row['Price'];
     if(!is_numeric($op))continue;
    
    $opentime = $row['Time'];
    $symbol = $row['Symbol'];
    $symbol = substr($symbol, 0, 6); 
    $trade = $row['Type'];
    $trade = ucfirst(strtolower($trade));

    if($trade == 'Buy') {
    }  
    else if($trade == 'Sell') {
    }
    else {
      continue;
    }
    $sl = $row['S/L'];
    $tp= $row['T/P'];

	$date1 = convert($opentime);
	 
	echo $sql = sprintf( "SELECT id FROM signals WHERE  author = '%s' AND op = '%s'  ORDER by opendate DESC LIMIT 40", $traderfile, $op);
	echo "<br>";
	$result = mysql_query($sql) or die( mysql_error() );
	$res = mysql_fetch_array($result);
	$id= $res['id'];
	
	if($id)
	{
	
	   echo $data = "UPDATE signals SET tp='" . $tp . "' , st='" . $sl . "'   WHERE id=" . $id; 

	}
	else {
	  
	  echo $data = "INSERT INTO signals (opendate, op, tp, st, trade, symbol, stock, source, author) 
					VALUES ('" . $date1 . "', '" . $op . "', '" . $tp . "', 
					'" . $sl. "', '" . $trade . "', '" . $symbol. "', 'forex', 'mql5.com', '" . $traderfile  . "'
        					)"; 
	}

	 mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  
    
}

$remotePageUrl = 'http://www.mql5.com/en/signals/' . $number . '/export/history'; //url of the page you want to save  
$remotePage = getUrl($remotePageUrl); //get the remote page
$remotePage= str_replace('Price;Commission;', 'Price2;Commission;', $remotePage);
$history = csv_to_array($remotePage, $delimiter = ';', '', '\\', "\n");
//echo "<pre>";
//print_r($history);
//echo "</pre>";


foreach($history as $row) {
    
    $op = $row['Price'];
     if(!is_numeric($op))continue;
    
       //$opentime= $row->find('td',0)->plaintext;
       $trade = $row['Time'];      
       $trade = ucfirst(strtolower($trade));    
      
      if($trade == 'Buy') {
      }  
      else if($trade == 'Sell') {
      }
      else {
        continue;
      }      
       
      $symbol = $row['Symbol'];    
      $symbol = substr($symbol, 0, 6); 
      $sl = $row['S/L'];
      $tp= $row['T/P'];

       $cp= $row['Price2'];	        
 
	$date2 = date('Y-m-d H:i:s');
	
	$sql = sprintf( "SELECT id FROM signals WHERE author = '%s' AND op = '%s'  AND (closedate IS NULL || cp=0)  ORDER by opendate DESC LIMIT 1", $traderfile, $op);
	$result = mysql_query( $sql ) or die( mysql_error() );
	$res= mysql_fetch_array($result);
	$id= $res['id'];
	
	if($id)
	{
	
	   $data = "UPDATE signals SET tp='" . $tp . "' , st='" . $sl . "' , cp='". $cp ."', closedate='". $date2."'  WHERE id=" . $id; 
	   mysql_query($data) or die("<b>A fatal MySQL error occured</b>.\n<br />Query: " . $data . "<br />\nError: (" . mysql_errno() . ") " . mysql_error());	  
	   
	}
	else {
			
	}


    
}

}

function convert($date) {
   date_default_timezone_set('Africa/Johannesburg'); 
   $date = str_replace(".","/",$date);
   $d = date('Y-m-d H:i:s', strtotime($date));
  return $d;
}

function getUrl($url, $method='', $vars='') {
    $ch = curl_init();
    if ($method == 'post') {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    $buffer = curl_exec($ch);
    curl_close($ch);
    return $buffer;
}
function csv_to_array($csv, $delimiter = ',', $enclosure = '"', $escape = '\\', $terminator = "\n") {
    $r = array();
    $rows = explode($terminator,trim($csv));
    $names = array_shift($rows);
    $names = str_getcsv($names,$delimiter,$enclosure,$escape);
    $nc = count($names);
    foreach ($rows as $row) {
        if (trim($row)) {
            $values = str_getcsv($row,$delimiter,$enclosure,$escape);
            if (!$values) $values = array_fill(0,$nc,null);
            $r[] = array_combine($names,$values);
        }
    }
    return $r;
} 
?>