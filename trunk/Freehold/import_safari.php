<?php
ini_set('display_errors', 1); 
error_reporting(E_ALL);
set_time_limit(0);
// Template Name: Import Safari
get_header(); ?>

<?php
	// Reset script with this.
	//UPDATE `properties` SET checked =0 WHERE 1 
	
	global $wbdb;
	
	//$distr = "'South Africa','Stellenbosch', 'Gordons Bay','Drakensberg','Strand','Wilderness','Somerset West','West Coast National Park','Swellendam', 'Krugersdorp','Durbanville','Kommetjie','Bellville','Cape Town','Garden Route','Bloubergstrand','Cape Peninsula','Simons Town','City Bowl','Hermanus','George','Knysna','Jeffreys Bay','Western Cape','Atlantic Seaboard North','Mossel Bay','Southern Suburbs','South Peninsula','Cape Winelands'";
	//$sql = "SELECT * FROM properties WHERE price > 2500 AND checked != 1 AND `district` IN (" . $distr . ") LIMIT 10";
	$sql = "SELECT * FROM properties WHERE price > 2500 AND checked != 1 LIMIT 2";
	$myrows = $wpdb->get_results( $sql );
	
	foreach ($myrows as $row) {
	
		//echo "<pre>";
		//print_r($row);
		//echo "</pre>";
		
		echo $row->id;
		echo "<br>";
		
		$types_arr = array();
	
		if (!empty($row->type)) {
			$row->type = str_replace(", ", ",", $row->type);
			$types = explode(",", $row->type);
			foreach ($types as $type) {

			   $type = wp_strip_all_tags($type);

			   /**
			   $slug = str_replace(" ", "-", $type);
			   $slug = strtolower($slug);
			
				$t_id = get_term_by('slug', $slug, 'property_type');
				
					if (empty($t_id->term_id)) {
						
						$tid = wp_insert_term(
						  $type, // the term 
						  'property_type', // the taxonomy
						  array(
							//'description'=> 'A yummy apple.',
							//'parent'=> $parent_term_id,
							'slug' => $slug
						  )
						);
						$term_id = $tid['term_id'];

					}
					else {
					
						$term_id = $t_id->term_id;
						
					}
				**/
					$types_arr[] = $type;

					
			}
		}
	$types_arr = array_unique($types_arr);
	
	$code = $row->code;
	$name = wp_strip_all_tags($row->name);
	
	$slug = str_replace("-"," ", $type);
	$slug = strtolower($type);
	

	$region = wp_strip_all_tags($row->region);

	$slug = str_replace(" ", "-", $region);
	$slug = strtolower($slug);
			
	$t_id = get_term_by('slug', $slug, 'property_type');
	$types_arr[] = $region;	
			
	if (empty($t_id->term_id)) {
				
		$tid = wp_insert_term(
		 $region, // the term 
		 'property_type', // the taxonomy
		  array(
		    //'description'=> 'A yummy apple.',
		    //'parent'=> $parent_term_id,
		    'slug' => $slug
		  )
		);
      }

	$town = wp_strip_all_tags($row->town);
	$district = wp_strip_all_tags($row->district);
	
	$hits = wp_strip_all_tags($row->hits);
	$grading = wp_strip_all_tags($row->grading);
	
	$price = $row->price;
	
	$geo = $row->latitude . ',' . $row->longitude;
	
	$json_url = "http://maps.googleapis.com/maps/api/geocode/json?latlng=" . $geo . "&sensor=false";
	$json = file_get_contents($json_url);
	$json_decode = json_decode($json);
	
	$address = $name . ", " . $region . ", " . $json_decode->results[0]->formatted_address;
	$address = wp_strip_all_tags($address);


	$images = sxml_unserialize($row->images);
	$images =  toArray($images); 
	if(empty($images[0]['image1'][0]))continue;

		//$src = wp_get_attachment_url( $id );
		
	// Check if exists	
	$p_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title ='" . $name . "'" );

	if (empty($p_id)) {
	
		$description = enter_description ($row->description_1, $row->description_2, $row->name);
		$excerpt = substr($description, 0, 400); 
	
		$my_post = array(
		  'post_title'    => $name,
		  'post_content'  => $description,
		  'post_excerpt'  => $excerpt,
		  'post_status'   => 'publish',
		  'post_author'   => 1,
		  'post_type' => 'property'
		);

			// Insert the post into the database
			$post_id = wp_insert_post( $my_post );
			wp_set_object_terms( $post_id, $types_arr, 'property_type' );	
			
			add_post_meta($post_id, 'safari_code', $code);
			add_post_meta($post_id, 'pyre_geo', $geo);
			add_post_meta($post_id, 'pyre_district', $district);
			add_post_meta($post_id, 'pyre_full_address', $address);
			add_post_meta($post_id, 'pyre_address', $region);
			add_post_meta($post_id, 'pyre_city', $town);
			add_post_meta($post_id, 'pyre_state', $district);
			add_post_meta($post_id, 'pyre_price', $price);
			add_post_meta($post_id, 'pyre_status', 'Call For Price');
			add_post_meta($post_id, 'pyre_hits', $hits);
			add_post_meta($post_id, 'pyre_grading', $grading);
		    add_post_meta($post_id, 'post_content', $description);

		    add_post_meta($post_id, 'affiliate', "safarinow");	

			upload_featured_images ($images, $post_id);	
			
			$wpdb->query("UPDATE properties SET checked = 1 WHERE code = " . $code . "");
		
    }
	else {
	
			$description = enter_description ($row->description_1, $row->description_2, $row->name);	   
			$excerpt = substr($description, 0, 400); 

		    $my_post = array();
		    $my_post['ID'] = $p_id;
		    $my_post['post_content'] = $description;
		    $my_post['post_excerpt'] = $excerpt;
		    wp_update_post( $my_post );
				   
			wp_set_object_terms( $p_id, $types_arr, 'property_type' );	
			
			update_post_meta($p_id, 'post_content', $description);
			update_post_meta($p_id, 'safari_code', $code);
			update_post_meta($p_id, 'pyre_district', $district);
			update_post_meta($p_id, 'pyre_full_address', $address);
			update_post_meta($p_id, 'pyre_address', $region);
			update_post_meta($p_id, 'pyre_city', $town);
			update_post_meta($p_id, 'pyre_state', $district);
			update_post_meta($p_id, 'pyre_price', $price);
			update_post_meta($p_id, 'pyre_status', 'Call for Price');
			update_post_meta($p_id, 'pyre_hits', $hits);
			update_post_meta($p_id, 'pyre_grading', $grading);

			update_post_meta($p_id, 'affiliate', "safarinow");
			
			upload_featured_images ($images, $p_id);
			
			$wpdb->query("UPDATE properties SET checked = 1	WHERE code = " . $code . "");
	}
	

	}
	
	
