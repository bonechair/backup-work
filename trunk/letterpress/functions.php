<?php
/**
 * Twenty Twelve functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 */
 

 function letterpress_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	//if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		//wp_enqueue_script( 'comment-reply' );

	/*
	 * Adds JavaScript for handling the navigation menu hide-and-show behavior.
	 */
	wp_enqueue_script( 'jpolaroid', get_template_directory_uri() . '/js/jquery.jpolaroid.minified.js', array(), '1.0', true );

	/*
	 * Loads our main stylesheet.
	 */
	wp_enqueue_style( 'letterpress-style', get_stylesheet_uri() );

}
add_action( 'wp_enqueue_scripts', 'letterpress_scripts_styles' );


/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since Twenty Twelve 1.0
 */
function letterpress_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'letterpress' ),
		'id' => 'sidebar-1',
		'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'letterpress' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '',
		'after_title' => '',
	) );

}
add_action( 'widgets_init', 'letterpress_widgets_init' );

if ( function_exists( 'add_theme_support' ) ) { 
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 150, 150, true ); // default Post Thumbnail dimensions (cropped)

// additional image sizes
// delete the next line if you do not need additional image sizes
add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
}


add_theme_support( 'woocommerce' );


 register_sidebar(array(
  'name' => __( 'Left Hand Sidebar Emporium' ),
  'id' => 'left-sidebar-emporium',
  'description' => __( 'Widgets in this area will be shown on the left-hand side.' ),
  'before_title' => '<h1>',
  'after_title' => '</h1>'
));
//first removing all from single product summary

//Rearange Single Product metas
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );


add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 30 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 40 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 50 );
//add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 60 );

add_action( 'woocommerce_archive_description', 'woocommerce_category_image', 2 );
function woocommerce_category_image() {
if ( is_product_category() ){
global $wp_query;
$cat = $wp_query->get_queried_object();
$thumbnail_id = get_woocommerce_term_meta( $cat->term_id, 'thumbnail_id', true );
$image = wp_get_attachment_url( $thumbnail_id );
if ( $image ) {
echo '<img src="' . $image . '" alt="" width="762"/>';
}
}
}
