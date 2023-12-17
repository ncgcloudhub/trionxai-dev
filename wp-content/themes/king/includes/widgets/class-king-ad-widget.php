<?php
/**
 * King Post Format Widget.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
/**
 * King_Postformat_Widget class.
 *
 * @see WP_Widget
 */
class King_Ad_Widget extends WP_Widget {

	/**
	 * Constructs a new instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_ad',
			'description'                 => esc_html__( 'You can add ad code or image ad.', 'king' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'king-ad-widget', esc_html__( 'King Ad', 'king' ), $widget_ops );
		$this->alt_option_name = 'widget_ad';
	}
	/**
	 * { function_description }
	 *
	 * @param      <type>  $args      The arguments
	 * @param      <type>  $instance  The instance
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}
		$icon = ! empty( $instance['icon'] ) ? $instance['icon'] . ' ' : '';
		$title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Sponsor', 'king' );
		$content = ( ! empty( $instance['content'] ) ) ? $instance['content'] : '';
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$out = '';
		if ( king_add_free_mode() ) {
			if ( $title ) {
				$out .= wp_kses_post( $args['before_title'] . $icon . $title . $args['after_title'] );
			}
			$out .= '<div class="king-ad-widget">';
			$out .= apply_filters( 'widget_custom_html_content', $content, $instance, $this );
			$out .= '</div>';
		}
		echo $out;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $new_instance  The new instance
	 * @param      <type>  $old_instance  The old instance
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	public function update( $new_instance, $old_instance ) {
		$instance            = $old_instance;
		$instance['title']   = sanitize_text_field( $new_instance['title'] );
		$instance['content'] = wp_unslash( $new_instance['content'] );
		$instance['icon'] = wp_unslash( $new_instance['icon'] );
		return $instance;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $instance  The instance
	 */
	public function form( $instance ) {
		$title   = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$content = isset( $instance['content'] ) ? $instance['content'] : '';
		$icon    = isset( $instance['icon'] ) ? $instance['icon'] : '';
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" placeholder="<i class='fa-solid fa-crown'></i>" />
		</p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>"><?php esc_html_e( 'HTML:', 'king' ); ?></label>
			<textarea class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" type="textarea" /><?php echo esc_textarea( $content ); ?></textarea>
		</p>
			
			<?php
		}
	}
/**
 * Trending posts2 function.
 *
 * @return mixed
 */
function kingad_widget() {
	register_widget( 'King_Ad_Widget' );
}
add_action( 'widgets_init', 'kingad_widget' );
?>
