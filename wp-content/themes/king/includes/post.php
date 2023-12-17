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
if ( ! function_exists( 'king_posttypes' ) ) :
	/**
	 * Post Types.
	 */
	function king_posttypes() {
		register_post_type(
			'list',
			array(
				'labels'        => array(
					'name'          => __( 'Lists' ),
					'singular_name' => __( 'List' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'list' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
				'taxonomies'    => array( 'post_tag', 'category' ),
				'menu_icon'     => 'dashicons-editor-ul',
			)
		);
		register_post_type(
			'poll',
			array(
				'labels'        => array(
					'name'          => __( 'Polls' ),
					'singular_name' => __( 'Poll' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'poll' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
				'taxonomies'    => array( 'post_tag', 'category' ),
				'menu_icon'     => 'dashicons-chart-bar',
			)
		);
		register_post_type(
			'trivia',
			array(
				'labels'        => array(
					'name'          => __( 'Trivia Quiz' ),
					'singular_name' => __( 'Quiz' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'trivia' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'editor', 'comments', 'thumbnail' ),
				'taxonomies'    => array( 'post_tag', 'category' ),
				'menu_icon'     => 'dashicons-forms',
			)
		);
		register_post_type(
			'stories',
			array(
				'labels'        => array(
					'name'          => __( 'Stories' ),
					'singular_name' => __( 'Story' ),
				),
				'public'        => true,
				'has_archive'   => true,
				'rewrite'       => array( 'slug' => 'stories' ),
				'menu_position' => 5,
				'supports'      => array( 'title', 'thumbnail' ),
				'menu_icon'     => 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhLS0gR2VuZXJhdG9yOiBBZG9iZSBJbGx1c3RyYXRvciAyMy4wLjAsIFNWRyBFeHBvcnQgUGx1Zy1JbiAuIFNWRyBWZXJzaW9uOiA2LjAwIEJ1aWxkIDApICAtLT4NCjxzdmcgdmVyc2lvbj0iMS4xIiBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgeD0iMHB4IiB5PSIwcHgiDQoJIHZpZXdCb3g9IjAgMCAyMCAyMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMjAgMjAiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPHBhdGggZmlsbD0iI0E3QUFBRCIgZD0iTTEwLDAuNWMtNS4zLDAtOS41LDQuMy05LjUsOS41czQuMyw5LjUsOS41LDkuNXM5LjUtNC4zLDkuNS05LjVTMTUuMywwLjUsMTAsMC41eiBNNS41LDE0LjFINC4yDQoJQzMuNSwxNC4xLDMsMTMuNiwzLDEzVjdjMC0wLjYsMC41LTEuMSwxLjEtMS4xaDEuM1YxNC4xeiBNMTMuMiwxMy45YzAsMC44LTAuNywxLjUtMS41LDEuNUg4LjNjLTAuOCwwLTEuNS0wLjctMS41LTEuNVY2LjENCgljMC0wLjgsMC43LTEuNSwxLjUtMS41aDMuNWMwLjgsMCwxLjUsMC43LDEuNSwxLjVWMTMuOXogTTE2LDE0LjFoLTEuM1Y1LjlIMTZjMC42LDAsMS4yLDAuNSwxLjIsMS4xVjEzDQoJQzE3LjEsMTMuNiwxNi42LDE0LjEsMTYsMTQuMXoiLz4NCjxsaW5lIGZpbGw9Im5vbmUiIHgxPSIxMyIgeTE9IjE2LjUiIHgyPSIxMyIgeTI9IjE1LjQiLz4NCjxsaW5lIGZpbGw9Im5vbmUiIHgxPSIxMyIgeTE9IjQuNiIgeDI9IjEzIiB5Mj0iMy4xIi8+DQo8L3N2Zz4NCg==',
			)
		);
	}
	add_action( 'init', 'king_posttypes' );
endif;
if ( ! function_exists( 'add_my_post_types_to_query' ) && ! is_admin() ) :
	/**
	 * Add Post types to home page and search result.
	 *
	 * @param <type> $query  The query.
	 *
	 * @return <type> ( description_of_the_return_value ).
	 */
	function add_my_post_types_to_query( $query ) {
		if ( ( is_home() || is_category() || is_tag() ) && $query->is_main_query() ) {
			$query->set( 'post_type', array( 'post', 'list', 'poll', 'trivia' ) );
		}
		return $query;
	}
	add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
endif;
if ( ! function_exists( 'king_post_types' ) ) :
	/**
	 * Post Types.
	 *
	 * @return     array  ( description_of_the_return_value )
	 */
	function king_post_types() {
		$ptype = array( 'post', 'list', 'poll', 'trivia' );
		return $ptype;
	}
endif;
if ( king_plugin_active( 'ACF' ) ) :
	if ( get_field( 'enable_text_translation', 'options' ) ) :
		/**
		 * Translate some texts in theme.
		 *
		 * @param string $translated_text  The translated text.
		 *
		 * @return string ( description_of_the_return_value )
		 */
		function king_change_text( $translated_text ) {
			if ( 'News' === $translated_text && get_field( 'news_text', 'options' ) ) {
				$translated_text = get_field( 'news_text', 'options' );
			}
			if ( 'Submit News' === $translated_text && get_field( 'submit_news_text', 'options' ) ) {
				$translated_text = get_field( 'submit_news_text', 'options' );
			}
			if ( 'Video' === $translated_text && get_field( 'videos_text', 'options' ) ) {
				$translated_text = get_field( 'videos_text', 'options' );
			}
			if ( 'Submit Video' === $translated_text && get_field( 'submit_video_text', 'options' ) ) {
				$translated_text = get_field( 'submit_video_text', 'options' );
			}
			if ( 'Image' === $translated_text && get_field( 'image_text', 'options' ) ) {
				$translated_text = get_field( 'image_text', 'options' );
			}
			if ( 'Submit Image' === $translated_text && get_field( 'submit_image_text', 'options' ) ) {
				$translated_text = get_field( 'submit_image_text', 'options' );
			}
			if ( 'Music' === $translated_text && get_field( 'music_text', 'options' ) ) {
				$translated_text = get_field( 'music_text', 'options' );
			}
			if ( 'Submit Music' === $translated_text && get_field( 'submit_music_text', 'options' ) ) {
				$translated_text = get_field( 'submit_music_text', 'options' );
			}
			if ( 'List' === $translated_text && get_field( 'list_text', 'options' ) ) {
				$translated_text = get_field( 'list_text', 'options' );
			}
			if ( 'Submit List' === $translated_text && get_field( 'submit_list_text', 'options' ) ) {
				$translated_text = get_field( 'submit_list_text', 'options' );
			}
			if ( 'Poll' === $translated_text && get_field( 'poll_text', 'options' ) ) {
				$translated_text = get_field( 'poll_text', 'options' );
			}
			if ( 'Submit Poll' === $translated_text && get_field( 'submit_poll_text', 'options' ) ) {
				$translated_text = get_field( 'submit_poll_text', 'options' );
			}
			if ( 'Trivia Quiz' === $translated_text && get_field( 'trivia_quiz_text', 'options' ) ) {
				$translated_text = get_field( 'trivia_quiz_text', 'options' );
			}
			if ( 'Submit Trivia Quiz' === $translated_text && get_field( 'submit_trivia_quiz_text', 'options' ) ) {
				$translated_text = get_field( 'submit_trivia_quiz_text', 'options' );
			}
			if ( 'featured' === $translated_text && get_field( 'featured_text', 'options' ) ) {
				$translated_text = get_field( 'featured_text', 'options' );
			}
			if ( 'trending' === $translated_text && get_field( 'trending_text', 'options' ) ) {
				$translated_text = get_field( 'trending_text', 'options' );
			}
			if ( 'My Settings' === $translated_text && get_field( 'my_settings_text', 'options' ) ) {
				$translated_text = get_field( 'my_settings_text', 'options' );
			}
			if ( 'Inbox' === $translated_text && get_field( 'inbox_text', 'options' ) ) {
				$translated_text = get_field( 'inbox_text', 'options' );
			}
			if ( 'Private Messages' === $translated_text && get_field( 'private_messages_text', 'options' ) ) {
				$translated_text = get_field( 'private_messages_text', 'options' );
			}
			if ( 'My Dashboard' === $translated_text && get_field( 'my_dashboard_text', 'options' ) ) {
				$translated_text = get_field( 'my_dashboard_text', 'options' );
			}
			if ( 'Submit Post' === $translated_text && get_field( 'submit_post_text', 'options' ) ) {
				$translated_text = get_field( 'submit_post_text', 'options' );
			}
			if ( 'Save' === $translated_text && get_field( 'save_text', 'options' ) ) {
				$translated_text = get_field( 'save_text', 'options' );
			}
			if ( 'Add New' === $translated_text && get_field( 'add_new_text', 'options' ) ) {
				$translated_text = get_field( 'add_new_text', 'options' );
			}
			if ( 'Select Image' === $translated_text && get_field( 'select_image_text', 'options' ) ) {
				$translated_text = get_field( 'select_image_text', 'options' );
			}
			if ( 'Bookmark' === $translated_text && get_field( 'bookmark_text', 'options' ) ) {
				$translated_text = get_field( 'bookmark_text', 'options' );
			}
			if ( 'My Bookmarks' === $translated_text && get_field( 'my_bookmarks_text', 'options' ) ) {
				$translated_text = get_field( 'my_bookmarks_text', 'options' );
			}
			if ( 'Stories' === $translated_text && get_field( 'stories_text', 'options' ) ) {
				$translated_text = get_field( 'stories_text', 'options' );
			}
			if ( 'Create Story' === $translated_text && get_field( 'create_story_text', 'options' ) ) {
				$translated_text = get_field( 'create_story_text', 'options' );
			}
			if ( 'Story' === $translated_text && get_field( 'story_text', 'options' ) ) {
				$translated_text = get_field( 'story_text', 'options' );
			}
			return $translated_text;
		}
		add_filter( 'gettext', 'king_change_text', 20 );
	endif;

	if ( 'king-grid-10' === get_field( 'select_default_display_option', 'options' ) ) :
		if ( function_exists( 'acf_add_local_field_group' ) ) :
			acf_add_local_field_group(
				array(
					'key'                   => 'group_5ea30e5d50d86',
					'title'                 => 'Post Size',
					'fields'                => array(
						array(
							'key'               => 'field_5ea30e84c5c54',
							'label'             => 'Post Size',
							'name'              => 'post_size',
							'type'              => 'radio',
							'instructions'      => '',
							'required'          => 0,
							'conditional_logic' => 0,
							'wrapper'           => array(
								'width' => '',
								'class' => '',
								'id'    => '',
							),
							'choices'           => array(
								'king-size-1x' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-1x.svg" height="150" width="150" />',
								'king-size-2x' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-2x.svg" height="150" width="150" />',
								'king-size-2y' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-2y.svg" height="150" width="150" />',
								'king-size-4x' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-4x.svg" height="150" width="150" />',
								'king-size-6x' => '<img src="../wp-content/themes/king/layouts/imgs/templates/post-size/size-6x.svg" height="150" width="150" />',
							),
							'allow_null'        => 0,
							'other_choice'      => 0,
							'default_value'     => '',
							'layout'            => 'horizontal',
							'return_format'     => 'value',
							'save_other_choice' => 0,
						),
					),
					'location'              => array(
						array(
							array(
								'param'    => 'post_type',
								'operator' => '==',
								'value'    => 'post',
							),
						),
					),
					'menu_order'            => 3,
					'position'              => 'normal',
					'style'                 => 'default',
					'label_placement'       => 'top',
					'instruction_placement' => 'label',
					'hide_on_screen'        => '',
					'active'                => true,
					'description'           => '',
				)
			);
		endif;
	endif;
	if ( ! function_exists( 'king_excerpt_length' ) ) :
		/**
		 * Length of post content in homepage.
		 *
		 * @param <type> $length The length.
		 *
		 * @return int ( description_of_the_return_value )
		 */
		function king_excerpt_length( $length ) {
			return 10;
		}
		add_filter( 'excerpt_length', 'king_excerpt_length' );
	endif;
	if ( ! function_exists( 'king_gifs' ) ) :
		/**
		 * Search Gifs.
		 */
		function king_gifs() {
			if ( get_field( 'enable_gifs_comments', 'options' ) ) :
				$keyword = sanitize_text_field( wp_unslash( $_POST['keyword'] ) );
				$api_key = get_field( 'giphy_api_key', 'options' );
				if ( $keyword ) {
					$url = 'http://api.giphy.com/v1/gifs/search?q=' . $keyword . '&api_key=' . $api_key . '&limit=15';
				} else {
					$url = 'https://api.giphy.com/v1/gifs/trending?api_key=' . $api_key . '&limit=15';
				}
				$access   = wp_remote_get( $url );
				$response = json_decode( $access['body'], true );
				$results  = $response['data'];
				foreach ( $results as $result ) {
					echo '<div class="king-gif" data-embed="' . esc_attr( $result['embed_url'] ) . '"><img src="https://i.giphy.com/media/' . esc_attr( $result['id'] ) . '/200.webp" /></div>';
				}
				die();
			endif;
		}
		add_action( 'wp_ajax_king_gifs', 'king_gifs' );
		add_action( 'wp_ajax_nopriv_king_gifs', 'king_gifs' );
	endif;
	if ( ! function_exists( 'king_replace_gifs' ) ) :
		/**
		 * Replace gif link to video.
		 *
		 * @param <type> $comment_text The comment text.
		 * @param <type> $comment The comment.
		 * @param <type> $args The arguments.
		 *
		 * @return     <type>  ( description_of_the_return_value )
		 */
		function king_replace_gifs( $comment_text, $comment, $args ) {
			if ( preg_match_all( '/<a href="https:\/\/giphy\.com\/embed\/([^"]+)"[^>]+>[^<]+<\/a>/', $comment_text, $output ) ) {
				$div  = '<div class="kinggif">';
				$div .= '<video preload="none" autoplay muted loop playsinline>';
				$div .= '<source src="https://media1.giphy.com/media/%s/giphy.mp4" type="video/mp4">';
				$div .= '</video>';
				$div .= '<span>' . esc_html__( 'by Giphy', 'king' ) . '</span>';
				$div .= '</div>';
				$urls = $output[0];
				$ids  = $output[1];
				foreach ( $urls as $index => $url ) {
					$video        = sprintf( $div, $ids[ $index ] );
					$comment_text = str_replace( $url, $video, $comment_text );
				}
			}
			return $comment_text;
		}
		add_filter( 'comment_text', 'king_replace_gifs', 10, 3 );
	endif;
	if ( ! function_exists( 'king_submit_ajax_comment' ) ) :
		/**
		 * Comment submit ajax.
		 */
		function king_submit_ajax_comment() {
			$comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
			$creact = wp_filter_post_kses( $_POST['creact'] );
			if ( $creact ) {
				update_field( 'comments_reactions', $creact, get_comment($comment->comment_ID) );
				update_comment_meta( $comment->comment_ID, '_comments_reactions', 'field_5c9bee01a519a' );
				$comment_id_7    = get_comment( $comment->comment_ID );
				$comment_post_id = $comment_id_7->comment_post_ID ;
				$total = get_post_meta( $comment_post_id, 'king_reaction_' . $creact . '', true );
				$total2 = $total ? $total : 0;
				$total3 = (int) $total2 + 1;

				update_post_meta( $comment_post_id, 'king_reaction_' . $creact . '', $total3 );
			}

			if ( is_wp_error( $comment ) ) {
				$error_data = intval( $comment->get_error_data() );
				if ( ! empty( $error_data ) ) {
					wp_die( '' . $comment->get_error_message() . '', esc_html__( 'Comment Submission Failure', 'king' ), array( 'response' => $error_data, 'back_link' => true ) );
				} else {
					wp_die( 'Unknown error' );
				}
			}

			$user = wp_get_current_user();
			do_action( 'set_comment_cookies', $comment, $user );
			$comment_depth  = 1;
			$comment_parent = $comment->comment_parent;
			while ( $comment_parent ) {
				$comment_depth++;
				$parent_comment = get_comment( $comment_parent );
				$comment_parent = $parent_comment->comment_parent;
			}
			$GLOBALS['comment']       = $comment;
			$GLOBALS['comment_depth'] = $comment_depth;
			$comment_html             = king_comment( $comment, array(), $comment_depth );
			echo $comment_html;
			die();
		}
		add_action( 'wp_ajax_king_submit_ajax_comment', 'king_submit_ajax_comment' );
		add_action( 'wp_ajax_nopriv_king_submit_ajax_comment', 'king_submit_ajax_comment' );
	endif;

	if ( ! function_exists( 'king_modify_comment_fields' ) ) :
		/**
		 * Modify Default Comments.
		 *
		 * @param <type> $fields  The fields.
		 *
		 * @return <type> ( description_of_the_return_value )
		 */
		function king_modify_comment_fields( $fields ) {

			$gifhtml = '<div class="king-comment-extra">';
			if ( get_field( 'enable_gifs_comments', 'options' ) ) :
				$gifhtml .= '<div class="king-gif-toggle" data-toggle="dropdown" data-target=".king-gifs" aria-expanded="true">GIF</div>';
				$gifhtml .= '<div class="king-gifs">
							<div class="king-gif-search">
								<input type="search" id="king-gifs" placeholder="' . esc_html__( 'Search', 'king' ) . '"  autocomplete="off" />
							</div>
							<div id="kingif-results"></div>
						</div>';
			endif;
			if ( get_field( 'enable_emoji_comments', 'options' ) ) :
				$gifhtml .= '<div class="king-emj-toggle" data-toggle="dropdown" data-target=".king-emj" aria-expanded="true"><i class="far fa-smile-wink"></i></div>';
				$gifhtml .= '<div class="king-emj"></div>';
			endif;
			$gifhtml .= '</div>';

			if ( get_field( 'author_image', 'user_' . get_current_user_id() ) ) :
				$image  = get_field( 'author_image', 'user_' . get_current_user_id() );
				$avatar = '<div class="user-cfrom-avatar" style="background-image:url(' . esc_url( $image['sizes']['thumbnail'] ) . ');" ></div>';
			else :
				$avatar = '<div class="user-cfrom-avatar"></div>';
			endif;

			if ( get_field( 'enable_reactions', 'option' ) ) :
			$creact = '<div class="king-reactions">
			<ul id="creact">
			    <li>
					<input id="cr-like" name="creact" type="radio" value="like"/>
					<label for="cr-like">'.king_rtexts('like').'</label>
			    </li>
			    <li>
					<input id="cr-love" name="creact" type="radio" value="love"/>
					<label for="cr-love">'.king_rtexts('love').'</label>
			    </li>
			    <li>
					<input id="cr-haha" name="creact" type="radio" value="haha"/>
					<label for="cr-haha">'.king_rtexts('haha').'</label>
			    </li>
			    <li>
					<input id="cr-wow" name="creact" type="radio" value="wow"/>
					<label for="cr-wow">'.king_rtexts('wow').'</label>
			    </li>
			    <li>
					<input id="cr-sad" name="creact" type="radio" value="sad"/>
					<label for="cr-sad">'.king_rtexts('sad').'</label>
			    </li>
			    <li>
			        <input id="cr-angry" name="creact" type="radio" value="angry"/>
			        <label for="cr-angry">'.king_rtexts('angry').'</label>
			    </li>
			</ul>
			</div>';
			else :
				$creact = '';
			endif;
			$fields['comment_field']      = '<div class="show-gif"></div><div class="comment-form-comment"><textarea id="comment" name="comment" aria-required="true" placeholder="' . esc_html__( 'Comment*', 'king' ) . '" ></textarea>' . $gifhtml . '</div>'.$creact;
			$fields['title_reply']        = $avatar;
			$fields['title_reply_before'] = '';
			$fields['cancel_reply_link']  = '<i class="fas fa-times"></i>';
			$fields['logged_in_as']       = '';
			return $fields;

		}
		add_filter( 'comment_form_defaults', 'king_modify_comment_fields' );
	endif;

		if ( ! function_exists( 'king_emoji' ) ) :
		/**
		 * King Emoji for comments.
		 */
		function king_emoji() {
			if ( get_field( 'enable_emoji_comments', 'options' ) ) :
				$output = '<div class="kingemj-smileys">';
				if ( ! get_field( 'hide_default_emojis', 'options' ) ) :
					$output .= '<span class="emojis" data-emj="🙂">🙂</span>
					<span class="emojis" data-emj="😊">😊</span>
					<span class="emojis" data-emj="😃">😃</span>
					<span class="emojis" data-emj="😅">😅</span>
					<span class="emojis" data-emj="🤣">🤣</span>
					<span class="emojis" data-emj="😊">😊</span>
					<span class="emojis" data-emj="😇">😇</span>
					<span class="emojis" data-emj="🙃">🙃</span>
					<span class="emojis" data-emj="😍">😍</span>
					<span class="emojis" data-emj="🥰">🥰</span>
					<span class="emojis" data-emj="😘">😘</span>
					<span class="emojis" data-emj="😝">😝</span>
					<span class="emojis" data-emj="😎">😎</span>
					<span class="emojis" data-emj="☹️">☹️</span>
					<span class="emojis" data-emj="😢">😢</span>
					<span class="emojis" data-emj="😡">😡</span>
					<span class="emojis" data-emj="😱">😱</span>
					<span class="emojis" data-emj="🤭">🤭</span>
					<span class="emojis" data-emj="🙄">🙄</span>
					<span class="emojis" data-emj="😬">😬</span>
					<span class="emojis" data-emj="😈">😈</span>
					<span class="emojis" data-emj="🥴">🥴</span>
					<span class="emojis" data-emj="🤕">🤕</span>
					<span class="emojis" data-emj="💩">💩</span>';
					$output .= '<span class="emojis" data-emj="👋">👋</span>
					<span class="emojis" data-emj="🤚">🤚</span>
					<span class="emojis" data-emj="👌">👌</span>
					<span class="emojis" data-emj="🤞">🤞</span>
					<span class="emojis" data-emj="🤟">🤟</span>
					<span class="emojis" data-emj="🖕">🖕</span>
					<span class="emojis" data-emj="👍">👍</span>
					<span class="emojis" data-emj="👊">👊</span>
					<span class="emojis" data-emj="👏">👏</span>
					<span class="emojis" data-emj="🙏">🙏</span>
					<span class="emojis" data-emj="💋">💋</span>
					<span class="emojis" data-emj="👅">👅</span>
					<span class="emojis" data-emj="🐶">🐶</span>
					<span class="emojis" data-emj="🙈">🙈</span>
					<span class="emojis" data-emj="🙉">🙉</span>
					<span class="emojis" data-emj="🙊">🙊</span>
					<span class="emojis" data-emj="🐥">🐥</span>
					<span class="emojis" data-emj="❤️">❤️</span>
					<span class="emojis" data-emj="🔞">🔞</span>
					<span class="emojis" data-emj="💯">💯</span>
					<span class="emojis" data-emj="🤑">🤑</span>
					<span class="emojis" data-emj="👹">👹</span>
					<span class="emojis" data-emj="🧠">🧠</span>
					<span class="emojis" data-emj="🎅">🎅</span>';
				endif;
				$emojis = get_field( 'add_new_emoji', 'option' );
				if ( $emojis ) :
					foreach ( $emojis as $emoji ) :
						$emo = $emoji['emoji'];
						$output .= '<span class="emojis" data-emj="' . esc_attr( $emo ) . '">' . esc_attr( $emo ) . '</span>';
					endforeach;
				endif;
				$output .= '</div>';
				echo $output;
				die();
			endif;
		}
		add_action( 'wp_ajax_king_emoji', 'king_emoji' );
		add_action( 'wp_ajax_nopriv_king_emoji', 'king_emoji' );
	endif;
	if ( ! function_exists( 'king_vote' ) ) :
		/**
		 * Vote Function.
		 *
		 * @param <type> $post_id  The post identifier.
		 * @param <type> $format The format.
		 *
		 * @return string ( description_of_the_return_value )
		 */
		function king_vote( $post_id, $format = null, $down = false ) {
			$nonce   = wp_create_nonce( 'king_vote_nonce' );
			$user_id = get_current_user_id();
			if ( 'c' === $format ) {
				$like    = get_comment_meta( $post_id, 'king_vote_likes' );
				$dislike = get_comment_meta( $post_id, 'king_vote_dislikes' );
				$lcount  = get_comment_meta( $post_id, 'king_like_count', true );
				$dcount  = get_comment_meta( $post_id, 'king_dislike_count', true );
			} elseif ( 'p' === $format ) {
				$like    = get_post_meta( $post_id, 'king_vote_likes' );
				$dislike = get_post_meta( $post_id, 'king_vote_dislikes' );
				$lcount  = get_post_meta( $post_id, 'king_like_count', true );
				$dcount  = get_post_meta( $post_id, 'king_dislike_count', true );
			}
			$voted   = '';
			$active  = '';
			$active2 = '';
			$lke = is_array($like) ? $like : '';
			$dlke = is_array($dislike) ? $dislike : '';
			if ( $like && in_array( $user_id, $like['0'] ) ) {
				$voted  = ' voted';
				$active = ' active';
			} elseif ( $dlke && in_array( $user_id, $dislike['0'] ) ) {
				$voted   = ' voted';
				$active2 = ' active';
			}
			if ( !is_user_logged_in() ) {
				$nlog = ' data-target="#myModal" data-toggle="modal"';
			} else {
				$nlog = '';
			}
			$iconup   = get_field( 'up_vote_custom_icon', 'options' ) ? get_field( 'up_vote_custom_icon', 'options' ) : '<i class="fas fa-chevron-up"></i>';
			$icondown = get_field( 'down_vote_custom_icon', 'options' ) ? get_field( 'down_vote_custom_icon', 'options' ) : '<i class="fas fa-chevron-down"></i>';
			$count    = king_vote_count( $post_id, $format );

			$output  = '<div class="king-vote' . esc_attr( $voted ) . '" data-id="' . esc_attr( $post_id ) . '" data-nonce="' . esc_attr( $nonce ) . '" data-number="' . esc_attr( $count['number'] ) . '" data-format="' . esc_attr( $format ) . '">';
			$output .= '<span class="king-vote-icon king-vote-like' . esc_attr( $active ) . '" data-action="like" ' . wp_kses_post( $nlog ) . '>' . wp_kses_post( $iconup ) . '</span>';
			$output .= '<span class="king-vote-count">' . esc_attr( $count['sl'] ) . '</span>';
			if ( false === $down ) {
				$output .= '<span class="king-vote-icon king-vote-dislike' . esc_attr( $active2 ) . '" data-action="dislike" ' . wp_kses_post( $nlog ) . '>' . wp_kses_post( $icondown ) . '</span>';
			}
			$output .= '</div>';
			return $output;
		}
	endif;
	if ( ! function_exists( 'king_vote_ajax' ) ) :
		/**
		 * Vote Ajax Calls.
		 */
		function king_vote_ajax() {
			$user_id          = get_current_user_id();
			$post_id          = sanitize_text_field( wp_unslash( $_POST['post_id'] ) );
			$type             = sanitize_text_field( wp_unslash( $_POST['type'] ) );
			$format           = sanitize_text_field( wp_unslash( $_POST['format'] ) );
			$nonce            = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			$response['done'] = false;
			if ( ! wp_verify_nonce( $nonce, 'king_vote_nonce' ) ) {
				die( '-1' );
			} elseif ( ! is_user_logged_in() ) {
				die( '-1' );
			} elseif ( empty( $post_id ) ) {
				die( '-1' );
			}
			if ( 'c' === $format ) {
				$like    = get_comment_meta( $post_id, 'king_vote_likes' );
				$dislike = get_comment_meta( $post_id, 'king_vote_dislikes' );
			} elseif ( 'p' === $format ) {
				$like    = get_post_meta( $post_id, 'king_vote_likes' );
				$dislike = get_post_meta( $post_id, 'king_vote_dislikes' );
			}

			if ( 'like' === $type ) {
				$lk    = $like;
				$cantlike = $dislike;
			} elseif ( 'dislike' === $type ) {
				$lk    = $dislike;
				$cantlike = $like;
			}
			$likess = is_array($lk) ? $lk[0] : '';
			$clike = is_array($cantlike) ? $cantlike[0] : '';
			if ( $likess && in_array( $user_id, $likess ) ) {
				$likes = check_array( $user_id, $lk );
				if ( $likes ) {
					$uid_key = array_search( $user_id, $likes );
					unset( $likes[ $uid_key ] );
					if ( 'c' === $format ) {
						if ( 'like' === $type ) {
							update_comment_meta( $post_id, 'king_vote_likes', $likes );
							$count = get_comment_meta( $post_id, 'king_like_count', true );
							$total = (int) $count - 1;
							update_comment_meta( $post_id, 'king_like_count', $total );
						} elseif ( 'dislike' === $type ) {
							update_comment_meta( $post_id, 'king_vote_dislikes', $likes );
							$count = get_comment_meta( $post_id, 'king_dislike_count', true );
							$total = (int) $count - 1;
							update_comment_meta( $post_id, 'king_dislike_count', $total );
						}
					} elseif ( 'p' === $format ) {
						if ( 'like' === $type ) {
							update_post_meta( $post_id, 'king_vote_likes', $likes );
							$count = get_post_meta( $post_id, 'king_like_count', true );
							$total = (int) $count - 1;
							update_post_meta( $post_id, 'king_like_count', $total );
						} elseif ( 'dislike' === $type ) {
							update_post_meta( $post_id, 'king_vote_dislikes', $likes );
							$count = get_post_meta( $post_id, 'king_dislike_count', true );
							$total = (int) $count - 1;
							update_post_meta( $post_id, 'king_dislike_count', $total );
						}
					}

					$response['status'] = 'unvoted';
					$response['done']   = true;
				}
			} elseif ( ! $clike ) {
				$liks = check_array( $user_id, $lk );
				if ( 'c' === $format ) {
					if ( 'like' === $type ) {
						update_comment_meta( $post_id, 'king_vote_likes', $liks );
						$count = get_comment_meta( $post_id, 'king_like_count', true );
						$total = (int) $count + 1;
						update_comment_meta( $post_id, 'king_like_count', $total );
						if ( get_field( 'enable_notification', 'options' ) ) {
							king_create_notify( $post_id, 'clike', 'c' );
						}
					} elseif ( 'dislike' === $type ) {
						update_comment_meta( $post_id, 'king_vote_dislikes', $liks );
						$count = get_comment_meta( $post_id, 'king_dislike_count', true );
						$total = (int) $count + 1;
						update_comment_meta( $post_id, 'king_dislike_count', $total );
						if ( get_field( 'enable_notification', 'options' ) ) {
							king_create_notify( $post_id, 'cdislike', 'c' );
						}
					}
				} elseif ( 'p' === $format ) {
					if ( 'like' === $type ) {
						update_post_meta( $post_id, 'king_vote_likes', $liks );
						$count = get_post_meta( $post_id, 'king_like_count', true );
						$total = (int) $count + 1;
						update_post_meta( $post_id, 'king_like_count', $total );
						if ( get_field( 'enable_notification', 'options' ) ) {
								king_create_notify( $post_id, 'like' );
						}
					} elseif ( 'dislike' === $type ) {
						update_post_meta( $post_id, 'king_vote_dislikes', $liks );
						$count = get_post_meta( $post_id, 'king_dislike_count', true );
						$total = (int) $count + 1;
						update_post_meta( $post_id, 'king_dislike_count', $total );
						if ( get_field( 'enable_notification', 'options' ) ) {
							king_create_notify( $post_id, 'dislike' );
						}
					}
				}
				$response['status'] = 'voted';
				$response['done']   = true;
			}
			wp_send_json( $response );
			die();
		}
		add_action( 'wp_ajax_nopriv_king_vote_ajax', 'king_vote_ajax' );
		add_action( 'wp_ajax_king_vote_ajax', 'king_vote_ajax' );
	endif;

	if ( ! function_exists( 'king_poll_answer' ) ) :
		/**
		 * Comment submit ajax.
		 */
		function king_poll_answer() {
			if ( is_user_logged_in() ) {
				$user_id = get_current_user_id();
			} else {
				$user_id = king_get_the_user_ip();
			}
			$post_id = sanitize_text_field( wp_unslash( $_POST['postid'] ) );
			$nonce   = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			$parent  = sanitize_text_field( wp_unslash( $_POST['parent'] ) );
			$child   = sanitize_text_field( wp_unslash( $_POST['child'] ) );
			if ( ! wp_verify_nonce( $nonce, 'king_poll_nonce' ) ) {
				die( '-1' );
			} elseif ( empty( $user_id ) ) {
				die( '-1' );
			} elseif ( empty( $post_id ) ) {
				die( '-1' );
			}

			$value = get_post_meta( $post_id, 'king_poll_' . ( $parent - 1 ) . '_poll_results', true );
			if ( isset( $value )  ) {
				$king_results = maybe_unserialize( $value );
			}
			if ( ! is_array( $king_results ) ) {
				$king_results = array();
			}
			if (  ! array_key_exists( $user_id, $king_results ) ) {
				$king_results[ $user_id ] = $child;
				$king_result              = maybe_serialize( $king_results );
				update_sub_field( array( 'king_poll', $parent, 'poll_results' ), $king_result, $post_id );
				wp_send_json_success();
				die();
			} else {
				wp_send_json_error();
				die();
			}
		}
		add_action( 'wp_ajax_king_poll_answer', 'king_poll_answer' );
		add_action( 'wp_ajax_nopriv_king_poll_answer', 'king_poll_answer' );
	endif;

	if ( ! function_exists( 'king_quiz_answer' ) ) :
		/**
		 * Comment submit ajax.
		 */
		function king_quiz_answer() {

			$post_id = sanitize_text_field( wp_unslash( $_POST['postid'] ) );
			$nonce   = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			$total   = sanitize_text_field( wp_unslash( $_POST['total'] ) );
			$correct = sanitize_text_field( wp_unslash( $_POST['correct'] ) );
			$rate    = round( 100 * $correct / $total );
			$rotate  = round( ( $correct * 100 ) / ( $total ) );
			$title   = get_the_title( $post_id ) . ' - ' . sprintf( __( 'I got %1$d out of %2$d right! Do you wanna try ?', 'king' ), absint( $correct ), absint( $total ) );

			$output  = '';
			if ( have_rows( 'quiz_results', $post_id ) ) :
				while ( have_rows( 'quiz_results', $post_id ) ) :
					the_row();
					$rdesc  = get_sub_field( 'quiz_result_description' );
					$rimage = get_sub_field( 'quiz_result_image' );
					$rtitle = get_sub_field( 'quiz_result' );
					$high   = get_sub_field( 'result_range_high' );
					$low    = get_sub_field( 'result_range_low' );
					if ( $rate >= $low && $rate <= $high ) :
						$output .= '<div class="quiz-result">';

						$output .= '<div class="result-circle">
							<svg class="circle" viewbox="0 0 40 40">
								<circle class="circle-back" fill="none" cx="20" cy="20" r="15.9"/>
								<circle class="circle-chart" stroke-dasharray="' . esc_attr( $rotate ) . ',100" stroke-linecap="round" fill="none" cx="20" cy="20" r="15.9"/>
							</svg>
							<div class="result-circle-in">' . esc_attr( $correct . ' / ' . $total ) . '</div>
						</div>';

						$output .= '<h3>' . $rtitle . '</h3>';
						if ( $rimage ) :
							$output .= '<img src="' . esc_url( $rimage['sizes']['medium_large'] ) . '" alt="' . esc_attr( $rimage['alt'] ) . '" />';
						endif;
						$output .= '<span class="qresult-desc">' . $rdesc . '</span>';
						$output .= '<div class="quiz-share">';
						$output .= '<h5>' . esc_html__( 'Share Your Result :', 'king' ) . '</h5>';
						$output .= '<span class="qresult-share">' . king_ft_share( $post_id, $title ) . '</span>';
						$output .= '</div>';
						$output .= '</div>';
						break;
					endif;
				endwhile;
			endif;
			$ext['cont'] = $output;
			$ext['rate'] = $rotate;

			echo wp_send_json( $ext );
			die();
		}
		add_action( 'wp_ajax_king_quiz_answer', 'king_quiz_answer' );
		add_action( 'wp_ajax_nopriv_king_quiz_answer', 'king_quiz_answer' );
	endif;

	if ( ! function_exists( 'king_flag_button' ) ) :
		/**
		 * Flag button.
		 *
		 * @param <type> $post_id  The post identifier.
		 * @param <type> $ptype    The ptype.
		 *
		 * @return     string  ( description_of_the_return_value )
		 */
		function king_flag_button( $post_id, $ptype ) {
			$nonce   = wp_create_nonce( 'king_flag_nonce' );
			$user_id = get_current_user_id();
			if ( 'p' === $ptype ) {
				$flag = get_post_meta( $post_id, 'king_flags' );
			} else {
				$flag = get_comment_meta( $post_id, 'king_flags' );
			}

			$flg = is_array($flag) ? $flag : '';
			$ftitle = __( 'Flag', 'king' );
			if ( $flg && is_super_admin() ) {
				$flaged = ' flagged';
				$fdism  = '1';
				$ftitle = __( 'Dismiss Flags', 'king' );
			} elseif ( $flg && in_array( $user_id, $flag['0'] ) ) {
				$flaged = ' flagged';
				$ftitle = __( 'Unflag', 'king' );
				$fdism  = '0';
			} else {
				$flaged = '';
				$fdism  = '0';
			}
			if ( is_user_logged_in() ) {
				$output  = '<div class="king-flag' . esc_attr( $flaged ) . '" data-id="' . esc_attr( $post_id ) . '" data-type="' . esc_attr( $ptype ) . '" data-nonce="' . esc_attr( $nonce ) . '" data-toggle="tooltip" data-placement="bottom" title="' . esc_attr( $ftitle ) . '" data-ds="' . esc_attr( $fdism ) . '"><i class="far fa-flag"></i></div>';
			} else {
				$output = '<div class="king-flag" data-toggle="dropdown" data-target=".king-alert-like" aria-expanded="false" role="link"><i class="far fa-flag"></i></div>';
			}
			return $output;
		}
	endif;
	if ( ! function_exists( 'king_flag_ajax' ) ) :
		/**
		 * Vote Ajax Calls.
		 */
		function king_flag_ajax() {
			$user_id = get_current_user_id();
			$post_id = sanitize_text_field( wp_unslash( $_POST['id'] ) );
			$ptype   = sanitize_text_field( wp_unslash( $_POST['ty'] ) );
			$nonce   = sanitize_text_field( wp_unslash( $_POST['nonce'] ) );
			$fdis    = sanitize_text_field( wp_unslash( $_POST['ds'] ) );
			if ( ! wp_verify_nonce( $nonce, 'king_flag_nonce' ) ) {
				die( '-1' );
			} elseif ( ! is_user_logged_in() ) {
				die( '-1' );
			} elseif ( empty( $post_id ) ) {
				die( '-1' );
			}
			if ( 'p' === $ptype ) {
				$like = get_post_meta( $post_id, 'king_flags' );
			} else {
				$like = get_comment_meta( $post_id, 'king_flags' );
			}

			$likes  = check_array( $user_id, $like );
			$count  = get_option( 'king_flag_count' );
			if ( $fdis == 1 ) {
				if ( 'p' === $ptype ) {
					delete_post_meta( $post_id, 'king_flags' );
				} else {
					delete_comment_meta( $post_id, 'king_flags' );
				}
			} else {
				$lks = is_array( $like ) ? $like[0] : '';
				if ( $lks && in_array( $user_id, $lks ) ) {
					if ( $likes ) {
						$uid_key = array_search( $user_id, $likes, true );
						unset( $likes[ $uid_key ] );
						if ( 0 === count( $likes ) ) {
							if ( 'p' === $ptype ) {
								delete_post_meta( $post_id, 'king_flags' );
							} else {
								delete_comment_meta( $post_id, 'king_flags' );
							}
						} else {
							if ( 'p' === $ptype ) {
								update_post_meta( $post_id, 'king_flags', $likes );
							} else {
								update_comment_meta( $post_id, 'king_flags', $likes );
							}
						}
						$nototal = (int) $count - 1;
						update_option( 'king_flag_count', $nototal );
						echo '0';
					}
				} else {
					if ( get_field( 'hide_posts_flag', 'options' ) ) {
						$amount = get_field( 'hide_after_this_amount', 'options' );
						if ( 'p' === $ptype ) {
							update_post_meta( $post_id, 'king_flags', $likes );
							if ( $amount == count( $like ) ) {
								wp_update_post( array( 'ID' => $post_id, 'post_status' => 'pending' ) );
							}
						} else {
							update_comment_meta( $post_id, 'king_flags', $likes );
							if ( $amount == count( $like ) ) {
								wp_set_comment_status( $post_id, 'hold' );
							}
						}
					} else {
						if ( 'p' === $ptype ) {
							update_post_meta( $post_id, 'king_flags', $likes );
						} else {
							update_comment_meta( $post_id, 'king_flags', $likes );
						}
					}
					if ( empty( $count ) || '' === $count ) {
						$count = 0;
					}
					$nototal = (int) $count + 1;
					update_option( 'king_flag_count', $nototal );
					echo '1';
				}
			}
			die();
		}
		add_action( 'wp_ajax_nopriv_king_flag_ajax', 'king_flag_ajax' );
		add_action( 'wp_ajax_king_flag_ajax', 'king_flag_ajax' );
	endif;
	if ( ! function_exists( 'king_show_flag' ) ) :
		/**
		 * Show flagged posts with ajax.
		 */
		function king_show_flag() {

			$flags     = get_posts( array( 'meta_key' => 'king_flags', 'post_type' => king_post_types(), 'post_status'    => array( 'pending', 'publish' ), 'posts_per_page' => '24' ) );
			$fcomments = get_comments( array( 'meta_key' => 'king_flags' ) );
			$ftext     = '';
			if ( $flags || $fcomments ) {
				if ( $flags ) {
					foreach ( $flags as $flag ) {
						$gflag = get_post_meta( $flag->ID, 'king_flags' );
						$ftext .= '<li><i class="far fa-flag"></i>' . king_who_flagged( $gflag ) . '' . esc_html__( ' flagged post  ', 'king' ) . ' <a href="' . get_permalink( $flag->ID ) . '" >' . esc_attr( get_the_title( $flag->ID ) ) . '</a></li>';
					}
				}
				if ( $fcomments ) {
					foreach ( $fcomments as $fcomment ) {
						$gflag = get_comment_meta( $fcomment->comment_ID, 'king_flags' );
						$ftext .= '<li><i class="far fa-flag"></i>' . king_who_flagged( $gflag ) . '' . esc_html__( 'flagged comment ', 'king' ) . ' <a href="' . get_comment_link( $fcomment->comment_ID ) . '" >' . esc_html__( 'comment#', 'king' ) . esc_attr( $fcomment->comment_ID ) . '</a></li>';
					}
				}
			} else {
				$ftext .= '<li class="king-clean-center"><i class="fas fa-fish"></i><br>' . esc_html__( 'Nothing new right now !', 'king' ) . '</li>';
			}
			delete_option( 'king_flag_count' );
			echo $ftext;
			die();
		}
		add_action( 'wp_ajax_nopriv_king_show_flag', 'king_show_flag' );
		add_action( 'wp_ajax_king_show_flag', 'king_show_flag' );
	endif;
	if ( ! function_exists( 'king_who_flagged' ) ) :
		/**
		 * Who flagged function.
		 *
		 * @param <type> $flags The flags.
		 *
		 * @return string ( description_of_the_return_value )
		 */
		function king_who_flagged( $flags ) {
			$ftitle = '';
			foreach ( $flags['0'] as $flag ) {
				$ftitle .= '<a href="' . esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . get_user_by( 'id', $flag )->user_login ) . '">' . get_user_by( 'id', $flag )->user_login . '</a>, ';
			}
			return $ftitle;
		}
	endif;
	if ( ! function_exists( 'king_homepage_login' ) ) :
		/**
		 * Login as homepage.
		 */
		function king_homepage_login() {
			if ( get_field( 'enable_homepage_login', 'options' ) ) :
				if ( ! get_query_var( 'bplogin' ) && ! get_query_var( 'bpregister' ) && ! get_query_var( 'bpreset' ) && ! is_user_logged_in() ) {
					wp_safe_redirect(  site_url() . '/' . $GLOBALS['king_login']  ); 
				}
			endif;
		}
		add_action( 'template_redirect', 'king_homepage_login' );
	endif;
	if ( ! function_exists( 'king_highlights' ) ) :
		/**
		 * King highlist story function.
		 */
		function king_highlights() {
			if ( ! is_user_logged_in() ) {
				die( '-1' );
			}
			$postid = ( isset( $_POST['to_book'] ) && is_numeric( $_POST['to_book'] ) ) ? $_POST['to_book'] : '';
			if ( empty( $postid ) ) {
				die( '-1' );
			}
			if ( metadata_exists( 'post', $postid, 'king_highlights' ) ) {
				delete_post_meta( $postid, 'king_highlights' );
			} else {
				update_post_meta( $postid, 'king_highlights', true );
				echo '1';
			}
			die();
		}
		add_action( 'wp_ajax_nopriv_king_highlights', 'king_highlights' );
		add_action( 'wp_ajax_king_highlights', 'king_highlights' );
	endif;
endif;
	if ( ! function_exists( 'king_social_share' ) ) :
		/**
		 * Social Share buttons.
		 */
		function king_social_share() {
			$pid = get_the_ID();
			$thumb = wp_get_attachment_url( get_post_thumbnail_id( $pid ) );
			$ttle = get_the_title( $pid );
			$urll = get_permalink( $pid );
			?>
			<div class="share-buttons">
				<?php echo king_ft_share( $pid, $ttle ); ?>
				<?php if ( get_field( 'display_pinterest_share_button', 'options' ) ) : ?>
					<a class="social-icon share-pin" data-dialog="pin-share-dialog" data-share="//pinterest.com/pin/create/button/?url=<?php echo esc_url( $urll ); ?>&amp;media=<?php echo esc_url( $thumb ); ?>&amp;description=<?php echo esc_attr( $ttle ); ?>" href="#" title="<?php esc_html_e( 'Pin this', 'king' ); ?>" rel="nofollow" onclick="kingShare()" data-postid="<?php echo esc_attr( $pid ); ?>" data-shared="0"><i class="fab fa-pinterest-square"></i></a>
				<?php endif; ?>
					<a class="social-icon share-em" href="mailto:?subject=<?php echo esc_attr( $ttle ); ?>&amp;body=<?php echo esc_url( $urll ); ?>" title="<?php esc_html_e( 'Email this', 'king' ); ?>"><i class="fas fa-envelope"></i></a>
				<?php if ( get_field( 'display_reddit_share_button', 'options' ) ) : ?> 
					<a class="social-icon share-pin" data-dialog="reddit-share-dialog" data-share="https://reddit.com/submit?url=<?php echo esc_url( $urll ); ?>&amp;title=<?php echo esc_attr( $ttle ); ?>" href="#" title="<?php esc_html_e( 'Share on Reddit', 'king' ); ?>" rel="nofollow" onclick="kingShare()" data-postid="<?php echo esc_attr( $pid ); ?>" data-shared="0"><i class="fa-brands fa-reddit-alien"></i></a>
				<?php endif; ?> 
				<?php if ( get_field( 'display_thumblr_share_button', 'option' ) ) : ?>
					<a class="social-icon share-tb" data-dialog="tumblr-share-dialog" data-share="http://www.tumblr.com/share/link?url=<?php echo esc_url( $urll ); ?>&amp;name=<?php echo esc_attr( $ttle ); ?>" href="#" title="<?php esc_html_e( 'Share on Tumblr', 'king' ); ?>" rel="nofollow" onclick="kingShare()" data-postid="<?php echo esc_attr( $pid ); ?>" data-shared="0"><i class="fab fa-tumblr-square"></i></a>
				<?php endif; ?>    
				<?php if ( get_field( 'display_linkedin_share_button', 'options' ) ) : ?>  
					<a class="social-icon share-link" data-dialog="link-share-dialog" data-share="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo esc_url( $urll ); ?>&amp;title=<?php echo esc_attr( $ttle ); ?>&amp;source=<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" href="#" title="<?php esc_html_e( 'Share on LinkedIn', 'king' ); ?>" rel="nofollow" onclick="kingShare()" data-postid="<?php echo esc_attr( $pid ); ?>" data-shared="0"><i class="fab fa-linkedin"></i></a>
				<?php endif; ?>      
				<?php if ( get_field( 'display_vk_share_button', 'options' ) ) : ?>
					<a class="social-icon share-vk" data-dialog="vk-share-dialog" data-share="http://vkontakte.ru/share.php?url=<?php echo esc_url( $urll ); ?>" href="#" title="<?php esc_html_e( 'Share on Vk', 'king' ); ?>" rel="nofollow" onclick="kingShare()" data-postid="<?php echo esc_attr( $pid ); ?>" data-shared="0"><i class="fab fa-vk"></i></a>
				<?php endif; ?>  
				<?php if ( get_field( 'display_wapp_share_button', 'options' ) ) : ?> 
					<a class="social-icon share-wapp" href="whatsapp://send?text=<?php echo esc_url( $urll ); ?>" data-action="share/whatsapp/share" title="<?php esc_html_e( 'Share on whatsapp', 'king' ); ?>"><i class="fab fa-whatsapp"></i></a>
				<?php endif; ?>
				<?php if ( is_single() ) : ?>
					<input type="text" id="modal-url" value="<?php echo esc_url( $urll ); ?>">
					<span class="copied" style="display: none;"><?php esc_html_e( 'Link Copied', 'king' ); ?></span>
				<?php endif; ?>
			</div>
			<?php
		}
	endif;
	if ( ! function_exists( 'king_ft_share' ) ) :
		function king_ft_share( $pid, $text ) {
			$output = '<a class="post-share share-fb" data-dialog="facebook-share-dialog" data-share="https://www.facebook.com/sharer/sharer.php?u=' . esc_url( get_permalink( $pid ) ) . '&quote=' . esc_attr( $text ) . '" href="#" title="'.esc_html__( 'Share on Facebook', 'king' ).'" rel="nofollow" onclick="kingShare()" data-postid="'.esc_attr( $pid ).'" data-shared="0"><i class="fab fa-facebook-square"></i></a>';
			$output .= '<a class="social-icon share-tw" data-dialog="twitter-share-dialog" data-share="http://twitter.com/share?text=' . esc_attr( $text ) . '&amp;url=' . esc_url( get_permalink( $pid ) ) . '" href="#" title="'.esc_html__( 'Share on Twitter', 'king' ).'" rel="nofollow" onclick="kingShare()" data-postid="'.esc_attr( $pid ).'" data-shared="0"><i class="fab fa-twitter"></i></a>';
			return $output;
		}
	endif;
	if ( ! function_exists( 'king_share_count' ) ) :
		function king_share_count() {
			$post_id = sanitize_text_field( wp_unslash( $_POST['postid'] ) );
			$sharecounter = get_post_meta( $post_id, 'share_counter', true );
			$sharecounter++;
			update_post_meta( $post_id, 'share_counter', $sharecounter );

			die();
		}
		add_action( 'wp_ajax_king_share_count', 'king_share_count' );
		add_action( 'wp_ajax_nopriv_king_share_count', 'king_share_count' );
	endif;

if ( ! function_exists( 'king_vote_count' ) ) :
	/**
	 * Count Votes.
	 *
	 * @param <type> $post_id The post identifier.
	 * @param <type> $format The format.
	 *
	 * @return <type> ( description_of_the_return_value )
	 */
	function king_vote_count( $post_id, $format ) {
		if ( 'c' === $format ) {
			$lcount = get_comment_meta( $post_id, 'king_like_count', true );
			$dcount = get_comment_meta( $post_id, 'king_dislike_count', true );
		} elseif ( 'p' === $format ) {
			$lcount = get_post_meta( $post_id, 'king_like_count', true );
			$dcount = get_post_meta( $post_id, 'king_dislike_count', true );
		}
		$count['number'] = (int) $lcount - (int) $dcount;
		$count['sl']     = king_sl_format_count( $count['number'] );
		return $count;
	}
endif;
if ( ! function_exists( 'king_get_the_user_ip' ) ) :
	/**
	 * Gets the user ip.
	 *
	 * @return     <type>  The user ip.
	 */
	function king_get_the_user_ip() {
		if ( ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ) );
		} elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ) );
		} else {
			$ip = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
		}
		return ip2long( apply_filters( 'wpb_get_ip', $ip ) );
	}
