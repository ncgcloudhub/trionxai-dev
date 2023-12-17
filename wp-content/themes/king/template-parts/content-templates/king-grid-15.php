<?php
/**
 * Post Templates 15.
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
		<?php get_template_part( 'template-parts/content-templates/content-parts/content-thumb-2' ); ?>
		<a href="<?php echo esc_url( the_permalink() ); ?>" class="ajax-popup-link grid15-button"><i class="fa-solid fa-magnifying-glass"></i></a>
		<?php king_entry_cat(); ?>
	</div>
	<?php get_template_part( 'template-parts/content-templates/content-parts/content-ft' ); ?>
	<div class="article-meta">
		<div class="article-meta-head">
			<header class="entry-header">
				<?php
				
				if ( is_single() ) {
					the_title( '<h1 class="entry-title">', '</h1>' );
				} else {
					the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );
				}
				?>
			</header><!-- .entry-header -->
			<div class="entry-09-meta">
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
		</div>
			<?php if ( get_post_status( get_the_ID() ) === 'draft' ) : ?>
				<a href="<?php echo esc_url( add_query_arg( 'term', get_the_ID(), home_url( $GLOBALS['king_updte'] . '/' ) ) ); ?>" class="king-fedit"><i class="fa fa-pencil" aria-hidden="true"></i><?php echo esc_html_e( 'Edit', 'king' ); ?></a>
			<?php endif; ?>
		</div><!-- .article-meta-head -->
	</div><!-- .article-meta -->	
</article><!--#post-##-->
</li>
