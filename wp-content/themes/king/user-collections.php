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
$GLOBALS['collections'] = 'active';
$profile_id             = get_query_var( 'profile_id' );
if ( $profile_id ) {
	$this_user = get_user_by( 'login', $profile_id );
} else {
	$this_user = wp_get_current_user();
}
$usrid = $this_user->ID;
if ( ! $usrid ) {
	wp_safe_redirect( site_url() );
}
$colls = get_user_meta( $usrid, 'king_collections', true );
$bucid = get_query_var( 'term' );
if ( isset( $_POST['king_dcollec'] ) && wp_verify_nonce( $_POST['delete_bucket_nonce'], 'delete_bucket' ) ) {
	delete_user_meta( $usrid, 'king_collect_' . $bucid );
	delete_user_meta( $usrid, 'king_collection_' . $bucid );
	if ( is_array( $colls ) && in_array( $bucid, $colls ) ) {
		$uid_key = array_search( $bucid, $colls );
		unset( $colls[ $uid_key ] );
		update_user_meta( $usrid, 'king_collections', $colls );
	}
	wp_safe_redirect( site_url() . '/' . $GLOBALS['king_collec'] );
	exit;
	
}
if ( get_field( 'select_default_display_option', 'options' ) ) {
	$display_option = get_field( 'select_default_display_option', 'options' );
} else {
	$display_option = 'king-grid-01';
}
?>
<?php get_header(); ?>

<?php get_template_part( 'template-parts/king-profile-header' ); ?>
<div id="primary" class="content-area lr-padding <?php echo esc_attr( $display_option ); ?>">
<div class="site-main-top kflex">
	<main id="main" class="site-main king-collections">
		<?php
		$buc   = get_user_meta( $usrid, 'king_collect_' . $bucid, true );
		if ( $bucid && $buc ) :
			?>
			<div class="bucket-title">
				<form action="" class="delete-bucket" method="post" enctype="multipart/form-data" autocomplete="off">
					<?php if ( true === $buc['p'] ) : ?>
						<i class="fa-solid fa-lock" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'Private', 'king' ); ?>"></i>
					<?php endif; ?>
					<?php if ( ! $profile_id ) : ?>	
						<button type="submit" name="king_dcollec" class="king-delete-bucket" data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'Delete Collection !', 'king' ); ?>"><i class="fa-solid fa-trash"></i></button>
					<?php endif; ?>
					<?php wp_nonce_field( 'delete_bucket', 'delete_bucket_nonce' ); ?>
				</form>
				<h1><?php echo esc_attr( $buc['t'] ); ?></h1>
				<span><?php echo esc_attr( $buc['d'] ); ?></span>
			</div>
			<ul class="king-posts">
				<li class="grid-sizer"></li>
				<?php
				$pags      = isset( $_GET['page'] ) ? $_GET['page'] : 0;
				$fav_posts = get_user_meta( $usrid, 'king_collection_' . $bucid, true );
				if ( $fav_posts ) :
					$the_query = new WP_Query(
						[
							'post__in'       => array_reverse( $fav_posts ),
							'orderby'        => 'post__in',
							'posts_per_page' => 10,
							'paged'          => $pags,
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
							$url = site_url() . '/' . $GLOBALS['king_collec'] . '/' . $profile_id . '%_%';
						} else {
							$url = site_url() . '/' . $GLOBALS['king_collec'] . '/%_%';
						}
							$big = 999999999; // need an unlikely integer.
							echo paginate_links(
								array(
									'base'      => $url,
									'format'    => $format,
									'current'   => max( 1, $pags ),
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
				<?php
			else :
				
				if ( $colls ) :
					?>
					<ul class="king-collections-ul">
						<?php
						foreach ( $colls as $coll ) :
							$collin   = get_user_meta( $usrid, 'king_collect_' . $coll, true );
							$cposts   = get_user_meta( $usrid, 'king_collection_' . $coll, true );
							$areverse = is_array( $cposts ) ? array_reverse( $cposts ) : '';
							$cp1      = isset( $areverse[0] ) ? get_the_post_thumbnail_url( $areverse[0], 'medium_large' ) : '';
							$cp2      = isset( $areverse[1] ) ? get_the_post_thumbnail_url( $areverse[1], 'thumbnail' ) : '';
							$cp3      = isset( $areverse[2] ) ? get_the_post_thumbnail_url( $areverse[2], 'thumbnail' ) : '';
							if ( $profile_id ) {
								$burl = site_url() . '/' . $GLOBALS['king_collec'] . '/' . $profile_id . '/?term=' . $coll;
							} else {
								$burl = site_url() . '/' . $GLOBALS['king_collec'] . '/?term=' . $coll;
							}
							if ( true !== $collin['p'] || $usrid === get_current_user_id() ) :
								?>

								<li class="king-collection">
									<a href="<?php echo esc_url( $burl ); ?>">
										<div class="king-collection-imgs">
											<div class="shot-image main-shot-image" style="background-image:url('<?php echo esc_url( $cp1 ); ?>');"></div>
											<div class="other-shots-container">
												<div class="shot-image other-shot-image" style="background-image:url('<?php echo esc_url( $cp2 ); ?>');"></div>
												<div class="shot-image other-shot-image" style="background-image:url('<?php echo esc_url( $cp3 ); ?>');"></div>
											</div>
										</div>
										<div class="king-collection-content">
											<span class="king-collection-t">
												<?php echo esc_attr( $collin['t'] ); ?>
												<?php if ( true === $collin['p'] ) : ?>
													<i class="fa-solid fa-lock"></i>
												<?php endif; ?>
											</span>
											<span><?php echo esc_attr( isset( $collin['d'] ) ? $collin['d'] : '' ); ?></span>
										</div>
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>

					</ul>
				<?php else : ?>
					<div class="no-follower"><i class="fab fa-slack-hash fa-2x"></i><?php esc_html_e( 'Sorry, no posts were found', 'king' ); ?> </div>
				<?php endif; ?>
			<?php endif; ?>
		</main>
	</div>
</div><!-- #primary -->
	<?php get_footer(); ?>
