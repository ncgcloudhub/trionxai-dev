<?php
/**
 * Login Modal in header theme part.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( ! is_user_logged_in() ) : ?>
<div class="king-modal-login modal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="king-modal-content">
	<button type="button" class="king-modal-close" data-dismiss="modal" aria-label="Close"><i class="icon fa fa-fw fa-times"></i></button>
		<form action="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] . '?loginto=' . add_query_arg( array(),$wp->request ) ); ?>" id="login-form" method="post">
		<div class="king-modal-header"><h4 class="App-titleControl App-titleControl--text"><?php esc_html_e( 'Log In', 'king' ) ?></h4></div>
		<div class="king-modal-form">
		<?php if ( get_field( 'custom_message_login', 'options' ) ) : ?>
			<div class="king-custom-message">
				<?php the_field( 'custom_message_login', 'options' ); ?>
			</div>
		<?php endif; ?>
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
			</div>
			<div class="king-modal-footer">
				<p class="LogInModal-forgotPassword"><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_reset'] ); ?>"><?php esc_html_e( 'Forgot password?', 'king' ); ?></a></p><p class="LogInModal-signUp"><?php esc_html_e( 'Don\'t have an account?', 'king' ); ?> <a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>"><?php esc_html_e( 'Sign Up', 'king' ); ?></a></p></div>	
			<?php if ( get_field( 'enable_social_logins_in_modal','option' ) ) : ?>		
				<?php get_template_part( 'template-parts/pages/social-login' ); ?>
			<?php endif; ?>				
			</div>
		</form>
	</div>
</div><!-- .king-modal-login -->
<?php endif; ?>