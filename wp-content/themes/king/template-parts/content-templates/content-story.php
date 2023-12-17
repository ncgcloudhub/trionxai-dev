<?php
/**
 * Post Templates 10.
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
<li class="king-post-item">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php the_permalink(); ?>" class="entry-image-link story-popup-one">
			<?php
			if ( has_post_thumbnail() ) :
				$attachment_id = get_post_thumbnail_id( get_the_ID() );
				$img           = wp_get_attachment_image_src( $attachment_id, 'medium_large' );
				?>
				<div class="entry-image" style="height:<?php echo esc_attr( $img[2] . 'px;' ); ?>">
					<div class="king-box-bg" data-king-img-src="<?php echo esc_url( $img[0] ); ?>"></div>
				</div>
			<?php else : ?>
				<span class="entry-no-thumb"></span>
			<?php endif; ?>			
		</a>
		<span class="king-stories-avatar">
			<?php
			$author_id = $post->post_author;
			$author    = get_the_author_meta( 'user_nicename', $author_id );

			if ( get_field( 'author_image', 'user_' . $author_id ) ) {
				$image = get_field( 'author_image', 'user_' . $author_id );
				?>
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>">
					<img class="content-author-avatar" src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
				</a>
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>">
					<?php echo esc_attr( $author ); ?>
				</a>
			<?php } ?>
		</span>
		<?php
		if ( get_current_user_id() == $author_id ) :
			if ( metadata_exists( 'post', get_the_ID(), 'king_highlights' ) ) {
				$class = ' added';
			} else {
				$class = '';
			}
			?>
			<div class="king-highlight<?php echo esc_attr( $class ); ?>" data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_html__( 'Highlight', 'king' ); ?>" data-storyid="<?php echo esc_attr( get_the_ID() ); ?>" ><i class="fas fa-star"></i></div>
		<?php endif; ?>
		<div class="article-meta">
			<header class="entry-header">
				<?php
				if ( is_single() ) {
					the_title( '<h1 class="entry-title">', '</h1>' );
				} else {
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				}
				?>
			</header><!-- .entry-header -->
			<div class="content-10-time"><?php the_time( 'F j, Y' ); ?></div>
		</div><!-- .article-meta -->	
	</article><!--#post-##-->
</li>
