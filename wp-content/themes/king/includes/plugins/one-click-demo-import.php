<?php
/**
 * King demo import options.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'King_Demo_Import' ) ) {
	/**
	 * King One click demo import.
	 */
	final class King_Demo_Import {

		/**
		 * Instance.
		 *
		 * @var        <type>
		 */
		private static $instance = null;

		/**
		 * Get instance.
		 *
		 * @return <type> The instance.
		 */
		public static function get_instance() {

			if ( null == static::$instance ) {
				static::$instance = new self();
			}
			return static::$instance;

		}

		/**
		 * Constructs a new instance.
		 */
		private function __construct() {
			$this->filters();

		}

		/**
		 * Filters.
		 */
		private function filters() {
			add_filter( 'pt-ocdi/import_files', array( $this, 'king_demo_data' ), 10 );
			add_action( 'pt-ocdi/after_import', array( $this, 'king_after_import' ), 10, 1 );
			add_filter( 'pt-ocdi/plugin_page_setup', array( $this, 'king_import_page' ), 10, 1 );
			add_filter( 'pt-ocdi/timeout_for_downloading_import_file', array( $this, 'king_timeout' ), 10, 1 );
			add_filter( 'pt-ocdi/confirmation_dialog_options', array( $this, 'king_import_dialog' ), 10, 1 );
			add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

		}

		/**
		 * Configure Demo Content data
		 */
		public function king_demo_data() {

			$king_url     = 'https://kingthemes.net/import';
			$import_note  = '<p>We recommend importing demo data on a clean WordPress installation. </p>';
			$import_note .= '<p><b>We highly recommend to create backup of your site before importing demos!</b></p>';
			$import_note .= '<p>You can take backup of your theme options with this plugin : <a href="https://wordpress.org/plugins/acf-options-importexport/" target="_blank">Plugin</a></p>';
			$import_note .= '<p><b>After importing demo content you will loose your Theme Settings, new demo options will be added.</b></p>';
			return array(
				/* Original */
				array(
					'id'                       => 'main',
					'import_file_name'         => esc_html__( 'Main Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/main/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/main/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'MAIN', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/main',
				),
				/* pin */
				array(
					'id'                       => 'pin',
					'import_file_name'         => esc_html__( 'Pin Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/pin/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/pin/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/pin/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Pin', 'king' ), $import_note ),
					'preview_url'              => 'https://wp.kingthemes.net/pin/',
				),
				/* ai */
				array(
					'id'                       => 'ai',
					'import_file_name'         => esc_html__( 'Ai Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/ai/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/ai/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/ai/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Ai', 'king' ), $import_note ),
					'preview_url'              => 'https://wp.kingthemes.net/ai/',
				),
				/* link */
				array(
					'id'                       => 'link',
					'import_file_name'         => esc_html__( 'Link Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/link/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/link/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/link/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Link', 'king' ), $import_note ),
					'preview_url'              => 'https://wp.kingthemes.net/link/',
				),
				/* insta */
				array(
					'id'                       => 'insta',
					'import_file_name'         => esc_html__( 'Kingstagram 2 Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/insta/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/insta/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/insta/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Kingstagram 2', 'king' ), $import_note ),
					'preview_url'              => 'https://wp.kingthemes.net/insta/',
				),
				/* magazine */
				array(
					'id'                       => 'magazine',
					'import_file_name'         => esc_html__( 'Magazine Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/magazine/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/magazine/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Magazine', 'king' ), $import_note ),
					'preview_url'              => 'https://wp.kingthemes.net/magazine/',
				),
				/* kingbook */
				array(
					'id'                       => 'kingbook',
					'import_file_name'         => esc_html__( 'Kingbook Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/kingbook/kingbook-demo.xml', $king_url ),
					'options'                  => sprintf( '%1$s/kingbook/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/kingbook/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Kingbook', 'king' ), $import_note ),
					'preview_url'              => 'https://wp.kingthemes.net/kingbook/',
				),
				/* Kingflix */
				array(
					'id'                       => 'kingflix',
					'import_file_name'         => esc_html__( 'Kingflix Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/kingflix/kingflix-demo.xml', $king_url ),
					'options'                  => sprintf( '%1$s/kingflix/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/kingflix/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Kingflix', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/kingflix/',
				),
				/* KingTube */
				array(
					'id'                       => 'kingtube',
					'import_file_name'         => esc_html__( 'KingTube Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/kingtube/kingtube-demo.xml', $king_url ),
					'options'                  => sprintf( '%1$s/kingtube/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/kingtube/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'KingTube', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/kingtube/',
				),
				/* Dark */
				array(
					'id'                       => 'dark',
					'import_file_name'         => esc_html__( 'Dark Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/dark/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/dark/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Dark', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/dark',
				),
				/* DesignKing */
				array(
					'id'                       => 'designking',
					'import_file_name'         => esc_html__( 'DesignKing Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/designking/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/designking/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/designking/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'DesignKing', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/designking',
				),
				/* Castle */
				array(
					'id'                       => 'castle',
					'import_file_name'         => esc_html__( 'Castle Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/castle/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/castle/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Castle', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/castle',
				),
				/* Masonry */
				array(
					'id'                       => 'masonry',
					'import_file_name'         => esc_html__( 'Masonry Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/masonry/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/masonry/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Masonry', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/masonry',
				),
				/* Boxed */
				array(
					'id'                       => 'boxed',
					'import_file_name'         => esc_html__( 'Boxed Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/boxed/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/boxed/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Boxed', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/boxed',
				),
				/* Kingstagram */
				array(
					'id'                       => 'kingstagram',
					'import_file_name'         => esc_html__( 'Kingstagram Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/kingstagram/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/kingstagram/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Kingstagram', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/kingstagram',
				),
				/* Crown */
				array(
					'id'                       => 'crown',
					'import_file_name'         => esc_html__( 'Crown Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/crown/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/crown/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/crown/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Crown', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/crown',
				),
				/* Prince */
				array(
					'id'                       => 'prince',
					'import_file_name'         => esc_html__( 'Prince Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/prince/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/prince/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Prince', 'king' ), $import_note ),
					'preview_url'              => 'https://wp.kingthemes.net/prince',
				),
				/* Viking */
				array(
					'id'                       => 'viking',
					'import_file_name'         => esc_html__( 'Viking Demo', 'king' ),
					'import_file_url'          => sprintf( '%1$s/main/king-demo-content.xml', $king_url ),
					'options'                  => sprintf( '%1$s/viking/options.json', $king_url ),
					'import_preview_image_url' => sprintf( '%1$s/viking/screenshot.png', $king_url ),
					'import_notice'            => sprintf( '<strong>%1$s</strong>%2$s', esc_html__( 'Viking', 'king' ), $import_note ),
					'preview_url'              => 'https://wordpress.kingthemes.net/viking',
				),
			);

		}



		/**
		 * After demo import.
		 *
		 * @param <type> $selected_import  The selected import.
		 */
		public function king_after_import( $selected_import ) {

			if ( 'kingflix' === $selected_import['id'] ) {

				$fpage    = get_page_by_title( 'kingflix' );
				$fpage_id = $fpage->ID;
				$bpage    = get_page_by_title( 'Sample Page' );
				$bpage_id = $bpage->ID;
				update_option( 'show_on_front', 'page' );
				update_option( 'page_on_front', $fpage_id );
				update_option( 'page_for_posts', $bpage_id );
			} else {
				update_option( 'show_on_front', 'posts' );
			}

			$jso     = wp_remote_get( $selected_import['options'] );
			$json    = wp_remote_retrieve_body( $jso );
			$options = json_decode( $json, true );

			foreach ( $options as $key => $option ) {
				update_option( $key, $option['value'], 'no' );
			}
			king_generate_options_css();

		}

		/**
		 * One click demo import page .
		 *
		 * @param <type> $plugin_page_setup  The plugin page setup.
		 *
		 * @return <type> ( description_of_the_return_value )
		 */
		public function king_import_page( $plugin_page_setup ) {
			$plugin_page_setup['page_title'] = esc_html__( 'King Demo Import', 'king' );
			$plugin_page_setup['menu_title'] = esc_html__( 'King Demo Import', 'king' );

			return $plugin_page_setup;
		}

		/**
		 * King timeout.
		 *
		 * @param integer $timeout  The timeout.
		 *
		 * @return integer  ( description_of_the_return_value )
		 */
		public function king_timeout( $timeout ) {
			$timeout = 1500;

			return $timeout;
		}

		/**
		 * Demo import dialog.
		 *
		 * @param <type> $options  The options.
		 *
		 * @return <type> ( description_of_the_return_value )
		 */
		public function king_import_dialog( $options ) {
			return array_merge(
				$options,
				array(
					'width'       => 500,
					'dialogClass' => 'wp-dialog',
					'resizable'   => false,
					'height'      => 'auto',
					'modal'       => true,
				)
			);
		}

	}

	King_Demo_Import::get_instance();
}
