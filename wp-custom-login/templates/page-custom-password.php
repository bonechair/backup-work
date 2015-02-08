<?php
/*
Template Name: Custom Lost Password
*/

//if ( is_user_logged_in() )wp_redirect( home_url() );

?>
<!DOCTYPE html>
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
	 	
	 <div id="main">	        

		<div class="containerCentered">

		<div style="width:390px;margin:35px auto 25px auto;padding:0px;">
		<h3 style="color:#3886a5;margin:0;padding:10px 0 10px 0;font-size:26px;">Custom Login Centre</h3>
			<form name="loginform" id="loginform" action="<?php echo get_option('home'); ?>/wp-login.php?action=lostpassword" method="post">
				<input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
				<br />
				<h5>Forgot your password?</h5>

				<p style="padding-left:5px!important;">
					<label style="font-size:9pt!important;">Enter your email address<br />
					<input type="text" name="user_login" id="user_forgot" class="input" value="" size="60" />
					</label>
				</p>

				<p class="submit">
					<input type="submit" name="wp-submit" id="wp-submit" class="button-primary" value="Email me a new password" style="width:240px;" />
					<input type="hidden" name="redirect_to" value="<?php echo get_option('home'); ?>/login/" />
				</p>
			</form>
        </div>

	</div>
		
	</div></div>
		
<?php wp_footer(); ?>

	<script type="text/javascript">
	try{document.getElementById('user_forgot').focus();}catch(e){}
	if(typeof wpOnload=='function')wpOnload();
	</script>
</body></html>
