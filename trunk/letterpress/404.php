<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that other
 * 'pages' on your WordPress site will use a different template.
 *
 */

get_header(); ?>


<div class="container_12" id="MainContentArea">

<!--<br /><br /> -->

<?php
 include("sidemenu.php");
?>
	<div style="float:left; width:589px; margin-right:20px;">	<!--start middle column-->
	
	
 

<!-- END ShopperPress Slider -->

<div class="frontcontent">

					<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'twentythirteen' ); ?></h2>
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'twentythirteen' ); ?></p>

					<?php get_search_form(); ?>

<div class="clearfix"></div>
</div>
</div>



<?php get_footer(); ?>