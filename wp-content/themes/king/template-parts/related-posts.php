<?php
/**
 * Post Page Related Posts box
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="king-related">
	<div class="related-title"><?php the_field( 'related_posts_heading', 'option' ) ?></div>
		<?php // Related Post Code Start.
		$relatednumber = get_field( 'related_length', 'options' );

		if ( get_field( 'display_related_posts_by', 'option' ) === 'categories' ) {

				// Get array of terms.
			$terms = get_the_terms( get_the_ID() , 'category' );
				// Pluck out the IDs to get an array of IDS.
			$relatedby = wp_list_pluck( $terms,'term_id' );
			$relatedby2 = 'category__in';

		} elseif ( get_field( 'display_related_posts_by', 'option' ) === 'tags' ) {

				// Get array of terms.
			$tagsterms = get_the_terms( get_the_ID() , 'post_tag', 'string' );
				// Pluck out the IDs to get an array of IDS.
			$relatedby = '123';
			if ( ! empty( $tagsterms ) ) {
				$relatedby = wp_list_pluck( $tagsterms,'term_id' );
			}

			$relatedby2 = 'tag__in';
		}

		$args = array(
			'' . $relatedby2 . '' => $relatedby,
			'post__not_in' => array( $post->ID ),
				'showposts' => $relatednumber,  // Number of related posts that will be shown.
				'ignore_sticky_posts' => 1,
			);

		$my_query = new wp_query( $args );
		if ( $my_query->have_posts() ) :
			while ( $my_query->have_posts() ) {
				$my_query->the_post();
				get_template_part( 'template-parts/posts/content', 'simple-post' );
			}
			wp_reset_postdata();
			else : ?>
			<div class="no-follower"><i class="fab fa-slack-hash fa-2x"></i><?php esc_html_e( 'Sorry, no posts were found', 'king' ); ?> </div>
	<?php endif; ?>
</div> <!-- .king-related -->
