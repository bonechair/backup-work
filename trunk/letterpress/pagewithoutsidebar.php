<?php
/**
 * Template Name: Page without Sidebar
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
	<div class="kontent">	<!--start middle column-->
	
	<h2><?php the_title(); ?></h2>
<!-- END ShopperPress Slider -->

<div class="frontcontent">

<?php

// The Loop
while ( have_posts() ) : the_post();
?>

<p><?php the_content(); ?></p>

</div>
<br>
<?php
  endwhile;

// Reset Query
wp_reset_query();

?>

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'letterpress' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
<div class="clearfix"></div></div>


</div>



<?php get_footer(); ?>