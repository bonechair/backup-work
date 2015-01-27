<?php
/*
Template Name: Voting/ Voting
*/

global $wpdb;

if ( !is_user_logged_in() ) {

	wp_redirect( home_url() . '/login' );

}

$uid 	= get_current_user_id();

if (isset($_GET['gold_id']) && isset($_GET['id'])) {

$wpdb->query( "DELETE FROM wp_votes WHERE comedy_id = " . $_GET['id'] . " AND voter = $uid AND medallion = 1" );

	$wpdb->insert( 
		'wp_votes', 
		array( 
			'comedy_id' => $_GET['id'], 
			'voter' => $uid,
			'comedian' => $_GET['gold_id'],
			'medallion' => 1,
		), 
		array( 
			'%d', 
			'%d', 
			'%d', 
			'%d'
		) 
	); 

 wp_redirect( home_url() . '/vote/?success=yes&id=' . $_GET['id'] );
 
}

if (isset($_GET['silver_id']) && isset($_GET['id'])) {

$wpdb->query( "DELETE FROM wp_votes WHERE comedy_id = " . $_GET['id'] . " AND voter = $uid AND medallion = 2" );

	$wpdb->insert( 
		'wp_votes', 
		array( 
			'comedy_id' => $_GET['id'], 
			'voter' => $uid,
			'comedian' => $_GET['silver_id'],
			'medallion' => 2,
		), 
		array( 
			'%d', 
			'%d', 
			'%d', 
			'%d'
		) 
	); 

 wp_redirect( home_url() . '/vote/?success=yes&id=' . $_GET['id'] );
 
}
if (isset($_GET['bronze_id']) && isset($_GET['id'])) {

$wpdb->query( "DELETE FROM wp_votes WHERE comedy_id = " . $_GET['id'] . " AND voter = $uid AND medallion = 3" );

	$wpdb->insert( 
		'wp_votes', 
		array( 
			'comedy_id' => $_GET['id'], 
			'voter' => $uid,
			'comedian' => $_GET['bronze_id'],
			'medallion' => 3,
		), 
		array( 
			'%d', 
			'%d', 
			'%d', 
			'%d'
		) 
	); 

 wp_redirect( home_url() . '/vote/?success=yes&id=' . $_GET['id'] );
 
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

<title><?php wp_title( '|', true, 'right' ); ?>

<?php echo bloginfo( 'name' ); ?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<meta name="viewport" content="width=device-width" />
<link rel="shortcut icon" href="<?php echo get_theme_mod('favicon_image'); ?>">

<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
<?php wp_head(); ?>

	<link rel="stylesheet" href="../wp-content/plugins/wp-comics-custom/wp-comics-custom/css/tabs.css" type="text/css" media="screen, projection">

	<script type="text/javascript" src="../wp-content/plugins/wp-comics-custom/wp-comics-custom/js/jquery-ui.js"></script>
    <script type="text/javascript">
		jQuery(function() {

			var $tabs = jQuery('#tabs').tabs();

			<?php
			if ($_GET['success'] == 'yes') {
			?>
			$tabs.tabs('select', 1);
			<?php
			}
			?>
			
			jQuery('.next-tab, .prev-tab').click(function() { 
					$tabs.tabs('select', jQuery(this).attr("rel"));
					jQuery('#portfolio-grid-frame2 div:first').trigger( "click" );
		           
				   return false;
		       });
       

		});
    </script>

<style>
.vt-header-sub {
    background: none repeat scroll 0 0 #232323;
    height: 180px;
    overflow: hidden;
    padding-bottom: 15px;
    padding-top: 20px;
    position: relative;
    z-index: 1;
}
.vt-header-sub h1{
	color:#61D9A4!important;
}
.top-box {
	width:33%;
	float:left;
	margin:5px 0 0 0;
}
.top-box a {
    font-size: 17px !important;
	margin-right:30px!important;
}
.top-box h4 {
    font-size: 24px !important;
    font-weight: bold;
}

/** LIGHTBOX MARKUP **/

.like-lightbox {
	/** Default lightbox to hidden */
	position:fixed;
	box-shadow: 0px 0px 8px rgba(0,0,0,.3);
	box-sizing: border-box;
	-webkit-transition: .5s ease-in-out;
	-moz-transition: .5s ease-in-out;
	-o-transition: .5s ease-in-out;
	transition: .5s ease-in-out;	
	z-index: 999;
	width: 100%;
	height: 100%;
	text-align: center;
	top: 0;
	left: 0;
	background: #000;
	color:#FFF;
}
.like-lightbox b{
	color:#FFF;
	font-size:1.6em;
}
.like-lightbox p{
	color:#FFF;
	font-size:0.8em;
}
.like-lightbox h1{
	margin:60px 0 0 0;
	color:#65DCA4;
	font-size:3em;
}
.like-lightbox .like-70s{
	width:60%;
	margin:0 auto;
}
.portfolio-image .names {
    color: #fff;
    font-size: 0.65em;
    margin: -15px 0 0;
    position: relative;
    text-align: center !important;
}
.portfolio-entry .place {
    margin: 0 -5px -30px 0;
    position: relative;
    z-index: 47;
}
.thegreensexy {
   background:#60DBA5;
   color:#000;
   width:100%;
   height:70px;
   text-align:center;
   font-size:0.9em;  
   padding:20px 0 0 0;
}
.thegreensexy b {
    font-size: 1em;
    font-weight: bold;
}

.arrow-down {
    margin:0 auto 0 auto;
	width: 0; 
	height: 0; 
	border-left: 15px solid transparent;
	border-right: 15px solid transparent;
	border-top: 15px solid #61D9A4;
}
</style>

</head>

<body <?php body_class(); ?>>
	 	
	 <div class="loader"></div>
	 	
	 <div id="main">	        

<div class="like-lightbox">
<div class="like-70s">

<br><Br>
		
</div>
</div> 
<script type="text/javascript">

	jQuery('.like-button').click(function () {

		jQuery('#welcome').hide();
	 
	});

</script>  


<br><br>
		<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="tabs">

    		<ul class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
        		<li class="ui-corner-top ui-state-focus ui-tabs-selected ui-state-active"><a href="#fragment-1">&#8226;</a></li>
        		<li class="ui-corner-top ui-state-default"><a href="#fragment-2">&#8226;</a></li>
        		<li class="ui-corner-top ui-state-default"><a href="#fragment-3">&#8226;</a></li>
        		<li class="ui-corner-top ui-state-default"><a href="#fragment-4">&#8226;</a></li>
    	   </ul>
	
        	<div id="fragment-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
        	<a href="#" class="next-tab mover" rel="2">Next »</a>			
        	      
				 <p>
				<div id="welcome">
					<h3>Welcome To The Comics Voting Centre</h3>
						<b>The rules are:</b>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus suscipit quam quam, ut commodo urna euismod ac. Integer non massa ac risus lobortis posuere. In mattis facilisis libero dignissim consequat. Suspendisse ac justo dui. Maecenas dolor enim, lobortis nec tempor non, ullamcorper ut eros. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean consequat sagittis arcu vitae iaculis..

					<input class="wpcf7-form-control wpcf7-submit like-button" type="submit" value="Okay got it" />
				</div>
				</p>
			 </div> 
   	
        	<div id="fragment-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
            <a href="#" class="next-tab mover" rel="3">Next »</a><a href="#" class="prev-tab mover" rel="1">« Previous</a>                   
				   
	<p>
	<div class="row">
	
			
		<div class="thegreensexy">
			<img src="/wp-content/themes/scribe/img/green-check.png">You have <b>cast all your votes</b> for this category
		</div>
			
		<div class="arrow-down"></div>
		<br /><br />
		
	<div class="col-md-12">
	  
    <div class="aq-template-wrapper aq_row" id="aq-template-wrapper-344">
	<div class="aq-block aq-block-pg_gallery_block col-md-12 col-xs-12 clearfix" id="aq-block-344-1">
	<div class="portfolio-grid pagination-infinite"><div class="portfolio-loader" style="display: none;"><div>
	</div></div><div class="sort_width_container clearfix">

	<div class="ajax-container">
	<div class="ajax-controls"><a class="close-ajax-container" href="#">
	<i class="dashicons dashicons-no"></i></a></div></div>
	<div style="margin: -4px; position: relative; height: 1119.18px; opacity: 1;" data-columns="7" data-post-count="50" data-effect="effect-2" class="portfolio-grid-container isotope" id="portfolio-grid-frame1">
		
	<?php 

		//$loop = new WP_Query( array( 'orderby' => 'rand', 'post_type' => 'wp-comics', 'posts_per_page' => 25 ) ); 
		$loop = new WP_Query( array( 'post_type' => 'wp-comics', 'posts_per_page' => 25 ) ); 

		while ( $loop->have_posts() ) : $loop->the_post(); 

			$yourname 	= get_post_meta( get_the_ID(), 'your-name' );
			$surname 	= get_post_meta( get_the_ID(), 'sur-name' );
			$my_excerpt = get_the_excerpt();
			$post_id 	= get_the_ID();			
			$theme 		= get_template_directory_uri();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'medium' );
			$image = $image[0];
			if(empty($image)) {
				continue;
				$image 	= $theme . '/img/default-pic.png';
			}
		
		$place = '';	
			
			$sql 	= "SELECT medallion FROM wp_votes WHERE voter = " . $uid . " AND comedy_id = " . $_GET['id'] . " AND comedian = " . $post_id . "  LIMIT 1";
			$medal	= $wpdb->get_var( $sql );
			if ($medal == 1) {
			   $place = '<img src="' . $theme . '/img/yellow-check.png" class="place">';
			}
			else if ($medal == 2) {
			   $place = '<img src="' . $theme . '/img/grey-check.png" class="place">';
			}
			else if ($medal == 3) {
			   $place = '<img src="' . $theme . '/img/orange-check.png" class="place">';
			}
	?>	
 
	<div style="padding: 4px; float:left;" class="portfolio-entry portfolio-overlay partners_sort  portfolio-animated" id="entry-<?php echo $post_id; ?>"><?php echo $place; ?><div class="portfolio-image project-load portfolio-animate effect-2" data-post-id="<?php echo $post_id; ?>" data-permalink="#" style="animation-delay: 0s;"><img alt="<?php echo $yourname[0]; ?> <?php echo $surname[0] ?>" src="<?php echo $image; ?>" class="entry-image"><div class="names"><?php echo $yourname[0]; ?> <?php echo $surname[0] ?></div><div class="img-overlay" <?php echo $overdisplay;?>><div class="dashicons dashicons-plus"></div></div></div></div>
			
	<?php endwhile; wp_reset_query(); ?>
	
	</div></div></div></div></div></div></div>
	</p>
	
	</div>

