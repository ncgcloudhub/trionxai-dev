<?php
/**
 * Trending Posts Widget.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
/**
 * Trending_Posts class.
 *
 * @see WP_Widget
 */
class King_Trending_Widget extends WP_Widget {

	/**
	 * Constructs a new instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_trending_posts',
			'description'                 => esc_html__( 'Your site&#8217;s Trending Posts', 'king' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'trending-posts', esc_html__( 'King Trending Posts', 'king' ), $widget_ops );
		$this->alt_option_name = 'widget_trending_posts';
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
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Trending Posts', 'king' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		$duration = intval( $instance['duration'] );
		if ( ! in_array( $duration, array( 0, 1, 7, 30, 365 ) ) ) {
			$duration = 0;
		}
		if ( 0 === $duration ) {
			$duration = null;
		}
		/**
		 * Filter the arguments for the trending Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the trending posts.
		 */
		$r = new WP_Query(
			apply_filters(
				'widget_posts_args',
				array(
					'meta_key'            => 'keep_trending',
					'meta_value'          => '1',
					'orderby'             => 'modified',
					'order'               => 'DESC',
					'date_query'          => array(
						'column' => 'post_date',
						'after'  => '- ' . $duration . ' days',
					),
					'posts_per_page'      => $number,
					'no_found_rows'       => true,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => true,
				)
			)
		);

		if ( $r->have_posts() ) :
			?>
			<?php
			echo wp_kses_post( $args['before_widget'] );
			if ( $title ) {
				echo wp_kses_post( $args['before_title'] . $icon . $title . $args['after_title'] );
			}
			while ( $r->have_posts() ) {
				$r->the_post();
				get_template_part( 'template-parts/posts/content', 'simple-post' );
			}
			echo wp_kses_post( $args['after_widget'] );
			wp_reset_postdata();
		endif;
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
		$instance             = $old_instance;
		$instance['title']    = sanitize_text_field( $new_instance['title'] );
		$instance['number']   = (int) $new_instance['number'];
		$instance['duration'] = (int) $new_instance['duration'];
		$instance['icon'] = wp_unslash( $new_instance['icon'] );
		return $instance;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $instance  The instance
	 */
	public function form( $instance ) {
		$title    = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number   = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$duration = isset( $instance['duration'] ) ? esc_attr( $instance['duration'] ) : '';
		if ( ! in_array( $duration, array( 0, 1, 7, 30, 365 ) ) ) {
			$duration = 0;
		}
		$icon    = isset( $instance['icon'] ) ? $instance['icon'] : '';
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" placeholder="<i class='fa-solid fa-crown'></i>" />
		</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'king' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>

				<p>
					<label for="<?php echo esc_attr( $this->get_field_id( 'duration' ) ); ?>"><?php esc_html_e( 'Limit to:', 'king' ); ?>
					<select id="<?php echo esc_attr( $this->get_field_id( 'duration' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'duration' ) ); ?>">
						<?php
						$duration_choices = array( 1 => esc_html__( '1 Day', 'king' ), 7 => esc_html__( '7 Days', 'king' ), 30 => esc_html__( '30 Days', 'king' ), 365 => esc_html__( '365 Days', 'king' ), 0 => esc_html__( 'All Time', 'king' ) );
						foreach ( $duration_choices as $duration_num => $duration_text ) {
							echo "<option value='$duration_num' " . ( $duration == $duration_num ? "selected='selected'" : '' ) . ">$duration_text</option>\n";
						}
						?>
					</select>
				</label>
			</p>
			<?php
		}
	}
/**
 * Trending posts2 function.
 *
 * @return mixed
 */
function trending_posts2() {
	register_widget( 'King_Trending_Widget' );
}
add_action( 'widgets_init', 'trending_posts2' );
?>
