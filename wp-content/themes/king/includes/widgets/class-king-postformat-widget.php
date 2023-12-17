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
class King_Postformat_Widget extends WP_Widget {

	/**
	 * Constructs a new instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_postformat_posts',
			'description'                 => esc_html__( 'Your site&#8217;s Post Format Posts', 'king' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'postformat-posts', esc_html__( 'King Post Formats', 'king' ), $widget_ops );
		$this->alt_option_name = 'widget_postformat_posts';
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
		$type = $instance['duration'];

		$choices = array( 
					'quote'  => esc_html__( 'News', 'king' ),
					'video'  => esc_html__( 'Videos', 'king' ),
					'image'  => esc_html__( 'Images', 'king' ),
					'audio'  => esc_html__( 'Musics', 'king' ),
					'list'   => esc_html__( 'Lists', 'king' ),
					'poll'   => esc_html__( 'Polls', 'king' ),
					'trivia' => esc_html__( 'Trivia Quizes', 'king' )
				);
		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Latest ', 'king' ) . esc_attr( $choices[$type] );

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );
		$icon = ! empty( $instance['icon'] ) ? $instance['icon'] . ' ' : '';
		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		
		if ( in_array( $type, array( 'list', 'poll', 'trivia' ) ) ) {
			$typef = $type;
		} else {
			$typef = 'post';
		}
		$sargs = array();
		if ( 'video' === $type ) {
			$sargs['class']  = true;
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

		$argz = array(
				'post_type'      => $typef,
				'post_status'    => 'publish',
				'order'          => 'DESC',
				'posts_per_page' => $number,
				'ignore_sticky_posts' => true,
			);
		if ( 'post' === $typef ) :
				$argz['tax_query'] = array(
					array(
						'taxonomy' => 'post_format',
						'field'    => 'slug',
						'terms'    => array( 'post-format-' . $type ),
					),
				);
		endif;
		$r = new WP_Query( apply_filters( 'widget_posts_args', $argz ) );

		if ( $r->have_posts() ) :
			?>
			<?php
			echo wp_kses_post( $args['before_widget'] );
			if ( $title ) {
				echo wp_kses_post( $args['before_title'] . $icon . $title . $args['after_title'] );
			}
			while ( $r->have_posts() ) {
				$r->the_post();
				get_template_part( 'template-parts/posts/content', 'simple-post', $sargs );
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
		$instance['duration'] = sanitize_text_field( $new_instance['duration'] );
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
		$duration = isset( $instance['duration'] ) ? esc_attr( $instance['duration'] ) : 'quote';
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
					<label for="<?php echo esc_attr( $this->get_field_id( 'duration' ) ); ?>"><?php esc_html_e( 'Post Format:', 'king' ); ?>
					<select id="<?php echo esc_attr( $this->get_field_id( 'duration' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'duration' ) ); ?>">
						<?php
						$duration_choices = array( 
							'quote'  => esc_html__( 'News', 'king' ),
							'video'  => esc_html__( 'Videos', 'king' ),
							'image'  => esc_html__( 'Images', 'king' ),
							'audio'  => esc_html__( 'Musics', 'king' ),
							'list'   => esc_html__( 'Lists', 'king' ),
							'poll'   => esc_html__( 'Polls', 'king' ),
							'trivia' => esc_html__( 'Trivia Quizes', 'king' )
						);
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
function postformat_posts() {
	register_widget( 'King_Postformat_Widget' );
}
add_action( 'widgets_init', 'postformat_posts' );
?>
