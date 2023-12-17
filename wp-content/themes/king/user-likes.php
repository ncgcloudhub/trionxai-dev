<?php
/**
 * User Liked Posts page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
$GLOBALS['likes'] = 'active';
$profile_id = get_query_var( 'profile_id' );
if ( $profile_id ) {
	$this_user = get_user_by( 'login', $profile_id );
} else {
	$this_user = wp_get_current_user();
}
if ( ! $this_user->ID ) {
	wp_redirect(site_url());
}
if ( get_field( 'select_default_display_option', 'options' ) ) {
	$display_option = get_field( 'select_default_display_option', 'options' );
} else {
	$display_option = 'king-grid-01';
}
$htemplate = get_field( 'profile_template', 'options' );
if ( $htemplate ) {
	$column = ' ' . $htemplate['column'];
	$display_option = ! empty($htemplate['post_layout']) ? $htemplate['post_layout'] : $display_option;
} else {
	$column = '';
}
?>
<?php get_header(); ?>

<?php get_template_part( 'template-parts/king-profile-header' ); ?>
<div id="primary" class="content-area lr-padding <?php echo esc_attr( $display_option ); ?>">
<div class="site-main-top kflex <?php echo esc_attr( $column ); ?>">
	<main id="main" class="site-main">
		<ul class="king-posts">
			<li class="grid-sizer"></li>
			<?php
			$pages = isset( $_GET['page'] ) ? $_GET['page'] : 0;
			if ( get_field( 'length_of_users_liked_posts', 'options' ) ) {
				$length_user_likes = get_field( 'length_of_users_liked_posts', 'option' );
			} else {
				$length_user_likes = '10';
			}

			$fav_posts = get_user_meta( $this_user->ID, 'king_favorites', true );


			if ( $fav_posts ) :
				$the_query = new WP_Query(
					[
						'post__in'       => array_reverse( $fav_posts ),
						'orderby'        => 'post__in',
						'posts_per_page' => $length_user_likes,
						'paged'          => $pages,
						'post__not_in'   => get_option( 'sticky_posts' ),
						'post_type'      => king_post_types(),
					]
				);

				$count = $the_query->found_posts;
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						get_template_part( 'template-parts/content-templates/' . $display_option );
					endwhile;
					wp_reset_postdata();
				endif;
			?>

				<div class="king-pagination">
					<?php
					$format = '?page=%#%';
					if ( $profile_id ) {
						$url = site_url() . '/' . $GLOBALS['king_likes'] . '/' . $profile_id . '%_%';
					} else {
						$url = site_url() . '/' . $GLOBALS['king_likes'] . '/%_%';
					}
							$big = 999999999; // need an unlikely integer.
							echo paginate_links(
								array(
									'base'      => $url,
									'format'    => $format,
									'current'   => max( 1, $pages ),
									'total'     => $the_query->max_num_pages,
									'prev_next' => true,
									'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
									'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
								)
							);
							?>
					</div>
				<?php else : ?>
		<div class="no-follower"><i class="fab fa-slack-hash fa-2x"></i><?php esc_html_e( 'Sorry, no posts were found', 'king' ); ?> </div>
		<?php endif; ?>
				</ul>
			</main><!-- #main -->
		</div>
	</div><!-- #primary -->
<?php get_footer(); ?>
