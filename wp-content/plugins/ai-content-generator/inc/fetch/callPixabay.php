<?php

add_action('wp_ajax_sage_ai_call_pixabay', 'sage_ai_call_pixabay');

function sage_ai_call_pixabay($search='', $images_required=1)
{

    $settings = get_option('wp_ai_content_gen_settings');
    $uploadedImageUrls = array();



    $is_ajax_call = empty($search) ? true : false;

    $api = $settings['pixabay_api'];
    if($is_ajax_call) {

        $search = $_POST['search'];
        $images_required = $_POST['imagesRequired'];
    }

    $pixabay_api_url = add_query_arg(array(
        'key'=>  $api,
        'q' => $search,
        'per_page' => 200,
    ), 'https://pixabay.com/api');


    $response = wp_remote_get($pixabay_api_url);

    if (is_array($response) && ! is_wp_error($response)) {
        $body    = wp_remote_retrieve_body($response); // use the content
        $body = json_decode($body);

        if (count($body->hits) === 0) {
            if($is_ajax_call) {
                wp_send_json_error($uploadedImageUrls);
            }
            return $uploadedImageUrls;
        }

        $selected_images = array();
        $selected_images_index = array();
        $total_images_count = count($body->hits);

        while (count($selected_images_index)  < $images_required) {
            $r = rand(1, $total_images_count) - 1;
            if (! in_array($r, $selected_images_index) && isset($body->hits[$r]->largeImageURL)) {
                $selected_images_index[]= $r;
            }

            $selected_images[] = $body->hits[$r]->largeImageURL;
        }

        if(!empty($selected_images)) {
            $uploadedImageUrls = sage_ai_upload_url_to_media($selected_images);
            if($is_ajax_call) {
                wp_send_json_success($uploadedImageUrls);
            }
            return $uploadedImageUrls;
        }


        if(empty($uploadedImageUrls)) {
            if($is_ajax_call) {
                wp_send_json_error($uploadedImageUrls);
            }
            return $uploadedImageUrls;

        }


    }
}
