<?php
/**
 * King Youtube Widget.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
/**
 * Youtube Widget class.
 *
 * @see WP_Widget
 */
class King_Youtube extends WP_Widget {

	/**
	 * Sets up a new Youtube widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_youtube',
			'description'                 => esc_html__( 'King Youtube Widget', 'king' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'king-youtube', esc_html__( 'King Youtube Widget', 'king' ), $widget_ops );
		$this->alt_option_name = 'widget_youtube';
	}
	/**
	 * Outputs the content for the current Youtube widget instance.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Youtube widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$title        = ( ! empty( $instance['title'] ) ) ? $instance['title'] : ' ';
		$title        = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$channel_url  = apply_filters( 'channel_url', $instance['channel_url'] );
		$channel_name = apply_filters( 'channel_name', $instance['channel_name'] );
		$video_url    = apply_filters( 'video_url', $instance['video_url'] );
		echo wp_kses_post( $args['before_widget'] );
		if ( $title ) {
			echo wp_kses_post( $args['before_title'] . '<i class="fab fa-youtube"></i> ' . $title . $args['after_title'] );
		}

		preg_match( '/[\\?\\&]v=([^\\?\\&]+)/', $video_url, $matches );
		$id = $matches[1];
		?>
		<div class="king-youtube-posts">
			<iframe width="560" height="190" src="https://www.youtube.com/embed/<?php echo esc_attr( $id ); ?>?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<p class="king-youtube-meta">
				<a href="<?php echo esc_url( $channel_url ); ?>" target="_blank">&#64;<?php echo wp_kses_post( $channel_name ); ?></a>
			</p>
			<p class="king-youtube-follow">
				<a href="<?php echo esc_url( $channel_url ); ?>" target="_blank"><?php esc_html_e( 'Subscribe', 'king' ); ?></a>
			</p>
		</div>
		<?php
		echo wp_kses_post( $args['after_widget'] );
	}
	/**
	 * Handles updating the settings for the current Youtube instance.
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
		$instance                 = $old_instance;
		$instance['title']        = sanitize_text_field( $new_instance['title'] );
		$instance['channel_url']  = sanitize_text_field( $new_instance['channel_url'] );
		$instance['channel_name'] = sanitize_text_field( $new_instance['channel_name'] );
		$instance['video_url']    = sanitize_text_field( $new_instance['video_url'] );
		return $instance;
	}

	/**
	 * Outputs the settings form for the Youtube widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		$title        = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$channel_url  = isset( $instance['channel_url'] ) ? esc_url( $instance['channel_url'] ) : '';
		$channel_name = isset( $instance['channel_name'] ) ? esc_attr( $instance['channel_name'] ) : '';
		$video_url    = isset( $instance['video_url'] ) ? esc_url( $instance['video_url'] ) : '';
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title :', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'channel_name' ) ); ?>"><?php esc_html_e( 'Channel Name :', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'channel_name' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'channel_name' ) ); ?>" type="text" value="<?php echo esc_attr( $channel_name ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'channel_url' ) ); ?>"><?php esc_html_e( 'Channel Url :', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'channel_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'channel_url' ) ); ?>" type="text" value="<?php echo esc_url( $channel_url ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>"><?php esc_html_e( 'A Video Url :', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'video_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'video_url' ) ); ?>" type="text" value="<?php echo esc_url( $video_url ); ?>" />
		</p>
		<?php
	}
}
/**
 * King_youtube_widget function.
 *
 * @return mixed
 */
function king_youtube_widget() {
	register_widget( 'King_Youtube' );
}
add_action( 'widgets_init', 'king_youtube_widget' );
?>
