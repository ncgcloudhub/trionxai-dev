<?php
/**
 * User Profile Page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
$GLOBALS['profile'] = 'active';
$profile_id         = get_query_var( 'profile_id' );
if ( $profile_id ) {
	$this_user = get_user_by( 'login', $profile_id );
} else {
	$this_user = wp_get_current_user();
}
if ( ! $this_user->ID ) {
	wp_safe_redirect( site_url() );
}
?>
<?php get_header(); ?>

<?php get_template_part( 'template-parts/king-profile-header' ); ?>
<?php
if ( get_field( 'enable_stories', 'options' ) ) {
	$storyargs['users']   = $this_user->ID;
	$storyargs['class']   = 'str-profile';
	$storyargs['profile'] = true;
	get_template_part( 'template-parts/king', 'stories', $storyargs );
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
	<?php if ( ! $profile_id ) : ?>
		<div class="king-3rd-nav">
			<span>
				<a class="<?php if ( ! get_query_var( 'orderby' ) ) { echo 'active'; } ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] ); ?>" ><?php esc_html_e( 'Published', 'king' ); ?></a>
				<a class="<?php if ( get_query_var( 'orderby' ) && get_query_var( 'orderby' ) === 'pending' ) {  echo 'active'; } ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/?orderby=pending' ); ?>" ><?php esc_html_e( 'Pending', 'king' ); ?></a>
				<?php if ( get_field( 'enable_save_posts', 'options' ) ) : ?>
					<a class="<?php if ( get_query_var( 'orderby' ) && get_query_var( 'orderby' ) === 'draft' ) { echo 'active'; } ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/?orderby=draft' ); ?>" ><?php esc_html_e( 'Draft', 'king' ); ?></a>
				<?php endif; ?>
				<?php if ( get_field( 'enable_stories', 'options' ) ) : ?>
					<a title="<?php echo esc_html_e( 'Stories', 'king' ); ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/?orderby=stories' ); ?>" class="stories-link <?php if ( get_query_var( 'orderby' ) && get_query_var( 'orderby' ) === 'stories' ) {  echo 'active'; } ?>"><?php echo esc_html_e( 'Stories', 'king' ); ?></a>
				<?php endif; ?>
			</span>
		</div>	
	<?php endif; ?>	
<div id="primary" class="profile-content-area lr-padding <?php echo esc_attr( $display_option ); ?>">

	<div class="kflex <?php echo esc_attr( $column ); ?> <?php if ( get_query_var( 'orderby' ) && get_query_var( 'orderby' ) === 'stories' ) {  echo 'content-story'; } else { echo 'site-main-top'; } ?>">
		<main id="main" class="site-main">
			<ul class="king-posts">
				<li class="grid-sizer"></li>
				<?php
				$pages = isset( $_GET['page'] ) ? $_GET['page'] : 0;
				if ( get_field( 'length_of_posts_in_profile', 'options' ) ) {
					$length_user_posts = get_field( 'length_of_posts_in_profile', 'option' );
				} else {
					$length_user_posts = '8';
				}
				if ( ( get_query_var( 'orderby' ) && get_query_var( 'orderby' ) === 'draft' ) && ! $profile_id ) {
					$the_query = new WP_Query(
						array(
							'posts_per_page' => $length_user_posts,
							'author'         => $this_user->ID,
							'paged'          => $pages,
							'post_status'    => array( 'draft' ),
							'post_type'      => king_post_types(),
						)
					);
				} elseif ( ( get_query_var( 'orderby' ) && get_query_var( 'orderby' ) === 'pending' ) && ! $profile_id ) {
					$the_query = new WP_Query(
						array(
							'posts_per_page' => $length_user_posts,
							'author'         => $this_user->ID,
							'paged'          => $pages,
							'post_status'    => array( 'pending' ),
							'post_type'      => king_post_types(),
						)
					);
				} elseif ( ( get_query_var( 'orderby' ) && get_query_var( 'orderby' ) === 'stories' ) && ! $profile_id && get_field( 'enable_stories', 'options' ) ) {
					$the_query = new WP_Query(
						array(
							'posts_per_page' => $length_user_posts,
							'author'         => $this_user->ID,
							'paged'          => $pages,
							'post_status'    => array( 'pending', 'publish' ),
							'post_type'      => 'stories',
						)
					);
				} else {
					$the_query = new WP_Query(
						array(
							'posts_per_page' => $length_user_posts,
							'author'         => $this_user->ID,
							'paged'          => $pages,
							'post_type'      => king_post_types(),
						)
					);
				}
				if ( $the_query->have_posts() ) :
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
						if ( get_query_var( 'orderby' ) === 'stories' && get_field( 'enable_stories', 'options' ) ) {
							get_template_part( 'template-parts/content-templates/content-story' );
						} else {
							get_template_part( 'template-parts/content-templates/' . $display_option );
						}
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<div class="no-follower"><i class="fab fa-slack-hash fa-2x"></i><?php esc_html_e( 'Sorry, no posts were found', 'king' ); ?> </div>
				<?php endif; ?>
				<div class="king-pagination">
					<?php
					$format = '?page=%#%';
					if ( $profile_id ) {
						$url = site_url() . '/' . $GLOBALS['king_account'] . '/' . $profile_id . '%_%';
					} else {
						$url = site_url() . '/' . $GLOBALS['king_account'] . '/%_%';
					}
					$big = 999999999;
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
			</ul>
		</main><!-- #main -->
	</div>
</div><!-- #primary -->
<?php
if ( get_field( 'enable_leaderboard_badges', 'option' ) ) :
	king_leaderboard_badge( $this_user->ID );
endif;
?>
<?php get_footer(); ?>
