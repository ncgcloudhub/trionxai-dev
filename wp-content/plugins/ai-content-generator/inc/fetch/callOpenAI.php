<?php

require WP_SAGE_AI_DIR . '/vendor/autoload.php'; // remove this line if you use a PHP Framework.

use Orhanerday\OpenAi\OpenAi;

add_action( 'wp_ajax_sage_ai_call_open_ai', 'sage_ai_call_open_ai' );

function sage_ai_call_open_ai( $prompt = '', $args = array() ) {

	$is_ajax = empty( $prompt ) ? true : false;

	if ( isset( $_POST['prompt'] ) ) {
		$prompt = $_POST['prompt'];
	}

	if ( false === get_option( 'wp_ai_content_gen_settings' ) ) {
		wp_send_json_error( 'API Key not set' );
	}

	$settings = get_option( 'wp_ai_content_gen_settings' );
	$apiKey   = $settings['api_key'];

	$open_ai = new OpenAi( $apiKey );

	if ( ! empty( $args['model'] ) && ( $args['model'] === 'text-moderation-stable' || $args['model'] === 'text-moderation-latest' ) ) {

		$open_ai_call_args = array(
			'model' => $args['model'],
			'input' => $prompt,
		);

		$message = sage_ai_call_open_ai_moderation( $open_ai_call_args, $open_ai, $is_ajax );

		return $message;

	}

	$best_of = 1;

	if ( ! empty( $args ) ) {
		$model             = $args['model'];
		$max_tokens        = (int) $args['max_tokens'];
		$temperature       = (float) $args['temperature'];
		$top_p             = (float) $args['top_p'];
		$frequency_penalty = (float) $args['frequency_penalty'];
		$presence_penalty  = (float) $args['presence_penalty'];
	} else {
		$model             = isset( $_POST['model'] ) ? $_POST['model'] : $settings['model'];
		$temperature       = isset( $_POST['temperature'] ) ? (float) $_POST['temperature'] : (float) $settings['temperature'];
		$max_tokens        = isset( $_POST['max_tokens'] ) ? (float) $_POST['max_tokens'] : (float) $settings['max_tokens'];
		$top_p             = isset( $_POST['top_p'] ) ? (float) $_POST['top_p'] : (float) $settings['top_p'];
		$best_of           = isset( $_POST['best_of'] ) ? (float) $_POST['best_of'] : (float) $settings['best_of'];
		$frequency_penalty = isset( $_POST['frequency_penalty'] ) ? (float) $_POST['frequency_penalty'] : (float) $settings['frequency_penalty'];
		$presence_penalty  = isset( $_POST['presence_penalty'] ) ? (float) $_POST['presence_penalty'] : (float) $settings['presence_penalty'];
	}

	if ( $model === 'gpt-3.5-turbo' || $model === 'gpt-3.5-turbo-16k' || $model === 'gpt-4' || $model === 'gpt-4-32k' ) {

		$messages          = array(
			array(
				'role'    => 'user',
				'content' => $prompt,
			),
		);
		$open_ai_call_args = array(
			'model'             => $model,
			'messages'          => $messages,
			'temperature'       => $temperature,
			'max_tokens'        => $max_tokens,
			'frequency_penalty' => $frequency_penalty,
			'presence_penalty'  => $presence_penalty,
			'top_p'             => $top_p,
		);
		$message           = sage_ai_call_open_ai_chat_completion( $open_ai_call_args, $open_ai, $is_ajax );
		return $message;

	} else {

		$open_ai_call_args = array(
			'model'             => $model,
			'prompt'            => $prompt,
			'temperature'       => $temperature,
			'max_tokens'        => $max_tokens,
			'frequency_penalty' => $frequency_penalty,
			'presence_penalty'  => $presence_penalty,
			'top_p'             => $top_p,
			'best_of'           => $best_of,
		);

		$message = sage_ai_call_open_ai_completion( $open_ai_call_args, $open_ai, $is_ajax );

		return $message;
	}
}


// moderation
function sage_ai_call_open_ai_moderation( $args, $open_ai, $is_ajax ) {

	$completion = $open_ai->moderation( $args );

	$response              = json_decode( $completion );
	$moderation_categories = array();

	if ( isset( $response->results ) ) {

		foreach ( $response->results as $result ) {

			if ( ! empty( $result->flagged ) ) {
				foreach ( $result->categories as $category_key => $category_value ) {
					// error_log( print_r( $category_key, true ) );

					if ( ! empty( $category_value ) ) {
						$moderation_categories[ $category_key ] = $category_key;
					}
				}
			} else {
				$moderation_categories['valid'] = 'This content is valid.';
			}
		}

		if ( $is_ajax ) {
			wp_send_json_success( $moderation_categories );
		} else {
			return $moderation_categories;
		}
	} else {
		// in case of error send the error message.
		if ( $is_ajax ) {
			wp_send_json_success( $response->error->message );
		} else {
			return $response->error->message;
		}
	}
}


// Chat Completion
function sage_ai_call_open_ai_chat_completion( $args, $open_ai, $is_ajax ) {

	$completion = $open_ai->chat( $args );

	$response = json_decode( $completion );

	if ( isset( $response->choices[0]->message->content ) ) {
		if ( $is_ajax ) {
			wp_send_json_success( $response->choices[0]->message->content );
		} else {
			return $response->choices[0]->message->content;
		}
	} elseif ( $is_ajax ) {
			wp_send_json_error( $response->error->message );
	} else {
		return $response->error->message;
	}
}


// completion.
function sage_ai_call_open_ai_completion( $args, $open_ai, $is_ajax ) {

	$completion = $open_ai->completion( $args );

	$response = json_decode( $completion );

	if ( isset( $response->choices[0]->text ) ) {
		if ( $is_ajax ) {
				wp_send_json_success( $response->choices[0]->text );
		} else {
				return $response->choices[0]->text;
		}
	} elseif ( $is_ajax ) {
			wp_send_json_error( $response->error->message );
	} else {
		return $response->error->message;
	}
}
