<?php
/**
 * Single Post.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header(); ?>
<?php
	$template  = get_field_object( 'single_post_templates', 'options' );
	$template2 = get_field_object( 'post_template' );

	if ( ! empty( $template2['value'] ) ) {
		get_template_part( 'template-parts/post-templates/single', 'post-' . $template2['value'] );
	} elseif ( ! empty( $template['value'] ) ) {
		get_template_part( 'template-parts/post-templates/single', 'post-' . $template['value'] );
	} else {
		get_template_part( 'template-parts/post-templates/single', 'post-template' );
	}
	get_template_part( 'template-parts/post-templates/single-parts/modal-share' );
?>


