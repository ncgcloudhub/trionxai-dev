<?php
/**
 * Register Page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
if ( is_user_logged_in() ) {
	wp_redirect( get_home_url() );
	exit;
}

global $king_theme_globals, $king_register_errors, $post;

// register.
if ( isset( $_POST['user_login'] ) &&  isset( $_POST['user_email'] ) && isset( $_POST['king_register_form_nonce'] ) && wp_verify_nonce( $_POST['king_register_form_nonce'], 'king_register_form' ) ) { // input var okay; sanitization okay.


	$username = sanitize_user( $_POST['user_login'] );
	$email    = sanitize_email( $_POST['user_email'] );
	$age      = isset( $_POST['confirm_age'] ) ? $_POST['confirm_age'] : '';

	// user data array.
	$register_userdata = array(
		'user_login'  => wp_kses( $username, '' ), // input var okay; sanitization okay.
		'user_email'  => wp_kses( $email, '' ), // input var okay; sanitization okay.
		'first_name'  => '',
		'last_name'   => '',
		'user_url'    => '',
		'description' => '',
		'role'        => 'author',
		'email'       => wp_kses( $email, '' ), // input var okay; sanitization okay.
	);

	$king_register_errors = array();

	$register_userdata['user_pass']    = wp_kses( $_POST['user_pass'], '' );
	$register_userdata['confirm_pass'] = wp_kses( $_POST['confirm_pass'], '' );

	// custom user meta array.
	$register_usermeta = array(
		'agree' => ( ( isset( $_POST['checkboxagree'] ) && ! empty( $_POST['checkboxagree'] ) ) ? '1' : '0' ), // input var okay; sanitization okay.
		'user_activation_key' => wp_generate_password( 20, false ),
	);


	if ( get_field( 'enable_recaptcha', 'options' ) ) :
		$captcha = $_POST['g-recaptcha-response'];
	endif;
	// validate username.
	if ( trim( $register_userdata['user_login'] ) === '' ) {
		$king_register_errors['user_login'] = esc_html__( 'Username is required.', 'king' );
	} elseif ( ( strlen( $register_userdata['user_login'] ) < 6 )  || ( strlen( $register_userdata['user_login'] ) > 40 ) ) {
		$king_register_errors['user_login'] = esc_html__( 'Sorry, username must be 6 characters or more.', 'king' );
	} elseif ( ! validate_username( $register_userdata['user_login'] ) ) {
		$king_register_errors['user_login'] = esc_html__( 'Sorry, the username you provided is invalid.', 'king' );
	} elseif ( username_exists( $register_userdata['user_login'] ) ) {
		$king_register_errors['user_login'] = esc_html__( 'Sorry, that username already exists.', 'king' );
	} elseif ( preg_match( '/[\s]+/', $register_userdata['user_login'] ) ) {
		$king_register_errors['user_login'] = esc_html__( 'Sorry, the username you provided is invalid.', 'king' );
	}

	if ( get_field( 'enable_recaptcha', 'options' ) ) :
		if ( ! $captcha ) {
			$king_register_errors['recaptcha'] = esc_html__( 'Please check the the captcha form', 'king' );
		} else {

			$secretkey    = get_field( 'recaptcha_secret', 'options' );
			$ip           = getenv( 'REMOTE_ADDR' );
			$response     = wp_remote_get( 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secretkey . '&response=' . $captcha . '&remoteip=' . $ip );
			$response2    = wp_remote_retrieve_body( $response );
			$responsekeys = json_decode( $response2, true );
			if ( intval( $responsekeys['success'] ) !== 1 ) {
				$king_register_errors['recaptcha_failed'] = esc_html__( 'You are spammer', 'king' );
			}
		}
	endif;
	// validate password.
	if ( trim( $register_userdata['user_pass'] ) === '' ) {
		$king_register_errors['user_pass'] = esc_html__( 'Password is required.', 'king' );
	} elseif ( ( strlen( $register_userdata['user_pass'] ) < 6 )  || ( strlen( $register_userdata['user_pass'] ) > 40 ) ) {
		$king_register_errors['user_pass'] = esc_html__( 'Sorry, password must be 6 characters or more.', 'king' );
	} elseif ( $register_userdata['user_pass'] !== $register_userdata['confirm_pass'] ) {
		$king_register_errors['confirm_pass'] = esc_html__( 'Password and repeat password fields must match.', 'king' );
	}


	if ( get_field( 'enable_age_verification', 'options' ) ) {
		if ( trim( $age ) === '' ) {
				$king_register_errors['confirm_age'] = esc_html__( 'Need to fill age verification', 'king' );
		} elseif ( get_age( $age ) <= get_field( 'minimum_age_for_registration', 'options' ) ) {
				$king_register_errors['confirm_age'] = esc_html__( 'You must be older than this age : ', 'king' ) . get_field( 'minimum_age_for_registration', 'options' );
		}
	}
	if ( get_field( 'enable_allowed_emails', 'options' ) && $register_userdata['user_email'] ) {
		$arr   = explode( '@', $register_userdata['user_email'] );
		$found = false;
		if ( have_rows( 'allowed_emails', 'option' ) ) :
			while ( have_rows( 'allowed_emails', 'option' ) ) : the_row();
				$mails = get_sub_field( 'allowed_email' );
				if ( $mails == strtolower( $arr[1] ) ) {
					$found = true;
				}
			endwhile;
			if ( ! $found ) {
				$king_register_errors['user_email'] = esc_html__( 'This email source not allowed for registration !', 'king' );
			}
		endif;
	}

	// validate user_email.
	if ( ! is_email( $register_userdata['user_email'] ) ) {
		$king_register_errors['user_email'] = esc_html__( 'You must enter a valid email address.', 'king' );
	} elseif ( email_exists( $register_userdata['user_email'] ) ) {
		$king_register_errors['user_email'] = esc_html__( 'Sorry, that email address is already in use.', 'king' );
	}

	if ( get_field( 'enable_terms_and_conditions', 'options' ) ) {
		// validate agree.
		if ( '0' === $register_usermeta['agree'] ) {
			$king_register_errors['agree'] = esc_html__( 'You must agree to our terms &amp; conditions to sign up.', 'king' );
		}
	}

	if ( empty( $king_register_errors ) ) {
		// insert new user.
		$new_user_id = wp_insert_user( $register_userdata );

		$new_user = get_userdata( $new_user_id );

		$user_obj = new WP_User( $new_user_id );

		if ( get_field( 'enable_user_groups', 'option' ) ) :
			$field_key = 'field_5e865379a58e8';
			if ( have_rows( 'user_groups', 'option' ) ) {
				while ( have_rows( 'user_groups', 'option' ) ) {
					the_row();
					$chek = get_sub_field( 'default_group_for_new_users' );
					if ( $chek ) {
						$post_users = get_sub_field( 'group_users' );
						array_push( $post_users, $new_user_id );
						update_sub_field( $field_key, $post_users, 'option' );

					}
				}
			}
		endif;

		// update custom user meta.
		foreach ( $register_usermeta as $key => $value ) {
			update_user_meta( $new_user_id, $key, $value );
		}

		if ( get_field( 'enable_membership', 'option' ) ) {
			wp_clear_auth_cookie();
			wp_set_current_user( $new_user_id, esc_attr( $username ) );
			wp_set_auth_cookie( $new_user_id, true );
			wp_safe_redirect( esc_url_raw( add_query_arg( array( 'template' => 'membership' ), site_url() . '/' . $GLOBALS['king_dashboard'] ) ) );
			exit;
		} else {
			wp_safe_redirect( esc_url_raw( add_query_arg( array( 'action' => 'registered' ), site_url() . '/' . $GLOBALS['king_register'] ) ) );
			exit;
		}
	}
}

/**
 * Gets the age.
 *
 * @param <type> $birth_date The birth date.
 *
 * @return integer  The age.
 */
