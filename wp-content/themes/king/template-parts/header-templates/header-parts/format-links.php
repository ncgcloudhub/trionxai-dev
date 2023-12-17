<?php
/**
 * The header part - left menu.
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

<?php
$hnav = get_field( 'king_header_nav', 'options' );
if ( $hnav && in_array( 'news_link', $hnav, true ) ) :
	?>
	<a href="<?php echo esc_url( get_post_format_link( 'quote' ) ); ?>" class="nav-news">
		<i class="far fa-circle"></i><?php echo esc_html_e( 'News', 'king' ); ?>
	</a>
<?php endif; ?>
<?php if ( $hnav && in_array( 'videos_link', $hnav, true ) ) : ?>
	<a href="<?php echo esc_url( get_post_format_link( 'video' ) ); ?>" class="nav-video">
		<i class="far fa-circle"></i><?php echo esc_html_e( 'Video', 'king' ); ?>
	</a>
<?php endif; ?>
<?php if ( $hnav && in_array( 'images_link', $hnav, true ) ) : ?>
	<a href="<?php echo esc_url( get_post_format_link( 'image' ) ); ?>" class="nav-image">
		<i class="far fa-circle"></i><?php echo esc_html_e( 'Image', 'king' ); ?>
	</a>
<?php endif; ?>
<?php if ( $hnav && in_array( 'musics_link', $hnav, true ) ) : ?>
	<a href="<?php echo esc_url( get_post_format_link( 'audio' ) ); ?>" class="nav-music">
		<i class="far fa-circle"></i><?php echo esc_html_e( 'Music', 'king' ); ?>
	</a>
<?php endif; ?>
<?php if ( $hnav && in_array( 'lists_link', $hnav, true ) ) : ?>
	<a href="<?php echo esc_url( get_post_type_archive_link( 'list' ) ); ?>" class="nav-list">
		<i class="far fa-circle"></i><?php echo esc_html_e( 'List', 'king' ); ?>
	</a>
<?php endif; ?>
<?php if ( $hnav && in_array( 'polls_link', $hnav, true ) ) : ?>
	<a href="<?php echo esc_url( get_post_type_archive_link( 'poll' ) ); ?>" class="nav-poll">
		<i class="far fa-circle"></i><?php echo esc_html_e( 'Poll', 'king' ); ?>
	</a>
<?php endif; ?>
<?php if ( $hnav && in_array( 'quiz_link', $hnav, true ) ) : ?>
	<a href="<?php echo esc_url( get_post_type_archive_link( 'trivia' ) ); ?>" class="nav-trivia">
		<i class="far fa-circle"></i><?php echo esc_html_e( 'Trivia Quiz', 'king' ); ?>
	</a>
<?php endif; ?>