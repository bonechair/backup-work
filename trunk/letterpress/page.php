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


<div style="float:right; width:180px; position:relative; right:0px;" class="rightstuff">	<!--start right column-->
	


<div class="menubox_box">


<?php
if (get_post_meta($post->ID, 'Badge', true)) {
?>
<img src="<?php print_custom_field('Badge:to_image_src'); ?>" />

<?php
}
else {
?>	
	
<h2><span style="background-color: #927D84;color: #FFFFFF;font-family: Georgia,'Times New Roman',Times,serif;font-size: 0.8em;letter-spacing: 2.7px;padding: 2px;">NEWS FROM OUR BLOG</span></h2> 		

<?php



// The Query
$args = array( 'posts_per_page' => 3, 'order'=> 'ASC', 'orderby' => 'title', 'category'=>'News' );

query_posts( $args );

// The Loop
while ( have_posts() ) : the_post();
?>
  <div class="post">
  <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><br>
  <small><?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></small> 
</div>
<div class="sidebar-post" style="margin-top:5px;"><p>
<?php the_excerpt(); ?></p>
<a href="<?php the_permalink(); ?>"><small style="color:#927D84; font-family: 'Trebuchet MS',Arial,Helvetica,sans-serif;font-size: 10px;margin-bottom: 10px;">Read full post</small></a>
</div>
<br>
<?php
  endwhile;

// Reset Query
wp_reset_query();
}
?>	
 
<?php get_sidebar(); ?>			
</div><!--end right column-->

</div>



<?php get_footer(); ?>