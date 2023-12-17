<?php
/**
 * User settings page.
 *
 * @package King
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide']     = 'hide';
$GLOBALS['settings'] = 'active';
global $king_submit_errors;
$this_user = wp_get_current_user();
if ( ! $this_user->ID ) {
	wp_die( esc_attr( 'You don not have permissions on this page.', 'king' ) );
}

/*
Update user information.
 */
if ( isset( $_POST['save-edit'] ) ) {
	$king_submit_errors = array();

	$king_about       = wp_strip_all_tags( sanitize_text_field( $_POST['edit-about'] ) );
	$king_firstname   = wp_strip_all_tags( sanitize_text_field( $_POST['firstname-edit'] ) );
	$king_lastname    = wp_strip_all_tags( sanitize_text_field( $_POST['lastname-edit'] ) );
	$king_facebook    = wp_strip_all_tags( sanitize_text_field( esc_url( wp_unslash( $_POST['facebook-edit'] ) ) ) ); // input var okay; sanitization okay.
	$king_twitter     = wp_strip_all_tags( sanitize_text_field( esc_url( wp_unslash( $_POST['twitter-edit'] ) ) ) ); // input var okay; sanitization okay.
	$king_insta       = wp_strip_all_tags( sanitize_text_field( esc_url( wp_unslash( $_POST['instagram-edit'] ) ) ) ); // input var okay; sanitization okay.
	$king_pin         = wp_strip_all_tags( sanitize_text_field( esc_url( wp_unslash( $_POST['pinterest-edit'] ) ) ) ); // input var okay; sanitization okay.
	$king_linkedin    = wp_strip_all_tags( sanitize_text_field( esc_url( wp_unslash( $_POST['linkedin-edit'] ) ) ) ); // input var okay; sanitization okay.
	$king_customurl   = wp_strip_all_tags( sanitize_text_field( esc_url( wp_unslash( $_POST['customurl-edit'] ) ) ) ); // input var okay; sanitization okay.
	$email            = sanitize_email( $_POST['email-edit'] );
	$password         = esc_attr( $_POST['password-edit'] );
	$confirm_password = esc_attr( $_POST['confirm-pass'] );

	if ( ! empty( $password ) ) {
		if ( ( strlen( $password ) < 6 ) || ( strlen( $password ) > 40 ) ) {
			$king_submit_errors['user_pass'] = esc_html__( 'Sorry, password must be 6 characters or more.', 'king' );
		} elseif ( $password !== $confirm_password ) {
			$king_submit_errors['confirm_pass'] = esc_html__( 'Password and repeat password fields must match.', 'king' );
		} else {
			wp_update_user( array( 'ID' => $this_user->ID, 'user_pass' => $password ) );
		}
	}

	if ( isset( $king_about ) && ( strlen( $king_about ) < 1000 ) ) {
		wp_update_user( array( 'ID' => $this_user->ID, 'description' => $king_about ) );
	}
	if ( isset( $king_firstname ) && ( strlen( $king_firstname ) < 140 ) && ! empty( $king_firstname ) ) {
		wp_update_user( array( 'ID' => $this_user->ID, 'first_name' => $king_firstname ) );
	}
	if ( isset( $king_lastname ) && ( strlen( $king_lastname ) < 140 ) && ! empty( $king_lastname ) ) {
		wp_update_user( array( 'ID' => $this_user->ID, 'last_name' => $king_lastname ) );
	}

	if ( isset( $king_facebook ) && ( strlen( $king_facebook ) < 140 ) ) {
		update_user_meta( $this_user->ID, '_profile_facebook', 'field_587be5f411824' );
		update_user_meta( $this_user->ID, 'profile_facebook', $king_facebook );
	}

	if ( isset( $king_twitter ) && ( strlen( $king_twitter ) < 140 ) ) {
		update_user_meta( $this_user->ID, '_profile_twitter', 'field_587be62b11825' );
		update_user_meta( $this_user->ID, 'profile_twitter', $king_twitter );
	}


	if ( isset( $king_pin ) && ( strlen( $king_pin ) < 140 ) ) {
		update_user_meta( $this_user->ID, '_profile_pinterest', 'field_5b5f73c17030f' );
		update_user_meta( $this_user->ID, 'profile_pinterest', $king_pin );
	}

	if ( isset( $king_insta ) && ( strlen( $king_insta ) < 140 ) ) {
		update_user_meta( $this_user->ID, '_profile_instagram', 'field_5b5f73a37030e' );
		update_user_meta( $this_user->ID, 'profile_instagram', $king_insta );
	}

	if ( isset( $king_linkedin ) && ( strlen( $king_linkedin ) < 140 ) ) {
		update_user_meta( $this_user->ID, '_profile_linkedin', 'field_587be65111826' );
		update_user_meta( $this_user->ID, 'profile_linkedin', $king_linkedin );
	}

	if ( isset( $king_customurl ) && ( strlen( $king_customurl ) < 140 ) ) {
		update_user_meta( $this_user->ID, '_profile_add_url', 'field_5a132d05c424b' );
		update_user_meta( $this_user->ID, 'profile_add_url', $king_customurl );
	}

	if ( $email ) { // input var okay; sanitization okay.
		$some_user = get_user_by( 'email', $email );
		if ( $some_user && ( $some_user->ID !== $this_user->ID ) ) {
			$king_submit_errors['confirm_email'] = esc_html__( 'This e-mail is already in use, please use another one.', 'king' );
		} else {
			wp_update_user( array( 'ID' => $this_user->ID, 'user_email' => $email ) );
		}
	}

	if ( empty( $king_submit_errors ) ) {
		do_action( 'acf/save_post' , 'user_'.$this_user->ID );
		wp_safe_redirect( site_url() . '/' . $GLOBALS['king_account'] );
		die( esc_html__( 'Saving Data', 'king' ) );
	}
}
/*Update User*/
acf_form_head();
?>
<?php get_header(); ?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<?php get_template_part( 'template-parts/king-profile-header' ); ?>

