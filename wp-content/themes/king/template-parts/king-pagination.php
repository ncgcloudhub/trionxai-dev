<?php
/**
 * Page Navigation.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php if ( get_field( 'pagination_type', 'options' ) === 'king-pagination-02' ) : ?>
	<?php
		global $wp_query;
		$posts_per_page = absint( get_query_var( 'posts_per_page' ) );
		$pagess         = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
		$found_posts    = absint( $wp_query->found_posts );
		$max_num_pages  = ceil( $found_posts / $posts_per_page );
	?>
<div class="king-pagination">
	<?php
	echo paginate_links( array(
		'format'    => 'page/%#%',
		'current'   => $pagess,
		'total'     => $max_num_pages,
		'prev_next' => true,
		'prev_text' => '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
		'next_text' => '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
	));
	?>
</div>
<?php else : ?>
	<?php the_posts_navigation(); ?>
<?php endif; ?>
