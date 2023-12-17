<?php
/**
 * User following users posts page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
if ( ( get_query_var( 'template' ) === 'membership' || get_query_var( 'template' ) === 'myplan' ) && get_field( 'enable_membership', 'option' ) && king_plugin_active( 'WooCommerce' ) && is_user_logged_in() ) {
	get_template_part( 'template-parts/pages/king-membership' );
} elseif ( get_query_var( 'template' ) === 'redirect' ) {
    get_template_part( 'template-parts/pages/king-redirect' );
} else {
	get_template_part( 'template-parts/pages/user-dashboard-template' );
}
get_footer();
