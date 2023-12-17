<?php
class Sage_AI_Core_Gen_Admin_Settings {

	/**
	 * Autoload method
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

		// add_action( 'init', array( $this, 'fetch_rss_and_create_posts' ) );

		add_action( 'admin_menu', array( &$this, 'register_sub_menu' ) );
		add_action( 'admin_init', array( $this, 'initialize_options' ) );
		add_action( 'admin_head', array( $this, 'set_js_variable' ) );

		add_action( 'admin_notices', array( $this, 'show_licence_notice' ) );
	}

	public function show_licence_notice() {

		$screen = get_current_screen();

		// Only render this notice in the post editor.
		if ( ! $screen || strpos( $screen->base, 'sage-ai-writer' ) === false ) {
			return;
		}

		$pro_plugin = 'ai-content-generator-pro/ai-content-generator-pro.php';

		$license_status = get_option( 'sage_ai_licenses_pro_status' );

		if ( $license_status !== 'valid' ) {

			if ( is_plugin_active( $pro_plugin ) ) {

				echo '<div class="notice notice-error"><p>';
				printf( __( 'Your license key for <strong>Sage AI Writer Pro</strong> is not valid. <strong>Pro features</strong> will not work without an active license. <a href="%s">Activate License</a>' ), admin_url( '/admin.php?page=sage_ai_licenses' ) );
				echo '</p></div>';

			}
		}

		// Render the notice's HTML.

		return false;
	}

	public function fetch_rss_and_create_posts() {

		$rssFeedUrl = 'https://rss.art19.com/apology-line'; // Replace with your RSS feed URL
		$rssFeed    = file_get_contents( $rssFeedUrl );

		$xml = simplexml_load_string( $rssFeed );

		foreach ( $xml->channel->item as $item ) {
			$title       = (string) $item->title;
			$description = (string) $item->description;

			// Create a new blog post in WordPress using the extracted data
			// You can use the WordPress REST API or a plugin like "wp_insert_post()"

		}
	}

	/**
	 * Register submenu
	 *
	 * @return void
	 */
	public function register_sub_menu() {
		add_menu_page( 'Sage AI', 'Sage AI Writer', 'manage_options', 'wp-ai-content-gen-settings', array( &$this, 'settings_layout' ) );

		// adding bulk content gen page
		add_submenu_page( 'wp-ai-content-gen-settings', 'Bulk Content', 'Bulk Content Generator', 'manage_options', 'wp_ai_content_gen_bulk', array( &$this, 'bulk_content_generator' ) );

		// adding landing page gen page
		add_submenu_page( 'wp-ai-content-gen-settings', 'Landing Pages', 'Landing Pages Generator', 'manage_options', 'wp_ai_content_gen_landing_page', array( &$this, 'landing_page_generator' ) );

		add_submenu_page( 'wp-ai-content-gen-settings', 'Prompts', 'Prompts', 'manage_options', 'ai-content-writer-templates', array( &$this, 'template_page' ) );

		add_submenu_page( 'wp-ai-content-gen-settings', 'Support', 'Support', 'manage_options', 'wp_ai_content_gen_support', array( &$this, 'support_text' ) );
	}

	public function template_page() {
		?>
	<div id="ai-content-writer-templates-cont"> </div>

		<?php
	}
	public function admin_scripts( $hook ) {

		wp_enqueue_style( 'wp_ai_content_gen_settings', WP_SAGE_AI_URL . '/assets/admin/css/admin-settings.css', array( 'wp-components' ) );
		wp_enqueue_script( 'ai_content_writer_pro_script', WP_SAGE_AI_URL . '/build/index.js', array( 'react', 'react-dom', 'wp-blocks', 'wp-components', 'wp-edit-post', 'wp-element', 'wp-i18n', 'wp-plugins', 'wp-primitives', 'lodash' ), '', true );

		wp_enqueue_style( 'ai_content_writer_pro_style', WP_SAGE_AI_URL . '/build/index.css' );

		if ( 'wp-ai-content_page_ai-content-writer-templates' === $hook ) {

			wp_enqueue_script( 'ai_content_writer_pro_script', WP_SAGE_AI_URL . '/build/index.js', array( 'react', 'react-dom', 'wp-blocks', 'wp-components', 'wp-edit-post', 'wp-element', 'wp-i18n', 'wp-plugins', 'wp-primitives', 'lodash' ), '', true );

			wp_enqueue_style( 'ai_content_writer_pro_style', WP_SAGE_AI_URL . '/build/index.css' );
		}
	}


