<?php
/**
 * The template for displaying the Categories page
 *
 * Template Name: categories 2
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); ?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<header class="page-top-header categories">
	<h1 class="page-title"><i class="fa fa-sliders fa-lg" aria-hidden="true"></i> <?php esc_html_e( 'Categories', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>
<div id="primary" class="content-area">
	<main id="main" class="site-main full-width">

		<div class="king-categories-page">
			<?php
			$categories = get_categories( array(
				'orderby' => 'count',
				'hide_empty' => false,
				'order' => 'DESC',
			) );
			foreach ( $categories as $cat ) :
				$color = get_field( 'category_colors', 'category_' . $cat->term_id );
				$catlogo = get_field( 'category_logo', 'category_' . $cat->term_id );
				$size = 'thumbnail';
				$thumb = is_array($catlogo) ? $catlogo['sizes'][ $size ] : '';
				$bgimage = get_field( 'category_background_image', 'category_' . $cat->term_id );
				if ( $bgimage ) {
					$bgimage = 'background-image:url(' . $bgimage['sizes']['large'] . ');';
				}
				?>   
				<?php if( $color || $bgimage ) : ?>
				<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="king-page-badge" style="background-color: <?php echo esc_attr( $color ); ?>; <?php echo esc_attr( $bgimage ); ?>">
				<?php else : ?>
					<a class="king-page-badge" href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
				<?php endif; ?>	
						<?php if( $catlogo ) : ?>
							<img src="<?php echo esc_attr( $thumb ); ?>" class="cat-logo" />
						<?php endif; ?>				
						<div class="king-categories-head-2">
							<?php echo esc_attr( $cat->name ); ?>
						</div>
						<div class="king-categories-desc">
							<?php echo esc_attr( $cat->description ); ?>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_footer(); ?>
