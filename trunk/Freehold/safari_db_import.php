<html>
<head>
<title>SafariNow Search</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
// Same as error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);


	$mysql = mysql_connect( 'localhost', 'root', 'dwwwe6e0') or die('Could not connect to mysql server.' );
	mysql_select_db('capetownlodging', $mysql) or die('Could not select database.');
	//$file = "http://www.safarinow.com/lib/hbef/xmlapi/search.aspx?i=112058&p=editer888&location=western%20cape&IncludeDescription=true";
	//$file = "http://www.safarinow.com/lib/hbef/xmlapi/search.aspx?query=establishment&i=112058&full=true";
	$file = "safari_db_import.xml";

// Extracts content from XML tag

	function GetElementByName ($xml, $start, $end) {

	   global $pos;
	   $startpos = strpos($xml, $start);
	   if ($startpos === false) {
		   return false;
	   }
	   $endpos = strpos($xml, $end);
	   $endpos = $endpos+strlen($end);
	   $pos = $endpos;
	   $endpos = $endpos-$startpos;
	   $endpos = $endpos - strlen($end);
	   $tag = substr ($xml, $startpos, $endpos);
	   $tag = substr ($tag, strlen($start));

	   return $tag;

	}

// Open and read xml file. You can replace this with your xml data.

	$pos = 0;
	$Nodes = array();
	$data = '';
 
	$data =file_get_contents($file);

$xml = new SimpleXMLElement($data);

foreach ($xml->product as $node) {
  
echo $node->name;
  echo "<br>";
  
	$code = $node->id;
	$name = $node->name;
	$shortdesc = $node->shortdesc;
	$desc = $node->desc;
	$hits = $node->rating;
	$typedesc = $node->typedesc;
  
//Long & Lat
	$longitude = $node->longitude;
	$latitude = $node->latitude;

	$point_image = $node->thumbnail;

	$shortdesc = str_replace("'","''",$shortdesc);
	$desc = str_replace("'","''",$desc);
	$name = str_replace("'","''",$name);

	$images = array();
	$images[0]['thumbnail'] = $node->thumbnail;
	$images[0]['imagea'] = $node->image1;
	$images[0]['imageb'] = $node->image2;

	$images[0]['image1'] = $node->Gallery->Image1;
	$images[0]['image2'] = $node->Gallery->Image2;
	$images[0]['image3'] = $node->Gallery->Image3;
	$images[0]['image4'] = $node->Gallery->Image4;
	$images[0]['image5'] = $node->Gallery->Image5;
	$images[0]['image6'] = $node->Gallery->Image6;
	$images[0]['image7'] = $node->Gallery->Image7;
	$images[0]['image8'] = $node->Gallery->Image8;
	$images[0]['image9'] = $node->Gallery->Image9;
	$images[0]['image10'] = $node->Gallery->Image10;
	
	$images[0]['thumbnail1'] = $node->Gallery->Thumbnail1;
	$images[0]['thumbnail2'] = $node->Gallery->Thumbnail2;
	$images[0]['thumbnail3'] = $node->Gallery->Thumbnail3;
	$images[0]['thumbnail4'] = $node->Gallery->Thumbnail4;
	$images[0]['thumbnail5'] = $node->Gallery->Thumbnail5;
	$images[0]['thumbnail6'] = $node->Gallery->Thumbnail6;
	$images[0]['thumbnail7'] = $node->Gallery->Thumbnail7;
	$images[0]['thumbnail8'] = $node->Gallery->Thumbnail8;
	$images[0]['thumbnail9'] = $node->Gallery->Thumbnail9;
	$images[0]['thumbnail10'] = $node->Gallery->Thumbnail10;
	
	$images = serialize($images);
	$destinations = $node->destinations;
	$destinations = explode(", ",$destinations);
	$affiliate = "Safarinow";
	$price = $node->minpps;
	$grading = $node->grading;
	$unit = "";	  


	if($price == 'NULL')
	{
		$price = $node->minunit;
		$unit = "yes";
	}

	

	$num_rows = ceil(mysql_num_rows(mysql_query("SELECT * FROM properties WHERE code='$code'")));
	$price= str_replace("R","",$price);

	if($num_rows >= 1)
	{
		$sql2 = "UPDATE properties set longitude='$longitude',latitude='$latitude',price='$price',images='$images', district='".$destinations[1]."', town='".$destinations[2]."' WHERE code='$code'";

		$sql_query2 = mysql_query($sql2);
		if (!$sql_query2) {
			echo mysql_error();
		}
		
		echo "$name updated<br>";
		
	}
	else{

		$sql = "INSERT INTO properties ( code, name, price, description_1, description_2, images, region, district, town, hits, Sponsor, perunit, type, longitude, latitude, grading  ) " .
				  "VALUES (  '$code', '$name', '$price', '$shortdesc', '$desc', '$images', '".$destinations[0]."', '".$destinations[1]."', '".$destinations[2]."', '$hits', '$affiliate', '$unit','$typedesc','$longitude','$latitude','$grading')";

		$sql_query = mysql_query($sql);
	if (!$sql_query) {
		echo mysql_error();
	}
			echo "$name inserted<br>";
	}

	
}


?>

</body>
</html>