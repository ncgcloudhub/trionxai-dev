<?php


// add_action('wp_ajax_sage_ai_upload_url_to_media', 'sage_ai_upload_url_to_media');

add_action('wp_ajax_sage_ai_read_csv', 'sage_ai_read_csv');


function sage_ai_upload_url_to_media($image_urls)
{
    // $imageURLs = explode(',', $_POST['urls']);

    $uploaded_image_urls = array();

    foreach($image_urls as $image_url) {
        // Extract the file extension from the image URL
        $path = parse_url($image_url, PHP_URL_PATH);
        $fileExtension = pathinfo($path, PATHINFO_EXTENSION);

        // Create a unique file name for the image with the original file extension
        $filename = uniqid() . '.' . $fileExtension;


        // Get the contents of the image from the URL
        $imageData = file_get_contents($image_url);

        // Upload the image to the WordPress uploads directory
        $upload = wp_upload_bits($filename, null, $imageData);

        // Check if the upload was successful
        if (!$upload['error']) {
            // Include the WordPress media management library
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            // Generate attachment metadata and create a post in the media library
            $attachmentData = array(
              'file' => $upload['file'],
              'post_mime_type' => $upload['type'],
              'post_title' => sanitize_file_name($filename),
              'post_content' => '',
              'post_status' => 'inherit'
            );


            $attachmentId = wp_insert_attachment($attachmentData, $upload['file']);


            // Generate attachment metadata
            $attachmentMetadata = wp_generate_attachment_metadata($attachmentId, $upload['file']);

            // Update the attachment metadata
            wp_update_attachment_metadata($attachmentId, $attachmentMetadata);

            // Get the image URL
            $imageUrl = wp_get_attachment_url($attachmentId);

            // Return the attachment ID
            $uploaded_image_urls[] = $imageUrl;
        } else {
            return($upload['error']);
        }
    }



    return($uploaded_image_urls);
}

function sage_ai_read_csv()
{

    if (isset($_FILES['file'])) {
        $file = $_FILES['file'];
        $csv_data = [];




        /// Set up the upload arguments
        $upload_overrides = array('test_form' => false);
        $uploaded_file = wp_handle_upload($file, $upload_overrides);

        if ($uploaded_file && !isset($uploaded_file['error'])) {
            // File uploaded successfully
            $file_url = $uploaded_file['url'];

            // Read the CSV file
            $file_handle = fopen($file_url, 'r');

            if ($file_handle !== false) {
                while (($data = fgetcsv($file_handle)) !== false) {
                    // Process each row of the CSV data
                    $csv_data[] = $data;
                    // Move the file pointer to the next line
                    rewind($file_handle);
                }

                fclose($file_handle);

                // Delete the CSV file
                if (file_exists($file_url)) {
                    unlink($file_url);
                }
            } else {
                wp_send_json_error('error reading csv file');
            }

            wp_send_json_success($csv_data);

        } else {
            // Error occurred during file upload
            wp_send_json_error('Error uploading file');
        }
    }
    wp_die();
}
