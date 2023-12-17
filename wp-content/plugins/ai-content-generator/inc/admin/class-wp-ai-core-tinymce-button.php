<?php

class Sage_AI_Core_Tinymce_Button {

	public function __construct() {
		// Adding "embed form" button to the editor
		add_action( 'media_buttons', array( $this, 'add_tinymce_button' ), 20 );
		add_filter( 'mce_buttons', array( $this, 'register_button' ) );
		// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
		add_filter( 'mce_external_plugins', array( $this, 'register_tinymce_javascript' ) );
		// Adding the modal
		// add_action( 'admin_print_footer_scripts', array( $this, 'add_mce_popup' ) );
	}


	public function register_tinymce_javascript( $plugin_array ) {
		$plugin_array['sageaibutton'] = WP_SAGE_AI_URL . '/assets/admin/js/tinymce-plugin.js';
		return $plugin_array;
	}

	public function register_button( $buttons ) {
		array_push( $buttons, 'sageaibutton' );
		return $buttons;
	}

	public function add_tinymce_button( $editor_id ) {

		$post_type = get_post_type();

		// display button matching new UI
		echo '<style>.gform_media_icon{
           background-position: center center;
           background-repeat: no-repeat;
           background-size: 16px auto;
           float: left;
           height: 16px;
           margin: 0;
           text-align: center;
           width: 16px;
           padding-top:10px;
           }
           .ai_content_writer_icon:before{
           color: #999;
           padding: 7px 0;
           transition: all 0.1s ease-in-out 0s;
           }
           .wp-core-ui a.gform_media_link{
            padding-left: 0.4em;
           }
        </style>';

		if ( $post_type === 'product' ) {
			if ( $editor_id === 'content' ) {
				echo '<span  class="button ai_content_writer_btn" id="sage_ai_product_writer_btn" aria-label="' . esc_attr__( 'Sage AI Product Writer', 'sage-ai-writer' ) . '">Sage AI Product Writer</span>';
			}

			if ( $editor_id === 'excerpt' ) {
				echo '<span  class="button ai_content_writer_btn" id="sage_ai_product_excerpt_writer_btn" aria-label="' . esc_attr__( 'Sage AI Product Writer', 'sage-ai-writer' ) . '">Sage AI Product Writer</span>';
			}
		} else {
			echo '<span class="button ai_content_writer_btn" id="sage_ai_content_writer_btn" aria-label="' . esc_attr__( 'Sage AI Writer', 'sage-ai-writer' ) . '">Sage AI Writer</span>';
		}
	}
}

new Sage_AI_Core_Tinymce_Button();
