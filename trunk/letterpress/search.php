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

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'letterpress' ), get_search_query() ); ?></h1>
			</header>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>


		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'letterpress' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
<div class="clearfix"></div></div>



<?php get_footer(); ?>