<?php

require WP_SAGE_AI_DIR . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

add_action( 'wp_ajax_sage_ai_call_dall_e', 'sage_ai_call_dall_e' );

function sage_ai_call_dall_e( $prompt = '', $images_required = 1 ) {
	$settings = get_option( 'wp_ai_content_gen_settings' );

	if ( empty( $settings ) || empty( $settings['api_key'] ) ) {
		wp_send_json_error( 'API Key not set' );
	}

	$apiKey     = $settings['api_key'];
	$image_size = $settings['image_size'];

	$is_ajax_call = empty( $prompt ) ? true : false;

	if ( $is_ajax_call && ! isset( $_POST['prompt'] ) ) {
		wp_send_json_error( 'Prompt not set' );
	}

	if ( $is_ajax_call ) {
		$prompt          = $_POST['prompt'];
		$images_required = isset( $_POST['imagesRequired'] ) ? (int) $_POST['imagesRequired'] : $images_required;
		$image_size      = isset( $_POST['size'] ) ? (int) $_POST['size'] : $image_size;
	}

	$open_ai = new OpenAi( $apiKey );

	$completion          = $open_ai->image(
		array(
			'prompt'          => $prompt,
			'n'               => $images_required,
			'size'            => $image_size,
			'response_format' => 'url',
		)
	);
	$response            = json_decode( $completion );
	$image_urls          = array();
	$uploaded_image_urls = array();

	if ( ! empty( $response->data ) ) {

		foreach ( $response->data as $image_data ) {

			if ( isset( $image_data->url ) ) {
				$image_urls[] = $image_data->url;
			}
		}

		if ( ! empty( $image_urls ) ) {
			$uploadedImageUrls = sage_ai_upload_url_to_media( $image_urls );
			if ( $is_ajax_call ) {
				wp_send_json_success( $uploadedImageUrls );
			}
			return $uploadedImageUrls;
		}
	}

	if ( $is_ajax_call ) {

		wp_send_json_success( $uploaded_image_urls );
	}

	return $uploaded_image_urls;
}
