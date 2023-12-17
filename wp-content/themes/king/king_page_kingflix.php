<?php
/**
 * The template for kingflix.
 *
 * Template Name: kingflix
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); ?>
<?php

$GLOBALS['hide'] = 'hide';

// Slider.
if ( is_front_page() && get_field( 'display_slider', 'options' ) && 'header-template-08' !== get_field( 'header_templates', 'options' ) ) :
	if ( ( get_field( 'slider_template', 'options' ) === 'slider-template-1' || get_field( 'slider_template', 'options' ) === 'slider-template-2' ) ) :
		get_template_part( 'template-parts/king-featured-posts' );
	elseif ( get_field( 'slider_template', 'options' ) === 'slider-template-3' ) :
		get_template_part( 'template-parts/king-featured-video' );
	endif;
endif;

?>
<?php get_template_part( 'template-parts/king-header-nav' ); ?>
<div id="primary" class="content-area king-kingflix">
	<main id="main" class="site-main full-width">
		<div class="king-kingflix-page">
			<?php
			// Mini Slider.
			if ( is_front_page() && get_field( 'display_mini_slider', 'options' ) ) :
				if ( get_field( 'show_in_mini_slider', 'options' ) === 'show_categories' ) {
					get_template_part( 'template-parts/king-featured-cats' );
				} else {
					get_template_part( 'template-parts/king-featured-small' );
				}
			endif;
			?>
			<?php
			if ( get_field( 'kingflix_display_bookmarked_posts' ) ) :
				$user_id = get_current_user_id();
				$rlposts = get_user_meta( $user_id, 'king_readlater', true );
				if ( $rlposts ) :
					?>
					<div class="kingflix-blocks">
						<div class="kingflix-head">
							<h4 class="king-editorschoice-title"><?php the_field( 'kingflix_bookmarked_posts_header' ); ?></h4>
						</div>
						<div class="kingflix-posts owl-carousel">
							<?php

							$recent_query = new WP_Query(
								[
									'post__in'  => array_reverse( $rlposts ),
									'orderby'   => 'post__in',
									'post_type' => king_post_types(),
								]
							);
							if ( $recent_query->have_posts() ) {
								while ( $recent_query->have_posts() ) {
									$recent_query->the_post();
									get_template_part( 'template-parts/posts/kingflix-post' );
								}
							}
							wp_reset_postdata();
							?>
						</div>
					</div>
				<?php endif; ?>
			<?php endif; ?>
			<?php if ( get_field( 'kingflix_display_trending_posts' ) ) : ?>
				<div class="kingflix-blocks">
					<div class="kingflix-head">
						<h4 class="king-editorschoice-title"><?php the_field( 'kingflix_trending_posts_header' ); ?></h4>
					</div>
					<div class="kingflix-posts owl-carousel">
						<?php
						$featured = get_posts(
							array(
								'posts_per_page' => get_field( 'kingflix_posts_number_in_categories' ),
								'meta_key'       => 'keep_trending',
								'meta_value'     => '1',
								'orderby'        => 'modified',
								'order'          => 'DESC',
								'post_type'      => king_post_types(),
							)
						);
						if ( $featured ) :
							foreach ( $featured as $post ) :
								setup_postdata( $post );
								get_template_part( 'template-parts/posts/kingflix-post' );
							endforeach;
							?>
							<?php wp_reset_postdata(); ?>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
			<?php
			$cats    = get_categories(
				array(
					'orderby'    => 'count',
					'hide_empty' => true,
					'order'      => 'DESC',
				)
			);
			$pnumber = get_field( 'kingflix_posts_number_in_categories' );
			foreach ( $cats as $cat ) {
				if ( 0 !== $cat->category_parent ) {
					echo '<span class="king-subcat">';
				}
				?>

				<div class="kingflix-blocks">
					<div class="kingflix-head">
						<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
							<?php echo esc_attr( $cat->name ); ?>
							<span><?php echo esc_html_e( 'Explore All', 'king' ); ?><i class="fas fa-chevron-right"></i></span>
						</a>
					</div>
					<div class="kingflix-posts owl-carousel">
						<?php
						global $post;
						$args         = array(
							'posts_per_page' => $pnumber,
							'category'       => $cat->term_id,
							'orderby'        => 'date',
							'order'          => 'DESC',
							'post_type'      => king_post_types(),
						);
						$custom_posts = get_posts( $args );
						if ( $custom_posts ) :
							foreach ( $custom_posts as $post ) :
								setup_postdata( $post );
								get_template_part( 'template-parts/posts/kingflix-post' );
							endforeach;
							?>
						<?php endif; ?>
					</div>
				</div>

				<?php
				if ( 0 !== $cat->category_parent ) {
					echo '</span>';
				}
			}
			?>
		</div>
	</main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
