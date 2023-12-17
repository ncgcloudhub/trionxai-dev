<?php
/**
 * Login Page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
global $post;
if ( is_user_logged_in() ) {
	wp_redirect( get_home_url() );
	exit;
}
if ( get_query_var( 'template' ) ) {
	$provider = get_query_var( 'template' );
	king_authenticate_user( $provider );
	exit;
}

$login = null;
// login.
if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) && wp_verify_nonce( $_POST['login_form_nonce'], 'login_form' ) ) { // input var okay; sanitization.

	$username = sanitize_text_field( wp_unslash( $_POST['username'] ) );
	$password = sanitize_text_field( $_POST['password'] );
	$login = wp_signon(
		array(
			'user_login'    => $username,
			'user_password' => $password,
			'remember'      => ( ( isset( $_POST['rememberme'] ) && absint( $_POST['rememberme'] ) ) ? true : false ),
		)
	);

	if ( ! is_wp_error( $login ) ) {
		wp_clear_auth_cookie();
		wp_set_current_user( $login->ID, esc_attr( $username ) );
		wp_set_auth_cookie( $login->ID, true );

		if ( get_field( 'enable_user_points', 'options' ) ) {
			king_user_points( $login->ID );
		}
		if ( isset( $_GET['loginto'] ) ) {
			wp_safe_redirect( home_url( $_GET['loginto'] ) );
		} else {
			wp_safe_redirect( get_home_url() );
		}
		exit;
	}
}
?>
<?php 
if ( get_field( 'enable_homepage_login', 'options' ) ) :
	wp_head();
	$style      = get_field( 'homelogin_page', 'options' );
	$ltemplate  = get_field_object( 'homepage_login_layout', 'options' );
	$ltemplatec = $ltemplate['value'] . ' hlogin';
	$stylecode  = 'style="background-image: url(\''.$style['background_image'].'\');background-color:'.$style['background_color'].';"';
	$styleleft  = 'style="background-image: url(\''.$style['image_on_left'].'\');"';
else :
	get_header();
	$ltemplatec = '';
	$style      = array();
	$styleleft  = array();
endif;

?>

<div id="primary" class="page-content-area <?php echo esc_attr( $ltemplatec ); ?>">
	 
<?php if ( isset ( $stylecode ) ) : ?>
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
				<?php if ( get_field( 'custom_message_login', 'options' ) ) : ?>
					<div class="king-custom-message">
						<?php the_field( 'custom_message_login', 'options' ); ?>
					</div>
				<?php endif; ?>
				<form action="" id="login-form" method="post">
					<?php if ( is_wp_error( $login ) ) { ?>
						<div class="alert alert-danger"><?php esc_html_e( 'Incorrect username or password. Please try again.', 'king' ) ?></div>
					<?php } ?>
					<div class="king-form-group">
						<input type="text" name="username" id="username" class="bpinput" placeholder="<?php esc_html_e( 'Your username', 'king' ); ?>" maxlength="50"/>
					</div>
					<div class="king-form-group">
						<input type="password" name="password" id="password" class="bpinput" placeholder="<?php esc_html_e( 'Your password', 'king' ); ?>" maxlength="50"/>
					</div>

					<div class="king-form-group">
						<input type="checkbox" name="rememberme" id="rememberme" />
						<label for="rememberme" class="rememberme-label"><?php esc_html_e( 'Remember me', 'king' ); ?></label>
					</div>
					<div class="king-form-group bwrap">
						<?php wp_nonce_field( 'login_form','login_form_nonce' ); ?>
						<input type="submit" class="king-submit-button" value="<?php esc_html_e( 'Login', 'king' ); ?>" id="king-submitbutton" name="login" /> 
					</div>
					</form>
		<div class="login-rl">
		<?php if ( get_option( 'users_can_register' ) ) : ?>
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>" class="login-register"><i class="fas fa-globe-africa"></i></i><?php esc_html_e( ' Register ', 'king' ); ?></a>
		<?php endif; ?>	
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_reset'] ); ?>" class="login-reset"><i class="fas fa-fish"></i><?php esc_html_e( 'Forgot password ?', 'king' ); ?></a>
		</div>
		<?php get_template_part( 'template-parts/pages/social-login' ); ?>
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
