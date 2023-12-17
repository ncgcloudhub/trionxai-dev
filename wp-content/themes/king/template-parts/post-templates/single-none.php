<?php
/**
 * Sible News page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>
<?php if ( has_post_thumbnail() ) :
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' ); ?>
	<div class="single-post-back king-box-bg" data-king-img-src="<?php echo esc_url( $thumb['0'] ); ?>">
		<?php elseif ( get_field( 'default_background', 'option' ) ) : $dbackground = get_field( 'default_background', 'options' ); ?>
			<div class="single-post-back king-box-bg" data-king-img-src="<?php echo esc_url( $dbackground ); ?>">
				<?php else : ?>
					<div class="single-post-back-no">
					<?php endif; ?>
					<div class="single-header-v5 sing-template-v6">
						<div class="v5-header-second">
							<?php king_entry_cat(); ?>
							<header class="entry-header">
								<?php
								if ( is_single() ) {
									the_title( '<h1 class="entry-title">', '</h1>' );
								} else {
									the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
								}
								?>
							</header><!-- .entry-header -->
						</div>
					</div>
				</div>
				<div id="primary" class="content-area sing-template-6">
					<main id="main" class="site-main post-page single-post no-permission">
						<?php if ( get_field( 'ads_above_content', 'option' ) && king_add_free_mode() ) : ?>
							<div class="ads-postpage"><?php $ad_above = get_field( 'ads_above_content', 'options' ); echo do_shortcode( $ad_above ); ?></div>
						<?php endif; ?>
						<?php while ( have_posts() ) : the_post(); ?>
							<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<header class="entry-header">
									<h3 class="entry-title">
										<i class="fas fa-lock fa-lg"></i>
										<?php esc_html_e( 'You do not have permission to see this post.', 'king' ); ?>
									</h3>
								</header><!-- .entry-header -->
								<?php if ( ! is_user_logged_in() ) : ?>
									<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" class="king-alert-button"><?php esc_html_e( 'Log in ', 'king' ); ?></a>
									<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>"><?php esc_html_e( 'Register', 'king' ); ?></a>
								<?php endif; ?>
							</div>
							<?php get_template_part( 'template-parts/post-templates/single-parts/authorbox' ); ?>
						<?php endwhile; ?>
						<?php if ( get_field( 'display_related', 'options' ) ) : ?>
							<?php get_template_part( 'template-parts/related-posts' ); ?>
						<?php endif; ?>

					</main><!-- #main -->

				</div><!-- #primary -->
				<?php get_footer(); ?>
