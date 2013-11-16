<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>  <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-24566598-1']);
_gaq.push(['_trackPageview']);
(function() {
var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

	<?php if(is_front_page() && of_get_option('home_title')): ?>
	<title><?php echo of_get_option('home_title'); ?></title>
	<?php else: ?>
	<title><?php bloginfo('name'); ?> <?php wp_title(' - ', true, 'left'); ?></title>
	<?php endif; ?>

	<meta name="viewport" content="width=device-width">
	<?php if(of_get_option('favicon')): ?>
	<link href="<?php echo of_get_option('favicon'); ?>" rel="shortcut icon" /> 
	<?php endif; ?>

	<script src="http://maps.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
	
	<?php wp_head(); ?>

	<?php echo '<style type="text/css">'; ?>
		nav {padding-top:<?php echo of_get_option('navigation_padding', '18px'); ?>; }
	.lt-ie8 #logo img, .lt-ie8 #logo {max-width:<?php echo of_get_option('logo_width', '144px'); ?>;}	
	<?php if(of_get_option('retina_logo', 'no') == 'yes'): ?>body #logo img {max-width:100%; height: auto;} .lt-ie9 body #logo {max-width:100%; }<?php endif; ?>
	<?php if(of_get_option('right_sidebar', 'no') == 'yes'): ?>#container-sidebar {float:left;} #sidebar { float:right;}<?php endif; ?>
	<?php if(of_get_option('custom_css')): ?><?php echo of_get_option('custom_css'); ?><?php endif; ?>
	nav, h1, h2, footer h3, footer h4, footer h5, footer h6 {font-family: '<?php echo of_get_option('navigation_font', 'PT Sans'); ?>', sans-serif; }
	input.submit, input.submit-advanced, .featured-price, h3, h4, h5, h6, .listings-address-widget, .page-count, .pagination, .button, .property-information-address, .property-information-price, #child-pages li a {font-family: '<?php echo of_get_option('submenu_font', 'Open Sans'); ?>', sans-serif; font-weight:600;}
	.featured-address-number {font-family: <?php echo of_get_option('featured_address', 'Georgia'); ?>, serif;}
	.featured-address-city, .listings-street-widget, .post-data, .share-section, .property-information-location, .property-highlight, .property-status, .share-section-listing span.share-text {font-family:"<?php echo of_get_option('secondary_address', 'Times New Roman'); ?>", Georgia, serif; }
	
	<?php if(of_get_option('currency_image')): ?>
	input#price-min, input#price-max {background-image:url(<?php echo of_get_option('currency_image', get_template_directory_uri() . '/images/dollar-sign.png'); ?>);}
	<?php endif; ?>
	
	<?php echo '</style>'; ?>
	
	<?php if(of_get_option('custom_js')): ?>
	<?php echo '<script type="text/javascript">'; ?>
	<?php echo of_get_option('custom_js'); ?>
	<?php echo '</script>'; ?>
	<?php endif; ?>
	
<?php
/**
if ( is_page_template('search-map.php') ) {
?>	
	
<script type = "text/javascript">
//<![CDATA[
var map = null;
var bounds = new google.maps.LatLngBounds();

function load_company_map() {
  var myOptions = {
    zoom: 11,
    center: new google.maps.LatLng(-33.92308134525937, 18.422642915544247),
	
	mapTypeControl: true,
    mapTypeControlOptions: {style: google.maps.MapTypeControlStyle.DROPDOWN_MENU},
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.HYBRID
  }
  
  map = new google.maps.Map(document.getElementById("google-map"), myOptions);
 
  google.maps.event.addListener(map, 'click', function() {
   infowindow.close();
  });

  // Add markers to the map
  // Set up three markers with info windows 
  
<?php
		$args = array(
			'post_type' => 'property',
			'posts_per_page' => 999999999999999
		);

		query_posts($args);
		if(have_posts()):		
?>		
		<?php while(have_posts()): the_post(); ?>
		
		<?php
		  if (get_post_meta($post->ID, "pyre_geo", true)) {
		?>
		var point = new google.maps.LatLng(<?php echo get_post_meta($post->ID, "pyre_geo", true); ?>);
		var marker = createMarker(point,'<ul><li><b><?=htmlspecialchars_decode(get_post_meta($post->ID, "post_title", true))?></b></li><li><a href="<?php the_permalink(); ?>" target="_blank"><?php the_post_thumbnail("widget-thumb"); ?></a></li><li><b>Price:</b> From R<?php echo get_post_meta($post->ID, "pyre_price", true); ?></li><a href="<?php the_permalink(); ?>" target="_blank">View Property</a></li></ul>');

		bounds.extend(point);	
		<?php
		  }
		?>
		
		
	<?php endwhile; ?>		
	<?php endif; ?>	
	
map.fitBounds(bounds);
}
 
 
var infowindow = new google.maps.InfoWindow( { 

	size: new google.maps.Size(300,300)

});
    
function createMarker(latlng, html) {
    var contentString = html;
    var marker = new google.maps.Marker({
        position: latlng,
        map: map,
        //icon: "http://google-maps-icons.googlecode.com/files/villa.png",
        zIndex: Math.round(latlng.lat()*-100000)<<5
        });

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(contentString); 
        infowindow.open(map,marker);
		marker.setAnimation(google.maps.Animation.DROP);
        });
}


function go(lat, lon){
  var point = new google.maps.LatLng(lat, lon);
  map.setCenter(point);
  map.setZoom(5);
}

//]]>
</script>
<?php
}

onload="load_company_map()" 
**/
?>

</head>
<body <?php body_class(''); ?>>

	<div class="header-top">
		<div class="width-container">
			<div class="header-top-left">
				<?php if(of_get_option('phone_number', '(800) 536-3532')): ?>
				<span href="" class="phone-header-top"><?php echo of_get_option('phone_number', '(800) 536-3532'); ?></span>
				<?php endif; ?>
				<?php if(of_get_option('email_address', 'no-reply@progressionstudios.com')): ?>
				<a href="mailto:<?php echo of_get_option('email_address', 'no-reply@progressionstudios.com'); ?>" class="email-header-top"><?php echo of_get_option('email_address', 'no-reply@progressionstudios.com'); ?></a>
				<?php endif; ?>
			</div><!-- close .header-top-left -->
			<div class="social-icons">
					<?php if(of_get_option('rss_link_header')): ?>
					<a class="rss" href="<?php echo of_get_option('rss_link_header'); ?>" target="_blank">r</a>
					<?php endif; ?>
					<?php if(of_get_option('facebook_link_header')): ?>
					<a class="facebook" href="<?php echo of_get_option('facebook_link_header'); ?>" target="_blank">F</a>
					<?php endif; ?>
					<?php if(of_get_option('twitter_link_header')): ?>
					<a class="twitter" href="<?php echo of_get_option('twitter_link_header'); ?>" target="_blank">t</a>
					<?php endif; ?>
					<?php if(of_get_option('skype_link_header')): ?>
					<a class="skype" href="<?php echo of_get_option('skype_link_header'); ?>" target="_blank">s</a>
					<?php endif; ?>
					<?php if(of_get_option('vimeo_link_header')): ?>
					<a class="vimeo" href="<?php echo of_get_option('vimeo_link_header'); ?>" target="_blank">v</a>
					<?php endif; ?>
					<?php if(of_get_option('linkedin_link_header')): ?>
					<a class="linkedin" href="<?php echo of_get_option('linkedin_link_header'); ?>" target="_blank">l</a>
					<?php endif; ?>
					<?php if(of_get_option('dribbble_link_header')): ?>
					<a class="dribbble" href="<?php echo of_get_option('dribbble_link_header'); ?>" target="_blank">d</a>
					<?php endif; ?>
					<?php if(of_get_option('forrst_link_header')): ?>
					<a class="forrst" href="<?php echo of_get_option('forrst_link_header'); ?>" target="_blank">f</a>
					<?php endif; ?>
					<?php if(of_get_option('flickr_link_header')): ?>
					<a class="flickr" href="<?php echo of_get_option('flickr_link_header'); ?>" target="_blank">n</a>
					<?php endif; ?>
					<?php if(of_get_option('google_link_header')): ?>
					<a class="google" href="<?php echo of_get_option('google_link_header'); ?>" target="_blank">g</a>
					<?php endif; ?>
					<?php if(of_get_option('youtube_link_header')): ?>
					<a class="youtube" href="<?php echo of_get_option('youtube_link_header'); ?>" target="_blank">y</a>
					<?php endif; ?>
			</div><!-- close .social-icons -->
		<div class="clearfix"></div>
		</div><!-- close .width-container -->
	</div>

	<header>
		<div class="header-border-top"></div>
		<div class="width-container">
			
			<h1 id="logo"><a href="<?php echo site_url(); ?>"><img src="<?php echo of_get_option('logo', get_template_directory_uri() . '/images/logo.png'); ?>" alt="<?php bloginfo('name'); ?>" /></a></h1>
			
			<nav>
				<?php wp_nav_menu(array('theme_location' => 'main_nav', 'depth' => 4, 'menu_class' => 'sf-menu')); ?>
			</nav>
			
		<div class="clearfix"></div>
		</div><!-- close .width-container -->
		<div class="header-border-bottom"></div>
	</header>

	<div id="search-container">
		<div class="width-container">
			<?php
			$purl = get_post_type_archive_link('property');
			?>
			<form method="get" class="searchform" action="<?php echo $purl; ?>">
				<input type="hidden" name="post_type" value="property" />
				<label for="s" class="assistive-text"><?php _e('Search','progressionstudios'); ?>:</label>
				<input type="text" class="field" name="search_keyword" id="s" placeholder="<?php echo of_get_option('search_keyword', 'Enter an address, zip code, suburb or city...'); ?>" />
				<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php _e('Search','progressionstudios'); ?>" />
				
				<div class="clearfix"></div>
				<div id="panel-search">
					
					<div class="header-advanced-pricing">
						<input type="text" class="field" name="price-min" id="price-min" placeholder="<?php _e('Min Price','progressionstudios'); ?>" />
					</div>
					
					<div class="price-range"><?php _e('to','progressionstudios'); ?></div>
					
					<div class="header-advanced-pricing">
						<input type="text" class="field" name="price-max" id="price-max" placeholder="<?php _e('Max Price','progressionstudios'); ?>" />
					</div>
					
					
		
					<div class="hidden-values">
						<select name="city"> 
							<option value="" selected="selected"><?php echo of_get_option('city_text', 'Choose City'); ?></option> 
							<?php foreach($city as $c): ?>
							<option value="<?php echo $c; ?>" <?php if($_GET['city'] == $c): ?>selected="selected"<?php endif; ?>><?php echo $c; ?></option>
							<?php endforeach; ?> 
						</select>
						<select name="state">
							<option value="" selected="selected"><?php echo of_get_option('state_text', 'State'); ?></option>
							<?php foreach($state as $s): ?> 
							<option value="<?php echo $s; ?>" <?php if($_GET['state'] == $s): ?>selected="selected"<?php endif; ?>><?php echo $s; ?></option>
							<?php endforeach; ?> 
						</select>
						<select name="zip"> 
							<option value="" selected="selected"><?php echo of_get_option('zip_text', 'Zip code'); ?></option> 
							<?php foreach($zip as $z): ?> 
							<option value="<?php echo $z; ?>" <?php if($_GET['zip'] == $z): ?>selected="selected"<?php endif; ?>><?php echo $z; ?></option>
							<?php endforeach; ?> 
						</select>
					</div>
					
		
<? /**					
					<div class="header-advanced-bedbath">
						<select name="beds"> 
							<option value="" selected="selected"><?php echo of_get_option('beds_text', 'Beds'); ?></option> 
							<option value="1">1+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option> 
							<option value="2">2+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option> 
							<option value="3">3+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option> 
							<option value="4">4+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option> 
							<option value="5">5+ <?php echo of_get_option('beds_text_short', 'bd'); ?></option> 
						</select>
					</div>		
					
					
					<div class="header-advanced-bedbath">
						<select name="baths"> 
							<option value="" selected="selected"><?php echo of_get_option('baths_text', 'Baths'); ?></option> 
							<option value="1">1+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option> 
							<option value="2">2+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option> 
							<option value="3">3+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option> 
							<option value="4">4+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option> 
							<option value="5">5+ <?php echo of_get_option('baths_text_short', 'ba'); ?></option> 
						</select>
					</div>
					
					
					
					<div class="header-prop-typestatus">
						<select name="sqft"> 
							<option value="" selected="selected"><?php echo of_get_option('square_feet_text', 'Square Feet'); ?></option> 
							<option value="250">250+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="500">500+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="1000">1000+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="1250">1250+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="1500">1500+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="2000">2000+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="2500">2500+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="3000">3000+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="3500">3500+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
							<option value="4000">4000+ <?php echo of_get_option('square_feet_text_small', 'sqft'); ?></option> 
						</select>
					</div>
**/ ?>
					<?php
					$ptype = get_terms('property_type');
					if($ptype):
					?>
					<div class="header-prop-typestatus">
						<select name="ptype"> 
							<option value="" selected="selected"><?php echo of_get_option('property_type_text', 'Property Type'); ?></option>
							<?php foreach($ptype as $pt): ?>
							<?php if($pt->name != 'Featured'): ?>
							<?php if($pt->name != 'Homepage'): ?>
							<?php if($pt->name != 'Widget'): ?>
								<?php if($pt->name != 'featured'): ?>
								<?php if($pt->name != 'homepage'): ?>
								<?php if($pt->name != 'widget'): ?>
							<option value="<?php echo $pt->slug; ?>"><?php echo $pt->name; ?></option>
							<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>
							<?php endif; ?>

							<?php endforeach; ?>
						</select>
					</div>
					<?php endif; ?>
<?
/**					
					<div class="header-prop-typestatus hidden-value-tablet">
						<select name="status"> 
							<option value="" selected="selected"><?php echo of_get_option('property_status_text', 'Property Status'); ?></option> 
							<option value="For Rent"><?php _e('For Rent','progressionstudios'); ?></option> 
							<option value="For Sale"><?php _e('For Sale','progressionstudios'); ?></option> 
							<option value="Open House"><?php _e('Open House','progressionstudios'); ?></option> 
							<!--option value="Reduced">Recently Reduced</option--> 
						</select>
					</div>
**/ ?>					
					<a class="more-search-options" href="<?php echo $purl; ?>"><?php _e('More search options','progressionstudios'); ?></a>
			
				</div>
				
			</form>
		</div><!-- close width-container -->
		
		
		
	<div class="clearfix"></div>
	</div><!-- close #search-container -->

	<div class="width-container">
		<a href="#" class="search-drop-down"><?php _e('Search More','progressionstudios'); ?></a>
	</div>