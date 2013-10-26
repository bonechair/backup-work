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
	<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie6.css" />
	<![endif]-->
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie7.css" />
	<![endif]-->
 	<!--[if IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/ie8.css" />
	<![endif]-->
</head>

<body <?php body_class(); ?>>

<div>

<div class="container_12">

<?php
global $post;
$terms = get_the_terms( $post->ID, 'product_cat' );
$emporium = false;

if($terms) {

	foreach ($terms as $term) {
		if($term->name == 'Emporium') {
		  $emporium = true;
		}
	}    
}

if ($emporium) {

if(!$_GET['ajax']){


?>
	<a href="/"><img src="/wp-content/themes/letterpress/img/emporium-header.png" width="960" style="margin:10px 10px -10px 10px" alt="The Letterpress Company"></a>
<?php
}
else {
?>
	<a href="/"><img src="/wp-content/themes/letterpress/img/emporium_view.png" style="margin:10px 10px 20px 10px" alt="The Letterpress Company"></a>
<?php
}

}
else {
?>	
	
	<div class="grid_7" id="Logo">

		<a href="/" title="The Letterpress Company">

			<img src="/wp-content/themes/letterpress/img/letterpresslogo.png" alt="The Letterpress Company">

		</a>

	</div>
<div id="letterpresstext"></div>
<div id="Logoright"></div>
<?php
}
?>	

<?php  if(!$_GET['ajax']) { ?>
    <div class="grid_12" id="Nav" style="margin-bottom:20px; padding-bottom:0px;">

	
<?php if ( !is_user_logged_in() ) {
?>

				<div style="float:right">
				<ul class="sf-menu sf-js-enabled sf-shadow"> 
				<?php /**
				<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_site_url()?>/wp-login.php?action=register&redirect_to">Register Page</a></li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_site_url()?>/wp-login.php?action=register&redirect_to"> | </a></li>
				**/ ?>
				<li class="menu-item menu-item-type-post_type menu-item-object-page"><?php echo wp_loginout(get_site_url())?></li>
				</ul>
				</div>
<?php
} else {  				
?>	
	<div style="float:right">
				<ul class="sf-menu sf-js-enabled sf-shadow"> 
				<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_site_url()?>/my-account/">MY ACCOUNT</a></li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_site_url()?>/my-account/">|</a></li>
				<li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="<?php echo get_site_url()?>/cart/">SHOPPING BASKET</a></li>		

				</ul>
				</div>
<?php
}			
	?>
	<ul class="sf-menu sf-js-enabled sf-shadow"> 

	<li></li>
		<li><a href="/bespoke/" title="BESPOKE">BESPOKE</a></li>
		<li><a href="/bespoke/" title="BESPOKE">|</a></li>
		<li><a href="/product-category/emporium" title="EMPORIUM">EMPORIUM</a></li>
		<li><a href="/product-category/emporium" title="BESPOKE">|</a></li>		
		<li><a href="/customise/" title="CUSTOMISE">CUSTOMISE</a></li>
		<li><a href="/customise/" title="CUSTOMISE">|</a></li>				
		<li><a href="/wholesale" title="WHOLESALE">WHOLESALE</a></li>
		<li><a href="/wholesale" title="WHOLESALE">|</a></li>
		<li><a href="/contact" title="CONTACT">CONTACT</a></li>
		<li><a href="/contact" title="CONTACT">|</a></li>
		<li><a href="/about-us/" title="ABOUT US">ABOUT US</a></li>
		<li><a href="/about-us/" title="ABOUT US">|</a></li>		
		<li><a href="/category/news" title="NEWS FROM OUR BLOG">BLOG</a></li>		
		<li><a href="/category/news" title="NEWS FROM OUR BLOG"> | </a></li>		
	    <li><a href="/faqs/" title="FAQs">FAQs</a></li>

	</ul>
 
   </div>

 	<br class="Clear">
	
 
</div>

<div class="container_12" id="subnav"></div>

<? } ?>
