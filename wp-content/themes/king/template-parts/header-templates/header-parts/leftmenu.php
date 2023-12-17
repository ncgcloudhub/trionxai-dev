<?php
/**
 * The header part - left menu.
 *
 * This is the header template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php $leftmenu = get_field( 'header_09_options', 'options' ); ?>

<div class="king-leftmenu king-scroll">
	<button class="king-leftmenu-close" type="button" data-toggle="dropdown" data-target=".king-leftmenu" aria-expanded="false"><i class="fa-solid fa-angle-left"></i></button>
	<form role="search" method="get" class="king-mobile-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<input type="search" class="king-mobile-search-field"
		placeholder="<?php echo esc_html_e( 'Search …', 'king' ); ?>"
		value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"
		title="<?php echo esc_html_e( 'Search', 'king' ); ?>" />
	</form>
	<div class="king-leftmenu-nav">
		<?php if ( ! $leftmenu['hide_header_nav'] ) : ?>
			<?php if ( $leftmenu['title_of_header_nav'] ) : ?>
				<h5><?php echo esc_attr( $leftmenu['title_of_header_nav'] ); ?></h5>
			<?php endif; ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/format-links' ); ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/newnav' ); ?>
		<?php endif; ?>
		<div class="king-cat-list-mobile">
			<?php if ( $leftmenu['title_of_menu'] ) : ?>
				<h5><?php echo esc_attr( $leftmenu['title_of_menu'] ); ?></h5>
			<?php endif; ?>
			<?php wp_nav_menu( array( 'theme_location' => 'left-menu' ) ); ?>
		</div>

		<?php if ( $leftmenu['show_following_users'] && is_user_logged_in() ) : ?>
			<?php if ( $leftmenu['following_users_title'] ) : ?>
				<h5><?php echo esc_attr( $leftmenu['following_users_title'] ); ?></h5>
			<?php endif; ?>
			<?php get_template_part( 'template-parts/header-templates/header-parts/following-users' ); ?>
		<?php endif; ?>
	</div>
</div><!-- .king-head-mobile -->