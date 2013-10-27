<?php
/**
 * The template for displaying Archive pages.
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

			<header class="page-header">
				<h2 class="page-title">Our News</h2>
			</header>

		<?php if ( have_posts() ) : ?>
			<header class="archive-header">
				<h1 class="archive-title"><?php
					if ( is_day() ) :
						printf( __( 'Daily Archives: %s', 'letterpress' ), get_the_date() );
					elseif ( is_month() ) :
						printf( __( 'Monthly Archives: %s', 'letterpress' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'letterpress' ) ) );
					elseif ( is_year() ) :
						printf( __( 'Yearly Archives: %s', 'letterpress' ), get_the_date( _x( 'Y', 'yearly archives date format', 'letterpress' ) ) );
					else :
						_e( 'Archives', 'letterpress' );
					endif;
				?></h1>
			</header><!-- .archive-header -->

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