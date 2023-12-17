<?php

function sage_ai_moderation_block_specific_comments( $approved, $commentdata ) {

	$comment_content = $commentdata['comment_content'];

	$settings           = get_option( 'wp_ai_content_gen_settings' );
	$moderation_model   = isset( $settings['moderation_model'] ) ? $settings['moderation_model'] : 'text-moderation-stable';
	$moderation_action  = isset( $settings['moderation_action_field'] ) ? $settings['moderation_action_field'] : '1';
	$moderation_enabled = isset( $settings['moderation_enabled'] ) ? $settings['moderation_enabled'] : '';

	if ( ! $moderation_enabled ) {
		return $approved;
	}

	$args = array(
		'model' => $moderation_model,
	);

	$moderations = sage_ai_call_open_ai( $comment_content, $args );

	if ( is_array( $moderations ) ) {

		foreach ( $moderations as $moderation_key => $moderation_value ) {

			if ( $moderation_key !== 'valid' ) {
				$approved = $moderation_action;
			}
		}
	}

	return $approved;
}

add_filter( 'pre_comment_approved', 'sage_ai_moderation_block_specific_comments', 10, 2 );
