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
<div class="king-rightmenu">
	<div class="king-top-icons">
		<?php if ( ! get_field( 'disable_users_submit', 'options' ) ) : ?>
			<button class="king-rightmenu-submit" data-toggle="modal" data-target="#submitmodal" role="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
		<?php endif; ?>
		<?php if ( get_field( 'enable_night_mode', 'options' ) ) : ?>
			<input type="checkbox" id="king-night" name="king-night">
			<label for="king-night" class="king-night-box">
				<span><i class="fa-solid fa-sun"></i> <?php esc_html_e( 'Light', 'king' ); ?></span>
				<span><i class="fa-solid fa-moon"></i> <?php esc_html_e( 'Dark', 'king' ); ?></span>
			</label>	
		<?php endif; ?>
		<button class="king-rightmenu-close" type="button" data-toggle="dropdown" data-target=".king-rightmenu" aria-expanded="false"><i class="fas fa-times" aria-hidden="true"></i></button>
	</div>
	<?php get_template_part( 'template-parts/header-templates/header-parts/leftnav' ); ?>
	<div class="king-bottom-icons">
	<?php
	$group     = get_field( 'header_08_options', 'options' );
	$repeaters = $group['bottom_icons'];
	if ( $repeaters ) :
		foreach ( $repeaters as $repeater ) {
				echo '<a href="' . esc_url( $repeater['link_url'] ) . '" >' . wp_kses_post( $repeater['icon_code'] ) . '</a>';
		}
	endif;
	?>
	</div>
</div>
