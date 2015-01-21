<!DOCTYPE html>
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
    background: none repeat scroll 0 0 #2F2F2F;
    height: 200px;
    overflow: hidden;
    padding-bottom: 15px;
    padding-top: 20px;
    position: relative;
    z-index: 1;
}
.vt-header-sub h1{
	color:#61D9A4!important;
	font-size:5.5em!important;
}
.s-header-sub {
    background: none repeat scroll 0 0 #61D9A4;
    height: 85px;
    overflow: hidden;
    padding-bottom: 15px;
    padding-top: 20px;
    position: relative;
    z-index: 1;
}
.s-header-sub h4{
	color:#2F2F2F!important;
	font-size:1.5em!important;
}
.col-md-10 p {
    vertical-align: top!important;
	clear:both;
}
.go-profile {
    vertical-align: text-top;
	float:left;
	margin-right:15px;
}		
.profile-img img {
    display:inline-block;
	width: 100%!important;
}	
.go-profile span {
	color:#61D9A4!important; 
	font-size:0.8em!important;
	clear:both;
}
.wpcf7-textarea {
	width: 100%!important;
	height: 200px!important;
}
.arrow-down {
    margin:0 auto 0 auto;
	width: 0; 
	height: 0; 
	border-left: 20px solid transparent;
	border-right: 20px solid transparent;
	border-top: 20px solid #61D9A4;
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
.wpcf7-text {
	margin:0!important;
}
input.file {
	position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity: 0);
	opacity: 0;
	z-index: 2;
}

hr {
    background: none repeat scroll 0 0 #ccc;
    clear: both;
    height: 1px;
    margin: 0!important;
    padding:0!important;
    width: 100%!important;
}

.grinfo {
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
	float: right!important;
    height: 52px!important;
    margin: -71px 26px !important;
    position: relative !important;
}
</style>

</head>

<body <?php body_class(); ?>>
	 	
	 <div class="loader"></div>
		
	 <div id="main">	

		<div class="containerCentered">
			<div class="top-box"><h4>Comics Voting Center</h4></div> 
			<div class="top-box" style="margin-top:17px;">
			<a href="<?php echo home_url(); ?>" style="color:#61D9A4;">Go Back To Website</a> 
			<a href="<?php echo home_url(); ?>/wp-login.php?action=logout" style="color:#2F2F2F;">Logout</a> 
				<?php /** <a href="<?php echo home_url(); ?>" style="color:#2F2F2F;">Vote</a> 
				<a href="<?php echo home_url(); ?>" style="color:#61D9A4;">My Profile</a>
				 <a href="<?php echo home_url(); ?>" style="color:#2F2F2F;">Help</a> **/ ?>
			</div> 
			<div class="top-box">
				<img src="<?php echo get_template_directory_uri(); ?>/img/02-Login.jpg">
			</div>	
		</div>
		
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); 
			
	$format = get_post_format(); 
	if( false === $format ) 
		$format = 'standard'; ?>
     
	    <section class="vt-header-sub" style="clear:both;">
	        <div class="containerCentered">

				<div class="row"><h1 id="changingtext"><?php the_title(); ?></h1></div>

			</div>
	    </section>
	    <section class="s-header-sub">
	        <div class="containerCentered">
			   	            				
				<div class="row"><h4 id="changingtext">My Profile Page</h4></div>
			
			</div>
	    </section>
		
		<div class="arrow-down"></div>

	 <div class="container box">
	 
   <div class="row">

	<section class="sc-blog-section">
		  
    <div <?php post_class(); ?> id="post-<?php the_ID(); ?>" >  
			<?php
				$meta = get_post_meta( get_the_ID() );
				//print_r($meta);
			?>
			
<?php get_template_part('postformats/format', $format); ?>			
			
			<?php
				the_content();
				$ex = wp_strip_all_tags(get_the_excerpt());
				$ex = str_replace('"', "''", $ex);
			?>
			<script type="text/javascript">

				jQuery(".your-id .wpcf7-text").hide();
				jQuery(".your-id .wpcf7-text").val("<?php echo get_the_ID(); ?>");
				jQuery(".wpcf7-email").val("<?php echo $meta['email'][0];?>");
				jQuery(".wpcf7-twitter").val("<?php echo $meta['twitter'][0];?>");
				jQuery(".wpcf7-facebook").val("<?php echo $meta['facebook'][0];?>");
				jQuery(".wpcf7-instagram").val("<?php echo $meta['instagram'][0];?>");
				jQuery(".wpcf7-social-other").val("<?php echo $meta['social-other'][0];?>");
				jQuery(".biography .wpcf7-textarea").val("<?php  echo $ex; ?>");
				jQuery(".pen-text .wpcf7-textarea").val("<?php  echo $meta['pen-text'][0];; ?>");
				jQuery(".ref1 input").val("<?php  echo $meta['ref1'][0]; ?>");
				jQuery(".ref2 input").val("<?php  echo $meta['ref2'][0]; ?>");
				jQuery(".refcell1 input").val("<?php  echo $meta['refcell1'][0]; ?>");
				jQuery(".refcell2 input").val("<?php  echo $meta['refcell2'][0]; ?>");				
				jQuery(".started select").val("<?php  echo $meta['started'][0]; ?>");
				jQuery(".province select").val("<?php  echo $meta['province'][0]; ?>");
				jQuery(".your-name input").val("<?php  echo $meta['your-name'][0]; ?>");
				jQuery(".sur-name input").val("<?php  echo $meta['sur-name'][0]; ?>");
				jQuery(".wpcf-id-number").val("<?php  echo $meta['id-number'][0]; ?>");
				jQuery(".wpcf-stage-number").val("<?php  echo $meta['stage-number'][0]; ?>");
				jQuery(".wpcf-contact-number").val("<?php  echo $meta['contact-number'][0]; ?>");

				<?php
				if($meta['Pen-Award'][0] == "1") {
				?>
				jQuery('.Pen-Award input[type=checkbox]').prop('checked', true);
				<?php
				}
				?>

				<?php
				  //if($meta['Ext-Image'] && !has_post_thumbnail( $post_id )) {
				?>

				var urlRelative = jQuery('.wp-post-image').attr("src");

				<?php
				  if($meta['Ext-Image'] && !has_post_thumbnail( $post_id )){
				    echo "urlRelative = '" . $meta['Ext-Image'][0] . "';";
				  }
				?>
				jQuery(".wp-post-image").hide();
				jQuery("#profile-photo").attr("src", urlRelative);

			</script>
			
	</div>
                   
      <?php endwhile;?>
 
	   </section>
     <div class="col-md-10 col-md-offset-1"> <br/>
       <?php //previous_post_link(); wp_link_pages();?>
       <div class="pull-right">
         <?php //next_post_link(); ?>
       </div>
       <?php endif; ?>
       <?php //comments_template( '', true ); ?>
     </div>
    </div></div></div>
    
      <?php wp_reset_query(); ?>
  </div> 
<script type="text/javascript">

    var left = 2000 - jQuery('.wpcf7-textarea').val().length;
    if (left < 0) {
        left = 0;
    }
    jQuery('.counter').text('Characters left: ' + left);

	jQuery('.wpcf7-textarea').keyup(function () {
		var left = 2000 - jQuery(this).val().length;
		if (left < 0) {
			left = 0;
		}
		jQuery('.counter').text('Characters left: ' + left);
	});

</script>
<?php get_footer();?>