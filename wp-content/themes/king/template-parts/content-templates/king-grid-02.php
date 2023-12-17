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
	<?php get_template_part( 'template-parts/content-templates/content-parts/content-right-top' ); ?>
	<div class="article-meta">
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-head' ); ?>
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-meta' ); ?>
	</div><!-- .article-meta -->
</article><!--#post-##-->
</li>
