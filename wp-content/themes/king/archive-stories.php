<?php
/**
 * The template for displaying archive pages.
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

<header class="page-top-header" >

			<?php
			if ( is_post_type_archive() ) {
				post_type_archive_title( '<h1 class="page-title">', '</h1>' );
			} else {
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			}
			?>

	</header><!-- .page-header -->
	<?php get_template_part( 'template-parts/king-header-nav' ); ?>
	<?php
	if ( get_field( 'pagination_type', 'options' ) ) {
		$pagination_id = get_field( 'pagination_type', 'options' );
	} else {
		$pagination_id = 'king-pagination-01';
	}
	$htemplate = get_field( 'archive_template', 'options' );
	if ( $htemplate ) {
		$sidebar = $htemplate['sidebar'];
		if ( $htemplate['column'] ) {
			$column = ' ' . $htemplate['column'];
		} else {
			$column = '';
		}
	} else {
		$sidebar = 'king-sidebar-01';
		$column  = '';
	}
	?>
	<div id="primary" class="content-area content-story lr-padding">
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
						?>

						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							get_template_part( 'template-parts/content-templates/content-story' );
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
