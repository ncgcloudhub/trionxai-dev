<?php
/**
 * Most Commented Widget.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
	/**
	 * Most_Commented_Widget class.
	 *
	 * @see WP_Widget
	 */
class King_Mostcommented_Widget extends WP_Widget {
	/**
	 * Constructs a new instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_mostcommented_entries',
			'description'                 => esc_html__( 'Your site&#8217;s most commented Posts.', 'king' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'commented-posts', esc_html__( 'King Most Commented Posts', 'king' ), $widget_ops );
		$this->alt_option_name = 'widget_mostcommented_entries';
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Most Commented Posts', 'king' );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$icon = ! empty( $instance['icon'] ) ? $instance['icon'] . ' ' : '';
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		/**
		 * Filter the arguments for the Most Commented Posts widget.
		 *
		 * @since 3.4.0
		 *
		 * @see WP_Query::get_posts()
		 *
		 * @param array $args An array of arguments used to retrieve the Hot posts.
		 */
		$num_posts = isset( $instance['num_posts'] ) ? absint( $instance['num_posts'] ) : 5;
		if ( $num_posts < 1 ) {
			$num_posts = 5;
		}
		$c_duration = intval( $instance['c_duration'] );
		if ( ! in_array( $c_duration, array( 0, 1, 7, 30, 365 ), true ) ) {
			$c_duration = 0;
		}
		if ( 0 === $c_duration ) {
			$c_duration = null;
		}
		$r = new WP_Query(
			array(
				'posts_per_page' => $num_posts,
				'orderby'        => 'comment_count',
				'order'          => 'DESC',
				'date_query'     => array(
					'column' => 'post_date',
					'after'  => '- ' . $c_duration . ' days',
				),
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
		$instance               = $old_instance;
		$instance['title']      = sanitize_text_field( $new_instance['title'] );
		$instance['num_posts']  = (int) $new_instance['num_posts'];
		$instance['c_duration'] = (int) $new_instance['c_duration'];
		$instance['icon'] = wp_unslash( $new_instance['icon'] );
		return $instance;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $instance  The instance
	 */
	public function form( $instance ) {
		$title      = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$num_posts  = isset( $instance['num_posts'] ) ? absint( $instance['num_posts'] ) : 5;
		$c_duration = isset( $instance['c_duration'] ) ? esc_attr( $instance['c_duration'] ) : '';
		$icon    = isset( $instance['icon'] ) ? $instance['icon'] : '';
		if ( ! in_array( $c_duration, array( 0, 1, 7, 30, 365 )) ) {
			$c_duration = 0;
		}
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'king' ); ?> <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></label></p>

		<p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" placeholder="<i class='fa-solid fa-crown'></i>" />
		</p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'num_posts' ) ); ?>"><?php esc_html_e( 'Maximum number of results:', 'king' ); ?>
			<select id="<?php echo esc_attr( $this->get_field_id( 'num_posts' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'num_posts' ) ); ?>">
				<?php
				for ( $i = 1; $i <= 20; ++$i ) {
					echo "<option value='$i' " . ( $num_posts == $i ? "selected='selected'" : '' ) . ">$i</option>\n";
				}
				?>
			</select>
		</label>
	</p>

	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'c_duration' ) ); ?>"><?php esc_html_e( 'Limit to:', 'king' ); ?>
		<select id="<?php echo esc_attr( $this->get_field_id( 'c_duration' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'c_duration' ) ); ?>">
			<?php
			$c_duration_choices = array( 1 => esc_html__( '1 Day', 'king' ), 7 => esc_html__( '7 Days', 'king' ), 30 => esc_html__( '30 Days', 'king' ), 365 => esc_html__( '365 Days', 'king' ), 0 => esc_html__( 'All Time', 'king' ) );
			foreach ( $c_duration_choices as $c_duration_num => $c_duration_text ) {
				echo "<option value='$c_duration_num' " . ( $c_duration == $c_duration_num ? "selected='selected'" : '' ) . ">$c_duration_text</option>\n";
			}
			?>
		</select>
	</label>
</p>
		<?php
	}

}
/**
 * Most_Commented function.
 *
 * @return mixed
 */
function most_commented_widget2() {
	register_widget( 'King_Mostcommented_Widget' );
}
add_action( 'widgets_init', 'most_commented_widget2' );
?>
