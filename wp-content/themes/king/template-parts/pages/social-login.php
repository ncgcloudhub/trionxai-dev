<?php
/**
 * Social Login buttons.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( get_field( 'enable_facebook_login', 'option' ) || get_field( 'enable_googleplus_login', 'option' ) ) : ?>
<div class="social-login">
	<span class="social-or"><?php esc_html_e( 'OR', 'king' ); ?></span>
	<?php if ( get_field( 'enable_facebook_login', 'option' ) ) : ?>
		<a class="fb-login" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] . '/Facebook' ); ?>"><i class="fab fa-facebook"></i><?php esc_html_e( 'Connect w/', 'king' ); ?> <b><?php esc_html_e( 'Facebook', 'king' ); ?></b></a>
	<?php endif; ?>		
	<?php if ( get_field( 'enable_googleplus_login', 'option' ) ) : ?>
		<a class="google-login" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] . '/Google' ); ?>"><i class="fab fa-google-plus"></i><?php esc_html_e( 'Connect w/', 'king' ); ?> <b><?php esc_html_e( 'Google', 'king' ); ?></b></a>				
	<?php endif; ?>
	<?php if ( get_field( 'enable_twitter_login', 'option' ) ) : ?>
		<a class="twi-login" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] . '/Twitter' ); ?>"><i class="fab fa-twitter"></i><?php esc_html_e( 'Connect w/', 'king' ); ?> <b><?php esc_html_e( 'Twitter', 'king' ); ?></b></a>
	<?php endif; ?>	
	<?php if ( get_field( 'enable_instagram_login', 'option' ) ) : ?>
		<a class="insta-login" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] . '/Instagram' ); ?>"><i class="fab fa-instagram"></i><?php esc_html_e( 'Connect w/', 'king' ); ?> <b><?php esc_html_e( 'Instagram', 'king' ); ?></b></a>
	<?php endif; ?>
	<?php if ( get_field( 'enable_reddit_login', 'option' ) ) : ?>
		<a class="reddit-login" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] . '/Reddit' ); ?>"><i class="fab fa-reddit"></i><?php esc_html_e( 'Connect w/', 'king' ); ?> <b><?php esc_html_e( 'Reddit', 'king' ); ?></b></a>
	<?php endif; ?>
	<?php if ( get_field( 'enable_vkontakte_login', 'option' ) ) : ?>
		<a class="vk-login" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] . '/Vkontakte' ); ?>"><i class="fab fa-vk"></i><?php esc_html_e( 'Connect w/', 'king' ); ?> <b><?php esc_html_e( 'Vkontakte', 'king' ); ?></b></a>
	<?php endif; ?>
</div>
<?php endif; ?>