<div id="primary" class="page-content-area">
	<main id="main" class="page-site-main">
		<div class="edit-dialog">
			<h5 class="dialog-title"><span><?php esc_attr_e( 'Edit Profile', 'king' ); ?></span></h5>
			<form action="" class="edit-profile" method="post" enctype="multipart/form-data" autocomplete="off">

				<div class="king-form-group">
					<label for="name-edit"><?php esc_attr_e( 'Username', 'king' ); ?></label>
					<input type="text" id="name-edit" class="bpinput" name="name-edit" readonly="readonly" value="<?php the_author_meta( 'user_login',$this_user->ID ); ?>">
			</div>

			<div class="king-form-group">
					<label for="password-edit"><?php esc_attr_e( 'Password', 'king' ); ?></label>
					<input type="password" id="password-edit" class="bpinput" placeholder="<?php esc_attr_e( 'Password', 'king' ); ?>" name="password-edit" autocomplete="off" maxlength="50" >
			</div>
			<?php if ( isset( $king_submit_errors['user_pass'] ) ) { ?>
			<div class="king-error"><?php echo esc_attr( $king_submit_errors['user_pass'] ); ?></div>
			<?php } ?>

			<div class="king-form-group">
				<label for="password-edit"><?php esc_attr_e( 'Repeat password', 'king' ); ?></label>
				<input id="confirm_pass" class="bpinput" type="password" placeholder="<?php esc_attr_e( 'Repeat password', 'king' ); ?>" value="" name="confirm-pass" autocomplete="off" maxlength="50" >
		</div>
		<?php if ( isset( $king_submit_errors['confirm_pass'] ) ) { ?>
		<div class="king-error"><?php echo esc_attr( $king_submit_errors['confirm_pass'] ); ?></div>
		<?php } ?>

		<div class="king-form-group">
			<label for="email-edit"><?php esc_attr_e( 'Email', 'king' ); ?></label>
			<input type="email" id="email-edit" class="bpinput" name="email-edit" placeholder="<?php the_author_meta( 'user_email', $this_user->ID ); ?>" maxlength="140">
	</div>
	<?php if ( isset( $king_submit_errors['confirm_email'] ) ) { ?>
	<div class="king-error"><?php echo esc_attr( $king_submit_errors['confirm_email'] ); ?></div>
	<?php } ?>

	<div class="king-form-group">
		<label for="firstname-edit"><?php esc_attr_e( 'First Name', 'king' ); ?></label>
		<input type="text" id="firstname-edit" class="bpinput" name="firstname-edit" placeholder="<?php the_author_meta( 'first_name',$this_user->ID ); ?>" maxlength="140">
