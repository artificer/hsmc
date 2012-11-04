<?php
/**
 * The sidebar containing the footer page widget areas.
 *
 * If no active widgets in the sidebar located in the footer they will be hidden completely.
 *
 * @package WordPress
 * @subpackage Actor
 * @since Actor 1.0
 */

/*
 * The footer page widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if ( ! is_active_sidebar( 'sidebar-4' ))
	return;

// If we get this far, we have widgets. Let do this.
?>
<div class="front-widget-area">
	<?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
	<div class="first front-widgets">
		<?php dynamic_sidebar( 'sidebar-4' ); ?>
	</div><!-- .first -->
	<?php endif; ?>

</div><!-- .front-widget-area -->