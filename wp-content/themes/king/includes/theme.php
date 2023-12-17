<?php
/**
 * Theme options.
 *
 * @package King.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( get_option( 'permalink_structure' ) ) :
	if ( king_plugin_active( 'ACF' ) && ! get_field( 'enable_wp_login', 'options' ) ) :
		/**
		 * Redirect logged in users to the right page
		 */
		function king_template_redirect() {
			if ( is_page( 'login' ) && is_user_logged_in() ) {
				wp_redirect( home_url( '/profile/' ) );
				exit();
			}
			if ( is_page( 'user' ) && ! is_user_logged_in() ) {
				wp_redirect( home_url( '/login/' ) );
				exit();
			}
		}
		add_action( 'template_redirect', 'king_template_redirect' );

		/**
		 * Login page redirect.
		 *
		 * @param <type> $redirect_to The redirect to.
		 * @param <type> $url The url.
		 * @param <type> $user The user.
		 *
		 * @return <type>  ( description_of_the_return_value ).
		 */
		function king_login_redirect( $redirect_to, $url, $user ) {
			if ( ! isset( $user->errors ) ) {
				return $redirect_to;
			}
			wp_safe_redirect( home_url( '/login/' ) . '?action=login&failed=1' );
			exit;
		}
		add_filter( 'login_redirect', 'king_login_redirect', 10, 3 );

		/**
		 * Registration page redirect
		 */
		function king_registration_redirect() {
			// don't lose your time with spammers, redirect them to a success page.
			wp_safe_redirect( home_url( '/register/' ) );
			exit;
		}
		add_filter( 'registration_redirect', 'king_registration_redirect', 10, 3 );
	endif;
	/**
	 * Password Reset Validate
	 */
	function king_validate_reset() {
		if ( isset( $_POST['user_login'] ) && ! empty( $_POST['user_login'] ) ) {
			$email_address = $_POST['user_login'];
			if ( filter_var( $email_address, FILTER_VALIDATE_EMAIL ) ) {
				if ( ! email_exists( $email_address ) ) {
					wp_redirect( 'reset/?action=userexist' );
					exit;
				}
			} else {
				$username = $_POST['user_login'];
				if ( ! username_exists( $username ) ) {
					wp_redirect( 'reset/?action=userexist' );
					exit;
				}
			}
		} else {
			wp_redirect( 'reset/?action=userexist' );
			exit;
		}
	}
	add_action( 'lostpassword_post', 'king_validate_reset', 99, 3 );

	/**
	 * Hide admin panel for users.
	 */
	function king_blockusers_init() {
		if ( is_admin() && ! current_user_can( 'administrator' ) && ! current_user_can( 'editor' ) && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
			wp_redirect( home_url() );
			exit;
		}
	}
	add_action( 'admin_init', 'king_blockusers_init' );

endif;
/**
 * Disable authors see all images
 *
 * @param where $where where.
 *
 * @return mixed
 */
function king_wpquery_where( $where ) {
	global $current_user;

	if ( is_user_logged_in() ) {
		// logged in user, but are we viewing the library?
		if ( isset( $_POST['action'] ) && ( $_POST['action'] === 'query-attachments' ) ) { // input var okay; sanitization okay
			$where .= ' AND post_author=' . $current_user->data->ID;
		}
	}

	return $where;
}
add_filter( 'posts_where', 'king_wpquery_where' );

if ( ! function_exists( 'king_favorite_button' ) ) :
	/**
	 * Favorite button.
	 *
	 * @param      <type>  $post_id  The post identifier
	 *
	 * @return     string  ( description_of_the_return_value )
	 */
	function king_favorite_button( $post_id ) {
		$user_id   = get_current_user_id();
		$bookmarks = get_user_meta( $user_id, 'king_favorites', true );
		$nonce     = wp_create_nonce( 'king-favorite-nonce' );
		$i     = 'far';
		$class = '';
		if ( is_array( $bookmarks ) && in_array( $post_id, $bookmarks ) ) {
			$i = 'fas';
			$class = ' added';
		}
		if ( is_user_logged_in() ) {
			$output = '<div class="king-like' . esc_attr( $class ) . '"  data-toggle="tooltip" data-placement="bottom" title="' . esc_html__( 'Add Favorites', 'king' ) . '"  data-id="' . esc_attr( $post_id ) . '" data-nonce="' . esc_attr( $nonce ) . '" >
			<i class="' . esc_attr( $i ) . ' fa-heart"></i>
			</div>';
		} else {
			$output = '<div class="king-like" data-toggle="dropdown" data-target=".king-alert-like" aria-expanded="false" role="link"><i class="far fa-heart"></i></div>';
		}
		return $output;
	}
endif;
if ( ! function_exists( 'king_favorite_ajax' ) ) :
	/**
	 * Favorite button ajax.
	 */
	function king_favorite_ajax() {
		$userid           = get_current_user_id();
		$postid           = sanitize_text_field( wp_unslash( $_POST['id'] ) );
		$nonce            = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );

		if ( ! wp_verify_nonce( $nonce, 'king-favorite-nonce' ) ) {
			die( '-1' );
		} elseif ( ! is_user_logged_in() ) {
			die( '-1' );
		} elseif ( empty( $postid ) ) {
			die( '-1' );
		}

		$post_likes = get_user_meta( $userid, 'king_favorites' );
		$post_users = $post_likes[0];
		if ( is_array( $post_users ) && in_array( $postid, $post_users ) ) {
			$post_users = check_array( $postid, $post_likes );
			if ( $post_users ) {
				$uid_key = array_search( $postid, $post_users );
				unset( $post_users[ $uid_key ] );
				update_user_meta( $userid, 'king_favorites', $post_users );
			}
		} else {
			$post_users = check_array( $postid, $post_likes );

			update_user_meta( $userid, 'king_favorites', $post_users );

			echo '1';
		}

		die();
	}
	add_action( 'wp_ajax_nopriv_king_favorite_ajax', 'king_favorite_ajax' );
	add_action( 'wp_ajax_king_favorite_ajax', 'king_favorite_ajax' );
endif;
if ( ! function_exists( 'king_sl_format_count' ) ) :
	/**
	 * Number format.
	 *
	 * @param      int   $number  The number
	 *
	 * @return     int   ( description_of_the_return_value )
	 */
	function king_sl_format_count( $number ) {
		$precision = 2;
		if ( $number >= 1000 && $number < 1000000 ) {
			$formatted = number_format( $number / 1000, $precision ) . 'K';
		} elseif ( $number >= 1000000 && $number < 1000000000 ) {
			$formatted = number_format( $number / 1000000, $precision ) . 'M';
		} elseif ( $number >= 1000000000 ) {
			$formatted = number_format( $number / 1000000000, $precision ) . 'B';
		} else {
			$formatted = $number; // Number is less than 1000.
		}
		$formatted = str_replace( '.00', '', $formatted );
		return $formatted;
	} // king_sl_format_count.
endif;

if ( ! function_exists( 'king_postviews' ) ) :
	/**
	 * Display or Count how many times a post has been viewed.
	 *
	 * @param <type> $id The identifier.
	 * @param <type> $action The action.
	 */
	function king_postviews( $id, $action ) {
		$kingcountmeta = '_post_views';
		$kingcount     = get_post_meta( $id, $kingcountmeta, true );
		if ( '' === $kingcount ) {
			if ( 'count' === $action ) {
				$kingcount = 0;
			}
			delete_post_meta( $id, $kingcountmeta );
			add_post_meta( $id, $kingcountmeta, 0 );
			if ( 'display' === $action ) {
				echo '0';
			}
		} else {
			if ( 'count' === $action ) {
				$kingcount++;
				update_post_meta( $id, $kingcountmeta, $kingcount );
			} else {
				if ( $kingcount > 999 ) {
					$postwiews = round( $kingcount / 1000 ) . 'k';
				} else {
					$postwiews = $kingcount;
				}
				echo esc_attr( $postwiews . '' );
			}
		}
	}
endif;
/**
 * Custom comment box
 *
 */
