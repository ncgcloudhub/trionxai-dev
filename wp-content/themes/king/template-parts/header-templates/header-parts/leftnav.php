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

<div class="king-leftnav">
	<div class="king-menu-left">
	<?php get_template_part( 'template-parts/header-templates/header-parts/format-links' ); ?>
	<?php get_template_part( 'template-parts/header-templates/header-parts/newnav' ); ?>
	</div>
	<?php get_template_part( 'template-parts/header-templates/header-parts/usermenu' ); ?>
</div><!-- .king-leftnav -->