endif;
if ( ! function_exists( 'king_post_format' ) ) :
	/**
	 * Get post format or type.
	 */
	function king_post_format() {
		$return = '<div class="king-post-format">';
		if ( has_post_format( 'quote' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'quote' ) ) . '" class="pformat-news nav-news">' . esc_html__( 'News', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( has_post_format( 'video' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'video' ) ) . '" class="pformat-video nav-video">' . esc_html__( 'Video', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( has_post_format( 'image' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'image' ) ) . '" class="pformat-image nav-image">' . esc_html__( 'Image', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( has_post_format( 'audio' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'audio' ) ) . '" class="pformat-music nav-music">' . esc_html__( 'music', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( has_post_format( 'link' ) ) :
			$return .= '<a href="' . esc_url( get_post_format_link( 'link' ) ) . '" class="pformat-link nav-link">' . esc_html__( 'link', 'king' ) . '<i class="fa-brands fa-hubspot"></i></a>';
		elseif ( 'list' === get_post_type() ) :
			$return .= '<a href="' . esc_url( get_post_type_archive_link( 'list' ) ) . '" class="pformat-list nav-list">' . esc_html__( 'List', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( 'poll' === get_post_type() ) :
			$return .= '<a href="' . esc_url( get_post_type_archive_link( 'poll' ) ) . '" class="pformat-poll nav-poll">' . esc_html__( 'Poll', 'king' ) . '<i class="far fa-circle"></i></a>';
		elseif ( 'trivia' === get_post_type() ) :
			$return .= '<a href="' . esc_url( get_post_type_archive_link( 'trivia' ) ) . '" class="pformat-trivia nav-trivia">' . esc_html__( 'Trivia Quiz', 'king' ) . '<i class="far fa-circle"></i></a>';
		endif;
		$return .= '</div>';
		return $return;
	}
endif;

if ( ! function_exists( 'king_num_perc' ) ) :
	/**
	 * get number percent
	 *
	 * @param      <type>  $less   The less
	 * @param      <type>  $full   The full
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function king_num_perc( $less, $full ) {
		$return = round( $less * 100 / $full, 2 ) . '%';
		return $return;
	}
endif;
if ( ! function_exists( 'king_excerpt_more' ) ) :
	/**
	 * Filter the excerpt "read more" string.
	 *
	 * @param string $more "Read more" excerpt string.
	 * @return string (Maybe) modified "read more" excerpt string.
	 */
	function king_excerpt_more( $more ) {
		return '...';
	}
	add_filter( 'excerpt_more', 'king_excerpt_more' );
endif;