<div id="fragment-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
<a href="#" class="next-tab mover" rel="4">Next »</a><a href="#" class="prev-tab mover" rel="2">« Previous</a>
<p>
<div class="row">
  <div class="col-md-12">
	  
    <div class="aq-template-wrapper aq_row">
	<div class="aq-block aq-block-pg_gallery_block col-md-12 col-xs-12 clearfix">
	<div class="portfolio-grid pagination-infinite"><div class="portfolio-loader" style="display: none;"><div>
	</div></div><div class="sort_width_container clearfix">

	<div class="ajax-container">
	<div class="ajax-controls"><a class="close-ajax-container" href="#">
	<i class="dashicons dashicons-no"></i></a></div></div>
	<div style="margin: -4px; position: relative; height: 1119.18px; opacity: 1;" data-columns="7" data-post-count="50" data-effect="effect-2" class="portfolio-grid-container isotope" id="portfolio-grid-frame2">
		
	<?php 

		//$loop = new WP_Query( array( 'orderby' => 'rand', 'post_type' => 'wp-comics', 'posts_per_page' => 25 ) ); 
		$loop = new WP_Query( array( 'post_type' => 'wp-comics', 'posts_per_page' => 25 ) ); 

		while ( $loop->have_posts() ) : $loop->the_post(); 

			$yourname 	= get_post_meta( get_the_ID(), 'your-name' );
			$surname 	= get_post_meta( get_the_ID(), 'sur-name' );
			$my_excerpt = get_the_excerpt();
			$post_id 	= get_the_ID();			
			$theme 		= get_template_directory_uri();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'medium' );
			$image = $image[0];
			if(empty($image)) {
				continue;
				$image 	= $theme . '/img/default-pic.png';
			}
		
		$place = '';	
		$overdisplay = '';
		
			$sql 	= "SELECT medallion FROM wp_votes WHERE voter = " . $uid . " AND comedy_id = " . $_GET['id'] . " AND comedian = " . $post_id . "  LIMIT 1";
			$medal	= $wpdb->get_var( $sql );
			if ($medal == 1) {
			   $place = '<img src="http://localhost/wordpress/wp-content/themes/scribe/img/yellow-check.png" class="place">';
			   $overdisplay = ' style="background-color:yellow;opacity:0.3;"';			
			   $names = ' style="z-index:1001;background-color:#000;opacity:0.9;"';				
			}
			else if ($medal == 2) {
			   $place = '<img src="http://localhost/wordpress/wp-content/themes/scribe/img/grey-check.png" class="place">';
			   $overdisplay = ' style="background-color:grey;opacity:0.3;"';
			   $names = ' style="z-index:1001;background-color:#000;opacity:0.9;"';	
			}
			else if ($medal == 3) {
			   $place = '<img src="http://localhost/wordpress/wp-content/themes/scribe/img/orange-check.png" class="place">';
			   $overdisplay = ' style="background-color:orange;opacity:0.3;"';
			   $names = ' style="z-index:1001;background-color:#000;opacity:0.9;"';			   
			}
			else {
				$overdisplay = ' style="background-color:#000;opacity:0.8;"';
			    $names = ' style="background-color:#000;opacity:0.4;"';
			}
	?>	
 
	<div style="padding: 4px; float:left;" class="portfolio-entry portfolio-overlay partners_sort  portfolio-animated" id="entry-<?php echo $post_id; ?>"><?php echo $place; ?><div class="portfolio-image project-load portfolio-animate effect-2" data-post-id="<?php echo $post_id; ?>" data-permalink="#" style="animation-delay: 0s;"><img alt="<?php echo $yourname[0]; ?> <?php echo $surname[0] ?>" src="<?php echo $image; ?>" class="entry-image"><div class="names" <?php echo $names; ?>><?php echo $yourname[0]; ?> <?php echo $surname[0] ?></div><div class="img-overlay" <?php echo $overdisplay;?>><div class="dashicons dashicons-plus"></div></div></div></div>
			
	<?php endwhile; wp_reset_query(); ?>
	
	</div></div></div></div></div></div></div>	
</p>	

</div>

	<div id="fragment-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
	<a href="#" class="prev-tab mover" rel="3">Previous »</a>			
		  
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus suscipit quam quam, ut commodo urna euismod ac. Integer non massa ac risus lobortis posuere. In mattis facilisis libero dignissim consequat. Suspendisse ac justo dui. Maecenas dolor enim, lobortis nec tempor non, ullamcorper ut eros. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean consequat sagittis arcu vitae iaculis..</p>
	 
	 </div> 

        </div>

				
<?php get_footer();?>