	public function set_js_variable() {

		// if (! (false == get_option('wp_ai_content_gen_settings'))) {
		$settings   = get_option( 'wp_ai_content_gen_settings' );
		$admin_url  = get_admin_url();
		$apiPageUrl = $admin_url . 'admin.php?page=wp-ai-content-gen-settings';

		// here get all the taxonomies listed under post type.
		// default will be the texonomies of post.
		$taxonomies = get_object_taxonomies( 'post', 'object' );

		$taxonomies_data = array();

		if ( ! empty( $taxonomies ) ) {
			// get the term data of that taxonomy. which is like all categories, tags.
			foreach ( $taxonomies as $taxonomy ) {

				// get data of taxonomy
				$taxonomy_terms = get_terms(
					array(
						'taxonomy'   => $taxonomy->name,
						'hide_empty' => false,
					)
				);

				$taxonomy_term_data = array();

				foreach ( $taxonomy_terms as $taxonomy_term ) {

					$taxonomy_term_data[] = array(
						'term_id'    => $taxonomy_term->term_id,
						'name'       => $taxonomy_term->name,
						'slug'       => $taxonomy_term->slug,
						'count'      => $taxonomy_term->count,
						'isSelected' => false,
					);
				}

				$taxonomies_data[] = array(
					'name'  => $taxonomy->name,
					'label' => $taxonomy->label,
					'data'  => $taxonomy_term_data,
				);
			}
		}

		$categories = get_categories(
			array(
				'hide_empty' => false,
			)
		);

		$post_categories = array();

		if ( ! empty( $categories ) ) {
			foreach ( $categories as $category ) {

				$category_info     = array(
					'label' => $category->name,
					'value' => $category->term_id,
				);
				$post_categories[] = $category_info;

			}
		}

		// get post types.
		$post_types            = array();
		$disallowed_post_types = array( 'product' );
		$custom_post_types     = get_post_types(
			array(
				'public'       => true,
				'_builtin'     => false,
				'show_in_rest' => true,
			),
			'objects'
		);

		$post_types[] = array(
			'label' => 'Post',
			'value' => 'post',
		);

		$post_types[] = array(
			'label' => 'Page',
			'value' => 'page',
		);

		foreach ( $custom_post_types as $custom_post_type ) {

			if ( ! in_array( $custom_post_type->name, $disallowed_post_types ) ) {

				$post_types[] = array(
					'label' => $custom_post_type->label,
					'value' => $custom_post_type->name,
				);

			}
		}

		$aiAssistantPrompts = ! empty( $settings['ai_assistant_prompts'] ) ? json_decode( $settings['ai_assistant_prompts'] ) : array(
			array(
				'name'        => 'Use as Prompt',
				'value'       => '[content]',
				'replaceText' => true,
				'readOnly'    => true,
			),
			array(
				'name'        => 'Write a paragraph',
				'value'       => 'Write a paragraph about [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Rephrase',
				'value'       => 'Rephrase: [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Text Extender',
				'value'       => 'Expand on: [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Summarize',
				'value'       => 'Write a summary for [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Pros & Cons',
				'value'       => 'Write Pros & Cons for [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Generate Ideas',
				'value'       => 'Generate Ideas about [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Introduction',
				'value'       => 'Write Introduction for [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Conclusion',
				'value'       => 'Write Conclusion for [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Outline',
				'value'       => 'Write an Outline for [content]',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Convert to passive Voice',
				'value'       => 'Convert [content] to passive Voice',
				'replaceText' => false,
				'readOnly'    => false,
			),
			array(
				'name'        => 'Convert to active Voice',
				'value'       => 'Convert [content] to active voice',
				'replaceText' => false,
				'readOnly'    => false,
			),

		);

		$license_status = get_option( 'sage_ai_licenses_pro_status' );

		$pro_plugin = 'ai-content-generator-pro/ai-content-generator-pro.php';

		if ( false === $license_status && is_plugin_active( $pro_plugin ) ) {
			$license_status = 'invalid';
		}

		$settings_array = array(
			'apiKey'             => ! empty( $settings['api_key'] ) ? $settings['api_key'] : '',
			'model'              => ! empty( $settings['model'] ) ? $settings['model'] : 'text-davinci-003',
			'temperature'        => ! empty( $settings['temperature'] ) ? $settings['temperature'] : '0.7',
			'max_tokens'         => ! empty( $settings['max_tokens'] ) ? $settings['max_tokens'] : '700',
			'top_p'              => ! empty( $settings['top_p'] ) ? $settings['top_p'] : '1',
			'best_of'            => ! empty( $settings['best_of'] ) ? $settings['best_of'] : '1',
			'frequency_penalty'  => ! empty( $settings['frequency_penalty'] ) ? $settings['frequency_penalty'] : '0.01',
			'presence_penalty'   => ! empty( $settings['presence_penalty'] ) ? $settings['presence_penalty'] : '0.01',
			'image_size'         => ! empty( $settings['image_size'] ) ? $settings['image_size'] : '512x512',
			'apiPageUrl'         => $apiPageUrl,
			'aiAssistantPrompts' => $aiAssistantPrompts,
			'sageAjaxUrl'        => admin_url( 'admin-ajax.php' ),
			'pluginUrl'          => WP_SAGE_AI_URL,
			'categories'         => $post_categories,
			'postTypes'          => $post_types,
			'pixabayApi'         => ! empty( $settings['pixabay_api'] ) ? $settings['pixabay_api'] : '',
			'taxonomies'         => $taxonomies_data,
			'adminUrl'           => admin_url(),
			'licenses'           => array(
				'pro' => $license_status,
			),
		);

		$queued_jobs = sage_ai_get_bulk_queue_data_with_changes();

		$processor = get_option( 'sage_ai_bulk_job_queue_processor' );

		if ( empty( $queued_jobs ) ) {
			$queued_jobs = array();
		}

		if ( empty( $processor['status'] ) ) {
			$processor['status'] = 'completed';
		}

		$queue_data = array(
			'queued_jobs' => $queued_jobs,
			'processor'   => $processor['status'],
		);

		?>
<script type="text/javascript">

var wp_ai_content_var = '<?php echo addslashes( json_encode( $settings_array ) ); ?>';
/** using json_hex_apos will escape single quote.. this prevents error when parsing it in js */
var wp_ai_content_var_bulk_queue = '<?php echo addslashes( json_encode( $queue_data ) ); ?>';

</script>

			<?php
	}


