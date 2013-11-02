<?php
/**
 * The sidebar containing the secondary widget area, displays on posts and pages.
 *
 * If no active widgets in this sidebar, it will be hidden completely.
 */

if ( is_active_sidebar( 'sidebar-1' ) ) : ?>

	<div id="right-nav">
		
		<?php dynamic_sidebar( 'sidebar-1' ); ?>

	</div><!-- #right-nav -->

<?php endif; ?>