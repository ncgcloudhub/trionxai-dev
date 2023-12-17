<?php
/**
 * User Profile following users page.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$GLOBALS['hide'] = 'hide';
$GLOBALS['following'] = 'active';
$profile_id           = get_query_var( 'profile_id' );
if ( $profile_id ) {
	$this_user = get_user_by( 'login',$profile_id );
} else {
	$this_user = wp_get_current_user();
}
if ( ! $this_user->ID ) {
	wp_redirect(site_url());
}
?>
<?php get_header(); ?>

<?php get_template_part( 'template-parts/king-profile-header' ); ?>
<div id="primary" class="profile-content-area kflex lr-padding">
	<main id="main" class="site-main">
		<?php
		if ( get_field( 'length_of_following', 'options' ) ) {
			$number = get_field( 'length_of_following', 'option' );
		} else {
			$number = '10';
		}
		$paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;

		if ( $paged === 1 ) {
			$offset = 0;
		} else {
			$offset     = ($paged - 1) * $number;
		}
		$user_query = new WP_User_Query( array(
			'meta_key' => 'wp__user_followd',
			'meta_value' => '"user-' . $this_user->ID . '";i:' . $this_user->ID . ';',
			'meta_compare' => 'LIKE',
			'number' => $number,
			'offset' => $offset,
			'order' => 'DESC',
		) );

		$count = $user_query->total_users;
		update_user_meta( $this_user->ID, 'wp__user_follow_count', $count );

		if ( ! empty( $user_query->results ) ) :
			foreach ( $user_query->results as $user ) {
				get_template_part( 'template-parts/pages/user', 'card', $user );
			}
		;else :
		?>
	<div class="no-follower"><i class="fab fa-slack-hash fa-2x"></i><?php esc_html_e( 'not following anyone yet', 'king' ); ?> </div>

			
		<?php endif; ?>

		<div class="king-pagination">
			<?php
			$total_user = $user_query->total_users;
			$total_pages = ceil( $total_user / $number );
			$format = '?page=%#%';
			if ( $profile_id ) {
				$url = site_url() . '/' . $GLOBALS['king_following'] . '/' . $profile_id . '%_%';
			} else {
				$url = site_url() . '/' . $GLOBALS['king_following'] . '%_%';
			}
			echo paginate_links( array(
				'base' => $url,
				'format' => $format,
				'current'  => max( 1, $paged ),
				'total'    => $total_pages,
				'prev_next'    => true,
				'prev_text'          => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
				'next_text'          => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
			) );
				?>
			</div>		
		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