</div>

<div class="king-form-group">
		<label for="lastname-edit"><?php esc_attr_e( 'Last Name', 'king' ); ?></label>
		<input type="text" id="lastname-edit" class="bpinput" name="lastname-edit" placeholder="<?php the_author_meta( 'last_name', $this_user->ID ); ?>" maxlength="140">
</div>

<div class="king-form-group">

		<?php
		acf_form(array(
			'post_id' => 'user_' . $this_user->ID,
			'form' => false,
			'return' => '',
			'uploader' => false,
			'instruction_placement' => 'title',
			'fields' => array('field_587be48552f9f', 'field_587be575569ec')
		));
		?>
</div>


<div class="king-form-group">
		<label for="facebook-edit"><?php esc_attr_e( 'facebook', 'king' ); ?></label>
		<input type="text" id="facebook-edit" class="bpinput" name="facebook-edit" value="<?php the_field( 'profile_facebook', 'user_' . $this_user->ID ); ?>" maxlength="140">
</div>

<div class="king-form-group">
		<label for="twitter-edit"><?php esc_attr_e( 'twitter', 'king' ); ?></label>
		<input type="text" id="twitter-edit" class="bpinput" name="twitter-edit" value="<?php the_field( 'profile_twitter', 'user_' . $this_user->ID ); ?>" maxlength="140">
</div>

<div class="king-form-group">
		<label for="instagram-edit"><?php esc_attr_e( 'instagram', 'king' ); ?></label>
		<input type="text" id="instagram-edit" class="bpinput" name="instagram-edit" value="<?php the_field( 'profile_instagram', 'user_' . $this_user->ID ); ?>" maxlength="140">
</div>

<div class="king-form-group">
		<label for="pinterest-edit"><?php esc_attr_e( 'pinterest', 'king' ); ?></label>
		<input type="text" id="pinterest-edit" class="bpinput" name="pinterest-edit" value="<?php the_field( 'profile_pinterest', 'user_' . $this_user->ID ); ?>" maxlength="140">
</div>

<div class="king-form-group">
		<label for="linkedin-edit"><?php esc_attr_e( 'linkedin', 'king' ); ?></label>
		<input type="text" id="linkedin-edit" class="bpinput" name="linkedin-edit" value="<?php the_field( 'profile_linkedin', 'user_' . $this_user->ID ); ?>" maxlength="140">
</div>
<div class="king-form-group">
		<label for="customurl-edit"><?php esc_attr_e( 'Url', 'king' ); ?></label>
		<input type="text" id="customurl-edit" class="bpinput" name="customurl-edit" value="<?php the_field( 'profile_add_url', 'user_' . $this_user->ID ); ?>" maxlength="140">
</div>

<div class="king-form-group">
		<label for="edit-about"><?php esc_attr_e( 'About', 'king' ); ?></label>
		<textarea name="edit-about" id="edit-about" class="bptextarea" rows="4" cols="50" maxlength="1000"><?php the_author_meta( 'description', $this_user->ID ); ?></textarea>
</div>
<p>
		<input type="submit" id="king-submitbutton" class="king-submit-button" name="save-edit" value="Save">
</p>
</form>
</div>
</main>
</div>
<?php wp_enqueue_media(); ?>
<?php get_footer(); ?>
