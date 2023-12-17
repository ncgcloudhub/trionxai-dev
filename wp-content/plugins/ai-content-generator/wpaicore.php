<?php
/*
 * Plugin Name:        Sage AI Content Writer
 * Description:       AI powered content generator for WordPress.
 * Plugin URI:       https://wpaicontent.com
 * Version:           2.2.5
 * Author:            Sage AI
 * Author URI:       https://wpaicontent.com
 * License:           GPL-2.0+
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WP_SAGE_AI_DIR' ) ) {
	define( 'WP_SAGE_AI_DIR', WP_PLUGIN_DIR . '/' . basename( __DIR__ ) );
}

if ( ! defined( 'WP_SAGE_AI_URL' ) ) {
	define( 'WP_SAGE_AI_URL', plugins_url() . '/' . basename( __DIR__ ) );
}



require ABSPATH . 'wp-load.php';



// lite
// ai-content-generator for light
// wpaicore.php

// pro
// ai-content-generator-pro
// ai-content-generator-pro.php

if ( class_exists( 'Sage_Ai_Writer' ) ) {


	if ( ! function_exists( 'sage_ai_pro_just_activated' ) ) {
		/**
		 * When we activate a Pro version, we need to do additional operations:
		 * 1) deactivate a Lite version;
		 * 2) register option which help to run all activation process for Pro version (custom tables creation, etc.).
		 *
		 * @since 1.6.2
		 */
		function sage_ai_pro_just_activated() {

			sage_ai_deactivate();
		}
	}

	add_action( 'activate_ai-content-generator-pro/ai-content-generator-pro.php', 'sage_ai_pro_just_activated' );

	if ( ! function_exists( 'sage_ai_lite_just_activated' ) ) {
		/**
		 * Store temporarily that the Lite version of the plugin was activated.
		 * This is needed because WP does a redirect after activation and
		 * we need to preserve this state to know whether user activated Lite or not.
		 *
		 * @since 1.5.8
		 */
		function sage_ai_lite_just_activated() {

			set_transient( 'sage_ai_lite_just_activated', true );
		}
	}

	add_action( 'activate_ai-content-generator/wpaicore.php', 'sage_ai_lite_just_activated' );

	if ( ! function_exists( 'sage_ai_lite_just_deactivated' ) ) {
		/**
		 * Store temporarily that Lite plugin was deactivated.
		 * Convert temporary "activated" value to a global variable,
		 * so it is available through the request. Remove from the storage.
		 *
		 * @since 1.5.8
		 */
		function sage_ai_lite_just_deactivated() {

			global $sage_ai_lite_just_activated, $sage_ai_lite_just_deactivated;

			$sage_ai_lite_just_activated   = (bool) get_transient( 'sage_ai_lite_just_activated' );
			$sage_ai_lite_just_deactivated = true;

			delete_transient( 'sage_ai_lite_just_activated' );
		}
	}
	add_action( 'deactivate_ai-content-generator/wpaicore.php', 'sage_ai_lite_just_deactivated' );

	if ( ! function_exists( 'sage_ai_deactivate' ) ) {
		/**
		 * Deactivate Lite if sage_ai already activated.
		 *
		 * @since 1.0.0
		 */
		function sage_ai_deactivate() {

			$plugin = 'ai-content-generator/wpaicore.php';

			deactivate_plugins( $plugin );
		}
	}

	add_action( 'admin_init', 'sage_ai_deactivate' );


	if ( ! function_exists( 'sage_ai_lite_notice' ) ) {
		/**
		 * Display the notice after deactivation when Pro is still active
		 * and user wanted to activate the Lite version of the plugin.
		 *
		 * @since 1.0.0
		 */
		function sage_ai_lite_notice() {

			global $sage_ai_lite_just_activated, $sage_ai_lite_just_deactivated;

			if (
				empty( $sage_ai_lite_just_activated ) ||
				empty( $sage_ai_lite_just_deactivated )
			) {
				return;
			}

			// Currently tried to activate Lite with Pro still active, so display the message.
			printf(
				'<div class="notice sage_ai-notice notice-warning sage_ai-license-notice" id="sage_ai-notice-pro-active">
					<h3 style="margin: .75em 0 0 0;">
						<img src="%1$s" style="vertical-align: text-top; width: 20px; margin-right: 7px;">%2$s
					</h3>
					<p>%3$s</p>
				</div>',
				esc_url( WP_SAGE_AI_URL . '/assets/img/exclamation-triangle.svg' ),
				esc_html__( 'Heads up!', 'sage_ai-lite' ),
				esc_html__( 'Your site already has Sage AI Pro activated. If you want to switch to Sage AI Lite, please first go to Plugins → Installed Plugins and deactivate Sage AI Pro. Then, you can activate Sage AI Lite.', 'sage_ai-lite' )
			);

			if ( isset( $_GET['activate'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
				unset( $_GET['activate'] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			}

			unset( $sage_ai_lite_just_activated, $sage_ai_lite_just_deactivated );
		}
	}
	add_action( 'admin_notices', 'sage_ai_lite_notice' );

	// Do not process the plugin code further.
	return;
} else {

	class Sage_Ai_Writer {

		function __construct() {

			add_action( 'plugins_loaded', array( $this, 'ai_content_writer_edit_include_files' ), 20 );
		}

		function ai_content_writer_edit_include_files() {

			require_once WP_SAGE_AI_DIR . '/inc/fetch/callOpenAI.php';
			if ( is_admin() ) {
				require_once WP_SAGE_AI_DIR . '/inc/log/log.php';
				require_once WP_SAGE_AI_DIR . '/inc/admin/class-wp-ai-core-tinymce-button.php';
				require_once WP_SAGE_AI_DIR . '/inc/admin/upload-to-media-library.php';
				require_once WP_SAGE_AI_DIR . '/inc/editor/classic-editor.php';
				require_once WP_SAGE_AI_DIR . '/inc/queue/generate-post-structure.php';
				require_once WP_SAGE_AI_DIR . '/inc/fetch/callDallE.php';
				require_once WP_SAGE_AI_DIR . '/inc/fetch/callPixabay.php';
				require_once WP_SAGE_AI_DIR . '/inc/admin/bulk-pages-generator.php';
				require_once WP_SAGE_AI_DIR . '/inc/admin/upload-to-media-library.php';
				require_once WP_SAGE_AI_DIR . '/inc/admin/class-wp-ai-core-gen-admin-settings.php';

				require_once WP_SAGE_AI_DIR . '/inc/admin/class-wp-ai-core-gen-admin-settings.php';
				require_once WP_SAGE_AI_DIR . '/inc/admin/class-sage-ai-writer-review.php';
			}

			// require_once WP_SAGE_AI_DIR . '/inc/addon/sage_ai-settings.php';
		}
	}

	new Sage_Ai_Writer();


}
