<?php
/**
 * Post Page Author Box
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<?php if ( ! get_field( 'hide_post_author_box', 'option' ) && get_option( 'permalink_structure' ) ) : ?>
<div class="post-author">
	<?php
	$vclass    = '';
	$vbadge    = '';
	$author    = get_the_author_meta( 'user_nicename' );
	$author_id = $post->post_author;
	if ( get_field( 'verified_account', 'user_' . $author_id ) ) :
		$vclass = 'verified';
		$vbadge = '<i class="fa fa-check-circle fa-2x verified_account" title="' . esc_html__( 'verified account', 'king' ) . '" aria-hidden="true"></i>';
	endif;
	?>
	<div class="post-author-top">
	<?php
	if ( get_field( 'author_image', 'user_' . $author_id ) ) :
		$image = get_field( 'author_image', 'user_' . $author_id );
		?>
		<a class="post-author-avatar-a <?php echo esc_attr( $vclass ); ?>" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>" >
			
			<img class="post-author-avatar" src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
		</a>
	<?php endif; ?>
		<a class="post-author-name" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>">
			<?php echo esc_attr( $author ); ?>
			<?php echo wp_kses_post( $vbadge ); ?>
		</a>
		<?php if ( get_field( 'enable_user_points', 'options' ) ) : ?>
			<div class="king-points" data-toggle="tooltip" data-placement="left" title="<?php echo esc_html_e( 'Points', 'king' ); ?>"><i class="fa fa-star" aria-hidden="true"></i> <?php echo king_user_points( $author_id ); ?></div>
		<?php endif; ?>
		<?php
		if ( get_field( 'enable_user_groups', 'options' ) ) :
			echo king_user_groups( $author_id );
		endif;
		?>
	</div>
	<?php if ( ! get_field( 'hide_author_about_text', 'option' ) ) : ?>
		<?php echo get_the_author_meta( 'description', $author_id ); ?>
	<?php endif; ?>
	<?php if ( ! get_field( 'hide_author_social_links', 'option' ) ) : ?>
		<div class="king-profile-social">
			<ul>
				<?php if ( get_field( 'profile_facebook', 'user_' . $author_id ) ) : ?>
					<li data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'facebook', 'king' ); ?>" class="fb"><a href="<?php the_field( 'profile_facebook', 'user_' . $author_id ); ?>" target="_blank"><i class="fab fa-facebook"></i></a></li>
				<?php endif; ?>
				<?php if ( get_field( 'profile_instagram', 'user_' . $author_id ) ) : ?>
					<li data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'instagram', 'king' ); ?>" class="g"><a href="<?php the_field( 'profile_instagram', 'user_' . $author_id ); ?>" target="_blank"><i class="fab fa-instagram"></i> </a></li>
				<?php endif; ?>
				<?php if ( get_field( 'profile_twitter', 'user_' . $author_id ) ) : ?>
					<li data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'twitter', 'king' ); ?>" class="twi"><a href="<?php the_field( 'profile_twitter', 'user_' . $author_id ); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
				<?php endif; ?>
				<?php if ( get_field( 'profile_linkedin', 'user_' . $author_id ) ) : ?>
					<li data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'linkedin', 'king' ); ?>" class="ln"><a href="<?php the_field( 'profile_linkedin', 'user_' . $author_id ); ?>" target="_blank"><i class="fab fa-linkedin"></i></a></li>
				<?php endif; ?>        
				<?php if ( get_field( 'profile_add_url', 'user_' . $author_id ) ) : ?>
					<li data-toggle="tooltip" data-placement="top" title="<?php echo esc_html_e( 'url', 'king' ); ?>" class="ln"><a href="<?php the_field( 'profile_add_url', 'user_' . $author_id ); ?>" target="_blank"><i class="fas fa-link"></i></a></li>
				<?php endif; ?> 				    
			</ul>
		</div>		
	<?php endif; ?>
	<?php
	if ( get_field( 'enable_user_badges', 'option' ) ) :
		$badges    = get_user_meta( $author_id, 'king_user_badges', true );
		$lb_badges = get_user_meta( $author_id, 'king_user_leaderboard', true );
		?>
		<div class="king-profile-box-badges" >
			<?php if ( $lb_badges ) : ?>
				<div class="king-profile-badge" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( str_replace( '_', ' ', $lb_badges ) ); ?>"><span class="lb-<?php echo esc_attr( $lb_badges ); ?>" ></span></div>
			<?php endif; ?>
			<?php if ( $badges ) : ?>
				<?php foreach ( $badges as $badge ) : ?>
					<div class="king-profile-badge" data-toggle="tooltip" data-placement="top" title="<?php echo esc_attr( str_replace( '_', ' ', $badge ) ); ?>"><span class="<?php echo esc_attr( $badge ); ?>"></span></div>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>	

</div><!-- .post-author -->
<?php endif; ?>