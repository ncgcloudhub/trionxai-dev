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
<?php if ( ( get_field( 'enable_flags_for_posts', 'options' ) || get_field( 'enable_flags_for_comments', 'options' ) ) && is_super_admin() ) : ?>
<div class="king-notify">
	<?php
		$flag  = get_option( 'king_flag_count' );
		$flagc = ! empty( $flag ) ? 'notify' : '';
	?>
	<div class="king-notify-box <?php echo esc_attr( $flagc ); ?>" id="flagbox">
		<div class="king-notify-toggle" id="ftoggle" data-toggle="dropdown" data-target="#flagmenu" aria-expanded="true"><i class="far fa-flag"></i><span class="king-notify-num"><?php echo esc_attr( $flag ); ?></span></div>
		<div class="king-notify-menu" id="flagmenu">
			<ul id="kingflagin" class="king-notify-inside king-scroll"><li class="king-clean-center"><div class="loader"></div></li></ul>
		</div>
	</div>
</div>
<?php endif; ?>
<?php if ( get_field( 'enable_notification', 'options' ) && is_user_logged_in() ) : ?>
<div class="king-notify">
	<?php
	$notify      = get_user_meta( get_current_user_id(), 'king_notify_count', true );
	$notifyclass = '';
	if ( $notify ) { $notifyclass = 'notify'; }
	?>
	<div class="king-notify-box <?php echo esc_attr( $notifyclass ); ?>" id="notifybox">
		<div class="king-notify-toggle" id="ntoggle" data-toggle="dropdown" data-target="#notifymenu" aria-expanded="true"><i class="far fa-bell fa-lg"></i><span class="king-notify-num"><?php echo esc_attr( $notify ); ?></span></div>
		<div class="king-notify-menu" id="notifymenu">
			<ul id="king-notify-inside" class="king-notify-inside king-scroll"><li class="king-clean-center"><div class="loader"></div></li></ul>
		</div>
	</div>
</div>
<?php endif; ?>