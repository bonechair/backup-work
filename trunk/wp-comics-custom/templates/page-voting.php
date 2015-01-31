<?php
/*
Template Name: Voting/ Voting
*/

global $wpdb;

if ( !is_user_logged_in() ) {

	wp_redirect( home_url() . '/login' );

}
if ( empty($_GET['id']) ) {

	wp_redirect( home_url() . '/voters-categories' );

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
 
<link rel="stylesheet" type="text/css" href="<?php echo plugins_url( 'wp-comics-custom/wp-comics-custom/css/voting-page.css' ); ?>">

</head>

<body <?php body_class(); ?>>
	 	
	<div class="loader"></div>
	
	<div id="main" style="background:#000;">
	
	<br>

		<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="tabs">
	<div class="exit"><a href="/voters-categories" class="mover"><img src="/wp-content/themes/scribe/img/exit.png"></a></div>	
		
			<ul class="ui-tabs-nav">
        		<li class="ui-corner-top"><a id="t-1" rel="1" href="#fragment-1">&#8226;</a></li>
        		<li class="ui-corner-top"><a id="t-2" rel="2" href="#fragment-2">&#8226;</a></li>
        		<li class="ui-corner-top"><a id="t-3" rel="3" href="#fragment-3">&#8226;</a></li>
        		<li class="ui-corner-top"><a id="t-4" rel="4" href="#fragment-4">&#8226;</a></li>
    	   </ul>
	
        	<div id="fragment-1" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">

				<div id="welcome">
					<h3>Welcome To The Comics Voting Centre</h3>
						<b>The rules are:</b>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus suscipit quam quam, ut commodo urna euismod ac. Integer non massa ac risus lobortis posuere. In mattis facilisis libero dignissim consequat. Suspendisse ac justo dui. Maecenas dolor enim, lobortis nec tempor non, ullamcorper ut eros. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean consequat sagittis arcu vitae iaculis..
					<br />
					<input class="wpcf7-form-control wpcf7-submit like-button" type="submit" value="Okay got it" />
				</div>

			 </div> 
   	
<div id="fragment-2" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
<div class="paginat">
<a href="#" class="next-tab mover" id="f1" rel="4" style="display:none;">Next <img src="/wp-content/themes/scribe/img/next.png" class="nextimg"></a>
<a href="#" class="next-tab mover" id="f2" rel="3">Next <img src="/wp-content/themes/scribe/img/next.png" class="nextimg"> </a>
<a href="#" class="prev-tab mover" id="f3" rel="2" style="display:none;"><img src="/wp-content/themes/scribe/img/previous.png" class="previmg">  Previous</a>                   
<a href="#" class="prev-tab mover" id="f4" rel="1"><img src="/wp-content/themes/scribe/img/previous.png" class="previmg">  Previous</a>                   
</div>				   
	<p>
	<div class="row">
	
		<div class="thegreensexy">
			<img src="/wp-content/themes/scribe/img/green-check.png">You have <b id="nvotes">2 votes</b> left for this category <span id="nvotes2"></span>
		</div>
			
		<div class="arrow-down"></div>
		
	<div class="voting-section">
	  
<?php

	function get_categories_ids( $args = '' ) {
	        $defaults = array( 'taxonomy' => 'comic-category' );
	        $args = wp_parse_args( $args, $defaults );
	
	        $taxonomy = $args['taxonomy'];

	        $taxonomy = apply_filters( 'get_categories_taxonomy', $taxonomy, $args );
	
	        if ( isset($args['type']) && 'link' == $args['type'] ) {
	                _deprecated_argument( __FUNCTION__, '3.0', '' );
	                $taxonomy = $args['taxonomy'] = 'link_category';
	        }
	
	        $categories = (array) get_terms( $taxonomy, $args );
	
	        foreach ( array_keys( $categories ) as $k )
	                _make_cat_compat( $categories[$k] );
	
	        return $categories;
	}
  $objects = get_categories_ids();
	
  foreach ($objects as $row) {

  $cat = $row->cat_ID;
  if($cat != $_GET['id'])continue;
?>
	<h2><?php echo $row->name; ?></h2>
	<p><?php echo $row->description; ?></p>
	<br />
<?php
}
?>	  
    <div class="aq-template-wrapper aq_row" id="aq-template-wrapper-344">
	<div class="" id="aq-block-344-1">
	<div class="portfolio-grid pagination-infinite"><div class="portfolio-loader" style="display: none;"><div>
	</div></div><div class="sort_width_container clearfix">

	<div class="ajax-container">
	<div class="ajax-controls"><a class="close-ajax-container" href="#">
	<i class="dashicons dashicons-no"></i></a></div></div>
	
	<?php 
	
		//$loop = new WP_Query( array( 'orderby' => 'rand', 'post_type' => 'wp-comics', 'posts_per_page' => -1 ) ); 

		$loop = new WP_Query( array( 
			'orderby' => 'rand', 
			'post_type' => 'wp-comics', 
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'comic-category',
					'field'    => 'id',
					'terms'    => $_GET['id']
					), 
		) 
		)); 
		?>
		
		<div style="margin: -4px; position: relative; height: auto; opacity: 1;"  data-post-count='1000' data-columns='5' data-effect="effect-2" class="portfolio-grid-container isotope" id="portfolio-grid-frame1">
		
		<?php
		while ( $loop->have_posts() ) : $loop->the_post(); 

			$yourname 	= get_post_meta( get_the_ID(), 'your-name' );
			$surname 	= get_post_meta( get_the_ID(), 'sur-name' );
			$my_excerpt = get_the_excerpt();
			$post_id 	= get_the_ID();			
			$theme 		= get_template_directory_uri();
			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );

			$image = $image[0];
			if(empty($image)) {
				continue;
				$image 	= $theme . '/img/default-pic.png';
			}
		
		$place = '';	
			$overdisplay = '';
			$sql 	= "SELECT medallion FROM wp_votes WHERE voter = " . $uid . " AND comedy_id = " . $_GET['id'] . " AND comedian = " . $post_id . "  LIMIT 1";
			$medal	= $wpdb->get_var( $sql );
			
			$display = '';
			if ($medal == 1) {
			   //$place = '<img src="' . $theme . '/img/yellow-check.png" class="place">';
			   $place = '<span class="checkmark gold"><div class="circle2"></div><div class="circle" style="border:15px solid #F7DA00;"></div> <div class="stem"></div> <div class="kick"></div></span>';
			   $overdisplay = ' style="background-color:yellow;opacity:0.7;"';			   
			}
			else if ($medal == 2) {
			   //$place = '<img src="' . $theme . '/img/grey-check.png" class="place">';
			   $place = '<span class="checkmark silver"><div class="circle2"></div><div class="circle" style="border:15px solid #B5C2CB;"></div> <div class="stem"></div> <div class="kick"></div></span>';
			   $overdisplay = ' style="background-color:grey;opacity:0.7;"';			   
			}
			else if ($medal == 3) {
			   //$place = '<img src="' . $theme . '/img/orange-check.png" class="place">';
			   $place = '<span class="checkmark bronze"><div class="circle2"></div><div class="circle" style="border:15px solid #CA633A;"></div> <div class="stem"></div> <div class="kick"></div></span>';
			   $overdisplay = ' style="background-color:orange;opacity:0.7;"';			   
			}
			else {
			   $display = 'blackops';
			}
	?>	
 
	<div class="portfolio-entry portfolio-overlay partners_sort portfolio-animated" id="entry-<?php echo $post_id; ?>"><?php echo $place; ?><div class="portfolio-image project-load portfolio-animate effect-2" data-post-id="<?php echo $post_id; ?>" data-permalink="#" style="animation-delay: 0s;"><img alt="<?php echo $yourname[0]; ?> <?php echo $surname[0] ?>" src="<?php echo $image; ?>" class="entry-image img1"><div class="names"><?php echo $yourname[0]; ?> <?php echo $surname[0] ?></div><div class="img-overlay <?php echo $display;?>" <?php echo $overdisplay;?>><div class="dashicons dashicons-plus"></div></div></div></div>


	<?php endwhile; wp_reset_query(); ?>
	
	</div></div></div></div></div></div></div>
	</p>
	
