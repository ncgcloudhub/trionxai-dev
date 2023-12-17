<?php
/**
 * King Theme Customizer.
 *
 * @package king
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	 exit;
}
/**
 * customize.
 *
 * @param      <type>  $wp_customize  The wp customize
 */
function king_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'king_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function king_customize_preview_js() {
	wp_enqueue_script( 'king_customizer', get_template_directory_uri() . '/layouts/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'king_customize_preview_js' );
