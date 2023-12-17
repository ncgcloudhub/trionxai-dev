<?php
/**
 * The header part - extraicons.
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
<?php if ( have_rows( 'add_new_icon_and_link_in_header', 'option' ) ) : ?>
	<?php while ( have_rows( 'add_new_icon_and_link_in_header', 'option' ) ) : the_row(); ?>
		<a href="<?php the_sub_field( 'header_icon_url' ); ?>" class="king-head-eicons"><?php the_sub_field( 'header_icon' ); ?></a>
	<?php endwhile; ?>
<?php endif; ?>
