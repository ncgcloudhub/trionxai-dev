<?php
/**
 * Gallery View.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
$ftclass = '';
if ( 'badges-2' === get_field( 'post_page_buttons_style', 'options' ) ) :
	$ftclass = ' flex-columns';
	?>
	<div class="king-post-out">
<?php endif; ?>
<div class="post-page-ft<?php echo esc_attr( $ftclass ); ?>">
	<div class="post-like">
		<?php
		if ( ! get_field( 'disable_post_votes', 'options' ) && king_plugin_active( 'ACF' ) ) :
			$down = get_field( 'disable_down_vote_in_posts', 'options' ) ? true : false;
			echo king_vote( get_the_ID(), 'p', $down );
		endif;
		?>
		<?php if ( ! is_user_logged_in() ) : ?>
			<div class="king-alert-like"><?php esc_html_e( 'Please ', 'king' ); ?><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>"><?php esc_html_e( 'log in ', 'king' ); ?></a><?php esc_html_e( ' or ', 'king' ); ?><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_register'] ); ?>"><?php esc_html_e( ' register ', 'king' ); ?></a><?php esc_html_e( ' to do it. ', 'king' ); ?></div>
		<?php endif; ?>
	</div><!-- .post-like -->
	<div class="ft-right">
		<button class="king-share-dropdown" data-toggle="modal" data-target="#sharemodal" role="button"><span class="share-counter"><?php echo esc_attr( get_post_meta( get_the_ID(), 'share_counter', true ) ); ?></span><i data-toggle="tooltip" data-placement="bottom" title="<?php esc_html_e( 'share', 'king' ); ?>" class="far fa-paper-plane"></i></button>

		<?php
		if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
			echo wp_kses_post( king_bookmark_button( get_current_user_id(), get_the_ID(), 'single-bookmarks' ) );
		endif;
		?>
	<?php echo king_favorite_button( get_the_ID() ); ?>
	<?php
	if ( get_field( 'enable_flags_for_posts', 'options' ) && is_user_logged_in() ) :
		echo king_flag_button( get_the_ID(), 'p' );
	endif;
	?>
	</div><!-- .ft-right -->
</div><!-- .post-page-featured-trending -->
<?php if ( 'badges-2' === get_field( 'post_page_buttons_style', 'options' ) ) : ?>
	<div class="king-post-in">
<?php endif; ?>