function URLIsValid($URL)
{
    $exists = true;
    $file_headers = @get_headers($URL);
    $InvalidHeaders = array('404', '403', '500');
    foreach($InvalidHeaders as $HeaderVal)
    {
            if(strstr($file_headers[0], $HeaderVal))
            {
                    $exists = false;
                    break;
            }
    }
    return $exists;
}

function set_featured_image ($image_url, $post_id) {
	
	$upload_dir = wp_upload_dir();
	$image_data = file_get_contents($image_url);
	$filename = basename($image_url);
	if(wp_mkdir_p($upload_dir['path'])) {
		$file = $upload_dir['path'] . '/' . $filename;
	}	
	else {
		$file = $upload_dir['basedir'] . '/' . $filename;
	}
	
	if (!file_exists($file)) {
		file_put_contents($file, $image_data);
		
		$wp_filetype = wp_check_filetype($filename, null );
		
		$attachment = array(
			'post_mime_type' => $wp_filetype['type'],
			'post_title' => sanitize_file_name($filename),
			'post_content' => '',
			'post_status' => 'inherit'
		);
		
		$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
		wp_update_attachment_metadata( $attach_id, $attach_data );

	
		return $attach_id;
	}

}

function upload_featured_images ($images, $post_id) {

              
		if (!empty($images[0]['image1'][0]) && $images[0]['image1'][0] != 'NULL' && URLIsValid($images[0]['image1'][0])) {
		   
			$image_url = $images[0]['image1'][0];
		   
			$attach_id = set_featured_image( $image_url, $post_id );
			set_post_thumbnail( $post_id, $attach_id );
		    add_post_meta($post_id, '_thumbnail_id', $attach_id);
			   
		}
		
		if (empty($image_url)) {
		  if (!empty($images[0]['image2'][0]) && $images[0]['image2'][0] != 'NULL' && URLIsValid($images[0]['image2'][0])) {
		   
			$image_url = $images[0]['image2'][0];
		   
			$attach_id = set_featured_image( $image_url, $post_id );
			set_post_thumbnail( $post_id, $attach_id );
		    add_post_meta($post_id, '_thumbnail_id', $attach_id);		   
		  }	
		}

		if (empty($image_url)) {
		  if (!empty($images[0]['image3'][0]) && $images[0]['image3'][0] != 'NULL' && URLIsValid($images[0]['image3'][0])) {
		   
			$image_url = $images[0]['image3'][0];
		   
			$attach_id = set_featured_image( $image_url, $post_id );
			set_post_thumbnail( $post_id, $attach_id );
		    add_post_meta($post_id, '_thumbnail_id', $attach_id);		   
		  }	
		}		
		
		if (!empty($images[0]['image2'][0]) && $images[0]['image2'][0] != 'NULL' && URLIsValid($images[0]['image2'][0])) {
			$image_url = $images[0]['image2'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}	
		if (!empty($images[0]['image3'][0]) && $images[0]['image3'][0] != 'NULL' && URLIsValid($images[0]['image3'][0])) {
			$image_url = $images[0]['image3'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}			
		if (!empty($images[0]['image4'][0]) && $images[0]['image4'][0] != 'NULL' && URLIsValid($images[0]['image4'][0])) {
			$image_url = $images[0]['image4'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}				
		if (!empty($images[0]['image5'][0]) && $images[0]['image5'][0] != 'NULL' && URLIsValid($images[0]['image5'][0])) {
			$image_url = $images[0]['image5'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}		
		if (!empty($images[0]['image6'][0]) && $images[0]['image6'][0] != 'NULL' && URLIsValid($images[0]['image6'][0])) {
			$image_url = $images[0]['image6'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}		
		if (!empty($images[0]['image7'][0]) && $images[0]['image7'][0] != 'NULL' && URLIsValid($images[0]['image7'][0])) {
			$image_url = $images[0]['image4'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}			
		if (!empty($images[0]['image8'][0]) && $images[0]['image8'][0] != 'NULL' && URLIsValid($images[0]['image8'][0])) {
			$image_url = $images[0]['image8'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}		
		if (!empty($images[0]['image9'][0]) && $images[0]['image9'][0] != 'NULL' && URLIsValid($images[0]['image9'][0])) {
			$image_url = $images[0]['image9'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}
		if (!empty($images[0]['image10'][0]) && $images[0]['image10'][0] != 'NULL' && URLIsValid($images[0]['image10'][0])) {
			$image_url = $images[0]['image10'][0];
			$attach_id = set_featured_image( $image_url, $post_id );
		}	
		
}	

function enter_description ($description1, $description2, $name) {

		$description = '';
		
		/**
		if (!empty($images[0])) {
			$description .= '[slider]';	
			if (!empty($images[0]['imagea']) && $images[0]['imagea'] != 'NULL' && URLIsValid($images[0]['imagea']) == TRUE)$description .= '[slide img="' . $images[0]['imagea'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['imageb']) && $images[0]['imageb'] != 'NULL' && URLIsValid($images[0]['imageb']) == TRUE)$description .= '[slide img="' . $images[0]['imageb'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['image1']) && $images[0]['image1'] != 'NULL' && URLIsValid($images[0]['image1']) == TRUE)$description .= '[slide img="' . $images[0]['image1'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['image2']) && $images[0]['image2'] != 'NULL' && URLIsValid($images[0]['image2']) == TRUE)$description .= '[slide img="' . $images[0]['image2'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['image3']) && $images[0]['image3'] != 'NULL' && URLIsValid($images[0]['image3']) == TRUE)$description .= '[slide img="' . $images[0]['image3'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['image4']) && $images[0]['image4'] != 'NULL' && URLIsValid($images[0]['image4']) == TRUE)$description .= '[slide img="' . $images[0]['image4'] . '" caption="' . $rname . '"]';
			if (!empty($images[0]['image5']) && $images[0]['image5'] != 'NULL' && URLIsValid($images[0]['image5']) == TRUE)$description .= '[slide img="' . $images[0]['image5'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['image6']) && $images[0]['image6'] != 'NULL' && URLIsValid($images[0]['image6']) == TRUE)$description .= '[slide img="' . $images[0]['image6'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['image7']) && $images[0]['image7'] != 'NULL' && URLIsValid($images[0]['image7']) == TRUE)$description .= '[slide img="' . $images[0]['image7'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['image8']) && $images[0]['image8'] != 'NULL' && URLIsValid($images[0]['image8']) == TRUE)$description .= '[slide img="' . $images[0]['image8'] . '" caption="' . $name . '"]';
			if (!empty($images[0]['image9']) && $images[0]['image9'] != 'NULL' && URLIsValid($images[0]['image9']) == TRUE)$description .= '[slide img="' . $images[0]['image9'] . '" caption="' . $name . '"]';
			$description .= '[/slider]';
		}
		**/
		
		$description .= $description1;
		$description .= '<br><br>';
		$description .= $description2;
		
		$description = wp_strip_all_tags($description);
		
	return $description;
}	
function sxml_unserialize($str) {
return unserialize(str_replace(array('O:16:"SimpleXMLElement":0:{}', 'O:16:"SimpleXMLElement":'), array('s:0:"";', 'O:8:"stdClass":'), $str));
} 
  function toArray($obj) {
    if(is_object($obj)) $obj = (array) $obj;
    if(is_array($obj)) {
      $new = array();
      foreach($obj as $key => $val) {
        $new[$key] = toArray($val);
      }
    }
    else { 
      $new = $obj;
    }
    return $new;
  } 	
?>
	
	
<?php get_footer(); ?>

<script>
	window.location.reload();
</script>