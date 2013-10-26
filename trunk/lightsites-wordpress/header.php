<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->

	<?php wp_head(); ?>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-24566598-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>

<body <?php body_class(); ?>>


      <div id='header'>
		  <div id='header-container'>
			<div id='site-title'><a href="/"><img src="/wp-content/themes/lightsites-wordpress/img/logo.png" alt="Lightsites" /></a></div>
			<div id='site-subtitle'></div>
			<div id='navigation'>
					<span class="separator"> | </span>	<div <?php if (is_front_page()) echo 'class="selected"'; ?>><a href="/">Home</a></div>
					<span class="separator"> | </span>	<div <?php if (is_category( 'services' )) echo 'class="selected"'; ?>><a href="/capetown-phpdeveloper/services">Services</a></div>
					<span class="separator"> | </span>	<div <?php if (is_category( 'cape-town-wordpress' )) echo 'class="selected"'; ?>><a href="/capetown-phpdeveloper/cape-town-wordpress" style="width:135px;">Wordpress</a></div>
					<span class="separator"> | </span>	<div <?php if (is_category( 'cape-town-web-design' )) echo 'class="selected"'; ?>><a href="/capetown-phpdeveloper/cape-town-web-design" style="width:100px;">Web Design</a></div>
					<span class="separator"> | </span>	<div <?php if (is_category( 'cape-town-seo-developer' )) echo 'class="selected"'; ?>><a href="/capetown-phpdeveloper/cape-town-seo-developer" style="width:130px;">SEO Developer</a></div>
					<span class="separator"> | </span>	<div <?php if (is_category( 'cape-town-ecommerce-websites' )) echo 'class="selected"'; ?>><a href="/capetown-phpdeveloper/cape-town-ecommerce-websites"  style="width:120px;">E-Commerce</a></div>
					<span class="separator"> | </span>	<div <?php if (is_category( 'lightsites-blog' )) echo 'class="selected"'; ?>><a href="/capetown-phpdeveloper/lightsites-blog/" style="width:120px;">Blog</a></div>
				    <span class="separator"> | </span>	<div <?php if (is_page( 'contact-us' )) echo 'class="selected"'; ?>><a href="/contact-us">Contact</a></div>
			</div>
		  </div>
      </div>

		<div class="clear">&nbsp;</div>	
				
	<div id="container">
		
	<div id="main">