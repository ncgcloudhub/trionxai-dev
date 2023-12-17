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

if ( ! king_theme_register() || ! king_plugin_active( 'envato_market' ) ) :
	if ( function_exists( 'acf_add_local_field_group' ) ) :
		acf_add_local_field_group(
			array(
				'key'    => 'group_5aaacfbca320f',
				'title'  => 'Register Theme',
				'fields' => array(
					array(
						'key' => 'field_5aaad00b6d5ec',
						'label' => 'Register King Theme',
						'name' => '',
						'type' => 'message',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'message' => 'You have to register your King Theme to see theme options ! Go to Envato Market plugin and insert Token !',
						'new_lines' => 'wpautop',
						'esc_html' => 0,
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-settings',
						),
					),
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-layout',
						),
					),
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-lists',
						),
					),
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'acf-options-customize',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			)
		);
	endif;
else :
	add_filter('acf/settings/load_json', 'king_json_load_point');
	function king_json_load_point( $paths ) {
	    // remove original path (optional)
	    unset($paths[0]);
	    // append path
	    $paths[] = KING_INCLUDES_PATH . 'theme-options';
	    // return
	    return $paths;

	}

endif;
/**
 * Register Theme.
 *
 * @return     boolean  ( description_of_the_return_value )
 */
function king_theme_register() {
	$king_register = get_transient( 'king_theme_registered' );

	if ( $king_register ) {
		return true;
	}
	if ( ! king_plugin_active( 'envato_market' ) ) {
		return true;
	}
	$purchased_themes = envato_market()->api()->themes();
	$my_theme         = wp_get_theme();
	foreach ( $purchased_themes as $purchased_theme ) {
		if ( $my_theme->get( 'TextDomain' ) === strtolower( $purchased_theme['name'] ) ) {
			$king_register = true;
		}
	}

	if ( $king_register ) {
		$expired = 60 * 60 * 24 * 100000000;
		set_transient( 'king_theme_registered', true, $expired );
	}

	return $king_register;
}
if ( ! king_theme_register() || ! king_plugin_active( 'envato_market' ) ) :
	/**
	 * King Admin Notices.
	 */
	function king_admin_notifications2() {
		$class   = 'notice notice-info is-dismissible theme-option-property-search-page-notification';
		$message = esc_html__( 'Required: You have to register King Theme !".', 'king' );
		printf( '<div class="%1$s"><p>%2$s</p></div>', $class, $message );
	}
	add_action( 'admin_notices', 'king_admin_notifications2' );
endif;
if( function_exists('acf_add_local_field_group') ) :
acf_add_local_field_group(array(
    'key' => 'group_58bf2f49e4513',
    'title' => 'Images',
    'fields' => array(
        array(
            'key' => 'field_58bf2f79ed6d3',
            'label' => 'Images Lists',
            'name' => 'images_lists',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => 'king-repeater',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'block',
            'button_label' => '',
            'sub_fields' => array(
                array(
                    'key' => 'field_58bf2f96ed6d4',
                    'label' => 'Images list',
                    'name' => 'images_list',
                    'type' => 'image',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'return_format' => 'array',
                    'preview_size' => 'large',
                    'library' => 'uploadedTo',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => 5,
                    'mime_types' => 'jpg, jpeg, png, gif,',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_format',
                'operator' => '==',
                'value' => 'image',
            ),
        ),
    ),
    'menu_order' => 0,
    'position' => 'normal',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => false,
    'description' => '',
));
endif;