<?php
/**
 * The template for displaying the NSFW page
 *
 * Template Name: nsfw
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
<header class="page-top-header nsfw">
	<h1 class="page-title"><i class="fa fa-paw"></i> <?php esc_html_e( 'NSFW', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>
<div id="primary" class="content-area king-nsfw lr-padding <?php echo esc_attr( $display_option ); ?>">
	<div id="king-pagination-02" class="site-main-top kflex <?php echo esc_attr( $sidebar . $column ); ?>">
		<?php
		if ( ( 'king-sidebar-02' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) ) {
			get_sidebar( '2' );
		}
		?>
		<main id="main" class="site-main" role="main">
			<ul class="king-posts">
				<li class="grid-sizer"></li>
				<?php
				if ( have_posts() ) :
					/* Start the Loop */
					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

					if ( get_field( 'length_nsfw', 'options' ) ) {
						$length_nsfw = get_field( 'length_nsfw', 'option' );
					} else {
						$length_nsfw = '10';
					}

					$args = array(
						'posts_per_page' => $length_nsfw,
						'meta_key'       => 'nsfw_post',
						'meta_value'     => '1',
						'orderby'        => 'modified',
						'order'          => 'DESC',
						'paged'          => $paged,
						'post__not_in'   => get_option( 'sticky_posts' ),
						'post_type'      => king_post_types(),
					);

					$nsfw = new WP_Query( $args );

					while ( $nsfw->have_posts() ) : $nsfw->the_post();

						get_template_part( 'template-parts/content-templates/' . $display_option );

					endwhile;

					?>
					<div class="king-pagination">
						<?php

							$big = 999999999; // need an unlikely integer.
							echo paginate_links( array(
								'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format'    => '?paged=%#%',
								'current'   => max( 1, get_query_var( 'paged' ) ),
								'total'     => $nsfw->max_num_pages,
								'prev_next' => true,
								'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
								'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
							) );
							?>
						</div>
						<?php
					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
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
