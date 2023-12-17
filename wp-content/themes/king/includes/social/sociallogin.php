<?php
/**
 * GooglePlus login oauth.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function king_authenticate_user($provider) {

	if ( is_user_logged_in() ) {
		return;
	}

	require_once KING_INCLUDES_PATH . 'social/hybridauth/autoload.php';
	require_once KING_INCLUDES_PATH . 'social/hybridauth/Hybridauth.php';

	$user_profile = false;
	$provider = ucwords($provider);

	if ( 'Google' === $provider && get_field( 'enable_googleplus_login', 'option' ) ) {
		$keysid    = get_field( 'googleplus_client_id', 'option' );
		$keysecret = get_field( 'googleplus_client_secret', 'option' );
	} elseif ( 'Facebook' === $provider && get_field( 'enable_facebook_login', 'option' ) ) {
		$keysid    = get_field( 'facebook_app_id', 'option' );
		$keysecret = get_field( 'facebook_secret_key', 'option' );
	} elseif ( 'Instagram' === $provider && get_field( 'enable_instagram_login', 'option' ) ) {
		$keysid    = get_field( 'instagram_app_id', 'option' );
		$keysecret = get_field( 'instagram_app_secret', 'option' );
	} elseif ( 'Twitter' === $provider && get_field( 'enable_twitter_login', 'option' ) ) {
		$keysid    = get_field( 'twitter_app_id', 'option' );
		$keysecret = get_field( 'twitter_app_secret', 'option' );
	} elseif ( 'Reddit' === $provider && get_field( 'enable_reddit_login', 'option' ) ) {
		$keysid    = get_field( 'reddit_app_id', 'option' );
		$keysecret = get_field( 'reddit_app_secret', 'option' );
	} elseif ( 'Vkontakte' === $provider && get_field( 'enable_vkontakte_login', 'option' ) ) {
		$keysid    = get_field( 'vkontakte_app_id', 'option' );
		$keysecret = get_field( 'vkontakte_app_secret', 'option' );
	} else {
		header( 'Location: ' . get_site_url() );
		die();
	}



	$config = [
		'callback' => esc_url( site_url() . '/' . $GLOBALS['king_login'] . '/' . $provider ),
		'keys' => ['id' => $keysid, 'secret' => $keysecret],
	];

	try {

		$class   = "Hybridauth\\Provider\\$provider";
		$adapter = new $class( $config );
		$adapter->authenticate();

		if ( $adapter->isConnected() ) {

			$user_profile = $adapter->getUserProfile();
			$adapter->disconnect();

			$error = '';
			$email = $user_profile->email;
			$uid   = $user_profile->identifier;
			$user_id = king_check_user( $provider, $uid, $email );
			if ( $user_id ) {
				king_log_in_user( $user_id );
			} else {

				if ( ! get_option( 'users_can_register' ) ) {
					header( 'Location: ' . get_site_url() );
					die();
				}

				$user_id = king_create_user( $provider, $user_profile );

				if ( ! is_wp_error( $user_id ) ) {
					if ( get_field( 'enable_user_groups', 'option' ) ) :
						$field_key = 'field_5e865379a58e8';
						if ( have_rows( 'user_groups', 'option' ) ) {
							while ( have_rows( 'user_groups', 'option' ) ) {
								the_row();
								$chek = get_sub_field( 'default_group_for_new_users' );
								if ( $chek ) {
									$post_users = get_sub_field( 'group_users' );
									array_push( $post_users, $user_id );
									update_sub_field( $field_key, $post_users, 'option' );

								}
							}
						}
					endif;
					king_log_in_user( $user_id );
				} else {
					header( 'Location: ' . get_site_url() );
					die();
				}
			}

		} else {
			throw new Exception( 'Authentication failed. User is not connected' );
		}
	} catch (\Exception $e) {
		echo $e->getMessage();
	}
}




function king_create_user( $provider, $user_profile ) {
	$display_name = king_get_user_display_name( $user_profile );
	$login        = king_get_user_unique_login( $user_profile );
	$email        = king_get_user_email( $user_profile );

	if ( empty( $login ) ) {
		$login = $user_profile->identifier;
	}

	if ( empty( $email ) || email_exists( $email ) ) {
		$email = sprintf( '%s@fake-%s.com', $login, $provider );
	}

	$userdata = array(
		'user_login'   => $login,
		'user_email'   => $email,
		'display_name' => $display_name,
		'user_pass'    => wp_generate_password(),
		'first_name'   => $user_profile->firstName,
		'last_name'    => $user_profile->lastName,
		'role'         => 'author',
	);

	$user_id = wp_insert_user( $userdata );
	$fb_avatar = $user_profile->photoURL;
	if ( ! empty( $fb_avatar ) ) {
		$avatar_id = king_upload_facebook_user_avatar( $fb_avatar , $user_id );
					// set as profile picture.
		update_user_meta( $user_id,'_author_image','field_587be48552f9f' );
		update_user_meta( $user_id,'author_image',$avatar_id );
	}
	update_user_meta( $user_id, 'king_login_' . $provider, $user_profile->identifier );
	if ( is_wp_error( $user_id ) ) {
		return $user_id;
	}

	return $user_id;
}
function king_get_user_unique_login( $user_profile ) {
	static $i;

			// Sanitize user login.
	$login = preg_replace( '/\s+/', '', sanitize_user( $user_profile->displayName, true ) );
	$login = strtolower( $login );
	if ( empty( $login ) ) {
		return false;
	}
	if ( $i ) {
		$login .= '-' . $i;
	}

	if ( ! username_exists( $login ) ) {
		$i = null;

		return $login;
	} else {
		$i++;

		return king_get_user_unique_login( $user_profile );
	}
}
function king_get_user_email( $user_profile ) {

	if ( ! empty( $user_profile->email ) && is_email( $user_profile->email ) ) {
		return $user_profile->email;
	}

	return false;
}
function king_get_user_display_name( $user_profile ) {
	if ( ! empty( $user_profile->displayName ) ) {
		return $user_profile->displayName;
	}

	$display_name = '';

	if ( ! empty( $user_profile->firstName ) ) {
		$display_name .= $user_profile->firstName;
	}

	if ( ! empty( $user_profile->lastName ) ) {
		$display_name .= ' ' . $user_profile->lastName;
	}

	return $display_name;
}
function king_upload_facebook_user_avatar( $fb_avatar, $user_id ) {
	// Need to require these files.
	if ( ! function_exists( 'media_handle_upload' ) ) {
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
	}

	$tmp = download_url( $fb_avatar );

	if ( is_wp_error( $tmp ) ) {
		@unlink( $file_array['tmp_name'] );
		$file_array['tmp_name'] = '';
		return $tmp;
	}

	$post_id = 0;
	$desc = 'avatarimg_user' . $user_id;
	$file_array = array();

	preg_match( '/[^\?]+\.(jpg|jpeg|gif|png)/i', $fb_avatar, $matches );

	$name = basename( $matches[0] );
	$url_type = wp_check_filetype( $name );

	$newfilename = 'avatarimg_user' . $user_id . '.jpg';
	$file_array['tmp_name'] = $tmp;
	$file_array['name'] = $newfilename;
	// do the validation and storage stuff.
	$id = media_handle_sideload( $file_array, $post_id, $desc );

	// If error storing permanently, unlink.
	if ( is_wp_error( $id ) ) {
		@unlink( $file_array['tmp_name'] );
		return $id;
	}
	return $id;
}

function king_log_in_user( $user_id, $redirection_url = '' ) {
	$user = get_user_by( 'id', $user_id );
	$secure_cookie = is_ssl();
	wp_set_auth_cookie( $user_id, true, $secure_cookie );
	do_action( 'wp_login', $user->user_login, $user );

	if ( empty( $redirection_url ) ) {

		$redirection_url = get_home_url();

	}
	wp_safe_redirect( $redirection_url );
	exit;
}

function king_check_user( $provider, $uid, $email ) {
	$user_id = false;
	if ( ! empty( $email ) ) {
		$em = email_exists( $email );

		if ( $em ) {
			$cmt = get_user_meta( $em, 'king_login_' . $provider, true );
			if ( $cmt === $uid ) {
				$user_id = $em;
			} else {
				$user_id = false;
			}
		}
	} 

	if ( ! $user_id ) {
		$users = get_users(
			array(
				'number' => 1,
				'fields' => 'ID',
				'meta_query' => array(
					array(
						'key'   => 'king_login_' . $provider,
						'value' => $uid,
					)
				)
			)
		);

		if ( ! empty( $users ) ) {
			$user_id = $users[0];
		}
	}
	return $user_id;
}