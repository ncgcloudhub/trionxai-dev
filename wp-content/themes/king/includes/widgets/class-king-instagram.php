<?php
/**
 * King Instagram Widget.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
/**
 * Instagram Widget class.
 *
 * @see WP_Widget
 */
class King_Instagram extends WP_Widget {

	/**
	 * Sets up a new Instagram widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_instagram',
			'description'                 => esc_html__( 'King Instagram Widget', 'king' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'king-instagram', esc_html__( 'King Instagram Widget', 'king' ), $widget_ops );
		$this->alt_option_name = 'widget_instagram';
	}
	/**
	 * Outputs the content for the current Instagram widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Instagram widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$title  = ( ! empty( $instance['title'] ) ) ? $instance['title'] : ' ';
		$title  = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$usrnme = ( ! empty( $instance['username'] ) ) ? $instance['username'] : '';
		$usrnme = str_replace( '@', '', $usrnme );
		$token  = ( ! empty( $instance['token'] ) ) ? $instance['token'] : '';
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 140;
		$limit  = ( ! empty( $instance['limit'] ) ) ? absint( $instance['limit'] ) : 9;
		echo wp_kses_post( $args['before_widget'] );
		if ( $title ) {
			echo wp_kses_post( $args['before_title'] . '<i class="fab fa-instagram"></i> ' . $title . $args['after_title'] );
		}
		$insta_posts = apply_filters( 'instagram_posts', $this->king_instagram_images( $usrnme, $number, $limit, $token ) );
		if ( is_wp_error( $insta_posts ) ) {
			echo wp_kses_post( $insta_posts->get_error_message() );
			return;
		}
		if ( empty( $insta_posts ) ) {
			echo esc_html__( 'Can not find this username or locked', 'king' );
			return;
		}
		$insta_posts = array_slice( $insta_posts, 0, $limit );
		?>
		<div class="king-insta-posts">
			<ul>
				<?php foreach ( $insta_posts as $item ) : ?>
					<li>
		<a href="<?php echo esc_url( $item['url'] ); ?>" data-king-img-src="<?php echo esc_url( $item['thumb'] ); ?>" class="king-insta-post" title="<?php echo esc_html( $item['text'] ); ?>" target="_blank" ><i class="fab fa-instagram"></i></a>
					</li>
				<?php endforeach; ?>
			</ul>
			<?php if ( $usrnme ) : ?>
				<div class="king-insta-follow"><a href="<?php echo esc_url( '//instagram.com/' . esc_attr( $usrnme ) ); ?>"><i class="fab fa-instagram"></i> <?php esc_html_e( 'Follow', 'king' ); ?></a></div>
			<?php endif; ?>
		</div>
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}
	/**
	 * Gets the instagram images.
	 *
	 * @param <type>  $name The username.
	 * @param integer $time The Cache time.
	 * @param integer $limit The limit of post.
	 * @param integer $token The token of post.
	 *
	 * @return     string   The instagram images.
	 */
	public function king_instagram_images( $name, $time, $limit, $token = null ) {
		$name        = trim( strtolower( $name ) );
		$insta_cache = get_transient( 'king-insta-cache-' . sanitize_title_with_dashes( $name ) );
		if ( false === $insta_cache ) {
			$profile_url = 'https://www.instagram.com/' . esc_attr( $name ) . '/?__a=1';
			$remote      = wp_remote_get( $profile_url );

			if ( empty( $name ) && empty( $token ) || is_wp_error( $remote ) ) {
				return new WP_Error( 'king_insta_no_response', esc_html__( 'Can not connect to Instagram.', 'king' ) );
			} elseif ( $token ) {
				$params = array(
					'sslverify' => false,
					'timeout'   => 100,
				);

				$url      = 'https://graph.instagram.com/me/media?fields=id,caption,media_url,permalink&access_token=' . trim( $token );
				$response = wp_remote_get( $url, $params );

				if ( is_wp_error( $response ) || empty( $response['response']['code'] ) || 200 != $response['response']['code'] ) {
					return new WP_Error( 'king_insta_no_response', esc_html__( 'Could not connect to Instagram API server.', 'king' ) );
				};
				$response = json_decode( wp_remote_retrieve_body( $response ) );
				$insta    = array();
				if ( ! empty( $response->data ) && is_array( $response->data ) ) {
					$i = 1;
					foreach ( $response->data as $image ) {

						$caption   = __( 'Instagram image 2', 'king' );
						$link      = '#';
						$thumbnail = '#';

						if ( ! empty( $image->permalink ) ) {
							$link = esc_url( $image->permalink );
						}

						if ( ! empty( $image->media_url ) ) {
							$thumbnail = esc_url( $image->media_url );
						}
						if ( ! empty( $image->$caption ) ) {
							$caption = wp_kses_post( $image->$caption );
						}

						$insta[] = array(
							'thumb' => $thumbnail,
							'text'  => wp_kses_post( $caption ),
							'url'   => $link,
						);
						if ( $i++ === $limit ) {
							break;
						}
					}

					if ( ! empty( $insta ) ) {
						$insta_cache = base64_encode( serialize( $insta ) );
						set_transient( 'king-insta-cache-' . sanitize_title_with_dashes( $name ), $insta_cache, $time * 60 );
					} else {
						$insta_cache = '';
					}
				}
			} elseif ( 200 !== wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'king_insta_no_response', esc_html__( 'Instagram did not respond', 'king' ) );
			} else {
				$response = wp_remote_retrieve_body( $remote );
				$data     = json_decode( $response, true );
				$images   = isset( $data['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ? $data['graphql']['user']['edge_owner_to_timeline_media']['edges'] : '';
				$insta    = array();
				$i        = 1;
				if ( $images ) {
					foreach ( $images as $image ) {
						$text = __( 'Instagram image', 'king' );
						if ( ! empty( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'] ) ) {
							$text = wp_kses( $image['node']['edge_media_to_caption']['edges'][0]['node']['text'], array() );
						}
						$insta[] = array(
							'text'  => $text,
							'url'   => trailingslashit( '//instagram.com/p/' . $image['node']['shortcode'] ),
							'thumb' => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][0]['src'] ),
							'large' => preg_replace( '/^https?\:/i', '', $image['node']['thumbnail_resources'][2]['src'] ),
						);
						if ( $i++ === $limit ) {
							break;
						}
					}
					if ( ! empty( $insta ) ) {
						$insta_cache = base64_encode( serialize( $insta ) );
						set_transient( 'king-insta-cache-' . sanitize_title_with_dashes( $name ), $insta_cache, $time * 60 );
					} else {
						$insta_cache = '';
					}
				}
			}
		}
		return unserialize( base64_decode( $insta_cache ) );
	}


