<?php
/**
 * Sinlge image post template-v1 page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div id="primary" class="content-area imagetemplate-v1">
	<main id="main" class="site-main post-page single-image">		
		<div class="imagetemplatev2">
			<?php if ( get_field( 'nsfw_post' ) && ! is_user_logged_in() ) : ?>
			<div class="post-video nsfw-post-page">
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>">
					<i class="fa fa-paw fa-3x"></i>
					<div><h1><?php echo esc_html_e( 'Not Safe For Work', 'king' ); ?></h1></div>
					<span><?php echo esc_html_e( 'Click to view this post.', 'king' ); ?></span>
				</a>	
			</div>
			<?php else : ?>
				<?php get_template_part( 'template-parts/post-templates/single-parts/single-gallery' ); ?>				
			<?php endif; ?>
		</div>	
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
					the_content( sprintf(
						/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'king' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );

					wp_link_pages( array(
						'before' => '<div class="page-links">',
						'after'  => '</div>',
					) );
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
	</main><!-- #main -->
	<?php get_sidebar(); ?> 	

</div><!-- #primary -->	
<?php get_footer(); ?>
