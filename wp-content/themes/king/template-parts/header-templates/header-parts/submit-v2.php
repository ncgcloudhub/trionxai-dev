<?php
/**
 * The header part - user menu.
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
<?php if ( get_field( 'disable_users_submit', 'options' ) !== true ) : ?>
	<?php if ( get_option( 'permalink_structure' ) ) : ?>
		<div class="king-modal-login modal" id="submitmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="king-modal-content">
				<button type="button" class="king-modal-close" data-dismiss="modal" aria-label="Close"><i class="icon fa fa-fw fa-times"></i></button>
				<div class="king-submit-v2">
					<ul class="king-submit-buttons">
					<?php if ( get_field( 'disable_news', 'options' ) !== true ) : ?>
						<li><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_snews'] ); ?>"><i class="fas fa-feather-alt"></i><?php echo esc_html_e( 'News', 'king' ); ?></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'disable_video', 'options' ) !== true ) : ?>
						<li><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_svideo'] ); ?>"><i class="fas fa-play"></i><?php echo esc_html_e( 'Video', 'king' ); ?></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'disable_image', 'options' ) !== true ) : ?>
						<li><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_simage'] ); ?>"><i class="fas fa-image"></i><?php echo esc_html_e( 'Image', 'king' ); ?></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'disable_music', 'options' ) !== true ) : ?>
						<li><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_saudio'] ); ?>"><i class="fas fa-headphones-alt"></i><?php echo esc_html_e( 'Music', 'king' ); ?></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'disable_list', 'options' ) !== true ) : ?>
						<li><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_snews'] . '/list' ); ?>"><i class="fas fa-equals"></i><?php echo esc_html_e( 'List', 'king' ); ?></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'disable_polls', 'options' ) !== true ) : ?>
						<li><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_snews'] . '/poll' ); ?>"><i class="fas fa-vote-yea"></i><?php echo esc_html_e( 'Poll', 'king' ); ?></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'disable_trivia', 'options' ) !== true ) : ?>
						<li><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_snews'] . '/trivia' ); ?>"><i class="fab fa-delicious"></i><?php echo esc_html_e( 'Trivia Quiz', 'king' ); ?></a></li>
					<?php endif; ?>
					<?php if ( ! get_field( 'disable_link', 'options' ) ) : ?>
						<li><a data-toggle="modal" data-dismiss="modal" data-target="#addlink" href="#" class="header-login-buttons"><i class="fa-brands fa-hubspot"></i><?php echo esc_html_e( 'Link', 'king' ); ?></a></li>
					<?php endif; ?>
					<?php if ( get_field( 'add_create_story_in_submit', 'options' ) ) : ?>
						<li><a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_snews'] . '/story' ); ?>"><i class="fas fa-portrait"></i><?php echo esc_html_e( 'Story', 'king' ); ?></a></li>
					<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>
	<?php endif; ?>
<?php endif; ?>
