<?php
/**
 * Reset Password Page
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
if ( is_user_logged_in() ) {
	wp_safe_redirect( get_home_url() );
	exit;
}
?>
<?php 
if ( get_field( 'enable_homepage_login', 'options' ) ) :
	wp_head();
	$style      = get_field( 'homeregister_page', 'options' );
	$ltemplate  = get_field_object( 'homepage_login_layout', 'options' );
	$ltemplatec = $ltemplate['value'] . ' hlogin';
	$stylecode  = 'style="background-image: url(\'' . $style['background_image'] . '\');background-color:' . $style['background_color'] . ';"';
	$styleleft  = 'style="background-image: url(\'' . $style['image_on_left'] . '\');"';
else :
	get_header();
	$ltemplatec = '';
	$style      = array();
	$styleleft  = array();
endif;
?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<!-- #primary BEGIN -->
<div id="primary" class="page-content-area <?php echo esc_attr( $ltemplatec ); ?>">
	<?php if ( isset( $stylecode ) ) : ?>
		<div class="hlogin-back" <?php echo wp_kses_post( $stylecode ); ?>></div>
	<?php endif; ?>
	<?php if ( get_field( 'enable_homepage_login', 'options' ) ) : ?>
		<div class="kinglogin-middle">
			<div class="hlogin-left" <?php echo wp_kses_post( $styleleft ); ?>>
			<?php if ( $style['message'] ) : ?>
				<div class="hlogin-message">
					<?php if ( get_field( 'logo_homepage_login', 'options' ) ) : ?>
					<div class="hlogin-logo"><?php echo wp_get_attachment_image( get_field( 'logo_homepage_login', 'options' ), 'medium' ); ?></div>
					<?php endif; ?>
					<?php echo wp_kses_post( $style['message'] ); ?>		
				</div>
			<?php endif; ?>
			</div>
		<?php endif; ?>
	<main id="main" class="page-site-main">
		<!--content-->
		<?php if ( isset( $_GET['action'] ) && $_GET['action'] === 'resetpassword' ) : ?>
		<div class="alert alert-success"><?php esc_attr_e( 'Confirmation email is sent to your email address', 'king' ); ?></div>
		<?php else : ?>
		<?php if ( isset( $_GET['action'] ) && $_GET['action'] === 'userexist' ) : ?>
			<div class="alert alert-success"><?php esc_attr_e( 'You must enter a valid and existing email address or username.', 'king' ); ?></div>
		<?php endif; ?>			
		<form action="<?php echo esc_url( wp_lostpassword_url( esc_url_raw( add_query_arg( array( 'action' => 'resetpassword' ), site_url() . '/' . $GLOBALS['king_reset'] ) ) ) ); ?>" id="login-form" method="post">
			<div class="king-form-group">
				<input type="text" name="user_login" id="user_email" class="bpinput" value="" placeholder="<?php esc_attr_e( 'Username or email address', 'king' ); ?>" maxlength="80" />
			</div>
			<div class="king-form-group bwrap">
				<input type="submit" class="king-submit-button" value="<?php esc_attr_e( 'Reset password', 'king' ); ?>" id="king-submitbutton" name="resetpassword" />
			</div>
		</form>
		<?php endif; ?>
	</main><!-- #main -->
<?php if ( get_field( 'enable_homepage_login', 'options' ) ) : ?>
</div>
<?php endif; ?>
</div><!-- .main-column -->
<?php
if ( ! get_field( 'enable_homepage_login', 'options' ) ) :
	get_footer();
endif;
?>