</div>

<div id="fragment-3" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">

</div>

	<div id="fragment-4" class="ui-tabs-panel ui-widget-content ui-corner-bottom ui-tabs-hide">
	
	<div class="paginat">
		<a href="#" class="prev-tab mover" rel="3"><img src="/wp-content/themes/scribe/img/previous.png" class="previmg"> Previous</a>			
	</div>
	
	<div class="thegreensexy">
			<img src="/wp-content/themes/scribe/img/green-check.png">You have <b>cast all your votes</b> for this category
		</div>
			
		<div class="arrow-down"></div>
		<br /><br />
		<div id="votedform">
		<p><?php echo do_shortcode( '[contact-form-7 id="1755" title="Voted"]' ); ?></p>
	 	</div>
		
	
	 </div> 

        </div>


		
		
</div></div>
		
<footer id="fill" style="background:#000;">

	<?php
	$f_columns = get_theme_mod('footer_columns');

	if ($f_columns == '4') {
	    $footer_widget_wrapper = 'sc_foot4';
	}

	elseif ($f_columns == '3') {
	    $footer_widget_wrapper = 'sc_foot3';
	}
	elseif ($f_columns == '2') {
	    $footer_widget_wrapper = 'sc_foot2';
	}
	 else {
	    $footer_widget_wrapper = 'sc_foot1';
	}
	
	?>
	
  </div>
  

</div> <span class="scroll-wrapper"><a id="back-to-top" class="back-to-top" href="#main"> <i class="icon-arrow-up"></i></a></span>

</footer>
		
<?php wp_footer(); ?>
<script type="text/javascript" src="<?php echo plugins_url( 'wp-comics-custom/wp-comics-custom/js/voting-page.js' ); ?>"></script>
<script type="text/javascript">
jQuery(function() {
		
<?php
if ($_GET['success'] == 'yes') {
?>
	jQuery('.ui-corner-top a').css('color', '#444');
	jQuery('#t-2').css('color', '#fff');
	jQuery('#fragment-2').fadeIn('slow');
	jQuery('.ui-tabs-nav').show();
	jQuery('.exit').show();
<?php
}
else {
?>
	jQuery('.ui-corner-top a').css('color', '#444');
	jQuery('#t-1').css('color', '#fff');
	jQuery('#fragment-1').fadeIn('slow');			
<?php
}
?>
});
</script>
</body></html>
		
