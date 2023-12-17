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
	<div class="grid15-top">
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-thumb' ); ?>
		<?php king_entry_cat(); ?>
	</div>
	<?php get_template_part( 'template-parts/content-templates/content-parts/content-right-top' ); ?>
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
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-meta' ); ?>
	</div><!-- .article-meta -->
</article><!--#post-##-->
</li>
