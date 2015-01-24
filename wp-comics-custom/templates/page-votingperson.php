<?php
/*
Template Name: Voting/ Profile
*/

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
    
	<?php 
	
    	$meta = get_post_meta( $_GET['p'] ); 
	    print_r($meta);
		
	?>
	
	</div>

   	  <div class="col-md-12">
           <div class="centered">
<?php
global $wp_query;

echo scribe_pagination(); 
?></div>      

      <?php wp_reset_query(); ?>
  </div> 

<?php if(get_post_meta($post->ID, "_sc_meta_value_key", true) ) { ?>

<?php } ?>

</div></div>
		
<?php wp_footer(); ?>

<script>
jQuery(document).ready(function(){
<?php
if(isset($_GET['partner_sort'])) {
?>
  jQuery("#js_sort_items").hide();
  jQuery(".<?php echo $_GET['partner_sort']; ?>_sort_button").trigger("click");
  jQuery(".<?php echo $_GET['partner_sort']; ?>_sort_button").trigger("click");
<?php
}
?> 
});
</script>
<footer id="fill">
 <span class="scroll-wrapper"><a id="back-to-top" class="back-to-top" href="#main"> <i class="icon-arrow-up"></i></a></span>

</footer>
</body></html>
