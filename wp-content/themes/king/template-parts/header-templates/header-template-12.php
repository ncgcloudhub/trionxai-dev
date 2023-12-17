<?php
/**
 * The header template-04.
 *
 * This is the header template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$usrid = get_current_user_id();
?>
<div id="page" class="site header-template-11">
	<?php get_template_part( 'template-parts/header-templates/header-parts/headerstrip' ); ?>
	<div class="header12-top king-header lr-padding">
		<?php get_template_part( 'template-parts/header-templates/header-parts/search' ); ?>
		<?php get_template_part( 'template-parts/header-templates/header-parts/submit' ); ?>
	</div>
<header id="masthead" class="site-header">

	<div class="king-header header-11-left">

		<?php get_template_part( 'template-parts/header-templates/header-parts/logo' ); ?>
		<div class="king-scroll header-11-menu">

			<?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => false, 'menu_class' => 'header-11-topmenu', ) ); ?>
			<a href="#" class="header-11-item" data-toggle="dropdown" data-target="#humenu, .header-11-left" aria-expanded="false" role="button">
				<i>
					<?php if ( get_field( 'author_image','user_' . $usrid ) ) : $image = get_field( 'author_image','user_' . $usrid ); ?>
						<img class="user-header-avatar" src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
					<?php else : ?>
						<span class="user-header-noavatar" ></span>
					<?php endif; ?>
				</i>
				<?php echo esc_html_e( 'Profile', 'king' ); ?>
			</a>
			<?php if ( get_field( 'enable_notification', 'options' ) && is_user_logged_in() ) : ?>
				<?php
				$notify      = get_user_meta( $usrid, 'king_notify_count', true );
				$notifyclass = isset( $notify ) ? 'notify' : 'notify';

				?>
				<a href="#" class="header-11-item" id="ntoggle" data-toggle="dropdown" data-target="#nbox, .header-11-left" aria-expanded="false" role="button"><i class="far fa-bell fa-lg"></i><?php echo esc_html_e( 'Notifications', 'king' ); ?>
				<?php if ( $notify ) : ?>
					<span class="king-nnum"><?php echo esc_attr( $notify ); ?></span>
				<?php endif; ?>
			</a>
		<?php endif; ?>

	</div>
	<a href="#" class="header-11-item" data-toggle="dropdown" data-target=".king-leftmenu, .header-11-left" aria-expanded="false" role="button"><i class="fa-solid fa-bars"></i><?php echo esc_html_e( 'More', 'king' ); ?></a>	
</div>
</header>
<?php get_template_part( 'template-parts/header-templates/header-parts/leftmenu' ); ?>


<div class="header-slide" id="humenu">
	<div class="king-leftnav">
		<?php get_template_part( 'template-parts/header-templates/header-parts/usermenu' ); ?>
		<?php if ( get_field( 'enable_night_mode', 'options' ) ) : ?>
				<input type="checkbox" id="king-night" name="king-night" class="hide">
				<label for="king-night" class="king-night-box">
					<span><i class="fa-solid fa-sun"></i> <?php esc_html_e( 'Light', 'king' ) ?></span>
					<span><i class="fa-solid fa-moon"></i> <?php esc_html_e( 'Dark', 'king' ) ?></span>
				</label>	
		<?php endif; ?>
	</div>
</div>

<div class="header-slide" id="nbox">
	<div class="king-notify-box <?php echo esc_attr( $notifyclass ); ?>" id="notifybox">

		<ul id="king-notify-inside" class="king-notify-inside king-scroll"><li class="king-clean-center"><div class="loader"></div></li></ul>

	</div>
</div>