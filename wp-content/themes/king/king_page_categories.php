<?php
/**
 * The template for displaying the Categories page
 *
 * Template Name: categories
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
	<main id="main" class="site-main">
		<div class="king-categories-page">
			<?php
			$cats = get_categories(
				array(
					'orderby'    => 'count',
					'hide_empty' => false,
					'order'      => 'DESC',
				)
			);
			foreach ( $cats as $cat ) {
				if ( 0 !== $cat->category_parent ) {
					echo '<span class="king-subcat">';
				}
				?>

				<div class="king-categories">
					<div class="king-categories-head">
						<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"> <?php echo esc_attr( $cat->name ); ?> </a>
						<i><?php echo esc_attr( $cat->category_count ); ?></i>
					</div>
					<div class="categories-posts">
						<?php
						global $post;
						$args = array( 'posts_per_page' => '4', 'category' => $cat->term_id, 'orderby' => 'date', 'order' => 'DESC' );
						$custom_posts = get_posts( $args );
						if ( $custom_posts ) :
							foreach ( $custom_posts as $post ) :
								setup_postdata( $post );
								get_template_part( 'template-parts/posts/content', 'toosimple-post' );
							endforeach;
							?>
							<?php else : ?>
								<span class="categories-noposts"><?php echo esc_html_e( 'No posts','king' ); ?> </span>
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
