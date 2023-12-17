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
$post_size = get_field( 'post_size' );
?>
<li class="king-post-item <?php echo esc_attr( $post_size ); ?> king-no-hover">
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php get_template_part( 'template-parts/content-templates/content-parts/content-thumb' ); ?>
	<div class="article-meta">
		<header class="entry-header">
			<?php king_entry_cat(); ?>
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
