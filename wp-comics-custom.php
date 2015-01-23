<?php
/*
Plugin Name: WP Comics Voting
Plugin URI: lightsites@gmail.com
Description: Wp Comics Voting Plugin
Version: 1.0
Author: Louis Christian Stoltz
*/

if(!class_exists('WP_Custom_Login_Profile'))
{
	class WP_Custom_Login_Profile
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			// Initialize Settings
			require_once(sprintf("%s/wp-comics-custom/settings.php", dirname(__FILE__)));
			$WP_Custom_Login_Profile_Settings = new WP_Custom_Login_Profile_Settings();

			// Register custom post types
			require_once(sprintf("%s/wp-comics-custom/post-types/wp-comics.php", dirname(__FILE__)));
			$Post_Type_Template = new Post_Type_Template();

			$plugin = plugin_basename(__FILE__);
			add_filter("plugin_action_links_$plugin", array( $this, 'plugin_settings_link' ));
		} // END public function __construct

		/**
		 * Activate the plugin
		 */
		public static function activate()
		{
			// Do nothing
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			// Do nothing
		} // END public static function deactivate

		// Add the settings link to the plugins page
		function plugin_settings_link($links)
		{
			$settings_link = '<a href="options-general.php?page=WP_Custom_Login_Profile">Settings</a>';
			array_unshift($links, $settings_link);
			return $links;
		}


	} // END class WP_Custom_Login_Profile
} // END if(!class_exists('WP_Custom_Login_Profile'))

if(class_exists('WP_Custom_Login_Profile'))
{
	// Installation and uninstallation hooks
	register_activation_hook(__FILE__, array('WP_Custom_Login_Profile', 'activate'));
	register_deactivation_hook(__FILE__, array('WP_Custom_Login_Profile', 'deactivate'));

	// instantiate the plugin class
	$WP_Custom_Login_Profile = new WP_Custom_Login_Profile();

}

//Database Upgrade
function install_db () {
global $wpdb;

	$charset_collate = $wpdb->get_charset_collate();

	$table_name = $wpdb->prefix . "votes"; 

	$sql = "
CREATE TABLE IF NOT EXISTS `wp_votes` (
`id` bigint(11) NOT NULL,
  `comedy_id` bigint(11) NOT NULL,
  `voter` bigint(11) NOT NULL,
  `comedian` bigint(11) NOT NULL,
  `medallion` int(11) NOT NULL,
  `description` longtext NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

ALTER TABLE `wp_votes` ADD PRIMARY KEY (`id`);

ALTER TABLE `wp_votes` ADD PRIMARY KEY (`id`);
ALTER TABLE `wp_votes` MODIFY `id` bigint(11) NOT NULL AUTO_INCREMENT;
	";
		
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );	
	
}

// Add custom validation for CF7 form fields
function custom_text_validation_filter($result,$tag){
	$type = $tag['type'];
	$name = $tag['name'];
	if($name == 'password2' && $_POST['password1'] != $_POST['password2']){ // Only apply to fields with the form field name of "page_url"

			$result['valid'] = false;
			$result['reason'][$name] = 'These passwords do not match';

	}
	$exists = email_exists($_POST['user-email']);
	if($exists){ 

			$result['valid'] = false;
			$result['reason'][$name] = 'That email already exists, try login';

	}

	return $result;
}
add_filter( 'wpcf7_validate_text', 'custom_text_validation_filter', 10, 2 ); // text field
add_filter( 'wpcf7_validate_text*', 'custom_text_validation_filter', 10, 2 ); //Req. text field.

