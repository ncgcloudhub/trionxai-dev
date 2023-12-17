<?php
/**
 * The template for displaying quote posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header(); ?>
<header class="page-top-header">
	<h1 class="page-title"><?php echo esc_html_e( 'News', 'king' ); ?></h1>
	<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>	
<?php
if ( get_field( 'pagination_type', 'options' ) ) {
	$pagination_id = get_field( 'pagination_type', 'options' );
} else {
	$pagination_id = 'king-pagination-01';
}
if ( get_field( 'select_default_display_option', 'options' ) ) {
	$display_option = get_field( 'select_default_display_option', 'options' );
} else {
	$display_option = 'king-grid-01';
}
$htemplate = get_field( 'news_page_template', 'options' );
if ( $htemplate ) {
	$sidebar = $htemplate['sidebar'];
	if ( $htemplate['column'] ) {
		$column = ' ' . $htemplate['column'];
	} else {
		$column = '';
	}
	$display_option = ! empty($htemplate['post_layout']) ? $htemplate['post_layout'] : $display_option;
} else {
	$sidebar = 'king-sidebar-01';
	$column  = '';
}
?>
<div id="primary" class="content-area lr-padding <?php echo esc_attr( $display_option ); ?>">
	<div id="<?php echo esc_attr( $pagination_id ); ?>" class="site-main-top kflex <?php echo esc_attr( $sidebar . $column ); ?>">
		<?php
		if ( ( 'king-sidebar-02' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) ) {
			get_sidebar( '2' );
		}
		?>
		<main id="main" class="site-main">
			<ul class="king-posts">
				<li class="grid-sizer"></li>
				<?php
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						get_template_part( 'template-parts/content-templates/' . $display_option );
					endwhile;
					get_template_part( 'template-parts/king-pagination' );
				else :
					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</ul>
		</main><!-- #main -->
		<?php
		if ( ( 'king-sidebar-01' === $sidebar ) || ( 'king-sidebar-03' === $sidebar ) || ( 'king-sidebar-05' === $sidebar ) ) {
			get_sidebar();
			if ( ( 'king-sidebar-05' === $sidebar ) ) {
				get_sidebar( '2' );
			}
		}
		?>
	</div>
</div><!-- #primary -->

<?php get_footer(); ?>
