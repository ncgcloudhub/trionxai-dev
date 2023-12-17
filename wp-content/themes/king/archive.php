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
<?php
// get the current taxonomy term.
$terms   = get_queried_object();
$color   = get_field( 'category_colors', $terms );
$catlogo = get_field( 'category_logo', $terms );
$thumb   = is_array($catlogo) ? $catlogo['sizes']['thumbnail'] : '';
$bgimage = get_field( 'category_background_image', $terms );
if ( $bgimage ) {
	$bgimage = 'background-image:url(' . $bgimage['url'] . '); min-height:250px;';
}
?>
<?php if ( $color || $bgimage || $catlogo ) : ?>
	<header class="page-top-header" style="background-color:<?php echo esc_attr( $color ); ?>; <?php echo esc_attr( $bgimage ); ?>" >
		<?php if ( $catlogo ) : ?>
			<img src="<?php echo esc_attr( $thumb ); ?>" class="cat-logo">
		<?php endif; ?>
		<?php else : ?>
			<header class="page-top-header" >
			<?php endif; ?>
			<?php
			if ( is_post_type_archive() ) {
				post_type_archive_title( '<h1 class="page-title">', '</h1>' );
			} else {
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			}
			?>

			<?php
			if ( isset( $terms->taxonomy ) && ( ( $terms->taxonomy === 'post_tag' && get_field( 'enable_tag_follow', 'options' ) ) || ( $terms->taxonomy === 'category' && get_field( 'enable_category_follow', 'options' ) ) && is_user_logged_in() ) ) :
				$termid     = get_queried_object_id();
				$this_user  = wp_get_current_user();
				$userid     = $this_user->ID;
				$post_likes = get_user_meta( $userid, 'king_follow_tags', true );
				$followed   = '';
			if ( is_array( $post_likes ) && in_array( $termid, $post_likes ) ) {
				$followed = 'followed';
			}
			?>
			<div class="tagfollow">
				<a class="<?php echo esc_attr( $followed ); ?>" href="<?php echo esc_attr( $termid ); ?>">
					<i class="fas fa-plus fa-lg"></i>
					<span class="tag-follow"><?php echo esc_html_e( 'follow', 'king' ); ?></span>
					<span class="tag-unfollow"><?php echo esc_html_e( 'unfollow', 'king' ); ?></span>
				</a>
				<div class="tagloader"></div>
			</div>
		<?php endif; ?>
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
	// Sidebar templates.
	$htemplate = get_field( 'archive_template', 'options' );
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
						?>

						<?php
						/* Start the Loop */
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