//Contact 7 form hooks
add_action( 'wpcf7_mail_sent', 'v_contact_add' );
function v_contact_add( $cf7 ) {

		$submission = WPCF7_Submission::get_instance();
		$data = $submission->get_posted_data();

		$files = $submission->uploaded_files();

		if (!$data['username']) {
		
			$yourname 			= $data['your-name'];
			$surname 			= $data['sur-name'];
			$password1 			= $data['password1'];
			$password2 			= $data['password2'];
			$fileupload 		= $files['file-upload']; 
			$email 				= $data['user-email'];
			$biography 			= $data['biography'];
			$twitter 			= $data['twitter'];
			$facebook 			= $data['facebook'];
			$id_number 			= $data['id-number'];
			$stage_number   	= $data['stage-number'];
			$started   			= $data['started'];
			$ref1   			= $data['ref1'];
			$ref2  				= $data['ref2'];
			$refcell1   		= $data['refcell1'];
			$refcell2   		= $data['refcell2'];
			$contact_number		= $data['contact-number'];
			$Pen_Award	    	= $data['Pen-Award'];
			if(!empty($Pen_Award))$Pen_Award = 1;
			$province	    	= $data['province'];

		$post = array(
			'post_type'    		=> "wp-comics",
			'post_status'    	=> "publish",
			'post_title'    	=> wp_strip_all_tags( $yourname . ' ' . $surname),		
			'post_content'    	=> '[contact-form-7 id="1153" title="Profile"]',		
			'post_excerpt'    	=> wp_strip_all_tags( $biography ),		
		);

		$post_id = wp_insert_post($post);

		$user_id = wp_create_user( $email, $password1, $email );	

		add_post_meta( $post_id, 'comedians-uid', $user_id );	
		add_post_meta( $post_id, 'your-name', $yourname );
		add_post_meta( $post_id, 'sur-name', $surname );
		add_post_meta( $post_id, 'email', $email );
		add_post_meta( $post_id, 'twitter', $twitter );
		add_post_meta( $post_id, 'facebook', $facebook );
		add_post_meta( $post_id, 'instagram', $instagram );
		add_post_meta( $post_id, 'social-other', $social_other);
		add_post_meta( $post_id, 'id-number', $id_number );
		add_post_meta( $post_id, 'started', $started );
		add_post_meta( $post_id, 'stage-number', $stage_number );
		add_post_meta( $post_id, 'ref1', $ref1 );
		add_post_meta( $post_id, 'ref2', $ref2 );
		add_post_meta( $post_id, 'refcell1', $refcell1 );
		add_post_meta( $post_id, 'refcell2', $refcell2 );
		add_post_meta( $post_id, 'contact-number', $contact_number );
		add_post_meta( $post_id, 'Pen-Award', $Pen_Award );
		add_post_meta( $post_id, 'province', $province );

		//Upload Featured Image
		$upload_dir = wp_upload_dir();

		$image_url = str_replace('//' , '/', $files['file-upload']);
		$image_url = str_replace(' ' , '%20', $files['file-upload']);
		$image_data = file_get_contents($image_url);

		$filename = basename($image_url);
		$filename = str_replace(' ' , '-', $filename);
		$filename = str_replace('%20' , '-', $filename);

		if(wp_mkdir_p($upload_dir['path']))
			$file = $upload_dir['path'] . '/' . $filename;
		else
			$file = $upload_dir['basedir'] . '/' . $filename;

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

		set_post_thumbnail( $post_id, $attach_id );
			
		//wp_redirect( home_url() . '/login' );
		
	}
	else {

		$fileupload 		= $files['file-upload']; 
		$biography 			= $data['biography'];
		$twitter 			= $data['twitter'];
		$facebook 			= $data['facebook'];
		$instagram 			= $data['instagram'];
		$social_other		= $data['social-other'];
		$website			= $data['website'];
		$yourname			= $data['your-name'];
		$surname			= $data['sur-name'];
		$id_number			= $data['id-number'];
		$started			= $data['started'];
		$stage_number		= $data['stage-number'];
		$ref1				= $data['ref1'];
		$ref2				= $data['ref2'];
		$refcell1			= $data['refcell1'];
		$refcell2			= $data['refcell2'];
		$contact_number		= $data['contact-number'];

		$province   		= $data['province'];
		$password   		= $data['password1'];
		
		$Pen_Award  		= $data['Pen-Award'];
		if(!empty($Pen_Award))$Pen_Award = 1;		
		$pen_text	  		= $data['pen-text'];

		$post_id = $data['your-id'];
		
		$post = array(
			'ID'    			=> $post_id,
			'post_type'    		=> "wp-comics",
			'post_status'    	=> "publish",		
			'post_excerpt'    	=> wp_strip_all_tags( $biography ),		
		);

		wp_update_post($post);

		$website    = get_post_meta( $post_id, 'website', true );
		$confirmed  = get_post_meta( $post_id, 'confirmed', true );
		$User_ID  	= get_post_meta( $post_id, 'comedians-uid', true );

		update_post_meta( $post_id, 'twitter', $twitter );
		update_post_meta( $post_id, 'facebook', $facebook );
		update_post_meta( $post_id, 'your-name', $yourname );
		update_post_meta( $post_id, 'sur-name', $surname );
		update_post_meta( $post_id, 'id-number', $id_number );
		update_post_meta( $post_id, 'started', $started );
		update_post_meta( $post_id, 'stage-number', $stage_number );
		update_post_meta( $post_id, 'ref1', $ref1 );
		update_post_meta( $post_id, 'ref2', $ref2 );
		update_post_meta( $post_id, 'refcell1', $refcell1 );
		update_post_meta( $post_id, 'refcell2', $refcell2 );
		update_post_meta( $post_id, 'contact-number', $contact_number );

		if ($password) {	
			delete_post_meta($post_id, 'password');
		    add_post_meta( $post_id, 'password', $password);
			wp_set_password( $password, $User_ID );
		}	
		
		if ($website) {	
			delete_post_meta($post_id, 'website');
		    add_post_meta( $post_id, 'website', $website);
		}
		if ($confirm) {	
			delete_post_meta($post_id, 'confirmed');		
		    add_post_meta( $post_id, 'confirmed', 1 );
		}
		if ($province) {
			delete_post_meta($post_id, 'province');		
		    add_post_meta( $post_id, 'province', $province);
		}
		if ($instagram) {
			delete_post_meta($post_id, 'instagram');		
		    add_post_meta( $post_id, 'instagram', $instagram);
		}
		if ($social_other) {
			delete_post_meta($post_id, 'social-other');		
		    add_post_meta( $post_id, 'social-other', $social_other);
		}		
		if ($pen_text) {
			delete_post_meta($post_id, 'pen-text');		
		    add_post_meta( $post_id, 'pen-text', $pen_text);
		}	
		if (!empty($Pen_Award)) {
			delete_post_meta($post_id, 'Pen-Award');		
		    add_post_meta( $post_id, 'Pen-Award', 1);
		}
		else {
			delete_post_meta($post_id, 'Pen-Award');		
		    add_post_meta( $post_id, 'Pen-Award', 0);
		}
		
		// $filename should be the path to a file in the upload directory.
			//Upload Featured Image
			$upload_dir = wp_upload_dir();

			$image_url = str_replace('//' , '/', $files['file-upload']);
			$image_url = str_replace(' ' , '%20', $files['file-upload']);
					
		if(file_exists($image_url)) {
			$image_data = file_get_contents($image_url);
			$filename = basename($image_url);
			$filename = str_replace(' ' , '-', $filename);
			$filename = str_replace('%20' , '-', $filename);

			if(wp_mkdir_p($upload_dir['path']))
				$file = $upload_dir['path'] . '/' . $filename;
			else
				$file = $upload_dir['basedir'] . '/' . $filename;

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

			set_post_thumbnail( $post_id, $attach_id );
					
		}	
		//wp_redirect( home_url() . '/vote'  );
	
	}
 
    //Manage columns	add_action( 'manage_posts_custom_column' , 'custom_columns_data', 10, 2 ); 

}