<?php
/**
 * The header part - user menu.
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
<div class="king-logged-user">
	<div class="king-username">
		<?php if ( ! is_user_logged_in() ) : ?>
			<div class="header-login" data-toggle="dropdown" data-target=".user-header-menu" aria-expanded="false"><i class="fas fa-user-circle"></i></div>
			<div class="user-header-menu">
				<div class="king-login-buttons">
					<?php if ( get_option( 'permalink_structure' ) ) : ?>
						<a data-toggle="modal" data-target="#myModal" href="#" class="header-login-buttons"><i class="fas fa-user-circle"></i><?php esc_html_e( ' Login ', 'king' ); ?></a>
					<?php else : ?>
						<a href="<?php echo esc_url( wp_login_url( home_url() ) ); ?>" class="header-login-buttons"><i class="fas fa-user-circle"></i> <?php esc_html_e( ' Login ', 'king' ) ?></a>
					<?php endif; ?>
					<?php if ( get_option( 'users_can_register' ) && get_option( 'permalink_structure' ) ) : ?>
						<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>" class="header-register"><i class="fas fa-globe-africa"></i><?php esc_html_e( ' Register ', 'king' ) ?></a>
					<?php endif; ?>
				</div>
			<?php if ( get_field( 'enable_night_mode', 'options' ) ) : ?>
				<input type="checkbox" id="king-night" name="king-night" class="hide">
				<label for="king-night" class="king-night-box">
					<span><i class="fa-solid fa-sun"></i> <?php esc_html_e( 'Light', 'king' ) ?></span>
					<span><i class="fa-solid fa-moon"></i> <?php esc_html_e( 'Dark', 'king' ) ?></span>
				</label>	
			<?php endif; ?>
		</div>
		<?php
	else :
		$usrid = get_current_user_id();
		?>
		<?php if ( get_field( 'author_image','user_' . $usrid ) ) : $image = get_field( 'author_image','user_' . $usrid ); ?>
			<img class="user-header-avatar" src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" data-toggle="dropdown" data-target=".user-header-menu" aria-expanded="false"/>
		<?php else : ?>
			<span class="user-header-noavatar" data-toggle="dropdown" data-target=".user-header-menu" aria-expanded="false"></span>
		<?php endif; ?>
		<?php $prvt_msg = get_user_meta( $usrid, 'king_prvtmsg_notify', true );
		if ( $prvt_msg ) {
			echo '<i class="prvt-dote"></i>';
		}
		?>
		<div class="user-header-menu">
			<div class="user-header-profile" >
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] ); ?>" ><?php echo esc_attr( wp_get_current_user()->display_name ); ?></a>
				<?php if ( get_field( 'enable_user_points', 'options' ) ) : ?>
					<div class="king-points" title="<?php echo esc_html_e( 'Points','king' ); ?>"><i class="fa fa-star" aria-hidden="true"></i> <?php echo get_user_meta( get_current_user_id(), 'king_user_points', true ); ?></div>
				<?php endif; ?>
			</div>
			<?php get_template_part( 'template-parts/header-templates/header-parts/usermenu' ); ?>
			<?php if ( get_field( 'enable_night_mode', 'options' ) ) : ?>
				<input type="checkbox" id="king-night" name="king-night" class="hide">
				<label for="king-night" class="king-night-box">
					<span><i class="fa-solid fa-sun"></i> <?php esc_html_e( 'Light', 'king' ) ?></span>
					<span><i class="fa-solid fa-moon"></i> <?php esc_html_e( 'Dark', 'king' ) ?></span>
				</label>	
			<?php endif; ?>
		</div>
<?php endif; ?>
</div>
</div><!-- .king-logged-user -->