if ( ! function_exists( 'king_comment' ) ) :
	function king_comment( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment ) :
			case 'pingback':
			case 'trackback':
				// Display trackbacks differently than normal comments.
			?>
			<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
				<p><?php esc_html_e( 'Pingback:', 'king' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( esc_html__( '(Edit)', 'king' ), '<span class="edit-link">', '</span>' ); ?></p>
				<?php
				break;
			default:
				global $post;
				?>
				<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
					<article id="comment-<?php comment_ID(); ?>" class="comment comment-box">

						<div class="comment-meta comment-author">
							<div class="avatar-wrap">
								<?php
									$id = $comment->user_id;
									$vclass = get_field( 'verified_account', 'user_' . $id ) ? ' verified' : '';
									$vbadge = get_field( 'verified_account', 'user_' . $id ) ? '<i class="fa fa-check-circle fa-2x verified_account" title="' . esc_html__( 'verified account', 'king' ) . '" aria-hidden="true"></i>' : '';
								
								if ( get_field( 'author_image', 'user_' . $id ) ) :
									$image = get_field( 'author_image', 'user_' . $id );
									?>
									<img class="user-comment-avatar<?php echo esc_attr( $vclass ); ?>" src="<?php  echo esc_url( $image['sizes']['thumbnail'] ); ?>"/>
									<?php else : ?>
										<span class="user-comment-noavatar<?php echo esc_attr( $vclass ); ?>" ><?php echo get_avatar( $comment, '60' ); ?></span>
									<?php endif; ?>
								</div>
								<span class="author-date">
									<?php if ( $comment->user_id ) : ?>
										<?php if ( get_option( 'permalink_structure' ) ) : ?>
											<?php $user_info = get_userdata( $id ); $cusernanme = $user_info->user_login; ?>
											<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $cusernanme ) ?>" class="user-header-settings">
										<?php endif; ?>
											<?php echo esc_attr( $user_info->display_name ); ?>

											<?php if ( get_option( 'permalink_structure' ) ) : ?>
											</a>
										<?php endif; ?>
											<?php echo wp_kses_post( $vbadge ); ?>
										<?php else : ?>
											<?php
											printf( '<cite class="fn">%1$s</cite> ', get_comment_author_link() );
											?>
										<?php endif; ?>
										<?php
										printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
											esc_url( get_comment_link( $comment->comment_ID ) ),
											get_comment_time( 'c' ),
											/* translators */
											sprintf( esc_attr( '%1$s  ', 'king' ), get_comment_date(), get_comment_time() )
										); ?>
									</span>
								</div><!-- .comment-meta -->
								<div class="comment-content">
									<?php if ( '0' === $comment->comment_approved ) : ?>
										<p class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'king' ); ?></p>
									<?php endif; ?>
									<?php comment_text(); ?>
								</div><!-- .comment-content -->
								<div class="comment-footer">
									<?php
									$field = get_field( 'comments_reactions', $comment );
									$value = isset( $field ) ? king_rtexts($field) : '';
									if ( $value ) :
										
										?>
										<?php if ( get_field( 'enable_reactions', 'option' ) ) : ?>
											<div class="king-reactions-comment">
												<span class="king-reaction-<?php echo esc_attr( $field ); ?>" title="<?php echo esc_attr( $field ); ?>"></span>
											</div>
										<?php endif; ?>
									<?php endif; ?>
									<?php comment_reply_link( array_merge( $args, array( 'reply_text' => esc_html__( 'Reply', 'king' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
									<?php
									if ( get_field( 'enable_flags_for_comments', 'options' ) && is_user_logged_in() ) :
										echo king_flag_button( $comment->comment_ID, 'c' );
									endif;
									?>
									<?php if ( is_super_admin() ) : ?>
										<section class="comment-edit">
											<?php
											edit_comment_link( '<i class="fas fa-pen-square"></i>' ); ?>
										</section><!-- .comment-edit -->
									<?php endif; ?>
									<?php
									if ( ! get_field( 'disable_comment_votes', 'options' ) && king_plugin_active( 'ACF' ) ) :
										$down = get_field( 'disable_down_vote_in_comments', 'options' ) ? true : false;
										echo king_vote( $comment->comment_ID, 'c', $down );
									endif;
									?>
								</div><!-- .comment-footer -->
							</article><!-- #comment-## -->
							<?php
							break;
							case 'comment':
	endswitch;
}
endif;

if ( ! function_exists( 'king_rtexts' ) ) :
	function king_rtexts( $value ) {
		if ( 'like' === $value && get_field( '1st_reaction_text', 'option' ) ) {
			$value = get_field( '1st_reaction_text', 'option' );
		} elseif ( 'love' === $value && get_field( '2nd_reaction_text', 'option' ) ) {
			$value = get_field( '2nd_reaction_text', 'option' );
		} elseif ( 'haha' === $value && get_field( '3rd_reaction_text', 'option' ) ) {
			$value = get_field( '3rd_reaction_text', 'option' );
		} elseif ( 'wow' === $value && get_field( '4th_reaction_text', 'option' ) ) {
			$value = get_field( '4th_reaction_text', 'option' );
		} elseif ( 'sad' === $value && get_field( '5th_reaction_text', 'option' ) ) {
			$value = get_field( '5th_reaction_text', 'option' );
		} elseif ( 'angry' === $value && get_field( '6th_reaction_text', 'option' ) ) {
			$value = get_field( '6th_reaction_text', 'option' );
		}
		return $value;
	}
endif;
/**
 * Processes follow/unfollow
 * @since    0.5
 */
add_action( 'wp_ajax_nopriv_king_process_simple_follow', 'king_process_simple_follow' );
add_action( 'wp_ajax_king_process_simple_follow', 'king_process_simple_follow' );
function king_process_simple_follow() {
	$nonce = isset( $_REQUEST['nonce'] ) ? sanitize_text_field( $_REQUEST['nonce'] ) : 0;
	if ( ! wp_verify_nonce( $nonce, 'simple-follows-nonce' ) ) {
		exit( esc_attr( 'Not permitted', 'king' ) );
	}
	$disabled     = ( isset( $_REQUEST['disabled'] ) && $_REQUEST['disabled'] === true ) ? true : false;
	$post_id      = ( isset( $_REQUEST['post_id'] ) && is_numeric( $_REQUEST['post_id'] ) ) ? $_REQUEST['post_id'] : '';
	$result       = array();
	$post_users   = null;
	$follow_count = 0;
	// Get plugin options.
	if ( '' !== $post_id ) {
		$count = get_user_meta( $post_id, 'wp__post_follow_count', true );
		$count = ( isset( $count ) && is_numeric( $count ) ) ? $count : 0;
		if ( ! king_already_followd( $post_id ) ) {
			if ( is_user_logged_in() ) {
				$user_id           = get_current_user_id();
				$post_users        = king_post_user_follows( $user_id, $post_id );
				$user_follow_count = get_user_option( '_user_follow_count', $user_id );
				$user_follow_count = ( isset( $user_follow_count ) && is_numeric( $user_follow_count ) ) ? $user_follow_count : 0;
				update_user_meta( $user_id, 'wp__user_follow_count', ++$user_follow_count );
				if ( $post_users ) {
					update_user_meta( $post_id, 'wp__user_followd', $post_users );
					if ( get_field( 'enable_notification', 'options' ) )  {
						king_create_notify( $post_id, 'follow', 'f' );
					}
				}
			}
			$follow_count       = ++$count;
			$response['status'] = 'followd';
			$response['icon']   = king_get_unfollow_icon();
		} else {
			if ( is_user_logged_in() ) {
				$user_id           = get_current_user_id();
				$post_users        = king_post_user_follows( $user_id, $post_id );
				$user_follow_count = get_user_option( '_user_follow_count', $user_id );
				$user_follow_count = ( isset( $user_follow_count ) && is_numeric( $user_follow_count ) ) ? $user_follow_count : 0;
				if ( $user_follow_count > 0 ) {
					update_user_option( $user_id, '_user_follow_count', --$user_follow_count );
				}
				if ( $post_users ) {
					$uid_key = array_search( $user_id, $post_users );
					unset( $post_users[ $uid_key ] );
					update_user_meta( $post_id, 'wp__user_followd', $post_users );
					if ( get_field( 'enable_notification', 'options' ) ) {
						$knotify_comment = array('type' => 'follow', 'postid' => $post_id, 'who' => $user_id );
						delete_user_meta( $post_id, 'king_notify', $knotify_comment );
						$kncount = get_user_meta( $post_id, 'king_notify_count', true );
						if (empty($kncount) || $kncount == '') {
							$kncount = 0;
						} else {
							$kntotal = (int) $kncount - 1;
						}
						update_user_meta( $post_id, 'king_notify_count', $kntotal );
					}
				}
			}
			$follow_count       = ( $count > 0 ) ? --$count : 0;
			$response['status'] = 'unfollowd';
			$response['icon']   = king_get_followd_icon();
		}

		update_user_option( $post_id, '_post_follow_count', $follow_count );
		update_user_meta( $post_id, '_post_follow_modified', date( 'Y-m-d H:i:s' ) );

		$response['count'] = king_get_follow_count( $follow_count, $post_id );
		if ( true === $disabled ) {
			wp_redirect( get_permalink( $post_id ) );
			exit();

		} else {
			wp_send_json( $response );
		}
	}
}

/**
 * Utility to test if the post is already followd.
 *
 * @since 0.5
 */
function king_already_followd( $post_id ) {
	$post_users = null;
	$user_id    = null;
	if ( is_user_logged_in() ) { // user is logged in.
		$user_id         = get_current_user_id();
		$post_meta_users = get_user_meta( $post_id, 'wp__user_followd' );
		if ( count( $post_meta_users ) !== 0 ) {
			$post_users = $post_meta_users[0];
		}
	}
	if ( is_array( $post_users ) && in_array( $user_id, $post_users ) ) {
		return true;
	} else {
		return false;
	}
} // king_already_followd.

/**
 * Output the follow button.
 *
 * @since    0.5
 */
function king_get_simple_follows_button( $post_id ) {
	$output        = '';
	$nonce         = wp_create_nonce( 'simple-follows-nonce' );
	$post_id_class = esc_attr( ' follow-button-' . $post_id );
	$follow_count  = get_user_meta( $post_id, 'wp__post_follow_count', true );
	$follow_count  = ( isset( $follow_count ) && is_numeric( $follow_count ) ) ? $follow_count : 0;
	$count         = king_get_follow_count( $follow_count, $post_id );
	$icon_empty    = king_get_followd_icon();
	$icon_full     = king_get_unfollow_icon();
	$loader        = '<span id="follow-loader"></span>';
	if ( king_already_followd( $post_id ) ) {
		$class = esc_attr( ' followd' );
		$title = esc_html__( 'Unfollow', 'king' );
		$icon  = $icon_full;
	} else {
		$class = '';
		$title = esc_html__( 'follow', 'king' );
		$icon  = $icon_empty;
	}
	$output = '<div class="user-follow-button"><a href="' . admin_url( 'admin-ajax.php?action=king_process_simple_follow' . '&post_id=' . $post_id . '&nonce=' . $nonce . '&disabled=true' ) . '" class="follow-button' . $post_id_class . $class . '" data-nonce="' . $nonce . '" data-post-id="' . $post_id . '" title="' . $title . '">' . $icon . $count . '</a>' . $loader . '</div>';
	return $output;
} // king_get_simple_follows_button.


/**
 * Utility retrieves post meta user follows (user id array),
 * then adds new user id to retrieved array
 * @since    0.5
 */
function king_post_user_follows( $user_id, $post_id ) {
	$post_users = '';
	$post_meta_users = get_user_meta( $post_id, 'wp__user_followd' );
	if ( count( $post_meta_users ) !== 0 ) {
		$post_users = $post_meta_users[0];
	}
	if ( ! is_array( $post_users ) ) {
		$post_users = array();
	}
	if ( ! in_array( $user_id, $post_users ) ) {
		$post_users[ 'user-' . $user_id ] = $user_id;
	}
	return $post_users;
} // king_post_user_follows.

/**
 * Follow icon.
 *
 * @return string  ( description_of_the_return_value ).
 */
function king_get_followd_icon() {
	$icon = '<i class="fas fa-plus-circle"></i>';
	return $icon;
}

/**
 * Unfollow Icon.
 *
 * @return     string  ( description_of_the_return_value )
 */
function king_get_unfollow_icon() {
	$icon = '<i class="fas fa-times-circle"></i>';
	return $icon;
}

/**
 * Follow COunt.
 *
 * @param <type>  $follow_count  The follow count.
 * @param <type>  $post_id       The post identifier.
 *
 * @return string  ( description_of_the_return_value )
 */
function king_get_follow_count( $follow_count, $post_id ) {
	$follow_text   = esc_html__( 'follow', 'king' );
	$unfollow_text = esc_html__( 'unfollow', 'king' );
	if ( king_already_followd( $post_id ) ) {
		$number = $unfollow_text;
	} else {
		$number = $follow_text;
	}
	$count = '<span class="sl-count">' . $number . '</span>';
	return $count;
} // king_get_follow_count.

/**
 * Disable acf css on front-end acf forms.
 */
function king_my_deregister_styles() {
	wp_deregister_style( 'acf' );
	wp_deregister_style( 'acf-field-group' );
	wp_deregister_style( 'wp-admin' );
	wp_deregister_style( 'acf-datepicker' );
}
add_action( 'wp_print_styles', 'king_my_deregister_styles', 100 );


/**
 * Meta tags
 */
function king_meta_tags() {
	$description = get_bloginfo( 'description' );
	if ( get_field( 'enable_meta_tags', 'options' ) ) :
		if ( is_single() ) :
			$description = wp_strip_all_tags( substr( get_the_excerpt(), 0, 100 ) );
			if ( get_field( 'facebook_share_description', 'options' ) ) {
				$excerpt = get_field( 'facebook_share_description', 'options' );
			} else {
				$excerpt = $description;
			}
			?>
		<meta name="description" content="<?php echo esc_attr( $description ); ?>">
		<!-- facebook meta tags -->
		<meta property="og:url" content="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"/>
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?php echo get_the_title( get_the_ID() ); ?>"/>
		<meta property="og:description" content="<?php echo esc_attr( $excerpt ); ?>" />
		<meta property="og:image" content="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ); ?>"/>
		<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>"/>
			<?php
			if ( get_field( 'twitter_share_description', 'options' ) ) {
				$twiexcerpt = get_field( 'twitter_share_description', 'options' );
			} else {
				$twiexcerpt = $description;
			}
			?>
		<!-- twitter meta tags -->
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:title" content="<?php echo get_the_title( get_the_ID() ); ?>">
		<meta name="twitter:description" content="<?php echo esc_attr( $twiexcerpt ); ?>">
		<meta name="twitter:image" content="<?php echo esc_url( wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) ) ); ?>">
	<?php else : ?>
		<meta name="description" content="<?php echo esc_attr( strip_tags( $description ) ); ?>">
		<?php
		endif;
	endif;
}
if ( class_exists( 'Acf' ) ) :

	if ( get_field( 'enable_reactions', 'option' ) && get_field( 'display_reactions_block', 'option' ) ) :
		/**
		 * Print count vote reactions
		 *
		 * @param int $post_id post id.
		 */
		function king_reactions( $post_id = false ) {
			if ( ! $post_id ) {
				$post_id = get_the_ID();
			}
			$king_reactions = array( 'like', 'love', 'haha', 'wow', 'sad', 'angry' );
			$output         = '';
			foreach ( $king_reactions as $king_reaction ) {
				$count_reaction = get_post_meta( $post_id, 'king_reaction_' . $king_reaction . '', true );

				if ( ! empty( $count_reaction ) ) {
					$output .= '<div class="king-reaction-item" title="' . esc_attr( $king_reaction ) . '"><span class="king-reaction-item-icon king-reaction-' . esc_attr( $king_reaction ) . '"></span><span class="king-reaction-count" >' . esc_attr( $count_reaction ) . '</span></div>';
				}
			}
			return $output;
		}
	endif;
	if ( get_field( 'enable_user_points', 'options' ) ) {
		/**
		 * King User points function.
		 *
		 * @since 0.5
		 */
		function king_user_points( $user_id ) {
			global $wpdb;
			$followers    = get_user_meta( $user_id, 'wp__post_follow_count', true );
			$followers    = is_numeric( $followers ) ? $followers : 0;
			$posts        = esc_attr( count_user_posts( $user_id ) );
			$comments     = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) AS total FROM $wpdb->comments WHERE comment_approved = 1 AND user_id = %s", $user_id ) );
			$followersx   = get_field( 'get_a_follower', 'options' );
			$postsx       = get_field( 'submitting_a_post', 'options' );
			$commentsx    = get_field( 'posting_a_comment', 'options' );
			$bonus_plus   = get_field( 'bonus_points', 'user_' . $user_id );
			$points_total = ( $followers * $followersx ) + ( $posts * $postsx ) + ( $comments * $commentsx ) + $bonus_plus;
			$user_point   = get_user_meta( $user_id, 'king_user_points', true );
			if ( $points_total !== $user_point ) {
				update_user_meta( $user_id, 'king_user_points', $points_total );
				$user_point = get_user_meta( $user_id, 'king_user_points', true );
			}
			return $user_point;
		} // king_user_points.
	}
	endif;

if ( ! get_option( 'permalink_structure' ) ) :
	/**
	 * King admin notify.
	 */
	function king_admin_notifications() {
		$class   = 'notice notice-info is-dismissible theme-option-property-search-page-notification';
		$message = esc_html__( 'Required: Please go to "Settings > Permalink" and select permalink format instead of the Plain. "This step is to prevent any 404 errors !".', 'king' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}
	add_action( 'admin_notices', 'king_admin_notifications' );
endif;
if ( king_plugin_active( 'ACF' ) ) :

	/**
	 * Nav menu acf fields.
	 *
	 * @param <type> $items  The items.
	 * @param <type> $args   The arguments.
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function king_wp_nav_menu_objects( $items, $args ) {
		foreach ( $items as &$item ) {
			$badgemenu = get_field( 'add_badge_to_menu', $item );
			$iconmenu  = get_field( 'add_icon_to_menu', $item );
			if ( $badgemenu || $iconmenu ) {
				$badgetext    = get_field( 'menu_badge_text', $item );
				$badgeback    = get_field( 'menu_badge_background_color', $item );
				$icon         = get_field( 'menu_item_icon', $item );
				$iconcolor    = get_field( 'menu_item_icon_color', $item );
				if ( $badgemenu ) {
					$item->title .= '<span class="menu-badge" style="background-color:' . $badgeback . '">' . $badgetext . '</span>';
				}
				if ( $iconmenu ) {
					$item->title = '<span style="color:' . $iconcolor . '">' . $icon . ' </span>' . $item->title;
				}
			}
		}
		return $items;
	}
	add_filter( 'wp_nav_menu_objects', 'king_wp_nav_menu_objects', 10, 2 );

	if ( ! function_exists( 'king_menu_item_array' ) ) {
		/**
		 * { function_description }
		 *
		 * @param      <type>  $items   The items
		 * @param      int     $parent  The parent
		 *
		 * @return     array   ( description_of_the_return_value )
		 */
		function king_menu_item_array( $items, $parent = 0 )
		{
			$bundle = [];
			foreach ( $items as $item ) {
				if ( $item->menu_item_parent == $parent ) {
					$child               = king_menu_item_array( $items, $item->ID );
					$bundle[] = array(
						'item'   => $item,
						'childs' => $child
					);
				}
			}

			return $bundle;
		}
	}
	/**
	 * File upload Limit
	 *
	 * @param  [type] $bytes [description].
	 * @return [type]        [description]
	 */
	function king_increase_upload( $bytes ) {
		if ( get_field( 'max_file_u_size', 'option' ) ) {
			$maxfilesize = get_field( 'max_file_u_size', 'option' );
		} else {
			$maxfilesize = '2';
		}
		return ( $maxfilesize * 1048576 ); // 32 megabytes
	}
	add_filter( 'upload_size_limit', 'king_increase_upload' );

	if ( get_field( 'enable_reactions_without_comments', 'option' ) ) :

		/**
		 * Reaction Box
		 *
		 * @return [type] [description]
		 */
		function king_reactions_box() {
			if ( ! wp_verify_nonce( $_REQUEST['nonce'], 'king_reactions_box_nonce' ) || ! isset( $_REQUEST['nonce'] ) ) {
				exit( 'No naughty business please' );
			}
			$post_id       = $_REQUEST['post'];
			$action        = $_REQUEST['type'];
			$user_id       = get_current_user_id();
			$box_reactions = get_post_meta( $post_id, 'king_reaction_' . $action . '', true );
			$box_reactions = ( empty( $box_reactions ) ) ? 0 : $box_reactions;
			$reactions     = (int) $box_reactions + 1;

			update_post_meta( $post_id, 'king_reaction_' . $action . '', $reactions );
			$new_reactions = reactions_total( $post_id, $reactions );

			$king_user_reactions = get_user_meta( $user_id, 'king_user_reactions' );
			if ( count( $king_user_reactions ) !== 0 ) {
				$king_reactions = $king_user_reactions[0];
			}
			if ( ! is_array( $king_reactions ) ) {
				$king_reactions = array();
			}
			if ( ! array_key_exists( $post_id, $king_reactions ) ) {
				$king_reactions[ $post_id ] = $action;
			}
			update_user_meta( $user_id, 'king_user_reactions', $king_reactions );
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
				echo json_encode(
					array(
						'reactions'     => $reactions,
						'new_reactions' => $new_reactions,
					)
				);
				die();
			} else {
				wp_redirect( get_permalink( $_REQUEST['post_id'] ) );
				exit();
			}
		}
		add_action( 'wp_ajax_nopriv_king_reactions_box', 'king_reactions_box' );
		add_action( 'wp_ajax_king_reactions_box', 'king_reactions_box' );

		/**
		 * Reaction Buttons
		 *
		 * @return [type] [description]
		 */
		function king_reactions_box_buttons() {
			$reaction_text = '';
			if ( is_single() ) {
				$user_id               = get_current_user_id();
				$post_id               = get_the_ID();
				$king_reaction_buttons = array( 'like', 'love', 'haha', 'wow', 'sad', 'angry' );
				$nonce                 = wp_create_nonce( 'king_reactions_box_nonce' );
				$disabled_class        = '';
				$not_logged            = '';
				$krc  = get_user_meta( $user_id, 'king_user_reactions', true );
				if ( ! is_array( $krc ) ) {
					$krc = array();
				}
				if ( array_key_exists( $post_id, $krc ) ) {
					$disabled_class = 'disabled';
				}
				if ( ! is_user_logged_in() ) {
					$not_logged = 'not_logged';
				}
				$reaction_text        = '<div class="single-boxes king-reactions-post-' . $post_id . ' ' . $disabled_class . '" data-nonce="' . $nonce . '" data-post="' . $post_id . '" data-voted="' . $disabled_class . '" data-logged="' . $not_logged . '"><div class="single-boxes-title"><h4>Reactions</h4></div>';

				foreach ( $king_reaction_buttons as $king_reaction_button ) {
					$box_reactions          = get_post_meta( $post_id, 'king_reaction_' . $king_reaction_button, true );
					$box_reactions          = ( empty( $box_reactions ) ) ? 0 : $box_reactions;
					$box_reactions_percent  = reactions_total( $post_id, $box_reactions );
					$box_reactions_percent2 = reactions_total( $post_id, $box_reactions, 1 );
					$voted_class            = '';
					if ( $disabled_class ) {
						$voted_class = 'voted';
					}

					$reaction_text .= '<div class="king-reaction-buttons ' . $voted_class . '">
					<div class="king-reactions-count king-reactions-count-' . esc_attr( $king_reaction_button ) . '">' . esc_attr( $box_reactions ) . '</div>
					<div class="king-reaction-bar">
					<div class="king-reactions-percent king-reaction-percent-' . esc_attr( $king_reaction_button ) . '" style="height: ' . esc_attr( $box_reactions_percent ) . '%"></div>
					</div>
					<div class="king-reactions-icon king-reaction-' . esc_attr( $king_reaction_button ) . '" data-new="' . $box_reactions_percent2 . '" data-action="' . esc_attr( $king_reaction_button ) . '">
					</div>
					</div>';

				}
				$reaction_text .= '<div id="king-reacted" class="king-reacted hide">' . esc_html__( 'Already reacted for this post.', 'king' ) . '</div>';
				$reaction_text .= '</div>';
			}
			return $reaction_text;
		}

		/**
		 * Reaction Totals.
		 *
		 * @param <type>  $post_id        The post identifier.
		 * @param integer $box_reactions  The box reactions.
		 * @param integer $total          The total.
		 *
		 * @return     integer  ( description_of_the_return_value )
		 */
		function reactions_total( $post_id, $box_reactions, $total=null ) {
			$king_reaction_buttons = array( 'like', 'love', 'haha', 'wow', 'sad', 'angry' );
			$box_reactions_percent = 0;
			$box_reactions_ts = array();
			foreach ( $king_reaction_buttons as $key => $value ) {
				$box_reactions_t      = get_post_meta( $post_id, 'king_reaction_'.$value, true );
				$box_reactions_ts[] .= ( empty( $box_reactions_t )  ? 0 : $box_reactions_t );
				
			}
			$box_reactions_total = is_array($box_reactions_ts) ? array_sum($box_reactions_ts) : 0;
			if ( $box_reactions_total !== 0 ) {
				$box_reactions_percent = round( ( $box_reactions * 100 ) / ( $box_reactions_total + $total ) );
			}
			return $box_reactions_percent;
		}
	endif;
	if ( get_field( 'enable_leaderboard_badges', 'option' ) ) :
		/**
		 * Save Acf leaderboard Badges.
		 *
		 * @return [type] [description]
		 */
		function king_leaderboard_badge() {
			$count = count( get_field( 'leaderboard_badges', 'option' ) );
			$query = get_users(
				array(
					'orderby'  => 'meta_value_num',
					'meta_key' => 'king_user_points',
					'order'    => 'DESC',
					'number'   => $count,
				)
			);
			foreach ( $query as $user ) {
				$userids[] = $user->ID;
			}

			// check if the repeater field has rows of data.
			if ( have_rows( 'leaderboard_badges', 'option' ) ) :

				// loop through the rows of data.
				while ( have_rows( 'leaderboard_badges', 'option' ) ) : the_row();

					$badgetitle[] = trim( str_replace( ' ', '_', get_sub_field( 'leaderboard_badge_title' ) ) );

				endwhile;
				$q = get_users(
					array(
						'meta_key' => 'king_user_leaderboard',
					)
				);
				foreach ( $q as $qq ) {
					delete_user_meta( $qq->ID, 'king_user_leaderboard' );
				}
			endif;
			foreach ( $userids as $user_id => $value ) {
				update_user_meta( $value, 'king_user_leaderboard', $badgetitle[$user_id] );
			}
		}

	endif;
endif;

if ( king_plugin_active( 'ACF' ) ) :
	if ( ( get_field( 'enable_tag_follow', 'options' ) || get_field( 'enable_category_follow', 'options' ) ) && is_user_logged_in() ) :
		/**
		 * Follow tags and Categories.
		 */
		function king_follow_tags() {
			if ( ! is_user_logged_in() ) {
				die( '-1' );
			}
			$postid     = $_POST['to_follow'];
			$this_user  = wp_get_current_user();
			$userid     = $this_user->ID;
			$post_likes = get_user_meta( $userid, 'king_follow_tags' );
			$post_users = $post_likes[0];
			if ( is_array( $post_users ) && in_array( $postid, $post_users ) ) {
				$post_users = check_array( $postid, $post_likes );
				if ( $post_users ) {
					$uid_key = array_search( $postid, $post_users );
					unset( $post_users[ $uid_key ] );
					update_user_meta( $userid, 'king_follow_tags', $post_users );
				}
			} else {
				$post_users = check_array( $postid, $post_likes );
				if ( $post_users ) {
					update_user_meta( $userid, 'king_follow_tags', $post_users );
				}
				echo 'added_like';
			}

			die();
		}
		add_action( 'wp_ajax_nopriv_king_follow_tags', 'king_follow_tags' );
		add_action( 'wp_ajax_king_follow_tags', 'king_follow_tags' );
	endif;

	if ( get_field( 'enable_notification', 'options' ) ) :
		/**
		 * Add comment notification.
		 *
		 * @param <type> $comment_ID        The comment id.
		 * @param <type> $comment_approved  The comment approved.
		 * @param <type> $commentdata       The commentdata.
		 */
		function king_comment_notify( $comment_ID, $comment_approved, $commentdata ) {
			if ( 1 === $comment_approved ) {
				$comment_post_id = $commentdata['comment_post_ID'];
				$user_id         = get_post_field( 'post_author', $comment_post_id );
				$type            = 'comment';
				$commenterid     = $commentdata['user_ID'];

				if ( $commentdata['comment_parent'] != '0' ) {
					$comment         = get_comment( $commentdata['comment_parent'] );
					$user_id         = $comment->user_id;
					$comment_post_id = $commentdata['comment_parent'];
					$type            = 'reply';
				}
				if ( esc_attr( $commenterid ) !== esc_attr( $user_id ) ) {
					king_create_notify( $comment_post_id, $type, null, $user_id );
				}
			}

		}
		add_action( 'comment_post', 'king_comment_notify', 10, 3 );

		/**
		 * Add notificaiton for comment.
		 *
		 * @param <type> $comment_id      The comment identifier.
		 * @param string $comment_status  The comment status.
		 */
		function king_comment_approved_notify( $comment_id, $comment_status ) {
			if ( $comment_status === 'approve' ) {
				$comment         = get_comment( $comment_id );
				$comment_post_id = $comment->comment_post_ID;
				$commenterid     = $comment->user_id;
				$user_id         = get_post_field( 'post_author', $comment_post_id );
				$type            = 'comment';
				if ( $comment->comment_parent != '0' ) {
					$commentp        = get_comment( $comment->comment_parent );
					$user_id         = $commentp->user_id;
					$comment_post_id = $comment->comment_parent;
					$type            = 'reply';
				}
				if ( esc_attr( $commenterid ) != esc_attr( $user_id ) ) {
					king_create_notify( $comment_post_id, $type, null, $user_id );
				}
			}
		}
		add_action( 'wp_set_comment_status', 'king_comment_approved_notify', 10, 2 );

		/**
		 * Show notification
		 */
		function king_show_notify() {
			$user_id     = get_current_user_id();
			$comments    = get_user_meta( $user_id, 'king_notify', false );
			$notify_text = '';

			if ( $comments ) {
				$notify_count = get_user_meta( $user_id, 'king_notify_count', true );
				if ( empty( $notify_count ) || $notify_count === '' ) {
					$notify_count = 0;
				}
				foreach ( array_reverse( $comments ) as $key => $comment ) {
					$user_info   = get_userdata( $comment['who'] );
					$user_url    = site_url() . '/' . $GLOBALS['king_account'] . '/' . $user_info->user_login;
					$user_avatar = '';
					$seen        = '';
					if ( get_field( 'author_image', 'user_' . $comment['who'] ) ) {
						$image       = get_field( 'author_image', 'user_' . $comment['who'] );
						$avatar      = $image['sizes']['thumbnail'];
						$user_avatar = '<img src="' . esc_url( $avatar ) . '" alt="profile" />';
					}
					if ( $key < (int) $notify_count ) {
						$seen = '<span class="notify-seen"></span>';
					}
					if ( 'comment' === $comment['type'] ) {
						$notify_text .= '<li>' . $seen . '<div class="king-notify-avatar"><span class="king-notify-avatar-img">' . $user_avatar . '</span><i class="fas fa-comment-alt fa-xs"></i></div><a href="' . esc_url( $user_url ) . '" >' . esc_attr( $user_info->user_login ) . ' </a>' . esc_html__( 'commented on', 'king' ) . ' <a href="' . get_permalink( $comment['postid'] ) . '" >' . esc_attr( get_the_title( $comment['postid'] ) ) . '</a></li>';
					} elseif ( 'reply' === $comment['type'] ) {
						$notify_text .= '<li>' . $seen . '<div class="king-notify-avatar"><span class="king-notify-avatar-img">' . $user_avatar . '</span><i class="fas fa-reply fa-xs"></i></div><a href="' . esc_url( $user_url ) . '" >' . esc_attr( $user_info->user_login ) . ' </a>' . esc_html__( 'replied your comment', 'king' ) . ' <a href="' . get_comment_link( $comment['postid'] ) . '" >' . esc_html__( 'See it', 'king' ) . '</a></li>';
					} elseif ( 'clike' === $comment['type'] ) {
						$notify_text .= '<li>' . $seen . '<div class="king-notify-avatar"><span class="king-notify-avatar-img">' . $user_avatar . '</span><i class="fas fa-reply fa-xs"></i></div><a href="' . esc_url( $user_url ) . '" >' . esc_attr( $user_info->user_login ) . ' </a>' . esc_html__( 'liked your comment', 'king' ) . ' <a href="' . get_comment_link( $comment['postid'] ) . '" >' . esc_html__( 'See it', 'king' ) . '</a></li>';
					} elseif ( 'cdislike' === $comment['type'] ) {
						$notify_text .= '<li>' . $seen . '<div class="king-notify-avatar"><span class="king-notify-avatar-img">' . $user_avatar . '</span><i class="fas fa-reply fa-xs"></i></div><a href="' . esc_url( $user_url ) . '" >' . esc_attr( $user_info->user_login ) . ' </a>' . esc_html__( 'disliked your comment', 'king' ) . ' <a href="' . get_comment_link( $comment['postid'] ) . '" >' . esc_html__( 'See it', 'king' ) . '</a></li>';
					} elseif ( 'follow' === $comment['type'] ) {
						$notify_text .= '<li>' . $seen . '<div class="king-notify-avatar"><span class="king-notify-avatar-img">' . $user_avatar . '</span><i class="fas fa-shoe-prints fa-xs"></i></div><a href="' . esc_url( $user_url ) . '" >' . esc_attr( $user_info->user_login ) . ' </a>' . esc_html__( 'started to follow you', 'king' ) . '</li>';
					} elseif ( 'like' === $comment['type'] ) {
						$notify_text .= '<li>' . $seen . '<div class="king-notify-avatar"><span class="king-notify-avatar-img">' . $user_avatar . '</span><i class="fas fa-thumbs-up fa-xs"></i></div><a href="' . esc_url( $user_url ) . '" >' . esc_attr( $user_info->user_login ) . ' </a>' . esc_html__( 'liked your post', 'king' ) . ' <a href="' . get_permalink( $comment['postid'] ) . '" >' . esc_attr( get_the_title( $comment['postid'] ) ) . '</a></li>';
					} elseif ( 'dislike' === $comment['type'] ) {
						$notify_text .= '<li>' . $seen . '<div class="king-notify-avatar"><span class="king-notify-avatar-img">' . $user_avatar . '</span><i class="fas fa-thumbs-down fa-xs"></i></div><a href="' . esc_url( $user_url ) . '" >' . esc_attr( $user_info->user_login ) . ' </a>' . esc_html__( 'disliked your post', 'king' ) . ' <a href="' . get_permalink( $comment['postid'] ) . '" >' . esc_attr( get_the_title( $comment['postid'] ) ) . '</a></li>';
					}
				}
				$notify_text .= '<li class="king-clean-center"><input type="button" class="king-clean" value="&#xf1b8;" title="' . esc_html__( 'Clear All', 'king' ) . '" /></li>';
				delete_user_meta( $user_id, 'king_notify_count' );

			} else {
				$notify_text .= '<li class="king-clean-center"><i class="fas fa-fish"></i><br>' . esc_html__( 'Nothing new right now !', 'king' ) . '</li>';
			}
			echo $notify_text;
			die();
		}
		add_action( 'wp_ajax_nopriv_king_show_notify', 'king_show_notify' );
		add_action( 'wp_ajax_king_show_notify', 'king_show_notify' );

		/**
		 * Clean button for notification.
		 */
		function king_clean_notify() {
			$user_id = get_current_user_id();
			delete_user_meta( $user_id, 'king_notify' );
			$notify_text = '<li class="king-clean-center"><i class="fas fa-fish"></i><br>' . esc_html__( 'Nothing new right now !', 'king' ) . '</li>';
			echo $notify_text;
			die();
		}
		add_action( 'wp_ajax_nopriv_king_clean_notify', 'king_clean_notify' );
		add_action( 'wp_ajax_king_clean_notify', 'king_clean_notify' );
		/**
		 * Create notification.
		 *
		 * @param <type> $post_id The post identifier.
		 * @param <type> $type The type.
		 * @param string $format The format.
		 */
		function king_create_notify( $post_id, $type, $format = null, $uid = null ) {
			$user_id         = get_current_user_id();
			$knotify_comment = array('type' => $type, 'postid' => $post_id, 'who' => $user_id );
			if ( 'f' === $format ) {
				$userid = $post_id;
			} elseif ( 'c' === $format ) {
				$comment = get_comment( $post_id );
				$userid  = $comment->user_id;
			} elseif ( $uid ) {
				$userid = $uid;
			} else {
				$userid = get_post_field( 'post_author', $post_id );
			}
			add_user_meta( $userid, 'king_notify', $knotify_comment );
			$count = get_user_meta( $userid, 'king_notify_count', true );
			if ( empty( $count ) || '' === $count ) {
				$count = 0;
			}
			$nototal = (int) $count + 1;
			update_user_meta( $userid, 'king_notify_count', $nototal );
		}
	endif;

	if ( get_field( 'enable_user_groups', 'options' ) ) :
		/**
		 * King User group get from theme options.
		 *
		 * @param string $field the field.
		 *
		 * @return string ( description_of_the_return_value )
		 */
		function king_load_user_group( $field ) {
			$field['choices'] = array();
			if ( have_rows( 'user_groups', 'option' ) ) {
				while ( have_rows( 'user_groups', 'option' ) ) {
					the_row();
					$value = get_sub_field( 'group_name' );
					$label = '<span class="group-icon" title="' . get_sub_field( 'group_name' ) . '" style="background-color: ' . get_sub_field( 'group_color' ) . ';">' . get_sub_field( 'group_icon' ) . '' . get_sub_field( 'group_name' ) . '</span>';

					$field['choices'][ $value ] = $label;
				}
			}
			return $field;
		}
		add_filter( 'acf/load_field/name=groups_create_posts', 'king_load_user_group' );
		add_filter( 'acf/load_field/name=groups_create_posts_without_approval', 'king_load_user_group' );
		add_filter( 'acf/load_field/name=groups_edit_their_own_posts', 'king_load_user_group' );
		add_filter( 'acf/load_field/name=groups_view_posts', 'king_load_user_group' );
		add_filter( 'acf/load_field/name=groups_write_comments', 'king_load_user_group' );
		add_filter( 'acf/load_field/name=groups_display_ads', 'king_load_user_group' );
		/**
		 * User list for group users.
		 *
		 * @param <type> $field  The field.
		 *
		 * @return <type>  ( description_of_the_return_value )
		 */
		function king_users_group( $field ) {
			$field['choices'] = array();
			$users            = get_users();
			foreach ( $users as $user ) {
				$field['choices'][ $user->ID ] = $user->user_login;
			}
			return $field;
		}
		add_filter( 'acf/load_field/name=group_users', 'king_users_group' );

		/**
		 * Group permissions.
		 *
		 * @param string $optn The optn.
		 *
		 * @return boolean ( description_of_the_return_value )
		 */
		function king_groups_permissions( $optn ) {
			$usid   = get_current_user_id();
			$optns  = get_field( '' . $optn . '', 'options' );
			$groups = get_field( 'user_groups', 'options' );
			$rtrn   = array();
			if ( $groups && $optns ) :
				foreach ( $groups as $group ) :
					$usergroups = $group['group_users'];
					if ( $usergroups ) :
						foreach ( $usergroups as $usergroup ) :
							if ( $usergroup == $usid ) :
								$rtrn[] = $group['group_name'];
							endif;
						endforeach;
					endif;
				endforeach;
				if ( array_intersect( $optns, $rtrn ) ) :
					return true;
				else :
					return false;
				endif;
			else :
				return true;
			endif;
		}
	endif;
	if ( get_field( 'enable_live_search', 'options' ) ) :
		/**
		 * King Live Search Results.
		 */
		function king_live_search() {
			$keyword = sanitize_text_field( wp_unslash( $_POST['keyword'] ) );
			if ( get_field( 'enable_live_user_search', 'options' ) ) :
				$args          = array(
					'order'          => 'ASC',
					'search'         => '*' . $keyword . '*',
					'number'         => 3,
					'search_columns' => array(
						'user_login',
						'user_nicename',
						'display_name',
					),
				);
				$wp_user_query = new WP_User_Query( $args );
				$authors       = $wp_user_query->get_results();
				$output        = '<div class="king-search-results">';

				if ( ! empty( $authors ) ) :
					$output .= '<span class="lsearch-title" >' . esc_html__( 'Users', 'king' ) . '</span>';
					foreach ( $authors as $author ) :
						$author_info = get_userdata( $author->ID );

						$output .= '<a href="' . esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author_info->user_login ) . '">';
						if ( get_field( 'author_image', 'user_' . $author->ID ) ) :
							$image   = get_field( 'author_image', 'user_' . $author->ID );
							$output .= '<img src="' . esc_url( $image['sizes']['thumbnail'] ) . '" alt="profile" />';
						else :
							$output .= '<span class="lsearch-noavatar"></span>';
						endif;
						$output .= $author_info->user_login;
						$output .= '</a>';
					endforeach;
				endif;
			endif;
			$the_query = new WP_Query(
				array(
					'posts_per_page' => 5,
					's'              => $keyword,
					'post_type'      => 'post',
					'post_status'    => 'publish',
				)
			);

			if ( $the_query->have_posts() && $keyword ) :
				$output .= '<span class="lsearch-title" >' . esc_html__( 'Posts', 'king' ) . '</span>';
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
					$output .= '<a href="' . esc_url( get_permalink() ) . '">';
					if ( has_post_format( 'quote' ) ) :
						$output .= '<span class="lsearch-format-news" >' . esc_html__( 'News', 'king' ) . '</span>';
					elseif ( has_post_format( 'video' ) ) :
						$output .= '<span class="lsearch-format-video" >' . esc_html__( 'Video', 'king' ) . '</span>';
					elseif ( has_post_format( 'image' ) ) :
						$output .= '<span class="lsearch-format-image" >' . esc_html__( 'Image', 'king' ) . '</span>';
					elseif ( has_post_format( 'audio' ) ) :
						$output .= '<span class="lsearch-format-music" >' . esc_html__( 'Music', 'king' ) . '</span>';
					endif;
					$output .= '' . get_the_title() . '';
					$output .= '</a>';
				endwhile;
				$output .= '<span class="lsearch-more" ><i class="fas fa-search"></i> <strong>' . esc_attr( $keyword ) . '</strong> - ' . esc_attr( $the_query->found_posts ) . '' . esc_html__( ' total results', 'king' ) . '</span>';
				wp_reset_postdata();
			else :
				$output .= esc_html__( 'No result found.', 'king' );
			endif;
			$output .= '</div>';
			echo $output;
			die();
		}
		add_action( 'wp_ajax_king_live_search', 'king_live_search' );
		add_action( 'wp_ajax_nopriv_king_live_search', 'king_live_search' );
	endif;


	if ( get_field( 'enable_bookmarks', 'options' ) ) :
		/**
		 * King bookmark function.
		 */
		function king_readlater() {
			if ( ! is_user_logged_in() ) {
				die( '-1' );
			}
			$postid = ( isset( $_POST['to_book'] ) && is_numeric( $_POST['to_book'] ) ) ? $_POST['to_book'] : '';
			if ( empty( $postid ) ) {
				die( '-1' );
			}
			$this_user  = wp_get_current_user();
			$userid     = $this_user->ID;
			$post_likes = get_user_meta( $userid, 'king_readlater' );
			$post_users = $post_likes[0];
			if ( is_array( $post_users ) && in_array( $postid, $post_users ) ) {
				$post_users = check_array( $postid, $post_likes );
				if ( $post_users ) {
					$uid_key = array_search( $postid, $post_users );
					unset( $post_users[ $uid_key ] );
					update_user_meta( $userid, 'king_readlater', $post_users );
				}
			} else {
				$post_users = check_array( $postid, $post_likes );
				if ( $post_users ) {
					update_user_meta( $userid, 'king_readlater', $post_users );
				}
				echo '1';
			}

			die();
		}
		add_action( 'wp_ajax_nopriv_king_readlater', 'king_readlater' );
		add_action( 'wp_ajax_king_readlater', 'king_readlater' );

		/**
		 * Show Bookmarked posts.
		 */
		function king_readlater_posts() {
			$user_id = get_current_user_id();
			$rlposts = get_user_meta( $user_id, 'king_readlater', true );
			$output  = '';

			if ( $rlposts ) {
				$recent_query = new WP_Query(
					[
						'post__in'  => array_reverse( $rlposts ),
						'orderby'   => 'post__in',
						'post_type' => king_post_types(),
					]
				);
				if ( $recent_query->have_posts() ) {
						$output .= '<div class="king-rlater-center"><a class="king-rlater-clean" title="' . esc_html__( 'Remove All', 'king' ) . '"><i class="far fa-trash-alt"></i> ' . esc_html__( 'Remove All List', 'king' ) . '</a></div>';
					while ( $recent_query->have_posts() ) {
						$recent_query->the_post();
						$thumb   = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'medium' );
						$output .= '<li>';
						$output .= '<a class="king-bookmark-posts" href="' . esc_url( get_permalink() ) . '">';
						$output .= '<div class="rlater-post-img" style="background-image: url(' . esc_url( $thumb['0'] ) . ')"></div>';
						$output .= '<div class="rlater-right">';
						$output .= '<span class="rlater-post-title" >' . get_the_title() . '</span>';
						$output .= '<span class="rlater-post-date" >' . get_post_time( 'F j, Y' ) . '</span>';
						$output .= '</div>';
						$output .= king_bookmark_button( $user_id, get_the_ID(), 'in-bookmarks' );
						$output .= '</a>';
						$output .= '</li>';
					}
					wp_reset_postdata();
				}
			} else {
				$output .= '<div class="king-rlater-center"><i class="fas fa-exclamation"></i><br>' . esc_html__( 'Nothing Found ! Please add some posts to see your added bookmarks.', 'king' ) . '</div>';
			}
			echo wp_kses_post( $output );
			die();
		}
		add_action( 'wp_ajax_nopriv_king_readlater_posts', 'king_readlater_posts' );
		add_action( 'wp_ajax_king_readlater_posts', 'king_readlater_posts' );
		if ( ! function_exists( 'king_clean_readlater' ) ) :
			/**
			 * Clean button for bookmarked posts.
			 */
			function king_clean_readlater() {
				$user_id = get_current_user_id();
				delete_user_meta( $user_id, 'king_readlater' );
				$output = '<div class="king-rlater-center"><i class="fas fa-exclamation"></i><br>' . esc_html__( 'Nothing Found ! Please add some posts to see your added bookmarks.', 'king' ) . '</div>';
				echo wp_kses_post( $output );
				die();
			}
			add_action( 'wp_ajax_nopriv_king_clean_readlater', 'king_clean_readlater' );
			add_action( 'wp_ajax_king_clean_readlater', 'king_clean_readlater' );
		endif;
		if ( ! function_exists( 'king_bookmark_button' ) ) :
			/**
			 * King Bookmark Button.
			 *
			 * @param <type> $user_id  The user identifier.
			 * @param <type> $post_id  The post identifier.
			 * @param <type> $bclass  The user identifier.
			 *
			 * @return string  ( description_of_the_return_value )
			 */
			function king_bookmark_button( $user_id, $post_id, $bclass = null ) {
					$bookmarks = get_user_meta( $user_id, 'king_readlater', true );
					$class     = 'far';
					$class2    = '';
				if ( is_array( $bookmarks ) && in_array( $post_id, $bookmarks ) ) {
					$class  = 'fas';
					$class2 = ' added';
				}
				$output = '<div class="king-ft-link king-readlater ' . esc_attr( $bclass ) . esc_attr( $class2 ) . '" data-toggle="tooltip" data-placement="bottom" title="' . esc_html__( 'Bookmark', 'king' ) . '" data-bookmarkid="' . esc_attr( $post_id ) . '" >
					<i class="' . esc_attr( $class ) . ' fa-bookmark"></i>
				</div>';
				return $output;
			}
		endif;
		if ( ! function_exists( 'king_header_bookmark' ) ) :
			/**
			 * { function_description }
			 *
			 * @return     string  ( description_of_the_return_value )
			 */
			function king_header_bookmark() {
				$user_id = get_current_user_id();
				$rlposts = get_user_meta( $user_id, 'king_readlater' );
				$count   = isset( $rlposts['0'] ) ? count( $rlposts['0'] ) : 0;
				$output  = '<div class="king-rlater" data-toggle="modal" data-target="#rlatermodal">
					<i class="far fa-bookmark"></i>
					<input type="hidden" class="king-bmcountin" value="' . esc_attr( $count ) . '" />
					<span class="king-bmcount">' . esc_attr( $count ) . '</span>
				</div>';
				return $output;
			}
		endif;
	endif;
	if ( ! function_exists( 'king_mega_menu' ) ) :
		/**
		 * Mega Menu posts.
		 *
		 * @param <type> $nmenu The nmenu.
		 * @param <type> $mformat The mformat.
		 * @param <type> $pnumber The pnumber.
		 * @param string $porder The porder.
		 * @param <type> $type The type.
		 * @param <type> $nivm The nivm.
		 *
		 * @return string  ( description_of_the_return_value )
		 */
		function king_mega_menu( $nmenu, $mformat, $pnumber, $porder, $type, $nivm = null, $dleft = array() ) {
			$repeaters =is_array($nmenu) ? $nmenu['links_in_mega_menu'] :'';
			$output    = '<div class="king-nav-dropdown">';
			
			if ( $dleft ) {
				$output .= '<div class="king-d-left" style="background-color:'.esc_attr($dleft['color']).';" data-king-img-src="'.esc_attr($dleft['bgimage']).'"><span class="king-d-content"><h3>'.wp_kses_post($dleft['title']).'</h3>'.wp_kses_post( $dleft['desc'] ).'</span></div>';
			}
			$args = array(
				'post_type'      => $type,
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'posts_per_page' => $pnumber,
			);
			if ( 'c' === $nivm ) :
				$args['cat'] = $mformat;				
			elseif ( 't' === $nivm ) :
				$args['tag_id'] = $mformat;
			endif;

			if ( 'f' === $nivm ) :
				$args['tax_query'] = array(
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => array( 'post-format-' . $mformat ),
					),
				);
			endif;


			if ( $porder === 'popular' ) :
				$args['meta_query']  = array(
					'relation'        => 'AND',
					'_post_views'     => array(
						'key'     => '_post_views',
						'type'    => 'NUMERIC',
						'compare' => 'LIKE',
					),
					'king_like_count' => array(
						'key'     => 'king_like_count',
						'type'    => 'NUMERIC',
						'compare' => 'LIKE',
					),
				);
				$args['orderby']    = array(
					'_post_views'     => 'DESC',
					'king_like_count' => 'DESC',
				);
			endif;
			if ( $repeaters ) :
				$output .= '<div class="mmenu-links">';
				foreach ( $repeaters as $repeater ) :
					$output .= '<a href="' . esc_url( $repeater['mega_menu_link_url'] ) . '">' . esc_attr( $repeater['mega_menu_link_text'] ) . '</a>';
				endforeach;
				$output .= '</div>';
			endif;
			$query = new WP_query( $args );
			while ( $query->have_posts() ) :
				$query->the_post();
				ob_start();
				get_template_part( 'template-parts/posts/content', 'toosimple-post' );
				$output .= ob_get_contents();
				ob_end_clean();
			endwhile;
			wp_reset_postdata();
			$output .= '</div>';
			return $output;
		}
	endif;
	if ( ! function_exists( 'check_array' ) ) :
		/**
		 * Check Array if added or not.
		 *
		 * @param <type> $user_id The user identifier.
		 * @param <type> $posts The post identifier.
		 *
		 * @return array|string  ( description_of_the_return_value )
		 */
		function check_array( $user_id, $posts ) {
			$post_users      = '';

			if ( count( $posts ) !== 0 ) {
				$post_users = $posts[0];
			}
			if ( ! is_array( $post_users ) ) {
				$post_users = array();
			}
			if ( ! in_array( $user_id, $post_users ) ) {
				$post_users[] = $user_id;
			}
			return $post_users;
		}
	endif;
	if ( ! function_exists( 'king_submit_newsletter' ) ) {
		/**
		 * Newsletter submit code.
		 */
		function king_submit_newsletter() {
			if ( empty( $_POST['email'] ) || ! is_email( wp_unslash( $_POST['email'] ) ) || ( strlen( wp_unslash( $_POST['email'] ) ) > 50 ) ) {
				wp_send_json( array( 'error' => esc_html__( 'Email is not valid.', 'king' ) ) );
				die();
			}
			if ( isset( $_POST['privacy'] ) && empty( $_POST['privacy'] ) ) {
				wp_send_json( array( 'error' => esc_html__( 'Please accept the terms of our newsletter.', 'king' ) ) );
				die();
			}
			$email       = sanitize_email( wp_unslash( $_POST['email'] ) );
			$subscribers = get_option( 'king_subscribers' );

			if ( empty( $subscribers ) || ! is_array( $subscribers ) ) {
				update_option( 'king_subscribers', array( $email ) );
				wp_send_json( array( 'success' => esc_html__( 'Your email successfully sent.', 'king' ) ) );
				die();
			} else {
				if ( in_array( $email, $subscribers ) ) {
					wp_send_json( array( 'error' => esc_html__( 'This email already added.', 'king' ) ) );
					die();
				}
				array_push( $subscribers, $email );
				update_option( 'king_subscribers', $subscribers );
				wp_send_json( array( 'success' => esc_html__( 'Your email successfully sent.', 'king' ) ) );
				die();
			}
		}
		add_action( 'wp_ajax_nopriv_king_submit_newsletter', 'king_submit_newsletter' );
		add_action( 'wp_ajax_king_submit_newsletter', 'king_submit_newsletter' );
	}
	if ( ! function_exists( 'king_subscribers' ) ) {
		/**
		 * Subscribers
		 */
		function king_subscribers() {

			if ( ! is_admin() ) {
				return;
			}

			global $pagenow;
			if ( $pagenow == 'tools.php' && current_user_can( 'download_subscribes' ) && isset( $_GET['download'] ) && $_GET['download'] == 'subscribers.csv' ) {
				header( 'Content-type: application/x-msdownload' );
				header( 'Content-Disposition: attachment; filename=subscribers.csv' );
				header( 'Pragma: no-cache' );
				header( 'Content-Transfer-Encoding: binary' );
				header( 'Expires: 0' );
				echo king_generate_subscribes_csv();
				exit();
			}
		}
		add_action( 'admin_init', 'king_subscribers', 90 );
	}
	if ( ! function_exists( 'king_generate_subscribes_csv' ) ) :
		/**
		 * Generate csv file to download.
		 *
		 * @return string ( description_of_the_return_value )
		 */
		function king_generate_subscribes_csv() {
			$subscribers = get_option( 'king_subscribers' );
			$output      = 'Email Address';
			$output     .= "\n";
			if ( ! empty( $subscribers ) && is_array( $subscribers ) ) {
				foreach ( $subscribers as $nemail ) {
					$output .= $nemail;
					$output .= "\n";
				}
			}

			return $output;
		}
	endif;
	/**
	 * Download permission for subscribers.
	 */
	function king_subscribers_download() {
		$role = get_role( 'administrator' );
		$role->add_cap( 'download_subscribes' );
	}
	add_action( 'admin_init', 'king_subscribers_download', 10 );


		function king_bucket() {
			if ( ! is_user_logged_in() ) {
				die( '-1' );
			}
			$cid = ( isset( $_POST['cid'] ) && is_numeric( $_POST['cid'] ) ) ? $_POST['cid'] : '';
			$pid = ( isset( $_POST['pid'] ) && is_numeric( $_POST['pid'] ) ) ? $_POST['pid'] : '';
			if ( empty( $cid ) ) {
				die( '-1' );
			}
			$userid  = get_current_user_id();
			$post_likes = get_user_meta( $userid, 'king_collection_'.$cid );
			$post_users = $post_likes[0];
			if ( is_array( $post_users ) && in_array( $pid, $post_users ) ) {
				$post_users = check_array( $pid, $post_likes );
				if ( $post_users ) {
					$uid_key = array_search( $pid, $post_users );
					unset( $post_users[ $uid_key ] );
					update_user_meta( $userid, 'king_collection_'.$cid, $post_users );
				}
			} else {
				$post_users = check_array( $pid, $post_likes );
				if ( $post_users ) {
					update_user_meta( $userid, 'king_collection_'.$cid, $post_users );
				}
				echo '1';
			}

			die();
		}
		add_action( 'wp_ajax_nopriv_king_bucket', 'king_bucket' );
		add_action( 'wp_ajax_king_bucket', 'king_bucket' );

		function king_create_bucket() {
			$nonce =isset( $_POST['nonce'] ) ? $_POST['nonce'] : '';
			if ( wp_verify_nonce( $nonce, 'king_ccollecn' ) ) {
				$king_cerrors = array();
				$title        = sanitize_text_field( $_POST['title'] );
				$uid          = get_current_user_id();
				if ( trim( $title ) === '' ) {
					$king_cerrors['title_empty'] = esc_html__( 'Title is required.', 'king' );
					die( '-1' );
				}
				if ( empty( $king_cerrors ) ) {
					$get_message = get_user_meta( $uid, 'king_collections', true );
					if ( $get_message === '' ) {
						$get_message = array();
					}
					$random = wp_rand( 10000, 999990 );
					$desc   = sanitize_text_field( $_POST['desc'] );
					$prv    = isset( $_POST['pri'] ) ? true : false ;
					$out = array('t' => $title, 'd' => $desc, 'p' => $prv);
					array_push( $get_message, $random );
					update_user_meta( $uid, 'king_collections', $get_message );
					update_user_meta( $uid, 'king_collect_'.$random, $out );
					echo '1';
				}
			}
			die();
		}
		add_action( 'wp_ajax_nopriv_king_create_bucket', 'king_create_bucket' );
		add_action( 'wp_ajax_king_create_bucket', 'king_create_bucket' );

		function king_add_free_mode()
		{
			$out = true;
			$usid = get_current_user_id();
			if ( get_field( 'enable_adfree_mode', 'option' ) ) :			
				if ( get_field( 'hide_ads_for_logged_users', 'option' ) && is_user_logged_in() ) :
					$out = false;
				else :
					if ( get_field( 'hide_ads_for_verified_users', 'option' ) && get_field( 'verified_account', 'user_' . $usid ) ) :
						$out = false;
					elseif ( get_field( 'hide_ads_with_enough_points', 'option' ) ) :
						$user_point = get_user_meta( $usid, 'king_user_points', true );
						if ( $user_point >= get_field( 'users_ad_points', 'option' ) ) :
							$out = false;
						endif;
					elseif ( get_field( 'hide_ads_for_premium_members', 'option' ) && get_field( 'enable_membership', 'option' ) && function_exists( 'is_woocommerce' ) && king_check_membership( null, $usid ) ) :
						$out = false;
					elseif ( get_field( 'enable_user_groups', 'option' ) && king_groups_permissions( 'groups_display_ads' ) && get_field( 'groups_display_ads', 'option' ) ) :
						$out = false;
					endif;
				endif;
			endif;
			return $out;
		}


	function king_ai_writer() {
		$input = sanitize_text_field( wp_unslash( $_POST['input'] ) );
		$select = sanitize_text_field( wp_unslash( $_POST['select'] ) );
		$selecti = ( $select === 'image' ) ? true : false;
		$openaiapi = get_field( 'openai_api_key', 'options' );
		if ($selecti) {
			$url = 'https://api.openai.com/v1/images/generations';
			$image_size = get_field( 'select_image_size', 'options' );
			$imagen = get_field( 'number_of_image_generation', 'options' );
			$params = array(
				'prompt'=> $input,
				'n'=> (int)$imagen,
				'size'=> $image_size, // 512×512	1024x1024
			);
		} else {
			$url = 'https://api.openai.com/v1/chat/completions';
			$max_tokens = get_field( 'max_tokens_for_content', 'options' );
			$params = array(
				'model' => 'gpt-3.5-turbo',
				'messages' => array(
					array(
						'role' => 'user',
						'content' => $input,
					),
				),
				'max_tokens' => (int)$max_tokens,
				'stop' => '',
			);
		}
		$params_json = wp_json_encode($params);
		$options = [
			'body'        => $params_json,
			'headers'     => [
				'Content-Type' => 'application/json',
				'Authorization' => 'Bearer '.$openaiapi.'',
			],
			'timeout'     => 200,
		];
		$response = wp_remote_post( $url, $options );
		if (is_wp_error($response)) {
			wp_die('API request failed');
		}
		$response_body = wp_remote_retrieve_body($response);
		$response_obj = json_decode($response_body, true);
		if ($response_obj['error']) {
			$text = $response_obj['error']['message'];
			echo wp_send_json_error($text);
		} else {
			if ($selecti) {
				$text = $response_obj['data'];
			} else {
				$text = preg_replace('/^\n+/', '', $response_obj['choices'][0]['message']['content']);
			}
			echo wp_send_json_success($text);
		}

		
		wp_die();
	}
	add_action('wp_ajax_king_ai_writer', 'king_ai_writer');
	add_action('wp_ajax_nopriv_king_ai_writer', 'king_ai_writer');
	function king_ai_upload() {

		$url = $_POST['iurl'];
		require_once KING_INCLUDES_PATH . 'videothumbs.php';
			
		$attach_id = king_upload_user_file_video( $url );
		echo wp_send_json($attach_id);

		wp_die();
	}
	add_action('wp_ajax_king_ai_upload', 'king_ai_upload');
	add_action('wp_ajax_nopriv_king_ai_upload', 'king_ai_upload');
endif;