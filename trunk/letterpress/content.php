<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 */
?>


<div class="ArticleBox">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >
		<?php if ( has_post_thumbnail()) : ?>
		<div class="entry-thumbnail">
			<?php the_post_thumbnail(); ?>
		</div>
		<?php endif; ?>
	<h2><a title="The Art of Letterpress" href="<?php the_permalink(); ?>"><?php echo the_title() ?></a></h2>
	
	<div class="post-date"><em><?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?><?php //comments_popup_link( '<span class="leave-reply">' . __( 'Leave a comment', 'lightsites' ) . '</span>', __( 'One comment so far', 'lightsites' ), __( 'View all % comments', 'lightsites' ) ); ?></em></div>
	<br>
	<div style="line-height:30px;" class="post-excerpt"><p></p><p><?php the_excerpt(); ?></p>
	<a title="" href="<?php the_permalink(); ?>">Read full post</a><p></p></div>
	
	
	</article><!-- #post -->

</div>
<div style="clear:both;"></div>
