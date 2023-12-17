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
	<div class="grid15-top">
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-thumb' ); ?>
		<?php king_entry_cat(); ?>
	</div>

	<?php get_template_part( 'template-parts/content-templates/content-parts/content-meta' ); ?>
	<div class="article-meta">
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-head' ); ?>
		<div class="entry-08-meta">
			<span class="content-08-avatar">
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
			</span>
			<span class="content-08-name">
				<a class="content-08-user" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>" ><?php echo esc_attr( $author ); ?></a>
				<span class="content-08-post-time"><?php the_time( 'F j, Y' ); ?></span>
			</span>

		</div>
	</div><!-- .article-meta -->	
</article><!--#post-##-->
</li>
