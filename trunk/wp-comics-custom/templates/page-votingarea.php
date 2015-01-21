<?php
/*
Template Name: Voting/ Registration
*/

if ( is_user_logged_in() ) {

	global $wpdb;
	
    $uid 				= get_current_user_id();
	$value 				= $wpdb->get_var( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'comedians-uid' AND meta_value=%s LIMIT 1" , $uid) );
	$slug 				= $wpdb->get_var( $wpdb->prepare("SELECT post_name FROM $wpdb->posts WHERE ID = %s LIMIT 1" , $value) );

	if ( $slug )wp_redirect( home_url() . '/wp-comics/' . $slug  );

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

hr {
    background: none repeat scroll 0 0 #ccc;
    clear: both;
    height: 1px;
    margin: 0!important;
    padding:0!important;
    width: 100%!important;
}

.wpcf7-textarea {
    height: 156px;
}

.go-profile .grinfo {
    clear: both;
    color: #61d9a4 !important;
    font-size: 0.75em !important;
    margin-top: -20px;
    position: absolute;
}
span.wpcf7-not-valid-tip {
    color: #ec1f26!important;
    float: right!important;
    font-size: 0.8em!important;
    margin: -90px 30px 0 0!important;
    position: relative!important;
}
.wpcf7-not-valid {
	border: 1px solid #ec1f26!important;
}

div.wpcf7-validation-errors {
    border-color: #ec1f26!important;
}
.wpcf7-checkbox {
	border: 0px solid #ec1f26!important;
}

.checks span.wpcf7-not-valid-tip {
    color: #ec1f26!important;
    float: left!important;
    font-size: 0.8em!important;
    margin: 0!important;
    position: relative!important;
}

.wpcf7-select {
   overflow: hidden!important;
   background: url(/wp-content/themes/scribe/img/down_arrow_select.png) no-repeat right #f9f9f9;
   border: 1px solid #ededed!important;
	appearance:none!important;
	-moz-appearance:none!important; /* Firefox */
	-webkit-appearance:none!important; /* Safari and Chrome */
	overflow: -moz-hidden-unscrollable!important;
	text-indent: 0.01px;
    text-overflow: '';
}

.dropdown-img {
	float: right;
    height: 52px;
    margin: -71px 26px !important;
    position: relative !important;
}
</style>

</head>

<body <?php body_class(); ?>>
	 	
	 <div class="loader"></div>
	 <div id="main">	        
	  	<div class="container"><h4>Comics Voting Center</h4></div>
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
	</div>

   	  <div class="col-md-12">
           <div class="centered">
<?php
global $wp_query;

echo scribe_pagination(); 
?></div>      

      <?php wp_reset_query(); ?>
  </div> 
  
<script type="text/javascript">
	jQuery('.password1 input[type="text"]').attr('type', 'password');
	jQuery('.password2 input[type="text"]').attr('type', 'password');
</script> 
<script type="text/javascript">
jQuery('.wpcf7-textarea').keyup(function () {
    var left = 2000 - jQuery(this).val().length;
    if (left < 0) {
        left = 0;
    }
    jQuery('.counter').text('Characters left: ' + left);
});
</script>
<?php get_footer();?>