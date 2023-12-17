<?php
/**
 * The template for displaying the Badges page
 *
 * Template Name: badges
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<header class="page-top-header badges">
	<h1 class="page-title"><i class="fa fa-id-badge fa-lg" aria-hidden="true"></i> <?php esc_html_e( 'Badges', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main full-width">
<?php if ( get_field( 'enable_user_badges', 'option' ) ) : ?>
	<div class="king-badges-page">
<?php
if ( have_rows( 'king_badges', 'option' ) ) :
	while ( have_rows( 'king_badges', 'option' ) ) :
		the_row();
		$badge_min = get_sub_field( 'badge_min_point' );
		$badge_max = get_sub_field( 'badge_max_point' );
		$badge_title = get_sub_field( 'badge_title' );
		$badge_desc = get_sub_field( 'badge_description' );

		$username[] = trim( str_replace( ' ', '', $badge_title ) );
		if ( get_row_layout() == 'badges_for_points' ) : ?>
			<div class="king-page-badge">
				<div class="king-profile-badge" title="<?php echo esc_attr( $badge_title ); ?>">
					<span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span>
				</div>
				<span class="badge-page-title"><?php echo esc_attr( $badge_title ); ?></span>
				<span class="badge-page-desc"><?php echo esc_attr( $badge_desc ); ?></span>
				<div class="badge-page-mm">
					<span class="badge-page-min"><?php esc_html_e( 'Min', 'king' ); ?><p><?php echo esc_attr( $badge_min ); ?></p><?php esc_html_e( 'Points', 'king' ); ?></span>
					<span class="badge-page-min"><?php esc_html_e( 'Max', 'king' ); ?><p><?php echo esc_attr( $badge_max ); ?></p><?php esc_html_e( 'Points', 'king' ); ?></span>
				</div>
			</div>
		<?php elseif ( get_row_layout() == 'badges_for_followers' ) : ?>
			<div class="king-page-badge">
				<div class="king-profile-badge" title="<?php echo esc_attr( $badge_title ); ?>">
					<span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span>
				</div>
				<span class="badge-page-title"><?php echo esc_attr( $badge_title ); ?></span>
				<span class="badge-page-desc"><?php echo esc_attr( $badge_desc ); ?></span>
				<div class="badge-page-mm">
					<span class="badge-page-min"><?php esc_html_e( 'Min', 'king' ); ?><p><?php echo esc_attr( $badge_min ); ?></p><?php esc_html_e( 'Followers', 'king' ); ?></span>
					<span class="badge-page-min"><?php esc_html_e( 'Max', 'king' ); ?><p><?php echo esc_attr( $badge_max ); ?></p><?php esc_html_e( 'Followers', 'king' ); ?></span>
				</div>
			</div>
		<?php elseif ( get_row_layout() == 'badges_for_posts' ) : ?>
			<div class="king-page-badge">
				<div class="king-profile-badge" title="<?php echo esc_attr( $badge_title ); ?>">
					<span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span>
				</div>
				<span class="badge-page-title"><?php echo esc_attr( $badge_title ); ?></span>
				<span class="badge-page-desc"><?php echo esc_attr( $badge_desc ); ?></span>
				<div class="badge-page-mm">
					<span class="badge-page-min"><?php esc_html_e( 'Min', 'king' ); ?><p><?php echo esc_attr( $badge_min ); ?></p><?php esc_html_e( 'Posts', 'king' ); ?></span>
					<span class="badge-page-min"><?php esc_html_e( 'Max', 'king' ); ?><p><?php echo esc_attr( $badge_max ); ?></p><?php esc_html_e( 'Posts', 'king' ); ?></span>
				</div>
			</div>
		<?php elseif ( get_row_layout() == 'badges_for_comments' ) : ?>
			<div class="king-page-badge">
				<div class="king-profile-badge" title="<?php echo esc_attr( $badge_title ); ?>">
					<span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span>
				</div>
				<span class="badge-page-title"><?php echo esc_attr( $badge_title ); ?></span>
				<span class="badge-page-desc"><?php echo esc_attr( $badge_desc ); ?></span>
				<div class="badge-page-mm">
					<span class="badge-page-min"><?php esc_html_e( 'Min', 'king' ); ?><p><?php echo esc_attr( $badge_min ); ?></p><?php esc_html_e( 'Comments', 'king' ); ?></span>
					<span class="badge-page-min"><?php esc_html_e( 'Max', 'king' ); ?><p><?php echo esc_attr( $badge_max ); ?></p><?php esc_html_e( 'Comments', 'king' ); ?></span>
				</div>
			</div>
		<?php elseif ( get_row_layout() == 'badges_for_likes' ) : ?>
			<div class="king-page-badge">
				<div class="king-profile-badge" title="<?php echo esc_attr( $badge_title ); ?>">
					<span class="<?php echo esc_attr( str_replace( ' ', '_', $badge_title ) ); ?>"></span>
				</div>
				<span class="badge-page-title"><?php echo esc_attr( $badge_title ); ?></span>
				<span class="badge-page-desc"><?php echo esc_attr( $badge_desc ); ?></span>
				<div class="badge-page-mm">
					<span class="badge-page-min"><?php esc_html_e( 'Min', 'king' ); ?><p><?php echo esc_attr( $badge_min ); ?></p><?php esc_html_e( 'Likes', 'king' ); ?></span>
					<span class="badge-page-min"><?php esc_html_e( 'Max', 'king' ); ?><p><?php echo esc_attr( $badge_max ); ?></p><?php esc_html_e( 'Likes', 'king' ); ?></span>
				</div>
			</div>
		<?php endif; ?>
	<?php endwhile; ?>
<?php endif; ?>
</div>
<?php endif; ?>
		<?php wp_reset_postdata(); ?>
	</main><!-- #main -->
</div><!-- #primary -->
<?php get_footer(); ?>
