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
	<?php get_template_part( 'template-parts/content-templates/content-parts/content-thumb' ); ?>
	<div class="article-meta">
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-head' ); ?>
		<div class="entry-09-meta">
			<span class="content-09-post-time"><?php echo esc_html_e( 'by', 'king' ); ?></span>
			<span class="content-09-avatar">
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
			<a class="content-09-user" href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>" ><?php echo esc_attr( $author ); ?></a>
			<span class="content-09-post-time"><?php the_time( 'F j, Y' ); ?></span>
		</div>
	</div><!-- .article-meta -->
	<?php
		if ( ! get_field( 'disable_post_votes', 'options' ) && king_plugin_active( 'ACF' ) ) :
				$down = get_field( 'disable_down_vote_in_posts', 'options' ) ? true : false;
				echo king_vote( get_the_ID(), 'p', $down );
		endif;
		?>
</article><!--#post-##-->
</li>
