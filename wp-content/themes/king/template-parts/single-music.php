<?php
/**
 * Single music page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<?php
if ( get_field( 'media_lists' ) ) {
	get_template_part( 'template-parts/post-templates/single-parts/playlist' );
} else {
	get_template_part( 'template-parts/post-templates/single-parts/video' );
}
?>
<div id="primary" class="content-area">
	<main id="main" class="site-main post-page single-video">
		<?php if ( get_field( 'ads_above_content', 'option' ) && king_add_free_mode() ) : ?>
			<div class="ads-postpage">
				<?php
				$ad_above = get_field( 'ads_above_content', 'options' );
				echo do_shortcode( $ad_above );
				?>
			</div>
		<?php endif; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php if ( get_field( 'add_sponsor' ) ) : ?>
					<div class="add-sponsor"><a href="<?php the_field( 'post_sponsor_link' ); ?>" target="_blank"><img src="<?php the_field( 'post_sponsor_logo' ); ?>" /></a><span class="sponsor-label"><?php the_field( 'post_sponsor_description' ); ?></span></div>
				<?php endif; ?>			
				<?php get_template_part( 'template-parts/post-templates/single-parts/posttitle' ); ?>
				<?php get_template_part( 'template-parts/post-templates/single-parts/badges' ); ?>
				<div class="entry-content">
					<?php
					the_content(
						sprintf(
							wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'king' ), array( 'span' => array( 'class' => array() ) ) ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						)
					);

					wp_link_pages(
						array(
							'before' => '<div class="page-links">',
							'after'  => '</div>',
						)
					);
					?>
				</div><!-- .entry-content -->

				<?php get_template_part( 'template-parts/post-templates/single-parts/nextprev' ); ?>
			</div><!-- #post-## -->
			<?php get_template_part( 'template-parts/post-templates/single-parts/single-boxes' ); ?>
			<?php
			if ( comments_open() || get_comments_number() ) :
				comments_template();
		endif;

		endwhile; // End of the loop.
		?>
		<?php if ( get_field( 'display_related', 'options' ) ) : ?>
			<?php get_template_part( 'template-parts/related-posts' ); ?>
		<?php endif; ?>
		<?php if ( get_post_status( $post->ID ) === 'pending' ) : ?>
			<div class="king-pending"><?php esc_html_e( 'This Music post will be checked and approved shortly.', 'king' ); ?></div>
		<?php endif; ?>
	</main><!-- #main -->
	<?php get_sidebar(); ?> 	

</div><!-- #primary -->
<?php get_template_part( 'template-parts/post-templates/single-parts/modal-share' ); ?>
<?php get_footer(); ?>
