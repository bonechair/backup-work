<?php

$theSignals = array(
"816032180" => "savasava", 
"816026508"=> "savasavaC",
"816034822"=> "konstantinFX",
"816035644"=> "dvejn",
"816027838"=> "RoboTraderPro6C",
"816033784"=> "StartraderW",
"816033283"=> "golden4xB",
);


$traderfile ='konstantinFX';
$number  = '816034822';

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

$result2 = file_get_contents('https://www.fxjunction.com/signals', false, $context);

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

echo $result1 = file_get_contents('https://www.fxjunction.com/signals', false, $context);

preg_match_all("/<tr>([^<]+)/", $result1, $matches);

foreach($matches as $row) {
//preg_match_all("/<tr>([^<]+)/", $row, $col);
print_r($row);
}


?>
