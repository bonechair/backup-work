<?php
/**
	$post_id      = $post->ID;

	$image_url    = get_post_meta($post->ID, 'Ext-Image', true);

		if(!empty($image_url)) {
		$image_url 		= str_replace("http://www.comicschoice.com//voting/app/webroot/uploads/images/", "/usr/www/users/stagizdkpp/wp-content/uploads/2015/01/", $image_url);
		$filename 		= str_replace("/usr/www/users/stagizdkpp/wp-content/uploads/2015/01/","", $image_url);

		$upload_dir = wp_upload_dir();

		if(file_get_contents($image_url)===false) die("Error reading file $image_url");
		
		$medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'medium' );
		if(file_get_contents($medium_image_url)) die("Error reading file2");

		$file = $image_url;

		$wp_filetype = wp_check_filetype($file, null );
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

		set_post_thumbnail( $post_id, $attach_id );
	}
**/	
?>