<?php
/**
 * The header part - search.
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
<div class="king-search-top">
	<div class="king-search">
		<form role="search" method="get" class="header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<button type="submit" class="header-search-submit"
			value=""><i class="fa fa-search fa-2x" aria-hidden="true"></i> </button>
			<input type="search" class="header-search-field"
			placeholder="<?php echo esc_html_e( 'Search …', 'king' ); ?>"
			value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"
			title="<?php echo esc_html_e( 'Search for:', 'king' ); ?>" />
		</form>
		<?php if ( get_field( 'enable_live_search', 'options' ) ) : ?>
			<div id="king-results"></div>
		<?php endif; ?>
	</div>
</div><!-- .king-search-top -->
