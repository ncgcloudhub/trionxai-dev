<?php
/**
 * Related Posts Widget.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
/**
 * Related_Posts class.
 *
 * @see WP_Widget
 */
class King_Related_Widget extends WP_Widget {

	/**
	 * Constructs a new instance.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'widget_related_posts',
			'description'                 => esc_html__( 'Your site&#8217;s Related Posts', 'king' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'related-posts', esc_html__( 'King Related Posts', 'king' ), $widget_ops );
		$this->alt_option_name = 'widget_related_posts';
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

		$title = ( ! empty( $instance['title'] ) ) ? $instance['title'] : esc_html__( 'Related Posts', 'king' );
		$icon = ! empty( $instance['icon'] ) ? $instance['icon'] . ' ' : '';
		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		$number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
		if ( ! $number ) {
			$number = 5;
		}

		global $post;

		$tags = wp_get_post_tags( $post->ID );

		if ( is_single() ) :
			if ( $tags ) {
				$tag_ids = array();
				foreach ( $tags as $individual_tag ) {
					$tag_ids[] = $individual_tag->term_id;
				}
				$r = new WP_Query(
					apply_filters(
						'widget_posts_args',
						array(
							'tag__in'             => $tag_ids,
							'post__not_in'        => array( $post->ID ),
							'showposts'           => $number,
							'ignore_sticky_posts' => 1,
						)
					)
				);

				if ( $r->have_posts() ) :
					?>
					<?php echo wp_kses_post( $args['before_widget'] ); ?>
					<?php
					if ( $title ) {
						echo wp_kses_post( $args['before_title'] . $icon . $title . $args['after_title'] );
					}
					?>
					<?php
					while ( $r->have_posts() ) {
						$r->the_post();
						get_template_part( 'template-parts/posts/content', 'simple-post' );
					}
					?>
				<?php endif; ?>
			<?php } ?>
			<?php echo wp_kses_post( $args['after_widget'] ); ?>
			<?php
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
		$instance           = $old_instance;
		$instance['title']  = sanitize_text_field( $new_instance['title'] );
		$instance['number'] = (int) $new_instance['number'];
		$instance['icon'] = wp_unslash( $new_instance['icon'] );
		return $instance;
	}

	/**
	 * { function_description }
	 *
	 * @param      <type>  $instance  The instance
	 */
	public function form( $instance ) {
		$title  = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
		$number = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
		$icon   = isset( $instance['icon'] ) ? $instance['icon'] : '';
		?>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" /></p>
		<p><label for="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>"><?php esc_html_e( 'Icon:', 'king' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'icon' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'icon' ) ); ?>" type="text" value="<?php echo esc_attr( $icon ); ?>" placeholder="<i class='fa-solid fa-crown'></i>" />
		</p>
			<p><label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php esc_html_e( 'Number of posts to show:', 'king' ); ?></label>
				<input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="number" step="1" min="1" value="<?php echo esc_attr( $number ); ?>" size="3" /></p>

				<?php
	}
}
/**
 * Related_posts_2 function.
 *
 * @return mixed
 */
function related_posts_2() {
	register_widget( 'King_Related_Widget' );
}
add_action( 'widgets_init', 'related_posts_2' );
?>