function get_age( $birth_date ) {

	list( $year, $month, $day) = explode( '-', $birth_date );

	$y_diff = date( 'Y' ) - $year;
	$m_diff = date( 'm' ) - $month;
	$d_diff = date( 'd' ) - $day;
	if ( $d_diff < 0 || $m_diff < 0 ) {
		$y_diff --;
	}
	return $y_diff;
}

global $post;
?>
<?php 
if ( get_field( 'enable_homepage_login', 'options' ) ) :
	wp_head();
	$style      = get_field( 'homeregister_page', 'options' );
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

<?php if ( ! get_option( 'users_can_register' ) ) : ?>
	<div class="king-alert"><i class="fa fa-bell fa-lg" aria-hidden="true"></i>
		<?php esc_html_e( 'Registration is disabled in this site !', 'king' ); ?>
	</div>
<?php else : ?> 
<!-- #primary BEGIN -->
<div id="primary" class="page-content-area <?php echo esc_attr( $ltemplatec ); ?>" >
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
	<!--content-->

	<?php if ( isset( $_GET['action'] ) && $_GET['action'] === 'registered' ) : ?>
		<div class="alert alert-success">
			<?php esc_html_e( 'Account was successfully created. You can login now !', 'king' ); ?>						
		</div>
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" class="king-alert-button"><?php esc_html_e( 'Log in ', 'king' ); ?></a>
	<?php else : ?>
		<?php if ( get_field( 'custom_message_register', 'options' ) ) : ?>
			<div class="king-custom-message">
				<?php the_field( 'custom_message_register', 'options' ); ?>
			</div>
		<?php endif; ?>	
	<form action="" id="register-form" method="post">
		<div class="king-form-group">
			<input tabindex="1" type="text" id="user_login" class="bpinput" name="user_login" placeholder="<?php esc_html_e( 'Username', 'king' ); ?>" value="<?php echo isset( $register_userdata['user_login'] ) ? $register_userdata['user_login'] : ''; ?>" maxlength="50" />
			<?php if ( isset( $king_register_errors['user_login'] ) ) { ?>
			<div class="king-error"><?php echo esc_attr( $king_register_errors['user_login'] ); ?></div>
			<?php } ?>
		</div>
		<div class="king-form-group">
			<input tabindex="2" type="email" id="user_email" class="bpinput" name="user_email" placeholder="<?php esc_html_e( 'Email', 'king' ); ?>" value="<?php echo isset( $register_userdata['user_email'] ) ? $register_userdata['user_email'] : ''; ?>" maxlength="80" />
			<?php if ( isset( $king_register_errors['user_email'] ) ) { ?>
			<div class="king-error"><?php echo esc_attr( $king_register_errors['user_email'] ); ?></div>
			<?php } ?>
		</div>

		<div class="king-form-group">
			<input id="user_pass" class="bpinput" type="password" placeholder="<?php esc_html_e( 'Password', 'king' ); ?>" tabindex="30" size="25" value="" name="user_pass" maxlength="50" />
			<?php if ( isset( $king_register_errors['user_pass'] ) ) { ?>
			<div class="king-error"><?php echo esc_attr( $king_register_errors['user_pass'] ); ?></div>
			<?php } ?>
		</div>
		<div class="king-form-group">
			<input id="confirm_pass" class="bpinput" type="password" tabindex="40" size="25" placeholder="<?php esc_html_e( 'Repeat password', 'king' ); ?>" value="" name="confirm_pass" maxlength="50" />
			<?php if ( isset( $king_register_errors['confirm_pass'] ) ) { ?>
			<div class="king-error"><?php echo esc_attr( $king_register_errors['confirm_pass'] ); ?></div>
			<?php } ?>

		</div>
		<?php if ( get_field( 'enable_age_verification', 'options' ) ) : ?>	
			<div class="king-form-group">
				<input id="confirm_age" class="bpinput" type="date" tabindex="40" size="4" placeholder="<?php esc_html_e( 'Age', 'king' ); ?>" value="" name="confirm_age" maxlength="4" />
				<?php if ( isset( $king_register_errors['confirm_age'] ) ) { ?>
				<div class="king-error"><?php echo esc_attr( $king_register_errors['confirm_age'] ); ?></div>
				<?php } ?>
			</div>
		<?php endif; ?>		
		<?php if ( get_field( 'enable_terms_and_conditions', 'options' ) ) : ?>	
			<div class="king-form-group">
				<input type="checkbox" name="checkboxagree" id="checkboxagree" />
				<label for="checkboxagree"><?php esc_html_e( 'I accept', 'king' ); ?></label><span class="open-terms" data-toggle="dropdown" data-target=".terms-cond" aria-expanded="false"><?php esc_html_e( ' terms and conditions', 'king' ); ?> </span>
				<?php if ( isset( $king_register_errors['agree'] ) ) { ?>
				<div class="king-error"><?php echo esc_attr( $king_register_errors['agree'] ); ?></div>
				<?php } ?>
				<div class="terms-cond"> <?php the_field( 'terms_and_conditions', 'options' ); ?> </div>
			</div>
		<?php endif; ?>	
		<?php if ( get_field( 'enable_recaptcha', 'options' ) ) : ?>
			<div class="king-form-group">
				<div class="g-recaptcha" data-sitekey="<?php the_field( 'recaptcha_key', 'options' ); ?>"></div>
				<?php if ( isset( $king_register_errors['recaptcha'] ) ) { ?>
				<div class="king-error"><?php echo esc_attr( $king_register_errors['recaptcha'] ); ?></div>
				<?php } ?>		
				<?php if ( isset( $king_register_errors['recaptcha_failed'] ) ) { ?>
				<div class="king-error"><?php echo esc_attr( $king_register_errors['recaptcha_failed'] ); ?></div>
				<?php } ?>	
			</div>		
		<?php endif; ?>				
		<div class="king-form-group bwrap">
			<?php wp_nonce_field( 'king_register_form', 'king_register_form_nonce' ); ?>
			<input type="submit" class="king-submit-button" data-loading-text="<?php esc_html_e( 'Loading...', 'king' ); ?>" value="<?php esc_html_e( 'Register', 'king' ); ?>" id="king-submitbutton" name="register" />
		</div>

	</form>
		<div class="login-rl">
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" class="login-register"><i class="fa fa-user" aria-hidden="true"></i><?php esc_html_e( ' Login ', 'king' ); ?></a>
		</div>	
		<?php get_template_part( 'template-parts/pages/social-login' ); ?>
	<?php endif; ?>
	</main><!-- #main -->
<?php if ( get_field( 'enable_homepage_login', 'options' ) ) : ?>
</div>
<?php endif; ?>
</div><!-- .main-column -->
<?php endif; ?>
<?php
if ( ! get_field( 'enable_homepage_login', 'options' ) ) :
	get_footer();
endif;
?>
