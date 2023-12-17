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
<li class="king-post-item">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( 'template-parts/content-templates/content-parts/content-thumb' ); ?>
	<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title">', '</h1>' );
		} else {
			the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
		}
		?>
	</header><!-- .entry-header -->
	<div class="article-meta-04">
		<div class="entry-meta-left">
			<span class="content-04-avatar">
				<?php
				$author    = get_the_author_meta( 'user_nicename' );
				$author_id = $post->post_author;
				if ( get_field( 'author_image', 'user_' . $author_id ) ) :
					$image = get_field( 'author_image', 'user_' . $author_id );
					?>
				<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>">
					<img class="content-author-avatar" src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
				</a>	
				<?php endif; ?>
				<a class="content-04-user" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>" ><?php echo esc_attr( $author ); ?></a>
			</span>
		</div>
		<div class="entry-meta-right">
			<?php get_template_part( 'template-parts/content-templates/content-parts/content-meta' ); ?>
		</div>
	</div><!-- .article-meta -->	
</article><!--#post-##-->
</li>
