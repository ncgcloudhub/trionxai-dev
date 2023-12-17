<?php
/**
 * The template for displaying the Hot page
 *
 * Template Name: hot
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
// Sidebar templates.
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
<header class="page-top-header hot">
	<h1 class="page-title"><?php esc_html_e( 'HOT!', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>
	<div class="king-3rd-nav">
		<span>
			<a class="<?php if ( ! get_query_var( 'orderby' ) ) { echo 'active'; } ?>" href="<?php echo esc_url( get_permalink() ); ?>" ><?php esc_html_e( 'HOT!', 'king' ); ?></a>
			<a href="<?php echo esc_url( get_permalink() . '?orderby=views' ); ?>" class="<?php if ( get_query_var( 'orderby' ) === 'views' ) {  echo 'active'; } ?>"><?php esc_html_e( 'Views', 'king' ); ?></a>
			<a href="<?php echo esc_url( get_permalink() . '?orderby=votes' ); ?>" class="<?php if ( get_query_var( 'orderby' ) === 'votes' ) { echo 'active'; } ?>"><?php esc_html_e( 'Votes', 'king' ); ?></a>
			<a href="<?php echo esc_url( get_permalink() . '?orderby=comments' ); ?>" class="<?php if ( get_query_var( 'orderby' ) === 'comments' ) { echo 'active'; } ?>"><?php esc_html_e( 'Comments', 'king' ); ?></a>
		</span>
	</div>
<div id="primary" class="content-area king-hot lr-padding <?php echo esc_attr( $display_option ); ?>">

	<div id="king-pagination-02" class="site-main-top kflex <?php echo esc_attr( $sidebar . $column ); ?>">
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
					$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
					/* Start the Loop */
					if ( get_field( 'length_hot', 'options' ) ) {
						$length_hot = get_field( 'length_hot', 'option' );
					} else {
						$length_hot = '10';
					}

				if ( get_query_var( 'orderby' ) === 'views' ) { // input var okay; sanitization.

					$args = array( 'posts_per_page' => $length_hot, 'meta_key' => '_post_views', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'paged' => $paged, 'post_type' => king_post_types() );

				} elseif ( get_query_var( 'orderby' ) === 'votes' ) {

					$args = array( 'posts_per_page' => $length_hot, 'meta_key' => 'king_like_count', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'paged' => $paged, 'post_type' => king_post_types() );

				} elseif ( get_query_var( 'orderby' ) === 'comments' ) {

					$args = array( 'posts_per_page' => $length_hot, 'orderby' => 'comment_count', 'order' => 'DESC', 'paged' => $paged, 'post_type' => king_post_types() );

				} else {
					$args = array(
						'posts_per_page' => $length_hot,
						'paged'          => $paged,
						'post_type'      => king_post_types(),
						'meta_query'     => array(
							'relation'         => 'AND',
							'_post_views'      => array(
								'key'     => '_post_views',
								'type'    => 'NUMERIC',
								'compare' => 'LIKE',
							),
							'king_like_count' => array(
								'key'     => 'king_like_count',
								'type'    => 'NUMERIC',
								'compare' => 'LIKE',
							),
						),
						'orderby'        => array(
							'_post_views'      => 'DESC',
							'king_like_count' => 'DESC',
						),
						'post__not_in'   => get_option( 'sticky_posts' ),
					);
				}
					$hot = new WP_Query( $args );
					while ( $hot->have_posts() ) :
						$hot->the_post();
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
							'total'     => $hot->max_num_pages,
							'prev_next' => true,
							'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
							'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
						) );
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
