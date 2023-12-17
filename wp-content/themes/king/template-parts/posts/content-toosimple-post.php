<?php
/**
 * Template part for displaying results in profile page.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$thumb = '';
?>
<div class="categories-post">
	<?php if ( get_field( 'nsfw_post' ) && ! is_user_logged_in() ) : ?>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>" class="nsfw-users-post nsfw-cat-post">
			<div class="categories-post-img">
			<i class="fa fa-paw fa-3x"></i>
			<div><h1><?php echo esc_html_e( 'Not Safe For Work', 'king' ); ?></h1></div>
			<span><?php echo esc_html_e( 'Click to view this post.', 'king' ); ?></span>
		</div>
			<div class="categories-post-title" ><?php the_title(); ?></div> 
		</a>
	<?php else : ?>
		<a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail() ) :
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				?>
				<div class="categories-post-img">
					<div class="king-box-bg" data-king-img-src="<?php echo esc_attr( $thumb[0] ); ?>"></div>
				</div>
				<?php else : ?>
					<span class="categories-post-no-thumb"></span>
				<?php endif; ?>
				<div class="categories-post-title" ><?php the_title(); ?></div>
			</a> 
		<?php endif; ?>     
	</div> 
