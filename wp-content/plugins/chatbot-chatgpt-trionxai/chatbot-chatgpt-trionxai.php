<?php
/*
Plugin Name: ChatGPT Integration
Description: A WordPress plugin to integrate ChatGPT with OpenAI.
Version: 1.0
Author: TrionxAI
*/

// Enqueue the styles and scripts
function chatgpt_enqueue_files() {
    wp_enqueue_style('chatgpt-frontend', plugin_dir_url(__FILE__) . 'frontend.css');
    wp_enqueue_script('chatgpt-frontend', plugin_dir_url(__FILE__) . 'frontend.js', array('jquery'), '1.0', true);
    wp_localize_script('chatgpt-frontend', 'chatGPT', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action('wp_enqueue_scripts', 'chatgpt_enqueue_files');

// Handle AJAX request for chatting with ChatGPT
function chatgpt_handle_ajax_request() {
    $message = isset($_POST['message']) ? sanitize_text_field($_POST['message']) : '';
    $model = isset($_POST['model']) ? sanitize_text_field($_POST['model']) : 'gpt-3.5-turbo';  // Default to gpt-3.5-turbo if not provided
    $response = chatgpt_get_response($message, $model);
    echo $response;
    wp_die();
}
add_action('wp_ajax_chatgpt_message', 'chatgpt_handle_ajax_request');
add_action('wp_ajax_nopriv_chatgpt_message', 'chatgpt_handle_ajax_request');

// Function to communicate with OpenAI's API
function chatgpt_get_response($message, $model) {
    $api_key = 'YOUR_OPENAI_API_KEY'; // Replace with your key
    $api_url = 'https://api.openai.com/v1/chat/completions';
    
    $args = array(
        'headers' => array(
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $api_key
        ),
        'body' => json_encode(array(
            'model' => $model,
            'messages' => array(array(
                'role' => 'user',
                'content' => $message
            ))
        ))
    );

    $response = wp_remote_post($api_url, $args);

    if (is_wp_error($response)) {
        return 'Error: ' . $response->get_error_message();
    }

    $body = wp_remote_retrieve_body($response);
    $data = json_decode($body, true);

    if (isset($data['choices'][0]['message']['content'])) {
        return trim($data['choices'][0]['message']['content']);
    } else {
        return 'Error retrieving response.';
    }
}

function chatgpt_shortcode() {
    ob_start(); // Start output buffering
    ?>
    <div id="chatgpt-container">
        <div id="chatgpt-messages"></div>
        <div id="chatgpt-input-container">
            <input type="text" id="chatgpt-input" placeholder="Type a message...">
            <select id="chatgpt-model-select">
                <option value="gpt-3.5-turbo">gpt-3.5-turbo</option>
                <option value="gpt-4">gpt-4</option>
            </select>
            <button id="chatgpt-send-btn">Send</button>
        </div>
    </div>
    <?php
    return ob_get_clean(); // End output buffering and return the buffered content
}
add_shortcode('chatgpt', 'chatgpt_shortcode');

