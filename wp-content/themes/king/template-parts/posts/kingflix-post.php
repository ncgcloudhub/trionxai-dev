<?php
/**
 * Template part for kingflix page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="kingflix-post">
	<div class="kingflix-post-content">
		<?php
		if ( has_post_thumbnail() ) :
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium_large' ); ?>
			<div class="kingflix-post-img" style="background-image: url('<?php echo esc_url( $thumb['0'] ); ?>')"></div>
			<?php else : ?>
				<span class="kingflix-post-no-thumb"></span>
			<?php endif; ?>     
			<div class="kingflix-post-in">
				<?php
				if ( get_field( 'enable_bookmarks', 'options' ) && is_user_logged_in() ) :
					echo wp_kses_post( king_bookmark_button( get_current_user_id(), get_the_ID(), 'kingflix-button' ) );
			endif;
			?>
			<a href="<?php the_permalink(); ?>" class="ajax-popup-link kingflix-button"><i class="fas fa-angle-down"></i></a>
			<span class="kingflix-post-title" ><a href="<?php the_permalink(); ?>"> <?php the_title(); ?></a> </span>
			<?php king_entry_cat(); ?> 
		</div>
	</div>
</div>