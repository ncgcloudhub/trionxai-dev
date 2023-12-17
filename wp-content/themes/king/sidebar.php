<?php
/**
 * Sidebar.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area">
	<div class="first-sidebar">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
		<div class="sidebar-ad">
			<?php if ( get_field( 'enable_sticky_ad', 'options' ) && king_add_free_mode() ) : ?>
				<div class="sidebar-adarea">
					<?php the_field( 'sidebar_sticky_ad', 'options' ); ?>
				</div>
			<?php endif; ?>
		</div>	
	</div>
</aside><!-- #secondary -->
