<?php
/**
 * The content part - thumb.
 *
 * This is a content template part.
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

<div class="post-featured-trending">
		<?php if ( has_post_format( 'link' ) && get_field( 'enable_affiliate' ) && get_field( 'sale_price' ) ) :  ?>
			<a href="<?php echo esc_url( get_field( 'ad_link' ) ); ?>" class="king-checkit king-ft-link" target="_blank" data-toggle="tooltip" data-placement="right" title="<?php echo esc_html_e( 'Check it out', 'king' ); ?>"><i class="fa-solid fa-tags"></i> <s><?php echo ( !empty(get_field( 'regular_price' )) ? esc_html_e( '$', 'king' ) . get_field( 'regular_price' ) : '' ); ?></s> <b><?php echo esc_html_e( '$', 'king' ); ?><?php the_field( 'sale_price' ); ?></b></a>
		<?php endif; ?>
	<span>
	<?php if ( get_field( 'featured-post' ) ) : ?>
		<div class="featured" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'featured', 'king' ); ?>">
			<i class="fa fa-rocket fa-lg" aria-hidden="true"></i>
		</div>
	<?php endif; ?>
	<?php if ( get_field( 'keep_trending' ) ) : ?>
		<div class="trending" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'trending', 'king' ); ?>">
			<i class="fa fa-bolt fa-lg" aria-hidden="true"></i>
		</div>
	<?php endif; ?>
	<?php if ( is_sticky() ) : ?>
		<div class="trending sticky" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'sticky', 'king' ); ?>">
			<i class="fa fa-paperclip fa-lg" aria-hidden="true"></i>
		</div>
	<?php endif; ?>
	<div class="king-postext king-ext-<?php echo esc_attr( get_the_ID() ); ?>">
		<?php
		if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
			echo wp_kses_post( king_bookmark_button( get_current_user_id(), get_the_ID() ) );
		endif;
		?>
		<?php if ( get_field( 'enable_collections', 'options' ) && is_user_logged_in() ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'term', 'bucketings', the_permalink() ) ); ?>" class="king-ft-link bucket-button" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'Add to Collection', 'king' ); ?>"><i class="fa-solid fa-calendar-plus"></i></a>
		<?php endif; ?>
		<a href="<?php echo esc_url( the_permalink() ); ?>" class="king-ft-link king-share-link" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html_e( 'Share', 'king' ); ?>"><i class="fa-solid fa-arrow-up-from-bracket"></i></a>
	</div>
</span>
</div>

