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
    margin: -15px 0 0 -20px;
    position: absolute;
    z-index: 47;
}
.portfolio-entry {
    padding: 4px;
	float:left!important;
	width:135px!important
	min-width:135px!important
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
.ui-tabs { 
	z-index:1000;
}
.ui-tabs .ui-tabs-nav { 
	margin:10px auto;
	list-style: none; 
	position: relative; 
	padding: 2px 2px 0; 
	overflow: hidden; 
	top: 1px; 
	z-index: 1000; 
	height: 25px; 
	width:150px;
}
.ui-tabs .ui-tabs-nav li { 
	position: relative; 
	float: left; 
	border-bottom-width: 0 !important; 
	margin: 0 2px -1px 0; 
}
.ui-tabs .ui-tabs-nav li a { 
	color:#444; 
    float: left;
    font-size: 40px;
    padding: 5px 5px;
    text-decoration: none; 
}
.ui-tabs-selected a { 
	color: white!important; 
}
.ui-tabs .ui-tabs-panel { 
	display: block; 
	border-width: 0; 
	background: none; 
	z-index:1000;
	border: 1px solid #000; 
	position: relative; 
	min-height: 200px; 
	height: auto !important; 
	height: 200px; 
}
a.mover { 
	padding: 6px 12px; 
	position: absolute;
	color: white; 
	font-weight: bold; 
	text-decoration: none; 
}
.exit { 
	margin:-20px auto -20px auto;
	position: relative; 
	z-index: 1000; 
	height: 35px; 
	width:160px;
}
.exit a{ 
	margin:0 0 0 30px;
}
.next-tab { 
	top: -35px; 
	right: 0; 
}
.prev-tab { 
	top: -35px;
	left: 0; 
 }
 h3, b {
	color:#FFF;
 }
#welcome { 
	margin:10px auto;
	position: relative; 
	z-index: 1000; 
	height:auto; 
	width:900px;
	text-align:center;	
}
.votingbar {
	display:block!important;
}
.ajax-controls {
    top:5px!important;
}
.ajax_project {
    margin-top: 0!important;
}
</style>

</head>

