<?php
/**
 * The template for displaying the Trend page
 *
 * Template Name: trend
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
if ( get_field( 'select_default_display_option', 'options' ) ) {
	$display_option = get_field( 'select_default_display_option', 'options' );
} else {
	$display_option = 'king-grid-01';
}
$htemplate = get_field( 'page_template' );
if ( $htemplate ) {
	$sidebar = $htemplate['sidebar'];
	if ( $htemplate['column'] ) {
		$column = ' ' . $htemplate['column'];
	} else {
		$column = '';
	}
	$display_option = ! empty($htemplate['post_layout']) ? $htemplate['post_layout'] : $display_option;
} else {
	$sidebar = 'king-sidebar-04';
	$column  = '';
}
?>
<header class="page-top-header trend">
	<h1 class="page-title"><i class="fa fa-bolt fa-lg" aria-hidden="true"></i> <?php esc_html_e( 'Trending', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<div id="primary" class="content-area lr-padding <?php echo esc_attr( $display_option ); ?>">
	<div class="site-main-top kflex <?php echo esc_attr( $sidebar . $column ); ?>">
		<?php
		if ( ( 'king-sidebar-02' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) ) {
			get_sidebar( '2' );
		}
		?>
		<main id="main" class="site-main">
			<ul class="king-posts">
				<li class="grid-sizer"></li>
			<?php
			if ( have_posts() ) :
				/* Start the Loop */

				if ( get_field( 'length_trend', 'options' ) ) {
					$length_trend = get_field( 'length_trend', 'option' );
				} else {
					$length_trend = '10';
				}

				$args = array(
					'posts_per_page' => $length_trend,
					'meta_key'       => 'keep_trending',
					'meta_value'     => '1',
					'orderby'        => 'modified',
					'order'          => 'DESC',
					'post__not_in'   => get_option( 'sticky_posts' ),
					'post_type'      => king_post_types(),
				);

				$trend = new WP_Query( $args );

				while ( $trend->have_posts() ) :
					$trend->the_post();

					/*
					 * Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content-templates/' . $display_option );


				endwhile;

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif;
			?>
			<?php wp_reset_postdata(); ?>
			</ul>
		</main><!-- #main -->
			<?php
			if ( ( 'king-sidebar-01' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) || ( 'king-sidebar-05' === $sidebar ) ) {
				get_sidebar();
				if ( ( 'king-sidebar-05' === $sidebar ) ) {
					get_sidebar( '2' );
				}
			}
			?>
	</div>
</div><!-- #primary -->

<?php get_footer(); ?>
