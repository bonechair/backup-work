<?php
/*
Template Name: Voting/ Voting
*/

if ( !is_user_logged_in() ) {

	wp_redirect( home_url() . '/login' );

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
	position: fixed;
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
</style>

</head>

<body <?php body_class(); ?>>
	 	
	 <div class="loader"></div>
	 <div id="main">	        
		<div class="containerCentered">
			<div class="top-box"><h4>Comics Voting Center</h4></div> 
			<div class="top-box" style="margin-top:17px;">
				<a href="<?php echo home_url(); ?>/vote" style="color:#61D9A4;">Vote</a>
				<a href="<?php echo home_url(); ?>/login" style="color:#2F2F2F;">My Profile</a>
				<a href="<?php echo home_url(); ?>/help" style="color:#2F2F2F;">Help</a>
			</div> 
			<div class="top-box">
				<img src="<?php echo get_template_directory_uri(); ?>/img/02-Login.jpg">
			</div>	
		</div>
		
		
  		<?php if ( has_post_thumbnail() ) { ?>
				<section class="sc-parallax" style="background-image:url(<?php $thumb_id = get_post_thumbnail_id(); $thumb_url = wp_get_attachment_image_src($thumb_id,'thumbnail-size', true); echo $thumb_url[0]; ?>
			);font-size:;" data-stellar-background-ratio="0.5" >
					           <div class="row"><div class="containerCentered">
							<h3></h3></div> <div class="sc-mask"></div>
					            <div class="container">
			<section class="vt-header-sub">
	       
			   	        <div class="containerCentered">
			   	            <div class="row">
			   	<h1 id="changingtext"><?php the_title(); ?></h1>
			   	        </div>
			   	    </section>
					                </div> 
					            </div>
					        </section>
     <?php } else { ?>  
	   
	    <section class="vt-header-sub">
   	        <div class="containerCentered">
   	            <div class="row">
   	<h1 id="changingtext"><?php the_title(); ?></h1>
   	        </div>
   	    </section>
		<?php } ?>

	<div class="container box">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>   	
	<?php the_content(); ?>
    <?php endwhile; ?>
    <?php endif; ?>

<div class="row">
  <div class="col-md-12">
	  
    <div class="aq-template-wrapper aq_row" id="aq-template-wrapper-344">
	<div class="aq-block aq-block-pg_gallery_block col-md-12 col-xs-12 clearfix" id="aq-block-344-1">
	<div class="portfolio-grid pagination-infinite"><div class="portfolio-loader" style="display: none;"><div>
	</div></div><div class="sort_width_container clearfix">

	<div class="ajax-container">
	<div class="ajax-controls"><a class="close-ajax-container" href="#">
	<i class="dashicons dashicons-no"></i></a></div></div>
	<div style="margin: -4px; position: relative; height: 1119.18px; opacity: 1;" data-columns="7" data-post-count="50" data-effect="effect-2" class="portfolio-grid-container isotope" id="portfolio-grid-frame">
		
		<?php 

			$loop = new WP_Query( array( 'orderby' => 'rand', 'post_type' => 'wp-comics', 'posts_per_page' => 25 ) ); 

			while ( $loop->have_posts() ) : $loop->the_post(); 

			$yourname 	= get_post_meta( get_the_ID(), 'your-name' );
			$surname 	= get_post_meta( get_the_ID(), 'sur-name' );
			$my_excerpt = get_the_excerpt();
			$post_id 	= get_the_ID();			

			$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );

			if(file_exists(!$image))continue;

		?>	
 
	<div style="padding: 4px; position: absolute; left: 0px; top: 0px;" class="portfolio-entry portfolio-overlay partners_sort  portfolio-animated" id="entry-<?php echo $post_id; ?>"><div class="portfolio-image project-load portfolio-animate effect-2" data-post-id="<?php echo $post_id; ?>" data-permalink="#" style="animation-delay: 0s;"><img alt="<?php echo $yourname[0]; ?> <?php echo $surname[0] ?>" src="<?php echo $image[0]; ?>" class="entry-image"><div class="img-overlay"><div class="dashicons dashicons-plus"></div></div></div></div>
			
	<?php endwhile; wp_reset_query(); ?>
	
	</div></div></div></div></div></div>

   	  <div class="col-md-12">
           <div class="centered">
<?php
global $wp_query;

echo scribe_pagination(); 
?></div>      

      <?php wp_reset_query(); ?>
  </div> 
  
<script type="text/javascript">

jQuery('.like-button').click(function () {

    jQuery('.like-lightbox').hide();
 
});
</script>  
  
<?php get_footer();?>