<body <?php body_class(); ?>>
	 	
	<div class="loader"></div>
	
	<div id="main" style="background:#000;">
	
	<br>

		<div class="ui-tabs ui-widget ui-widget-content ui-corner-all" id="tabs">
	<div class="exit"><a href="/voters-categories" class="mover">Exit</a></div>	
		
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
<a href="#" class="next-tab mover" id="f1" rel="4" style="display:none;">Next »</a>
<a href="#" class="next-tab mover" id="f2" rel="3">Next »</a>
<a href="#" class="prev-tab mover" id="f3" rel="2" style="display:none;">« Previous</a>                   
<a href="#" class="prev-tab mover" id="f4" rel="1">« Previous</a>                   
				   
	<p>
	<div class="row">
	
		<div class="thegreensexy">
			<img src="/wp-content/themes/scribe/img/green-check.png">You have <b id="nvotes">2 votes</b> left for this category
		</div>
			
		<div class="arrow-down"></div>
		<br /><br />
		
	<div style="margin:0 auto;width:900px;position:relative;">
	  
    <div class="aq-template-wrapper aq_row" id="aq-template-wrapper-344">
	<div class="" id="aq-block-344-1">
	<div class="portfolio-grid pagination-infinite"><div class="portfolio-loader" style="display: none;"><div>
	</div></div><div class="sort_width_container clearfix">

	<div class="ajax-container">
	<div class="ajax-controls"><a class="close-ajax-container" href="#">
	<i class="dashicons dashicons-no"></i></a></div></div>
	<div style="margin: -4px; position: relative; height: 1119.18px; opacity: 1;" data-columns="7" data-post-count="50" data-effect="effect-2" class="portfolio-grid-container isotope" id="portfolio-grid-frame1">
		
	<?php 
	
		//$loop = new WP_Query( array( 'orderby' => 'rand', 'post_type' => 'wp-comics', 'posts_per_page' => -1 ) ); 

		$loop = new WP_Query( array( 
			'tax_query' => array(
				array(
					'taxonomy' => 'comic-category',
					'field'    => 'id',
					'terms'    => $_GET['id']
					), 
			'orderby' => 'rand', 
			'post_type' => 'wp-comics', 
			'posts_per_page' => -1 
		) 
		)); 

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
			
			$display = '';
			if ($medal == 1) {
			   $place = '<img src="' . $theme . '/img/yellow-check.png" class="place">';
			   $overdisplay = ' style="background-color:yellow;opacity:0.3;"';			   
			}
			else if ($medal == 2) {
			   $place = '<img src="' . $theme . '/img/grey-check.png" class="place">';
			   $overdisplay = ' style="background-color:grey;opacity:0.3;"';			   
			}
			else if ($medal == 3) {
			   $place = '<img src="' . $theme . '/img/orange-check.png" class="place">';
			   $overdisplay = ' style="background-color:orange;opacity:0.3;"';			   
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
	<a href="#" class="prev-tab mover" rel="3">« Previous</a>			
		<div class="thegreensexy">
			<img src="/wp-content/themes/scribe/img/green-check.png">You have <b>cast all your votes</b> for this category
		</div>
			
		<div class="arrow-down"></div>
		<br /><br />		  
		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus suscipit quam quam, ut commodo urna euismod ac. Integer non massa ac risus lobortis posuere. In mattis facilisis libero dignissim consequat. Suspendisse ac justo dui. Maecenas dolor enim, lobortis nec tempor non, ullamcorper ut eros. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean consequat sagittis arcu vitae iaculis..</p>
	 
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

    <script type="text/javascript">
		jQuery(function() {
		
			jQuery('.ui-tabs-panel').hide();
			jQuery('.ui-tabs-nav').hide();
			jQuery('.exit').hide();
			
			jQuery('.like-button').click(function () {

		        jQuery('.ui-tabs-panel').hide();
		        jQuery('.ui-corner-top a').css('color', '#444');
				jQuery('#t-2').css('color', '#fff');
			 	jQuery('.ui-tabs-nav').show();
				jQuery('.exit').show();

					 jQuery(".close-ajax-container").trigger('click');
					 jQuery('.portfolio-entry').hide();	
				     jQuery('#fragment-2').fadeIn('slow');	
					 jQuery(".img1:first").trigger('click');
				   	 jQuery('.portfolio-entry').show();	
					 
				     jQuery('.blackops').css('background', '');			   	   
				     jQuery('.blackops').css('opacity', '');						 
			});
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
			jQuery('.ui-corner-top a').click(function() { 
		           jQuery('.ui-tabs-panel').hide();
		           jQuery('.ui-corner-top a').css('color', '#444');
				   jQuery('#t-' + jQuery(this).attr("rel")).css('color', '#fff');
				   
				   var s = jQuery(this).attr("rel");
				   if(s == 1) {
				     jQuery('#fragment-1').fadeIn('slow');		 
				   }				   					   
				   if(s == 2) {
					 jQuery(".close-ajax-container").trigger('click');
					 jQuery('.portfolio-entry').hide();	
				     jQuery('#fragment-2').fadeIn('slow');	
					 jQuery(".img1:first").trigger('click');
				   	 jQuery('.portfolio-entry').show();	
				     jQuery('.blackops').css('background', '');			   	   
				     jQuery('.blackops').css('opacity', '');	
				   	 jQuery('#f1').hide();						 
				     jQuery('#f2').show();	
				     jQuery('#f3').hide();						 
				     jQuery('#f4').show();						 
				   }
				   if(s == 3) {
				 	 jQuery(".close-ajax-container").trigger('click');
				     jQuery('#f2').hide();						 
				     jQuery('#f1').show();
				     jQuery('#f3').hide();						 
				     jQuery('#f4').show();					 
				     jQuery('#fragment-2').fadeIn('slow');		   
				     jQuery('.blackops').css('background', '#000');			   	   
				     jQuery('.blackops').css('opacity', 0.8);			   				 
				   }
				   if(s == 4) {
				     jQuery('#fragment-4').fadeIn('slow');			   
				   }				   

	
				   if( s != 1) {
				     jQuery('.ui-tabs-nav').show();
				     jQuery('.exit').show();
				   }
				   else {
				     jQuery('.ui-tabs-nav').hide();
				     jQuery('.exit').hide();
				   }
				   return false;
		       });			
			   
			jQuery('.next-tab, .prev-tab').click(function() { 
		           jQuery('.ui-tabs-panel').hide();
		           jQuery('.ui-corner-top a').css('color', '#444');
				   jQuery('#t-' + jQuery(this).attr("rel")).css('color', '#fff');
				     
				   var s = jQuery(this).attr("rel");
				   if(s == 1) {
				     jQuery('#fragment-1').fadeIn('slow');					 
				   }				   					   
				   if(s == 2) {
					 jQuery(".close-ajax-container").trigger('click');
					 jQuery('.portfolio-entry').hide();	
				     jQuery('#fragment-2').fadeIn('slow');	
					 jQuery(".img1:first").trigger('click');
				   	 jQuery('.portfolio-entry').show();		
				     jQuery('.blackops').css('background', '');			   	   
				     jQuery('.blackops').css('opacity', '');
				   	 jQuery('#f1').hide();						 
				     jQuery('#f2').show();	
				     jQuery('#f3').hide();						 
				     jQuery('#f4').show();						 
				   }
				   if(s == 3) {
				   
				   	 jQuery(".close-ajax-container").trigger('click');
				   	 jQuery('#f2').hide();						 
				     jQuery('#f1').show();	
					 jQuery('#f4').hide();						 
				     jQuery('#f3').show();	
				     jQuery('#fragment-2').fadeIn('slow');			   	   
				     jQuery('.blackops').css('background', '#000');			   	   
				     jQuery('.blackops').css('opacity', 0.8);			   	   
				   }			   
				   if(s == 4) {
				     jQuery('#fragment-4').fadeIn('slow');			   
				   }	
				   if( s != 1) {
				     jQuery('.ui-tabs-nav').show();
				     jQuery('.exit').show();
				   }
				   else {
				     jQuery('.ui-tabs-nav').hide();
				     jQuery('.exit').hide();
				   }
				   return false;
		       });
       
			var numItems = jQuery('#fragment-2 .place').length;
			numItems = 3 - numItems;
		
			if(numItems == 2){
				jQuery('#nvotes').html('1 vote');
			}else {
				jQuery('#nvotes').html(numItems + ' votes');
			}
			
			
			
		});
    </script>

</body></html>
		