	/**
	 * Handles updating the settings for the current Instagram instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = sanitize_text_field( $new_instance['title'] );
		$instance['username'] = sanitize_text_field( $new_instance['username'] );
		$instance['token']    = sanitize_text_field( $new_instance['token'] );
		$instance['number']   = (int) $new_instance['number'];
		$instance['limit']    = (int) $new_instance['limit'];
		return $instance;
	}

	/**
	 * Outputs the settings form for the Instagram widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title    = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$username = isset( $instance['username'] ) ? esc_attr( $instance['username'] ) : '';
		$token    = isset( $instance['token'] ) ? esc_attr( $instance['token'] ) : '';
		$number   = isset( $instance['number'] ) ? absint( $instance['number'] ) : 140;
		$limit    = isset( $instance['limit'] ) ? absint( $instance['limit'] ) : 9;
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title :', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>"><?php esc_html_e( 'Username ( without @ ) :', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'username' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'username' ) ); ?>" type="text" value="<?php echo esc_attr( $username ); ?>" />
		</p>
		<p>
			<p><strong>PLEASE NOTE:</strong>The Instagram server will limit connection, so this method may not work with shared hosting plans. Please try to use the token method below.</p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'token' ) ); ?>"><?php esc_html_e( 'Instagram token :', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'token' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'token' ) ); ?>" type="text" value="<?php echo esc_attr( $token ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Cache time ( minutes ):', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>"><?php esc_html_e( 'Number of posts', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'limit' ) ); ?>" type="limit" step="1" min="1" value="<?php echo esc_attr( $limit ); ?>" size="3" />
		</p>
		<?php
	}
}
/**
 * King_instagram_widget function.
 *
 * @return mixed
 */
function king_instagram_widget() {
	register_widget( 'King_Instagram' );
}
add_action( 'widgets_init', 'king_instagram_widget' );
?>
