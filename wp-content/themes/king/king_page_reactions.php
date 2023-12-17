<?php
/**
 * The template for displaying the Hot page
 *
 * Template Name: reactions
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
		$column = '' . $htemplate['column'];
	} else {
		$column = '';
	}
	$display_option = ! empty($htemplate['post_layout']) ? $htemplate['post_layout'] : $display_option;
} else {
	$sidebar = 'king-sidebar-04';
	$column  = '';
}
?>
<header class="page-top-header reactions">
	<h1 class="page-title"><?php esc_html_e( 'Reactions', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>
	<div class="king-3rd-nav">
		<span>
			<a class="king-reaction-item-icon king-reaction-like <?php if ( ! get_query_var( 'orderby' ) ) { echo 'active'; } ?>" href="<?php echo esc_url( get_permalink() ); ?>" ></a>
			<a href="<?php echo esc_url( get_permalink() . '?orderby=love' ); ?>" class="king-reaction-item-icon king-reaction-love <?php if ( get_query_var( 'orderby' ) === 'love' ) : ?>active<?php endif; ?>"></a>
			<a href="<?php echo esc_url( get_permalink() . '?orderby=haha' ); ?>" class="king-reaction-item-icon king-reaction-haha <?php if ( get_query_var( 'orderby' ) === 'haha' ) : ?>active<?php endif; ?>"></a>
			<a href="<?php echo esc_url( get_permalink() . '?orderby=wow' ); ?>" class="king-reaction-item-icon king-reaction-wow <?php if ( get_query_var( 'orderby' ) === 'wow' ) : ?>active<?php endif; ?>"></a>
			<a href="<?php echo esc_url( get_permalink() . '?orderby=sad' ); ?>" class="king-reaction-item-icon king-reaction-sad <?php if ( get_query_var( 'orderby' ) === 'sad' ) : ?>active<?php endif; ?>"></a>
			<a href="<?php echo esc_url( get_permalink() . '?orderby=angry' ); ?>" class="king-reaction-item-icon king-reaction-angry <?php if ( get_query_var( 'orderby' ) === 'angry' ) : ?>active<?php endif; ?>"></a>
		</span>
	</div>
<div id="primary" class="content-area king-reactions-page lr-padding <?php echo esc_attr( $display_option ); ?>">

	<div id="switchview" class="site-main-top kflex <?php echo esc_attr( $sidebar . $column ); ?>">
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

					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;

					if ( get_field( 'length_reaction', 'options' ) ) {
						$length_hot = get_field( 'length_reaction', 'option' );
					} else {
						$length_hot = '10';
					}

				if ( get_query_var( 'orderby' ) === 'love' ) { // input var okay; sanitization.

					$meta_key = 'king_reaction_love';

				} elseif ( get_query_var( 'orderby' ) === 'haha' ) { // input var okay; sanitization.

					$meta_key = 'king_reaction_haha';

				} elseif ( get_query_var( 'orderby' ) === 'wow' ) { // input var okay; sanitization.

					$meta_key = 'king_reaction_wow';

				} elseif ( get_query_var( 'orderby' ) === 'sad' ) { // input var okay; sanitization.

					$meta_key = 'king_reaction_sad';

				} elseif ( get_query_var( 'orderby' ) === 'angry' ) { // input var okay; sanitization.

					$meta_key = 'king_reaction_angry';

				} else {

					$meta_key = 'king_reaction_like';

				}
				$args = array(
					'posts_per_page' => $length_hot,
					'meta_key'       => $meta_key,
					'orderby'        => 'meta_value_num',
					'order'          => 'DESC',
					'paged'          => $paged,
					'post__not_in'   => get_option( 'sticky_posts' ),
					'post_type'      => king_post_types(),
				);
				$query = new WP_Query( $args );

				while ( $query->have_posts() ) : $query->the_post();
					get_template_part( 'template-parts/content-templates/' . $display_option );
				endwhile;
				?>
				<div class="king-pagination">
					<?php

							$big = 999999999; // need an unlikely integer.
							echo paginate_links(
								array(
									'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
									'format'    => '?paged=%#%',
									'current'   => max( 1, get_query_var( 'paged' ) ),
									'total'     => $query->max_num_pages,
									'prev_next' => true,
									'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
									'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
								)
							);
							?>
						</div>
						<?php wp_reset_postdata(); ?>
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
