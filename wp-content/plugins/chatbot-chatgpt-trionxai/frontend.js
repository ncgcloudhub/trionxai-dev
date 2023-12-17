jQuery(document).ready(function ($) {

    $('#chatgpt-send-btn').click(function () {
        var userMessage = $('#chatgpt-input').val();
        var selectedModel = $('#chatgpt-model-select').val();

        if (userMessage.trim() === '') {
            return; // Don't send an empty message
        }

        // Display user's message
        $('#chatgpt-messages').append('<div class="user-message">User: ' + userMessage + '</div>');

        // Send AJAX request
        $.ajax({
            type: 'POST',
            url: chatGPT.ajax_url,
            data: {
                action: 'chatgpt_message',
                message: userMessage,
                model: selectedModel
            },
            success: function (response) {
                // Display ChatGPT's response
                $('#chatgpt-messages').append('<div class="gpt-response">ChatGPT: ' + response + '</div>');
            },
            error: function () {
                $('#chatgpt-messages').append('<div class="gpt-response-error">Error getting response.</div>');
            }
        });

        // Clear the input field
        $('#chatgpt-input').val('');
    });

});
