<?php
/**
 * The template for displaying the Users page
 *
 * Template Name: users v2
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>
<?php $GLOBALS['hide'] = 'hide'; ?>
<header class="page-top-header users">
	<h1 class="page-title"><i class="fa fa-universal-access fa-lg" aria-hidden="true"></i> <?php esc_html_e( 'Users', 'king' ); ?></h1>
</header><!-- .page-header -->
<?php get_template_part( 'template-parts/king-header-nav' ); ?>

<div id="primary" class="content-area kflex lr-padding">
	<main id="main" class="site-main">
		<div class="king-categories-page">
		<?php
		if ( get_field( 'length_users', 'options' ) ) {
			$number = get_field( 'length_users', 'option' );
		} else {
			$number = '10';
		}
		$paged       = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		$offset      = ( $paged - 1 ) * $number;
		$args        = array(
			'orderby'     => 'post_count',
			'order'       => 'DESC',
			'offset'      => $offset,
			'number'      => $number,
			'count_total' => false,
			'fields'      => 'all',
			'who'         => '',
		);
		$users       = get_users($args);

		$total_users = count(get_users());

		// Array of stdClass objects.
		foreach ( $users as $user ) :
			get_template_part( 'template-parts/pages/user', 'card', $user );
		endforeach;
		?>
<div class="king-pagination">
	<?php
	if ( $total_users > $number ) {

		$pl_args = array(
			'base'      => add_query_arg( 'paged', '%#%' ),
			'format'    => '',
			'total'     => ceil( $total_users / $number ),
			'current'   => max( 1, $paged ),
			'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
			'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
		);
		// for /page/n.
		if ( $GLOBALS['wp_rewrite']->using_permalinks() ) {
			$pl_args['base'] = user_trailingslashit( trailingslashit( get_pagenum_link( 1 ) ) . 'page/%#%/', 'paged' );
		}

		echo paginate_links( $pl_args );
	}
	?>
</div>
</div>
</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
