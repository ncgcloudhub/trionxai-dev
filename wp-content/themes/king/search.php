<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>

<header class="page-top-header">
	<h1 class="page-title"><?php printf( esc_html__( 'Search Results for: %s', 'king' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
</header><!-- .page-top-header -->
<form role="search" method="get" class="spage-search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<input type="search" class="spage-search-field"
			placeholder="<?php echo esc_html_e( 'Search …', 'king' ); ?>"
			value="<?php echo get_search_query(); ?>" name="s" autocomplete="off"
			title="<?php echo esc_html_e( 'Search for:', 'king' ); ?>" />
			<button type="submit" class="live-header-search-submit"
			value=""><i class="fa fa-search fa-2x" aria-hidden="true"></i> </button>
		</form>
<?php
if ( get_field( 'pagination_type', 'options' ) ) {
	$pagination_id = get_field( 'pagination_type', 'options' );
} else {
	$pagination_id = 'king-pagination-04';
}
if ( get_field( 'select_default_display_option', 'options' ) ) {
	$display_option = get_field( 'select_default_display_option', 'options' );
} else {
	$display_option = 'king-grid-01';
}
$htemplate = get_field( 'search_page_template', 'options' );
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
<?php
		if ( get_field( 'show_user_results_in_search', 'options' ) ) :
			$keyword       = esc_attr( get_search_query() );
			$args          = array(
				'order'          => 'ASC',
				'search'         => '*' . $keyword . '*',
				'search_columns' => array(
					'user_login',
					'user_nicename',
					'display_name',
				),
			);
			$wp_user_query = new WP_User_Query( $args );
			$authors       = $wp_user_query->get_results();


			if ( ! empty( $authors ) ) : ?>
				<div class="usearch-page">
					<?php
					foreach ( $authors as $author ) :
						$author_info = get_userdata( $author->ID ); ?>

						<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author_info->user_login ); ?>">
							<?php if ( get_field( 'author_image', 'user_' . $author->ID ) ) :
								$image = get_field( 'author_image', 'user_' . $author->ID );
								?>
								<img src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" alt="profile" />
								<?php else : ?>
									<span class="usearch-noavatar"></span>
								<?php endif; ?>
								<?php echo esc_attr( $author_info->user_login ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			<?php endif; ?>
<section id="primary" class="content-area lr-padding <?php echo esc_attr( $display_option ); ?>">

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
					if ( have_posts() ) : ?>
						<?php
						/* Start the Loop */
						while ( have_posts() ) : the_post();
							get_template_part( 'template-parts/content-templates/' . $display_option );
						endwhile;
						get_template_part( 'template-parts/king-pagination' );

				else :

					get_template_part( 'template-parts/content', 'none' );

				endif; ?>
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
</section><!-- #primary -->

<?php get_footer(); ?>
