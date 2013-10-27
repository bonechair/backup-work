<?php
/**
 * Single Product Meta
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<?php $pinterestimage = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
<ul class="social-icons">
<li><a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($post->ID)); ?>&description=<?php the_title(); ?>&media=<?php echo $pinterestimage[0]; ?>" target="_blank"><img src="/wp-content/themes/letterpress/img/pinit.png"></a><b>SEE PINBOARD</b></li>
<li><img src="/wp-content/themes/letterpress/img/favorite.png"><b>FAVORITE</b></li>
<li><b>SHARE</b>
<a href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink($post->ID)); ?>&description=<?php the_title(); ?>&media=<?php echo $pinterestimage[0]; ?>" target="_blank"><img src="/wp-content/themes/letterpress/img/pinit2.png"></a>
<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink($post->ID)); ?>" target="_blank"><img src="/wp-content/themes/letterpress/img/facebook.png"></a>
<a href="https://twitter.com/intent/tweet?text=Checkout Letterpress Website&url=<?php echo urlencode(get_permalink($post->ID)); ?>" target="_blank"><img src="/wp-content/themes/letterpress/img/twitter.png"></a>
</li>
</ul>
<div class="product_meta">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option( 'woocommerce_enable_sku' ) == 'yes' && $product->get_sku() ) : ?>
		<span itemprop="productID" class="sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo $product->get_sku(); ?></span>.</span>
	<?php endif; ?>

	<?php
		//$size = sizeof( get_the_terms( $post->ID, 'product_cat' ) );
		//echo $product->get_categories( ', ', '<span class="posted_in">' . _n( 'Category:', 'Categories:', $size, 'woocommerce' ) . ' ', '.</span>' );
	?>

	<?php
		$size = sizeof( get_the_terms( $post->ID, 'product_tag' ) );
		echo $product->get_tags( '<br><br>', '<span class="tagged_as">' . _n( '', '', $size, 'woocommerce' ) . ' ', '</span>' );
	?>


	<?php do_action( 'woocommerce_product_meta_end' ); ?>

	<span class="fancybox quick_view_ultimate_button quick_view_ultimate_click" data-link="/quote/" id="33">GET A QUOTE</span>
</div>
	<br>