<?php
/**
 * The content part - meta.
 *
 * This is a content template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="entry-meta">
	<?php
	$display_option = get_field( 'select_default_display_option', 'options' );
	if ( isset( $args['home'] ) ) {
		if ( ! get_field( 'disable_post_votes', 'options' ) && king_plugin_active( 'ACF' ) ) :
			$down = get_field( 'disable_down_vote_in_posts', 'options' ) ? true : false;
			echo king_vote( get_the_ID(), 'p', $down );
		endif;
	}
	?>
	<div class="king-pmeta">
		<span class="post-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>
			<?php
			$likes = king_vote_count( get_the_ID(), 'p' );
			echo esc_attr( $likes['sl'] );
			?>
		</span>
		<span class="post-views"><i class="fa fa-eye" aria-hidden="true"></i><?php echo esc_attr( king_postviews( get_the_ID(), 'display' ) ); ?></span>
		<span class="post-comments"><i class="fa fa-comment" aria-hidden="true"></i><?php comments_number( ' 0 ', ' 1 ', ' % ' ); ?></span>
		<span class="content-share-counter">
			<i class="far fa-paper-plane"></i>
			<?php echo esc_attr( get_post_meta( get_the_ID(), 'share_counter', true ) ); ?>
		</span>
	</div>
	<span class="post-time"><i class="far fa-clock"></i><?php the_time( 'F j, Y' ); ?></span>
</div><!-- .entry-meta -->

