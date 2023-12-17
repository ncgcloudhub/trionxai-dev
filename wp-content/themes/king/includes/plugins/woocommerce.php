<?php
/**
 * Theme options.
 *
 * @package King.
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', 'king_woocommerce_support' );
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar',             'woocommerce_get_sidebar',                  10 );

add_action( 'woocommerce_before_main_content', 'king_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'king_wrapper_end', 10 );
add_filter( 'theme_page_templates', 'king_store_shop_page_templates', 9, 3 );
add_filter( 'theme_page_templates', 'king_shop_home_page_templates', 11, 3 );

add_action( 'king_shop_header_markup', 'woocommerce_catalog_ordering', 10 );
add_action( 'king_shop_header_markup', 'woocommerce_result_count', 10 );
add_action( 'king_shop_header_markup', 'woocommerce_breadcrumb', 10 );

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering',30 );
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_filter( 'woocommerce_breadcrumb_defaults', 'king_change_breadcrumb_delimiter' );
/**
 * Add angle to breadcrumb
 * @param  [type] $defaults [description]
 * @return [type]           [description]
 */
function king_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = ' <i class="fa fa-angle-right"></i> ';
	return $defaults;
}
/**
 * Declare WooCommerce support
 */
function king_woocommerce_support() {
	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
/**
 * King wrapper start
 *
 * @return [type] [description]
 */
function king_wrapper_start() {
	echo '<div id="primary" class="content-area king-shop lr-padding">';
	if ( is_shop() ) {
		if ( king_woocommerce_page_has_sidebar() ) {
			echo '<main id="main" class="site-main">';
		} else {
			echo '<main id="main" class="site-main full-width">';
		}
	}
	if ( is_product() ) {
		if ( is_active_sidebar( 'sidebar-woo-single' ) ) {
			echo '<main id="main" class="site-main">';
		} else {
			echo '<main id="main" class="site-main full-single-width">';
		}
	}
	do_action( 'king_shop_header_markup' );
}
/**
 * King wrapper end
 * @return [type] [description]
 */
function king_wrapper_end() {
	echo '</main><!-- #main -->';
	if ( is_shop() ) {
		if ( king_woocommerce_page_has_sidebar() ) {
			echo '<aside id="secondary" class="widget-area">';
			echo '<div class="woo-sidebar">';
				dynamic_sidebar( 'sidebar-woo' );
			echo '</div>';
			echo '</aside>';
		}
	}
	if ( is_product() && is_active_sidebar( 'sidebar-woo-single' ) ) {
		if ( king_woocommerce_page_has_sidebar() ) {
			echo '<aside id="secondary" class="widget-area">';
			echo '<div class="woo-product-sidebar">';
				dynamic_sidebar( 'sidebar-woo-single' );
			echo '</div>';
			echo '</aside>';
		}
	}
	echo '</div><!-- #primary -->';
}

/**
 * Add theme woocommerce support
 *
 * @return [type] [description]
 */
function woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'woocommerce_support' );
/**
 * Manage product list columns
 *
 * @param array $columns    List of columns.
 *
 * @return array
 */
function king_wc_product_list_custom_columns( $columns ) {
	if ( isset( $columns['featured_image'] ) ) {
		unset( $columns['featured_image'] );
	}

	return $columns;
}

/**
 * [king_store_shop_page_templates description]
 * @param  [type] $page_templates [description]
 * @param  [type] $class          [description]
 * @param  [type] $post           [description]
 * @return [type]                 [description]
 */
function king_store_shop_page_templates( $page_templates, $class, $post ) {
	$shop_page_id = wc_get_page_id( 'shop' );

	if ( $post && absint( $shop_page_id ) === absint( $post->ID ) ) {
		global $king_shop_page_templates;

		$king_shop_page_templates = $page_templates;
	}

	return $page_templates;
}

/**
 * King Shop Home page template
 *
 * @param  [type] $page_templates [description]
 * @param  [type] $class          [description]
 * @param  [type] $post           [description]
 * @return [type]                 [description]
 */
function king_shop_home_page_templates( $page_templates, $class, $post ) {
	$shop_page_id = wc_get_page_id( 'shop' );

	if ( $post && absint( $shop_page_id ) === absint( $post->ID ) ) {
		global $king_shop_page_templates;

		if ( empty( $page_templates ) && ! empty( $king_shop_page_templates ) ) {
			$page_templates = $king_shop_page_templates;
		}
	}

	return $page_templates;
}

/**
 * King woocommerce sidebar
 *
 * @return [type] [description]
 */
function king_woocommerce_page_has_sidebar() {
	$result = true;

	$shop_page_id = wc_get_page_id( 'shop' );
	$template = get_post_meta( $shop_page_id, '_wp_page_template', true );

	if ( 'page-no-sidebar.php' === $template ) {
		$result = false;
	}

	return $result;
}

/**
 * Woocommerce sidebar
 *
 * @return [type] [description]
 */
function king_woocommerce_sidebar() {
	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Shop Sidebar', 'king' ),
		'id'            => 'sidebar-woo',
		'description'   => esc_html__( 'Add widgets here.', 'king' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
	register_sidebar( array(
		'name'          => esc_html__( 'WooCommerce Single Product Sidebar', 'king' ),
		'id'            => 'sidebar-woo-single',
		'description'   => esc_html__( 'Add widgets here.', 'king' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'king_woocommerce_sidebar' );