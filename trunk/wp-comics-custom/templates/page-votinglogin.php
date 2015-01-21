<?php
/*
Template Name: Voting/ Login
*/

if ( is_user_logged_in() ) {

	global $wpdb;
	
    $uid 				= get_current_user_id();
	$value 				= $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'comedians-uid' AND meta_value=%s LIMIT 1" , $uid) );
	$slug 				= $wpdb->get_var( $wpdb->prepare("SELECT post_name FROM $wpdb->posts WHERE ID = %s LIMIT 1" , $value) );

	if ( $slug )wp_redirect( home_url() . '/wp-comics/' . $slug  );

}
else {

	//wp_redirect( home_url() . '/login'  );

}

?><!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title>
<?php wp_title( '|', true, 'right' ); ?>
<?php echo bloginfo( 'name' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="shortcut icon" href="<?php echo get_theme_mod('favicon_image'); ?>">

<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	 	
	 <div class="loader"></div>
	 <div id="main">	        

		<div class="containerCentered">
		<a href="/"><u style="font-size:9pt;color:#000;margin:0 0 10px 0;">Back to Website</u></a>
		<br>
		<img src="/wp-content/themes/scribe/img/02-Login.jpg" alt="">
		
		<div style="border:1px solid #dededb;width:390px;margin:35px auto 25px auto;padding:0px;">
		<h3 style="background:#000;color:#61D9A4;margin:0;padding:10px 0 10px 0;font-size:26px;">Comics Voting Centre</h3>
			<form name="loginform" id="loginform" action="<?php echo get_option('home'); ?>/wp-login.php" method="post">
				<p style="padding-left:5px!important;text-align:left!important;">
					<label>Username<br />
					<input type="text" name="log" id="user_login" class="input" value="" size="60" />
					</label>

					<label>
					Password<br />
					<input type="password" name="pwd" id="user_pass" class="input" value="" size="60" style="margin:0!important;" />
					<a href="<?php echo get_option('home'); ?>/lostpassword" title="Password Lost and Found">Forget your password?</a>
					</label>
				</p>
				
				<input name="rememberme" type="hidden" id="rememberme" value="forever" />

				<p class="submit">
					<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Log In" style="width:200px;" />
					<input type="hidden" name="redirect_to" value="<?php echo get_option('home'); ?>/register" />
					<input type="hidden" name="testcookie" value="1" />
					<p><a href="<?php echo get_option('home'); ?>/register" title="Register">Not registered? Register here</a></p>
				</p>
			</form>
        </div>

		<img src="/wp-content/themes/scribe/img/02-Login-footer.jpg" alt="">
	</div>
		
	</div></div>
		
<?php wp_footer(); ?>


</body></html>
