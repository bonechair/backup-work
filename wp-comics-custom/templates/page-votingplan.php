<?php
/*
Template Name: Voting/ Categories
*/

if ( !is_user_logged_in() ) {

	wp_redirect( home_url() . '/login'  );

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
.left {
  float:left;
}
.right {
  float:right;
}
.voty {
  margin:5px;
  width:auto;
  text-align:right;
}
.voty .place{
  margin: 0 -17px -15px 0;
  position:relative;
}
.voty .names {
    color: #fff;
    font-size: 0.7em;
    margin: -20px 0 0;
    position: relative;
    text-align: center !important;
	text-overflow: ellipsis;
	width:100px;
	font-weight:bold;
}
.cat-row {
  padding-top:10px;
  width:100%;
  height:160px;
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

		<hr style="clear:both;">
		<br />
	<?php
	  $theme 	= get_template_directory_uri();

	  $default 	= '<img src="' . $theme . '/img/default-pic.png">';
 
	  $orange 	= '<img src="' . $theme . '/img/orange.png">';
	  $orange_c = '<img src="' . $theme . '/img/orange-check.png">';
	  
	  $grey	 	= '<img src="' . $theme . '/img/grey.png">';
	  $grey_c 	= '<img src="' . $theme . '/img/grey-check.png">';	

	  $yellow 	= '<img src="' . $theme . '/img/yellow.png">';
	  $yellow_c = '<img src="' . $theme . '/img/yellow-check.png">';		  
	?>

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
	global $wpdb;
	
  foreach ($objects as $row) {
	  
	  $cat = $row->cat_ID;
?>
	<div class="cat-row left">

		<div class="left" style="width:65%;">
		  <h4><a href="<?php echo get_site_url(); ?>/vote?id=<?php echo $cat; ?>"><?php echo $row->name; ?></a></h4> 
		  <p><?php echo $row->description; ?></p>
		</div>
<?php

	  $uid 		= get_current_user_id();
	  $sql = "SELECT comedian FROM wp_votes WHERE voter = $uid AND comedy_id =  $cat AND medallion = 3 LIMIT 1";
	  $post1	= $wpdb->get_var( $sql );
	  $image1 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post1 ), 'thumbnail' );
			
	$yourname 	= get_post_meta( $post1, 'your-name' );
	$surname 	= get_post_meta( $post1, 'sur-name' );
	
		  if(empty($post1)){
			$medallion = $yellow;
		  }
		  else {
			$medallion = $yellow_c;
		  }  
		  if(empty($image1)){
			$image1 = $default;
		  }
		  else {
			$image1 = '<img src="' . $image1[0] . '" width="101" height="101">';
		  }  	  
	  ?>

	<div class="voty right"><div class="place"><?php echo $medallion; ?></a></div><a href="#"><?php echo $image1;?><div class="names"><?php echo $yourname[0]; ?> <?php echo $surname[0] ?></div></div>

	  <?php
	  $sql = "SELECT comedian FROM wp_votes WHERE voter = $uid AND comedy_id = $cat AND medallion = 2 LIMIT 1";
	  $post2	= $wpdb->get_var( $sql );
	  $image2 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post2 ), 'thumbnail' );
	
	$yourname 	= get_post_meta( $post2, 'your-name' );
	$surname 	= get_post_meta( $post2, 'sur-name' );
		  
		  if(empty($post2)){
			$medallion = $grey;
		  }
		  else {
			$medallion = $grey_c;
		  }  
		  if(empty($image2)){
			$image2 = $default;
		  }
		  else {
			$image2 = '<img src="' . $image2[0] . '" width="101" height="101">';
		  }    
	  ?>

	<div class="voty right"><div class="place"><?php echo $medallion; ?></a></div><a href="#"><?php echo $image2;?><div class="names"><?php echo $yourname[0]; ?> <?php echo $surname[0] ?></div></div>

	<?php

	  $sql = "SELECT comedian FROM wp_votes WHERE voter = $uid AND comedy_id = $cat AND medallion = 1 LIMIT 1";
	  $post3	= $wpdb->get_var( $sql );
	  $image3 	= wp_get_attachment_image_src( get_post_thumbnail_id( $post3 ), 'thumbnail' );
	
	$yourname 	= get_post_meta( $post3, 'your-name' );
	$surname 	= get_post_meta( $post3, 'sur-name' );
		  
		  if(empty($post3)){
			$medallion = $orange;
		  }
		  else {
			$medallion = $orange_c;
		  }  
		  if(empty($image3)){
			$image3 = $default;
		  }
		  else {
			$image3 = '<img src="' . $image3[0] . '" width="101" height="101">';
		  }  
?>

	<div class="voty right"><div class="place"><?php echo $medallion; ?></a></div><a href="#"><?php echo $image3;?><div class="names"><?php echo $yourname[0]; ?> <?php echo $surname[0] ?></div></div>

	</div>

<hr style="clear:both;">
	
<?php
}
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
 
<?php get_footer();?>