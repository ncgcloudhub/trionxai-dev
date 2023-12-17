<?php
/**
 * Topusers Widget.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
/**
 * Topusers_widget class.
 *
 * @see WP_Widget
 */
class King_Topusers_Widget extends WP_Widget {

	/**
	 * Constructs a new instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_topusers',
			'description'                 => esc_html__( 'Your site&#8217;s top users', 'king' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'top-users', __( 'King Topusers Widget', 'king' ), $widget_ops );
		$this->alt_option_name = 'widget_topusers';
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
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Topusers Widget', 'king' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		$orderby = $instance['orderby'];

		/**
		 * Filter the arguments for the Topusers widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the Topusers posts.
		 */

		if ( 'wp__post_follow_count' === $orderby ) {
			$r = array(
				'orderby'  => 'meta_value',
				'meta_key' => 'wp__post_follow_count',
				'order'    => 'DESC',
				'number'   => $number,
			);
		} elseif ( 'post_count' === $orderby ) {
			$r = array(
				'orderby' => 'post_count',
				'order'   => 'DESC',
				'number'  => $number,
			);
		}
		$query = get_users( $r );
		?>
		<?php echo wp_kses_post( $args['before_widget'] ); ?>
		<?php
		if ( $title ) {
			echo wp_kses_post( $args['before_title'] . $icon . $title . $args['after_title'] );
		}
		?>

		<?php
		foreach ( $query as $user ) :
			get_template_part( 'template-parts/pages/user', 'card', $user );
		endforeach;
		?>
		<?php echo wp_kses_post( $args['after_widget'] ); ?>
		<?php
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
		$instance['number']  = (int) $new_instance['number'];
		$instance['orderby'] = $new_instance['orderby'];
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
		$number  = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$orderby = isset( $instance['orderby'] ) ? esc_attr( $instance['orderby'] ) : '';
		$icon    = isset( $instance['icon'] ) ? $instance['icon'] : '';
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" placeholder="<i class='fa-solid fa-crown'></i>" />
		</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of Users to show:', 'king' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>
				<!-- PART 3: Widget s field START -->
				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By', 'king' ); ?>
					<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
						<?php
						$orderby_choices = array( "wp__post_follow_count" => esc_html__( 'User Followers', 'king' ), "post_count" => esc_html__( 'User Posts', 'king' ));
						foreach ( $orderby_choices as $orderby_num => $orderby_text ) {
							echo "<option value='$orderby_num' " . ( $orderby == $orderby_num ? "selected='selected'" : '' ) . ">$orderby_text</option>\n";
						}
						?>
					</select>
				</label>
			</p>     
			<!-- Widget City field END -->
			<?php
		}
	}
/**
 * Topusers_widget2 function.
 *
 * @return mixed
 */
function topusers_widget_2() {
	register_widget( 'King_Topusers_Widget' );
}
add_action( 'widgets_init', 'topusers_widget_2' );
?>
