<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<?php
$author_id = $post->post_author;
if ( 'bucketings' === get_query_var( 'term' ) ) {
	get_template_part( 'template-parts/pages/create-collection' );
} elseif ( function_exists( 'is_woocommerce' ) && get_field( 'enable_membership', 'options' ) && king_check_membership( get_the_ID() ) === false && ! is_super_admin() && esc_attr( $author_id ) !== esc_attr( get_current_user_id() ) ) {
	get_template_part( 'template-parts/post-templates/single-pay' );
} elseif ( get_field( 'enable_user_groups', 'options' ) && ! king_groups_permissions( 'groups_view_posts' ) && ! is_super_admin() ) {
	get_template_part( 'template-parts/post-templates/single-none' );
} elseif ( post_password_required() ) {
	get_template_part( 'template-parts/post-templates/single-pass' );
} elseif ( has_post_format( 'video' ) ) {
	get_template_part( 'template-parts/single', 'video' );
} elseif ( has_post_format( 'audio' ) ) {
	get_template_part( 'template-parts/single', 'music' );
} elseif ( has_post_format( 'image' ) ) {
	get_template_part( 'template-parts/single', 'image' );
} elseif ( has_post_format( 'link' ) ) {
	get_template_part( 'template-parts/single', 'link' );
} elseif ( 'poll' === get_post_type() ) {
	get_template_part( 'template-parts/single', 'poll' );
} elseif ( 'trivia' === get_post_type() ) {
	get_template_part( 'template-parts/single', 'trivia' );
} elseif ( 'stories' === get_post_type() ) {
	get_template_part( 'template-parts/single', 'story' );
} else {
	get_template_part( 'template-parts/single', 'post' );
}

king_postviews( get_the_ID(), 'count' );

?>
<?php if ( get_post_status( get_the_ID() ) === 'pending' ) : ?>
	<div class="king-pending"><?php esc_html_e( 'This post will be checked and approved shortly.', 'king' ); ?></div>
<?php endif; ?>
