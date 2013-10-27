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
	
	
 

<!-- END ShopperPress Slider -->

<div class="frontcontent">

		<?php if ( have_posts() ) : ?>

			<h2 class="archive-title">BLOG ARCHIVE</h2>

				<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta portfolio portfolio-text"><?php echo category_description(); ?></div>
				<?php endif; ?>

			</header><!-- .archive-header -->

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

<div class="clearfix"></div>
</div>

<?php get_search_form(); ?>

</div>



<?php get_footer(); ?>