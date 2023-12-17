<?php
/**
 * The header part - headnav.
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
<div class="king-head-nav">
	<ul>
	<?php
	$hnav = get_field( 'king_header_nav', 'options' );
	if ( $hnav && in_array( 'news_link', $hnav, true ) ) :
		?>
		<li>
			<a href="<?php echo esc_url( get_post_format_link( 'quote' ) ); ?>" class="king-head-nav-a nav-news"><i class="far fa-circle"></i><?php echo esc_html_e( 'News', 'king' ); ?></a>
			<?php
			$nmenu = get_field( 'for_news_link', 'option' );
			if ( ! empty( $nmenu['for_news'] ) ) :
				echo wp_kses_post( king_mega_menu( $nmenu, 'quote', $nmenu['mpost_number'], $nmenu['show_in_mega_menu'], 'post', 'f' ) );
			endif;
			?>
		</li>
	<?php endif; ?>
	<?php if ( $hnav && in_array( 'videos_link', $hnav, true ) ) : ?>
		<li>
			<a href="<?php echo esc_url( get_post_format_link( 'video' ) ); ?>" class="king-head-nav-a nav-video"><i class="far fa-circle"></i><?php echo esc_html_e( 'Video', 'king' ); ?></a>
			<?php
			$vmenu = get_field( 'for_video_link', 'option' );
			if ( ! empty( $vmenu['for_video'] ) ) :
				echo wp_kses_post( king_mega_menu( $vmenu, 'video', $vmenu['mpost_number'], $vmenu['show_in_mega_menu'], 'post', 'f' ) );
			endif;
			?>
		</li>
	<?php endif; ?>
	<?php if ( $hnav && in_array( 'images_link', $hnav, true ) ) : ?>
		<li>
			<a href="<?php echo esc_url( get_post_format_link( 'image' ) ); ?>" class="king-head-nav-a nav-image"><i class="far fa-circle"></i><?php echo esc_html_e( 'Image', 'king' ); ?></a>
			<?php
			$imenu = get_field( 'for_image_link', 'option' );
			if ( ! empty( $imenu['for_image'] ) ) :
				echo wp_kses_post( king_mega_menu( $imenu, 'image', $imenu['mpost_number'], $imenu['show_in_mega_menu'], 'post', 'f' ) );
			endif;
			?>
		</li>
	<?php endif; ?>
	<?php if ( $hnav && in_array( 'musics_link', $hnav, true ) ) : ?>
		<li>
			<a href="<?php echo esc_url( get_post_format_link( 'audio' ) ); ?>" class="king-head-nav-a nav-music"><i class="far fa-circle"></i><?php echo esc_html_e( 'Music', 'king' ); ?></a>
			<?php
			$mmenu = get_field( 'for_music_link', 'option' );
			if ( ! empty( $mmenu['for_music'] ) ) :
				echo wp_kses_post( king_mega_menu( $mmenu, 'audio', $mmenu['mpost_number'], $mmenu['show_in_mega_menu'], 'post', 'f' ) );
			endif;
			?>
		</li>
	<?php endif; ?>
	<?php if ( $hnav && in_array( 'lists_link', $hnav, true ) ) : ?>
		<li>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'list' ) ); ?>" class="king-head-nav-a nav-list"><i class="far fa-circle"></i><?php echo esc_html_e( 'List', 'king' ); ?></a>
			<?php
			$mmenu = get_field( 'for_list_link', 'option' );
			if ( ! empty( $mmenu['for_list'] ) ) :
				echo wp_kses_post( king_mega_menu( $mmenu, 'list', $mmenu['mpost_number'], $mmenu['show_in_mega_menu'], 'list' ) );
			endif;
			?>
		</li>
	<?php endif; ?>
	<?php if ( $hnav && in_array( 'polls_link', $hnav, true ) ) : ?>
		<li>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'poll' ) ); ?>" class="king-head-nav-a nav-poll"><i class="far fa-circle"></i><?php echo esc_html_e( 'Poll', 'king' ); ?></a>
			<?php
			$mmenu = get_field( 'for_poll_link', 'option' );
			if ( ! empty( $mmenu['for_poll'] ) ) :
				echo wp_kses_post( king_mega_menu( $mmenu, 'poll', $mmenu['mpost_number'], $mmenu['show_in_mega_menu'], 'poll' ) );
			endif;
			?>
		</li>
	<?php endif; ?>
	<?php if ( $hnav && in_array( 'quiz_link', $hnav, true ) ) : ?>
		<li>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'trivia' ) ); ?>" class="king-head-nav-a nav-trivia"><i class="far fa-circle"></i><?php echo esc_html_e( 'Trivia Quiz', 'king' ); ?></a>
			<?php
			$mmenu = get_field( 'for_trivia_link', 'option' );
			if ( ! empty( $mmenu['for_trivia'] ) ) :
				echo wp_kses_post( king_mega_menu( $mmenu, 'trivia', $mmenu['mpost_number'], $mmenu['show_in_mega_menu'], 'trivia' ) );
			endif;
			?>
		</li>
	<?php endif; ?>
	<?php get_template_part( 'template-parts/header-templates/header-parts/newnav' ); ?>
	<?php
	$hargs = isset( $args['dots'] ) ? $args['dots'] : true;
	if ( ! get_field( 'hide_categories', 'options' ) && $hargs ) :
		$columns = get_field_object( 'header_menu_columns', 'options' );
		?>
		<li class="king-hmenu">
			<span class="king-cat-dots" data-toggle="dropdown" data-target=".king-cat-list" aria-expanded="false" role="button">More</span>
			<div class="king-cat-list <?php echo esc_attr( $columns['value'] ); ?>">
				<?php wp_nav_menu( array( 'theme_location' => 'header-menu' ) ); ?>
			</div>
		</li>
	<?php endif; ?>
</div><!-- .king-head-nav -->