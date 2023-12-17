<?php
/**
 * The header part - header strip.
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
<?php if ( get_field( 'enable_headerstrip', 'options' ) ) : ?>
	<?php if ( ( get_field( 'show_only_logged_users', 'options' ) && is_user_logged_in() ) || ! get_field( 'show_only_logged_users', 'options' ) ) : ?>
	<div class="king-headerstrip" data-headerstrip="<?php the_field( 'hs_expired_time', 'options' ); ?>" id="hs-<?php the_field( 'hs_expired_time', 'options' ); ?>" style="display: none;">
		<div class="king-hs-content">
			<?php the_field( 'headerstrip_text', 'options' ); ?>
			<?php if ( get_field( 'headerstrip_button_url', 'options' ) && get_field( 'headerstrip_button_text', 'options' ) ) : ?>
				<a href="<?php the_field( 'headerstrip_button_url', 'options' ); ?>" class="king-hs-button"><?php the_field( 'headerstrip_button_text', 'options' ); ?></a>
			<?php endif; ?>
		</div>
		<a class="king-hs-close"><i class="fas fa-times"></i></a>
	</div>
	<?php endif; ?>
<?php endif; ?>
