<?php
/**
 * The content part - right top.
 *
 * This is a content template part.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="content-right-top">
	<?php echo wp_kses_post( king_post_format() ); ?>
	<span class="content-avatar">
		<?php
		$author    = get_the_author_meta( 'user_nicename' );
		$author_id = $post->post_author;
		if ( get_field( 'author_image', 'user_' . $author_id ) ) {
			$image = get_field( 'author_image', 'user_' . $author_id );
			?>
		<a href="<?php echo esc_url( site_url() . '/' . $GLOBALS['king_account'] . '/' . $author ); ?>">
			<img class="content-author-avatar" src="<?php echo esc_url( $image['sizes']['thumbnail'] ); ?>" />
		</a>	
		<?php } ?>
	</span>
</div>

