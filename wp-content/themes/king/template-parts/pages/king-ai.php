<?php
/**
 * King Ai.
 *
 * @package King
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the selected options from the options page
$selected_options = get_field('enable_content_or_image_generation', 'options');

// Check which options are selected and display the appropriate select box
if ($selected_options && !in_array('content', $selected_options)) {
    $select_box = '<select id="ai-select" style="display:none;">' .
                  '<option value="image">' . esc_html__('Image', 'king') . '</option>' .
                  '</select>';
} elseif ($selected_options && !in_array('image', $selected_options)) {
    $select_box = '<select id="ai-select" class="hide">' .
                  '<option value="content">' . esc_html__('Content', 'king') . '</option>' .
                  '</select>';
} else {
    $select_box = '<select id="ai-select">' .
                  '<option value="content">' . esc_html__('Content', 'king') . '</option>' .
                  '<option value="image">' . esc_html__('Image', 'king') . '</option>' .
                  '</select>';
}

$who = get_field('who_can_use_ai', 'options');
$out = false;
$usid = get_current_user_id();
			
	if ( in_array( 'all', $who ) ) :
		$out = true;
	elseif ( in_array( 'verified', $who ) && get_field( 'verified_account', 'user_' . $usid ) ) :
		$out = true;
	elseif ( in_array( 'premium', $who ) && get_field( 'enable_membership', 'option' ) && function_exists( 'is_woocommerce' ) && king_check_membership( null, $usid ) ) :
		$out = true;
	endif;

?>
<?php if ( is_super_admin() || $out ) : ?>
	<div class="kingai-input">
		<input type="text" id="ai-box" class="bpinput" placeholder="<?php esc_html_e( 'Ask to AI', 'king' ); ?>" autocomplete="off" />
		<div class="kingai-buttons">
			<?php echo $select_box; ?>
			<button type="button" id="ai-submit"><i class="fa-solid fa-paper-plane"></i><div class="loader"></div></button>
		</div>
		<div id="ai-results"></div>
	</div>
<?php endif; ?>
