<?php
// Template Name: Json Map
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: application/json");

if (strstr($_GET['area'], 'district_')) {
	
	$_GET['area'] = str_replace('district_', '', $_GET['area']);
	
					$args = array(
					'post_type' => 'property',
					'post_type' => 'property',
					'meta_key'=> 'pyre_district',
					'meta_value'=> $_GET['area'],
					'posts_per_page' => 9000
					);
}
else {
if (empty($_GET['area'])) {
  $_GET['area'] = 'Cape Town';
}

		$args = array(
		'post_type' => 'property',
		'meta_key'=> 'pyre_address',
		'meta_value'=> $_GET['area'],
		'posts_per_page' => 9000
		);

}
$json = array();
$i = 0;		
query_posts($args);
while(have_posts()){ 
  $i++;
  
		the_post(); 
		$image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'small');

		$geo             			 = split("," , get_post_meta($post->ID, "pyre_geo", true));
		
		$bus['longitude'] 		 = str_replace(" ", "", $geo[1]);
		$bus['latitude'] 			 = str_replace(" ", "", $geo[0]);
		//$bus['address'] 			 = addslashes(get_post_meta($post->ID, "pyre_full_address", true));
		//$bus['title'] 				 = addslashes(get_post_meta($post->ID, "post_title", true));
		$bus['icon'] 				 = of_get_option("map_icon", get_template_directory_uri() . "/images/home.png");
		$bus['html']['content']  = '<a href="' . post_permalink() . '" class="alignright map-image-thumb"><img src="' . $image_url[0] . '"></a><div class="property-information-address"><a href="' . post_permalink() . '">' .  htmlspecialchars_decode(get_the_title()) . '</a></div><div class="property-information-location"><a href="' . post_permalink() . '">' .  addslashes(get_post_meta(get_the_ID(), "pyre_city", true)) . ', ' .  addslashes(get_post_meta(get_the_ID(), "pyre_state", true)) . ', ' .  addslashes(get_post_meta(get_the_ID(), "pyre_address", true)) . '</a></div><div class="property-information-price"><a href="' . post_permalink() . '">R' .  addslashes(get_post_meta(get_the_ID(), "pyre_price", true)) . '</a></div><a href="' . post_permalink() . '" class="view-listing-map">' . of_get_option("view_listing_button", "View Listing") . '</a>';
		array_push($json, $bus);
}

echo json_encode($json);

?>