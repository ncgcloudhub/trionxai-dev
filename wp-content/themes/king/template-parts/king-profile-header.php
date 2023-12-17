<?php
/**
 * Profile Header Theme Part.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
$profile_id = get_query_var( 'profile_id' );
if ( $profile_id ) {
	$this_user = get_user_by( 'login', $profile_id );
} else {
	$this_user = wp_get_current_user();
}
$user_id = $this_user->ID;
if ( ! $user_id ) {
	wp_redirect( site_url() );
}
?>

<?php
if ( get_field( 'cover_image', 'user_' . $user_id ) ) {
	$coverimage = get_field( 'cover_image', 'user_' . $user_id );
	$cover      = $coverimage['url'];
} elseif ( get_field( 'default_cover', 'options' ) ) {
	$coverimage = get_field( 'default_cover', 'options' );
	$cover      = $coverimage['url'];
} else {
	$cover = '';
}
?>

<div class="king-profile-top" id="nocover" >
		<?php if ( ! empty( $cover ) ) : ?> 
		<div class="profile-cover" data-king-img-src="<?php echo esc_url( $cover ); ?>"></div>
	<?php else: ?>
		<div class="profile-cover"></div>
	<?php endif; ?>
	<div class="king-profile-head">
		<div class="king-profile-user">		
			<?php
			$url    = '';
			$uposts = get_posts(
				array(
					'posts_per_page' => 1,
					'author'         => $user_id,
					'post_type'      => 'stories',
					'date_query'     => array(
						'column' => 'post_date',
						'after'  => '- 1 days',
					),
				)
			);
			if ( $uposts ) {
				$url = get_permalink( $uposts[0]->ID );
			}
			?>
			<div class="king-profile-avatar">
				<?php if ( $url ) : ?>
					<a href="<?php echo esc_url( $url ); ?>" class="savatar story-popup-one">
						<svg class="circle" viewbox="0 0 40 40">
							<linearGradient id="SVGID_1_" gradientUnits="userSpaceOnUse" x1="1.4" y1="20" x2="34.4" y2="20">
								<stop  offset="1.385225e-07" style="stop-color:#3452ff"/>
								<stop  offset="1" style="stop-color:#845ef4"/>
							</linearGradient>
							<circle class="circle-chart" stroke="url(#SVGID_1_)" stroke-dasharray="100,100" stroke-linecap="round" fill="none" cx="20" cy="20" r="15.9"/>
						</svg>
				<?php endif; ?>
				<?php
				if ( get_field( 'author_image', 'user_' . $user_id ) ) :
					$image = get_field( 'author_image', 'user_' . $user_id );
					?>
					<img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
					<?php else : ?>
						<span class="no-avatar"></span>  
					<?php endif; ?>
					<?php if ( function_exists( 'is_woocommerce' ) && get_field( 'enable_membership', 'options' ) && king_check_membership( null, $user_id ) === true && ! $profile_id ) : ?>
						<a data-toggle="tooltip" data-placement="top" title="<?php the_field( 'membership_icon_title', 'option' ); ?>" class="membership-link" href="<?php echo esc_url( add_query_arg( array( 'template' => 'myplan' ), site_url() . '/' . $GLOBALS['king_dashboard'] ) ); ?>" ><?php the_field( 'membership_icon', 'options' ); ?></a>
					<?php elseif ( function_exists( 'is_woocommerce' ) && get_field( 'enable_membership', 'options' ) && king_check_membership( null, $user_id ) === true && $profile_id ) : ?>
						<span data-toggle="tooltip" data-placement="top" title="<?php the_field( 'membership_icon_title', 'option' ); ?>" class="membership-link" ><?php the_field( 'membership_icon', 'options' ); ?></span>
					<?php endif; ?>
					<?php if ( $url ) : ?>
					</a>
				<?php endif; ?>
				</div>
				<?php if ( get_field( 'enable_user_points', 'options' ) ) : ?>
					<div class="king-points" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'Points','king' ); ?>"><i class="fa fa-star" aria-hidden="true"></i> <?php echo king_user_points( $user_id ); ?></div>
				<?php endif; ?>				
			</div>		
			<div class="king-profile-info">
				<h4><?php echo esc_attr( $this_user->data->display_name ); ?>
				<?php if ( get_field( 'verified_account', 'user_' . $user_id ) ) : ?>	
					<i class="fa fa-check-circle fa-2x verified_account" aria-hidden="true" data-toggle="tooltip" data-placement="right" title="<?php echo esc_html_e( 'verified', 'king' ); ?>"></i>
				<?php endif; ?>
				</h4>
				<?php echo wp_kses_post( get_the_author_meta( 'first_name', $user_id ) ); ?> 
				<?php echo wp_kses_post( get_the_author_meta( 'last_name', $user_id ) ); ?>
			</div>
			<?php
			if ( get_field( 'enable_user_groups', 'options' ) ) :
				echo king_user_groups( $user_id );
			endif;
			?>
			<div class="king-profile-social">
				<ul>
					<?php if ( get_the_author_meta( 'description', $this_user->ID ) ) : ?>
						<li data-toggle="tooltip" data-placement="left" title="<?php echo esc_html_e( 'About', 'king' ); ?>"><a data-toggle="modal" data-target="#aboutmodal" role="button"><i class="fas fa-address-card"></i></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'profile_facebook', 'user_' . $user_id ) ) : ?>
						<li data-toggle="tooltip" data-placement="left" title="<?php echo esc_html_e( 'facebook', 'king' ); ?>" class="fb"><a href="<?php the_field( 'profile_facebook', 'user_' . $user_id ); ?>" target="_blank"><i class="fab fa-facebook"></i></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'profile_twitter', 'user_' . $user_id ) ) : ?>
						<li data-toggle="tooltip" data-placement="left" title="<?php echo esc_html_e( 'twitter', 'king' ); ?>" class="twi"><a href="<?php the_field( 'profile_twitter', 'user_' . $user_id ); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'profile_instagram', 'user_' . $user_id ) ) : ?>
						<li data-toggle="tooltip" data-placement="left" title="<?php echo esc_html_e( 'instagram', 'king' ); ?>" class="g"><a href="<?php the_field( 'profile_instagram', 'user_' . $user_id ); ?>" target="_blank"><i class="fab fa-instagram"></i> </a></li>
					<?php endif; ?>
					<?php if ( get_field( 'profile_pinterest', 'user_' . $user_id ) ) : ?>
						<li data-toggle="tooltip" data-placement="left" title="<?php echo esc_html_e( 'pinterest', 'king' ); ?>" class="g"><a href="<?php the_field( 'profile_pinterest', 'user_' . $user_id ); ?>" target="_blank"><i class="fab fa-pinterest-p"></i> </a></li>
					<?php endif; ?>
					<?php if ( get_field( 'profile_linkedin', 'user_' . $user_id ) ) : ?>
						<li data-toggle="tooltip" data-placement="left" title="<?php echo esc_html_e( 'linkedin', 'king' ); ?>" class="ln"><a href="<?php the_field( 'profile_linkedin', 'user_' . $user_id ); ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
					<?php endif; ?>        
					<?php if ( get_field( 'profile_add_url', 'user_' . $user_id ) ) : ?>
						<li data-toggle="tooltip" data-placement="left" title="<?php echo esc_html_e( 'url', 'king' ); ?>" class="ln"><a href="<?php the_field( 'profile_add_url', 'user_' . $user_id ); ?>" target="_blank"><i class="fas fa-link"></i></a></li>
					<?php endif; ?> 				    
				</ul>
			</div>
			<?php if ( ( $profile_id ) && ( is_user_logged_in() ) ) : ?>
			<div class="profile-fm">
				<?php
				$currentuser = wp_get_current_user();
				if ( $user_id !== $currentuser->ID ) {
					echo king_get_simple_follows_button( $user_id );
				}
				if ( ( $user_id !== get_current_user_id() ) && get_field( 'enable_private_messages', 'options' ) ) :
					?>
				<a data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'send a message', 'king' ); ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_prvtmsg'] . '/' . $this_user->user_login ); ?>" class="pm-profile"><i class="fa fa-envelope" aria-hidden="true"></i></a>	
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="profile-stats">
		<span class="profile-stats-num">
			<?php $posts = count_user_posts( $user_id, array('post', 'list', 'poll', 'trivia') ); ?>
			<i><?php echo esc_attr( $posts ); ?></i>
			<?php echo esc_html_e( 'Posts', 'king' ); ?>
		</span><!-- posts -->
		<span class="profile-stats-num">
			<i>
				<?php
				$likes = get_user_meta( $user_id, 'king_favorites', true );
				if ( ! empty( $likes ) ) {
					$likes = count($likes);
				} else {
					$likes = '0';
				}
				echo esc_attr( $likes );
				?>
			</i>                
			<?php echo esc_html_e( 'Favorites', 'king' ); ?>                  
		</span><!-- likes -->
		<span class="profile-stats-num">
			<i>
				<?php
				$comment_count = get_comments(array(
				    'user_id'   => $user_id,
				    'count'     => true,
				));
				echo esc_attr( $comment_count );
				?>
			</i>
			<?php echo esc_html_e( 'Comments', 'king' ); ?>
		</span><!-- comments -->
		<span class="profile-stats-num">

			<i>
				<?php
				$following = get_user_meta( $user_id, 'wp__user_follow_count', true );
				if ( ! empty( $following ) ) {
					echo esc_attr( $following );
				} else {
					echo '0';
				}

				?>
			</i>
			<?php echo esc_html_e( 'Following', 'king' ); ?>
		</span><!-- following -->
		<span class="profile-stats-num">
			<i>
				<?php
				$followers = get_user_meta( $user_id, 'wp__post_follow_count', true );
				if ( ! empty( $followers ) ) {
					echo esc_attr( $followers );
				} else {
					echo '0';
				}

				?>
			</i>
			<?php echo esc_html_e( 'Followers', 'king' ); ?>
		</span><!-- followers -->
	</div>   
	<?php if ( get_field( 'enable_user_badges', 'option' ) ) : ?>
		<div class="king-profile-badges">
			<?php
			$lb_badges = get_user_meta( $user_id, 'king_user_leaderboard', true );
			if ( $lb_badges && get_field( 'enable_leaderboard_badges', 'option' ) ) :
				?>
				<div class="king-profile-badge" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( str_replace( '_', ' ', $lb_badges ) ); ?>"><span class="lb-<?php echo esc_attr( $lb_badges ); ?>" ></span></div>
			<?php endif;
			if ( have_rows( 'king_badges', 'option' ) ) :
				while ( have_rows( 'king_badges', 'option' ) ) :
					the_row();
					$badge_min   = get_sub_field( 'badge_min_point' );
					$badge_max   = get_sub_field( 'badge_max_point' );
					$badge_title = get_sub_field( 'badge_title' );
					$badge_desc  = get_sub_field( 'badge_description' ) ? ' : ' . get_sub_field( 'badge_description' ) : '';
					$short = array();

					$user_point = get_user_meta( $user_id, 'king_user_points', true );

					$username[] = trim( str_replace( ' ', '', $badge_title ) );
					if ( get_row_layout() == 'badges_for_points' ) :
						if ( ( $user_point >= $badge_min ) && ( $badge_max >= $user_point ) ) :
							$short[] = trim( str_replace( ' ', '_', $badge_title ) );
						?>
						<div class="king-profile-badge" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $badge_title ); ?><?php echo esc_attr( $badge_desc ); ?> "><span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span></div>
						<?php
					endif;
				elseif ( get_row_layout() == 'badges_for_followers' ) :
					if ( ( $followers >= $badge_min ) && ( $badge_max >= $followers ) ) :
						$short[] = trim( str_replace( ' ', '_', $badge_title ) );
					?>
					<div class="king-profile-badge" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $badge_title ); ?><?php echo esc_attr( $badge_desc ); ?> "><span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span></div>
					<?php
				endif;
			elseif ( get_row_layout() == 'badges_for_posts' ) :
				if ( ( $posts >= $badge_min ) && ( $badge_max >= $posts ) ) :
					$short[] = trim( str_replace( ' ', '_', $badge_title ) );
				?>
				<div class="king-profile-badge" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $badge_title ); ?><?php echo esc_attr( $badge_desc ); ?> "><span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span></div>
				<?php
			endif;
		elseif ( get_row_layout() == 'badges_for_comments' ) :
			if ( ( $comment_count >= $badge_min ) && ( $badge_max >= $comment_count ) ) :
				$short[] = trim( str_replace( ' ', '_', $badge_title ) );
			?>
			<div class="king-profile-badge" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $badge_title ); ?><?php echo esc_attr( $badge_desc ); ?> "><span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span></div>
				<?php
		endif;
	elseif ( get_row_layout() == 'badges_for_likes' ) :
		if ( ( $likes >= $badge_min ) && ( $badge_max >= $likes ) ) :
			$short[] = trim( str_replace( ' ', '_', $badge_title ) );
			?>
		<div class="king-profile-badge" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( $badge_title ); ?><?php echo esc_attr( $badge_desc ); ?> "><span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span></div>
			<?php
	endif;
endif;
endwhile;
	update_user_meta( $user_id, 'king_user_badges', $short );
endif;
			?>
</div>
<?php endif; ?>
<div class="king-profile-links">
	<?php if ( ! $profile_id ) : ?>				
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] ); ?>" class="my-posts <?php echo esc_attr( isset( $GLOBALS['profile'] ) ? $GLOBALS['profile'] : '' ); ?>"><?php echo esc_html_e( 'Posts', 'king' ); ?></a>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_likes'] ); ?>" class="my-likes <?php echo esc_attr( isset( $GLOBALS['likes'] ) ? $GLOBALS['likes'] : '' ); ?>"><?php echo esc_html_e( 'Favorites', 'king' ); ?></a>
		<?php if ( get_field( 'enable_collections', 'options' ) ) : ?>
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_collec'] ); ?>" class="my-collections <?php echo esc_attr( isset( $GLOBALS['collections'] ) ? $GLOBALS['collections'] : '' ); ?>"><?php echo esc_html_e( 'Collections', 'king' ); ?></a>
		<?php endif; ?>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_followers'] ); ?>" class="followers <?php echo esc_attr( isset( $GLOBALS['followers'] ) ? $GLOBALS['followers'] : '' ); ?>"><?php echo esc_html_e( 'Followers', 'king' ); ?></a>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_following'] ); ?>" class="following <?php echo esc_attr( isset( $GLOBALS['following'] ) ? $GLOBALS['following'] : '' ); ?>"><?php echo esc_html_e( 'Following', 'king' ); ?></a>
		<a data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'settings', 'king' ); ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $GLOBALS['king_edit'] ); ?>" class="edit-profile <?php echo esc_attr( isset( $GLOBALS['settings'] ) ? $GLOBALS['settings'] : '' ); ?>"><i class="fa fa-cog" aria-hidden="true"></i></a>
		<?php else : ?>
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $this_user->data->user_login ); ?>" class="my-posts <?php echo esc_attr( isset( $GLOBALS['profile'] ) ? $GLOBALS['profile'] : '' ); ?>"><?php echo esc_html__( 'Posts', 'king' ); ?></a>
			<?php if ( get_field( 'enable_collections', 'options' ) ) : ?>
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_collec'] . '/' . $this_user->data->user_login ); ?>" class="my-collections <?php echo esc_attr( isset( $GLOBALS['collections'] ) ? $GLOBALS['collections'] : '' ); ?>"><?php echo esc_html_e( 'Collections', 'king' ); ?></a>
			<?php endif; ?>
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_likes'] . '/' . $this_user->data->user_login ); ?>" class="my-likes <?php echo esc_attr( isset( $GLOBALS['likes'] ) ? $GLOBALS['likes'] : '' ); ?>"><?php echo esc_html__( 'Favorites', 'king' ); ?></a>      
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_followers'] . '/' . $this_user->data->user_login ); ?>" class="followers <?php echo esc_attr( isset( $GLOBALS['followers'] ) ? $GLOBALS['followers'] : '' ); ?>"><?php echo esc_html__( 'Followers', 'king' ); ?></a>
			<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_following'] . '/' . $this_user->data->user_login ); ?>" class="following <?php echo esc_attr( isset( $GLOBALS['following'] ) ? $GLOBALS['following'] : '' ); ?>"><?php echo esc_html__( 'Following', 'king' ); ?></a> 
		<?php endif; ?>
	</div>

</div>
</div>
<?php if ( get_the_author_meta( 'description', $this_user->ID ) ) : ?>
	<div class="king-modal-login modal" id="aboutmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="king-modal-content">
			<button type="button" class="king-modal-close" data-dismiss="modal" aria-label="Close"><i class="icon fa fa-fw fa-times"></i></button>
			<div class="king-modal-header"><h4><?php echo esc_html_e( 'About', 'king' ); ?></h4></div>
			<div class="king-about king-scroll">
				<?php echo esc_attr( get_the_author_meta( 'description', $this_user->ID ) ); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
