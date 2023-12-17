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
<div class="live-king-search-top" id="live-search">
	<span class="king-close" aria-hidden="true"></span>
	<div class="live-king-search">
		<form role="search" method="get" class="live-header-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" class="live-header-search-field"
			placeholder="<?php echo esc_html_e( 'Search …', 'king' ); ?>"
			value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"
			title="<?php echo esc_html_e( 'Search for:', 'king' ); ?>" />
			<button type="submit" class="live-header-search-submit"
			value=""><i class="fa fa-search fa-2x" aria-hidden="true"></i> </button>
		</form>
		<?php if ( get_field( 'enable_live_search', 'options' ) ) : ?>
			<div id="king-results"></div>
		<?php endif; ?>						
	</div>
</div><!-- .king-search-top -->
