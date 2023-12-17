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
$vclass = '';
if ( isset( $args['class'] ) ) {
	$vclass = ' simple-video';
}

?>
<div class="king-simple-post<?php echo esc_attr( $vclass ); ?>">
	<?php if ( get_field( 'nsfw_post' ) && ! is_user_logged_in() ) : ?>
	<div class="nsfw-post-simple">
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_login'] ); ?>">
			<i class="fa fa-paw fa-3x"></i>
			<div><h1><?php echo esc_html_e( 'Not Safe For Work', 'king' ); ?></h1></div>
			<span><?php echo esc_html_e( 'Click to view this post.', 'king' ); ?></span>
		</a>    
	</div>
	<?php else : ?> 
		<a href="<?php the_permalink(); ?>" class="simple-post-thumb">
			<?php
			if ( has_post_thumbnail() ) :
				$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'medium' );
				?>
				<div class="simple-post-image">
					<img width="<?php echo esc_attr( $thumb[1] ); ?>" height="<?php echo esc_attr( $thumb[2] ); ?>" data-king-img-src="<?php echo esc_url( $thumb[0] ); ?>" class="king-lazy"/>
				</div>
				<?php else : ?>
					<div class="simple-post-image simple-nothumb">
				</div>
				<?php endif; ?> 
		</a>
	<?php endif; ?> 			
	<header class="simple-post-header">
		<?php the_title( sprintf( '<span class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></span>' ); ?>

	</header><!-- .entry-header -->
	<div class="entry-meta">
		<div>
		<span class="post-likes"><i class="fa fa-thumbs-up" aria-hidden="true"></i>
			<?php
			$likes = king_vote_count( get_the_ID(), 'p' );
			echo esc_attr( $likes['sl'] );
			?>
		</span>
		<span class="post-views"><i class="fa fa-eye" aria-hidden="true"></i><?php echo esc_attr( king_postviews( get_the_ID(), 'display' ) ); ?></span>
		<span class="post-comments"><i class="fa fa-comment" aria-hidden="true"></i><?php comments_number( ' 0 ', ' 1 ', ' % ' ); ?></span>
		</div>
		<span class="post-time"><i class="far fa-clock"></i><?php the_time( 'F j, Y' ); ?></span>
	</div><!-- .entry-meta -->	
</div><!-- #post-## -->
