<?php
/**
 * The header part - header strip.
 *
 * This is the header template part.
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
<aside id="king-newsletter" class="king-newsletter" data-expired="<?php the_field( 'newsletter_expired', 'options' ); ?>" data-delay="<?php the_field( 'newsletter_delay_time', 'options' ); ?>" data-id="newsl-<?php the_field( 'newsletter_delay_time', 'options' ); ?>" style="display: none;">
	<div class="king-newsletter-popup">
		<div class="king-newsletter-content">
			<?php
			if ( get_field( 'newsletter_cover_image', 'options' ) ) :
				$coverimage = get_field( 'newsletter_cover_image', 'options' );
				$cover      = $coverimage['sizes']['large'];
				?>
				<div class="king-newsletter-left"><div class="king-box-bg" data-king-img-src="<?php echo esc_attr( $cover ); ?>"></div></div>
			<?php endif; ?>
			<div class="king-newsletter-right">
			<?php if ( get_field( 'newsletter_title', 'options' ) ) : ?>
				<h3><?php the_field( 'newsletter_title', 'options' ); ?></h3>
			<?php endif; ?>
			<?php if ( get_field( 'newsletter_description', 'options' ) ) : ?>
				<div class="king-newsletter-desc"><p><?php the_field( 'newsletter_description', 'options' ); ?></p></div>
			<?php endif; ?>
			<form class="king-newsletter-form" action="#" method="post">
				<div class="king-newsletter-notice" >
					<span class="king-newsletter-error" style="display: none;"><?php echo esc_html_e( 'Please fill all required fields !', 'king' ); ?></span>
				</div>
				<div class="king-newsletter-input">
					<input class="newsletter-email" placeholder="<?php echo esc_html_e( 'your e-mail', 'king' ); ?>" type="email" name="king_email_subscribe" required>
			<?php if ( get_field( 'newsletter_submit_text', 'options' ) ) : ?>
				<button type="submit" name="submit" class="newsletter-submit"><?php the_field( 'newsletter_submit_text', 'options' ); ?></button>
			<?php endif; ?>	
				</div>
				<?php if ( get_field( 'privacy_text', 'options' ) ) : ?>
				<div class="king-newsletter-privacy">
					<input type="checkbox" id="king-privacy" name="king_privacy" class="newsletter-checkbox" required>
					<label for="king-privacy"><?php the_field( 'privacy_text', 'options' ); ?></label>
				</div>
				<?php endif; ?>	
			</form>
			<button id="king-newsletter-close" title="<?php echo esc_html_e( 'Close', 'king' ); ?>"><i class="fas fa-times"></i></button>
			</div>
		</div>
	</div>
</aside>