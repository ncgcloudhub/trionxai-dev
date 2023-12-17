<?php
/**
 * Single Video.
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

	$videotemplate  = get_field_object( 'video_posts_templates', 'options' );
	$videotemplate2 = get_field_object( 'video_template' );

	if ( ! empty( $videotemplate2['value'] ) ) {
		get_template_part( 'template-parts/post-templates/single', $videotemplate2['value'] );
	} elseif ( ! empty( $videotemplate['value'] ) ) {
		get_template_part( 'template-parts/post-templates/single', $videotemplate['value'] );
	} else {
		get_template_part( 'template-parts/post-templates/single', 'video-template' );
	}
	get_template_part( 'template-parts/post-templates/single-parts/modal-share' );

?>


