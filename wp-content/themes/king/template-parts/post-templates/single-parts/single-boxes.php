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

<?php
$ad_below = get_field( 'ads_below_content', 'options' );
if ( $ad_below && king_add_free_mode() ) :
	?>
	<div class="ads-postpage">
		<?php echo do_shortcode( $ad_below ); ?>
	</div>
<?php endif; ?>
<?php if ( get_field( 'editors_choice' ) && get_field( 'display_editors_choice_note', 'option' ) ) : ?>
<div class="single-boxes">
	<div class="single-boxes-title"><i class="fab fa-pagelines fa-2x fa-flip-horizontal"></i><h4><?php the_field( 'editors_choice_title', 'option' ); ?></h4><i class="fab fa-pagelines fa-2x"></i></div>
	<?php if ( get_field( 'editors_note' ) ) : ?>
		<?php the_field( 'editors_note' ); ?>
		<?php else : ?>
			<?php the_field( 'editors_choice_default_text', 'option' ); ?>
		<?php endif; ?>	
	</div>
<?php endif; ?>	
<?php if ( get_field( 'enable_reactions_without_comments', 'option' ) ) : ?>
	<?php echo king_reactions_box_buttons(); ?>
<?php endif; ?>			
<?php if ( get_field( 'enable_reactions', 'option' ) && get_field( 'display_reactions_block', 'option' ) ) : ?>				
<div class="single-boxes king-reactions-block">
	<div class="single-boxes-title"><h4><?php esc_html_e( 'Reactions', 'king' ); ?></h4></div>
	<?php echo wp_kses_post( king_reactions( get_the_ID() ) ); ?>
</div><!-- .king-reactions-block -->
<?php endif; ?>						
<?php if ( get_field( 'display_who_liked', 'options' ) ) : ?>
	<div class="single-boxes postlike-users">
		<?php
		$userlikes = get_post_meta( get_the_ID() , 'king_vote_likes', true );
		if ( ! empty( $userlikes ) ) : ?>
			<div class="single-boxes-title"><h4><?php the_field( 'who_liked_box_title', 'option' ); ?></h4></div>	
			<?php
			$user_query = new WP_User_Query( array( 'include' => $userlikes, 'number' => 4, 'order' => 'DESC' ) );
							// User Loop.
			if ( ! empty( $user_query->results ) ) {
				foreach ( $user_query->results as $user ) {
					?>

					<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $user->user_login ); ?>" >
						<?php if ( get_field( 'author_image','user_' . $user->ID ) ) : $image = get_field( 'author_image','user_' . $user->ID ); ?>
							<img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
							<?php else : ?>
								<span class="postlike-users-noavatar"></span>
							<?php endif; ?>
						</a>    

						<?php
					}
				}
				;else : ?>
				<h3><?php the_field( 'if_nobody_liked_box_title', 'option' ); ?></h3>
			<?php endif; ?> 
		</div><!-- .postlike-users -->
	<?php endif; ?> 
	<?php get_template_part( 'template-parts/post-templates/single-parts/authorbox' ); ?>
	<?php if ( get_post_status( $post->ID ) === 'draft' ) : ?>
		<div class="king-pending"><?php esc_html_e( 'This post saved as draft, you can see and edit all saved post drafts', 'king' ); ?><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . '?orderby=draft' ); ?>"><?php esc_html_e( ' HERE.', 'king' ); ?></a></div>
	<?php endif; ?>