	/**
	 * Render submenu
	 *
	 * @return void
	 */
	public function settings_layout() {
		?>
<!-- Create a header in the default WordPress 'wrap' container -->
<div class="wrap wp-ai-content-gen-settings-wrap">

	<!-- Make a call to the WordPress function for rendering errors when settings are saved. -->
		<?php settings_errors(); ?>

	<!-- Create the form that will be used to render our options -->
	<form method="post" action="options.php">
		<?php settings_fields( 'wp_ai_content_gen_settings' ); ?>
		<?php do_settings_sections( 'wp_ai_content_gen_settings' ); ?>
	</div>

		<?php submit_button(); ?>
	</form>

</div><!-- /.wrap -->
		<?php
	}

	public function initialize_options() {
		// If settings don't exist, create them.
		if ( false == get_option( 'wp_ai_content_gen_settings' ) ) {
			add_option( 'wp_ai_content_gen_settings' );
		} // end if

		add_settings_section(
			'wp_ai_content_gen_settings_section',
			'',
			array( $this, 'section_callback' ),
			'wp_ai_content_gen_settings'
		);

		add_settings_field(
			'api_key',
			'API Key',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array( 'field' => 'api_key' )
		);

		add_settings_field(
			'model',
			'Model',
			array( $this, 'model_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array( 'field' => 'model' )
		);

		add_settings_field(
			'temperature',
			'Temperature',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array(
				'field'   => 'temperature',
				'default' => '0.7',
			)
		);
		add_settings_field(
			'max_tokens',
			'Max tokens',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array(
				'field'   => 'max_tokens',
				'default' => '700',
			)
		);

		add_settings_field(
			'top_p',
			'Top P',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array(
				'field'   => 'top_p',
				'default' => '1',
			)
		);
		add_settings_field(
			'best_of',
			'Best Of',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array(
				'field'   => 'best_of',
				'default' => '1',
			)
		);
		add_settings_field(
			'frequency_penalty',
			'Frequency Penality',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array(
				'field'   => 'frequency_penalty',
				'default' => '0.01',
			)
		);

		add_settings_field(
			'presence_penalty',
			'Presence Penality',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array(
				'field'   => 'presence_penalty',
				'default' => '0.01',
			)
		);
		add_settings_field(
			'image_size',
			'Image Size',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_gen_settings_section',
			array(
				'field'   => 'image_size',
				'default' => '512x512',
			)
		);

		add_settings_section(
			'wp_ai_content_assistant_settings_section',
			'',
			array( $this, 'assistant_section_callback' ),
			'wp_ai_content_gen_settings'
		);
		add_settings_field(
			'ai_assistant_prompts',
			'Assistant Prompts',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_assistant_settings_section',
			array(
				'field'   => 'ai_assistant_prompts',
				'default' => '',
			)
		);

		add_settings_section(
			'wp_ai_content_integrations_section',
			'',
			array( $this, 'integrations_section_callback' ),
			'wp_ai_content_gen_settings'
		);

		add_settings_field(
			'pixabay_api',
			'Pixabay API Key',
			array( $this, 'settings_field' ),
			'wp_ai_content_gen_settings',
			'wp_ai_content_integrations_section',
			array(
				'field' => 'pixabay_api',
			)
		);

		// register settings
		register_setting( 'wp_ai_content_gen_settings', 'wp_ai_content_gen_settings' );
	}

	public function section_callback() {

		$url_active_tab = isset( $_GET['active-tab'] ) ? $_GET['active-tab'] : '';

		?>

		<style>

			.wp-ai-assistant-section{
				display: none;
			}
			.wp-ai-integration-section{
				display: none;
			}
			.wp-ai-assistant-section .form-table tr th{
				display: none;
			}
		</style>

		<script>
			
			(function($){

				$(function(){
					
					$( document ).ready(function() {

						
					
					
						// show settings section on tab click
						$(document).on('click', '#wp-ai-main-setting', function(){
							var display = $('.wp-ai-setting-section').css('display');

							if( display != 'block'){

								$('#wp-ai-assistant-settings').removeClass('nav-tab-active');
								$('#wp-ai-integration-settings').removeClass('nav-tab-active');

								$(this).addClass('nav-tab-active')
								$('.wp-ai-setting-section').show();
								$('.wp-ai-assistant-section').hide();
								$('.wp-ai-integration-section').hide();
							}

						})

						// show Assistant section on tab click
						$(document).on('click', '#wp-ai-assistant-settings', function(){
							
							var display = $('.wp-ai-assistant-section').css('display');

							if( display != 'block'){

								$('#wp-ai-main-setting').removeClass('nav-tab-active');
								$('#wp-ai-integration-settings').removeClass('nav-tab-active');

								$(this).addClass('nav-tab-active')

								$('.wp-ai-assistant-section').show();
								$('.wp-ai-setting-section').hide();
								$('.wp-ai-integration-section').hide();

							}
						})

						// show Integrations section on tab click
						$(document).on('click', '#wp-ai-integration-settings', function(){
							
							var display = $('.wp-ai-integration-section').css('display');

							if( display != 'block'){

								$('#wp-ai-assistant-settings').removeClass('nav-tab-active');
								$('#wp-ai-main-setting').removeClass('nav-tab-active');

								$(this).addClass('nav-tab-active')

								$('.wp-ai-integration-section').show();
								$('.wp-ai-assistant-section').hide();
								$('.wp-ai-setting-section').hide();
							}
						})

						<?php
						if ( $url_active_tab === 'integrations' ) {
							echo '$("#wp-ai-integration-settings").click();';
						}
						?>

					})
				})

			})(jQuery)

		
		</script>
		
		<nav class="wp-ai-tab-wrapper">
			<a href="javascript:void(0)" id="wp-ai-main-setting" class="nav-tab nav-tab-active"> Settings</a>
			<a href="javascript:void(0)" id="wp-ai-assistant-settings" class="nav-tab ">AI Assistant</a>
			<a href="javascript:void(0)" id="wp-ai-integration-settings" class="nav-tab ">Integrations</a>
		</nav>

		<div class="wp-ai-setting-section">

		<?php
	}

	public function assistant_section_callback() {
		?>
		</div>
		<div class="wp-ai-assistant-section">
		
  
		<?php
	}

	public function integrations_section_callback() {
		?>
		</div>
		<div class="wp-ai-integration-section">
		
  
		<?php
	}

	public function settings_field( $args ) {
		$options = get_option( 'wp_ai_content_gen_settings' );
		$name    = $args['field'];
		$type    = isset( $args['type'] ) ? $args['type'] : 'text';
		$value   = isset( $options[ $name ] ) ? $options[ $name ] : ( isset( $args['default'] ) ? $args['default'] : '' );

		if ( $name === 'ai_assistant_prompts' ) {
			echo '<div id="sage-ai-assistant-prompts"></div>';

			// closing section div;

			return;
		}

		// Render the output
		echo '<input type="' . esc_attr( $type ) . '" class="regular-text" id="' . esc_attr( $name ) . '" name="wp_ai_content_gen_settings[' . esc_attr( $name ) . ']" value="' . esc_attr( $value ) . '" />';

		if ( 'api_key' === $args['field'] ) {
			echo ' <a href="https://beta.openai.com/account/api-keys" target="_blank">Get API Key</a>';
		}

		if ( 'pixabay_api' === $args['field'] ) {
			echo ' <a href="https://wpsageai.com/docs/integrating-pixabay-with-sage-ai-writer/" target="_blank">Get API Key</a>';
		}
	}

	public function model_field() {
		$options = get_option( 'wp_ai_content_gen_settings' );
		$value   = isset( $options['model'] ) ? $options['model'] : 'text-davinci-003';
		?>
		<select name="wp_ai_content_gen_settings[model]" >
			<option <?php selected( $value, 'gpt-4', true ); ?> value="gpt-4" > gpt-4</option>
			<option <?php selected( $value, 'gpt-3.5-turbo', true ); ?> value="gpt-3.5-turbo" > gpt-3.5-turbo</option>
			<option <?php selected( $value, 'text-davinci-003', true ); ?> value="text-davinci-003" > text-davinci-003</option>
			<option <?php selected( $value, 'text-davinci-002', true ); ?> value="text-davinci-002" > text-davinci-002</option>
			<option <?php selected( $value, 'text-curie-001', true ); ?> value="text-curie-001" > text-curie-001</option>
			<option <?php selected( $value, 'text-babbage-001', true ); ?> value="text-babbage-001" > text-babbage-001</option>
			<option <?php selected( $value, 'text-ada-001', true ); ?> value="text-ada-001" > text-ada-001</option>
		</select>

		<?php
	}

	// bulk Generator Function.
	public function bulk_content_generator() {
		?>

	<div class="wrap wp-ai-content-bulk-settings-wrap">
		<div id="sage-ai-bulk-content-generator"></div>
		<?php
	}

	// bulk Generator Function.
	public function landing_page_generator() {
		?>

	<div class="wrap wp-ai-content-landing-settings-wrap">
		<div id="sage-ai-landing-page-generator">

		</div>
		<?php
	}

	public function support_text() {

		?>
		<div class="wrap wp-ai-content-gen-settings-wrap">
			<p> If you have any questions, please contact us at <a href="https://wpaicontent.com">wpaicontent.com</a></p>
				<?php
	}
}

new Sage_AI_Core_Gen_Admin_Settings();
