<?php
/*
Template Name: Voting/ Images
*/

?>
<?php wp_head(); ?>

<?php $loop = new WP_Query( array( 'post_type' => 'wp-comics', 'posts_per_page' => -1 ) ); ?>
<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

<?php
		$post_id = get_the_ID();

//$email	    = get_post_meta( get_the_ID(), 'email' );
//$yourname 	= get_post_meta( get_the_ID(), 'your-name' );
//$surname 	= get_post_meta( get_the_ID(), 'sur-name' );
//$my_excerpt = get_the_excerpt();


global $wpdb;
$wpdb->query( "DELETE FROM $wpdb->postmeta WHERE meta_key = '_thumbnail_id' AND post_id = " . $post_id );

/**
$password1 = wp_generate_password();
$user_id = wp_create_user( $email[0], $password1, $email[0] );	
wp_update_user( array( 'ID' => $user_id, 'first_name' => $yourname[0] ) );
wp_update_user( array( 'ID' => $user_id, 'last_name' => $surname[0] ) );
wp_update_user( array( 'ID' => $user_id, 'description' => $my_excerpt ) );

update_post_meta( $post_id, 'comedians-uid', $user_id );
update_post_meta( $post_id, 'password', $password1 );

echo $email[0] . ' === ' . $password1;
**/

		//Upload Featured Image
		$image_url				= get_post_meta( get_the_ID(), 'Ext-Image' );
		
		if(empty($image_url))continue;
		
		//echo $image_url 		= str_replace("http://www.comicschoice.com//voting/app/webroot/uploads/images/", "http://staging.comicschoice.com/wp-content/uploads/comedians/", $image_url[0]);
		echo $image_url 		= str_replace("http://www.comicschoice.com//voting/app/webroot/uploads/images/", "/usr/www/users/stagizdkpp/wp-content/uploads/2015/01/", $image_url[0]);
		echo "<br>";
		$filename 				= str_replace("/usr/www/users/stagizdkpp/wp-content/uploads/2015/01/","", $image_url);

		$upload_dir = wp_upload_dir();


		//if($image_data = file_get_contents($image_url)===false) die("Error reading file $image_url");
		
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
	
?>

<?php endwhile; wp_reset_query(); ?>
	
<?php wp_reset_query(); ?>

<?php get_footer();?>