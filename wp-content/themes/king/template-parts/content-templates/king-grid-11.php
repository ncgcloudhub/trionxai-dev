<?php
/**
 * Post Templates 01.
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
<li class="king-post-item king-no-hover">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-thumb' ); ?>

		<div class="article-meta-11">
			<div class="meta-11-left">
				<span class="content-11-avatar">
					<?php
					$author    = get_the_author_meta( 'user_nicename' );
					$author_id = $post->post_author;
					if ( get_field( 'author_image', 'user_' . $author_id ) ) :
						$image = get_field( 'author_image', 'user_' . $author_id );
						?>
						<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>">
							<img class="content-author-avatar" src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>">
							<span class="content-author-noavatar"></span>
						</a>
					<?php endif; ?>

				</span>
			</div>
			<div class="meta-11-right">
				<header class="entry-header">
					<?php
					if ( is_single() ) {
						the_title( '<h1 class="entry-title">', '</h1>' );
					} else {
						the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
					}
					?>
				</header><!-- .entry-header -->
				<a class="content-11-user" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>" ><?php echo esc_attr( $author ); ?></a>
				<span class="content-11-post-views"><?php echo esc_attr( king_postviews( get_the_ID(), 'display' ) ); ?> <?php echo esc_html_e( 'views', 'king' ); ?> • <?php echo esc_attr( sprintf( human_time_diff( get_the_date( 'U' ), current_time( 'timestamp' ) ) ) ) . esc_html__( ' ago', 'king' ); ?></span>
			</div>
		</div><!-- .article-meta -->	
	</article><!--#post-##-->
</li>
