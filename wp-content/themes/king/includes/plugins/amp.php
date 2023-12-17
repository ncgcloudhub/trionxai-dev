<?php
/**
 * Amp For Google.
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package king
 */

define( 'AMP_QUERY_VAR', apply_filters( 'amp_query_var', 'amp' ) );

add_rewrite_endpoint( AMP_QUERY_VAR, EP_PERMALINK );

/**
 * Amp Template.
 *
 * @param <type> $template  The template.
 *
 * @return <type> ( description_of_the_return_value )
 */
function amp_page_template( $template ) {
	if( get_query_var( AMP_QUERY_VAR, false ) !== false ) {
		if ( is_single() ) {
			$template = get_template_directory() . '/amp/amp-single.php';
		}
	}
	return $template;
}
add_filter( 'template_include', 'amp_page_template', 99 );
/**
 * Get video IDs for amp
 *
 * @param  [type] $url [description]
 * @return [type]      [description]
 */
function king_parse_video_uri( $url ) {

		// Parse the url 

	$parse = parse_url( $url );

		// Set blank variables
	$video_type = '';
	$video_id = '';

	if (!isset($parse['host'])) {
		return false;
	}

		// Url is http://youtu.be/xxxx
	if ( $parse['host'] == 'youtu.be' ) {
		$video_type = 'youtube';
		$video_id = ltrim( $parse['path'],'/' );	
	}
		// Url is http://www.youtube.com/watch?v=xxxx 
		// or http://www.youtube.com/watch?feature=player_embedded&v=xxx
		// or http://www.youtube.com/embed/xxxx
	if ( ( $parse['host'] == 'youtube.com' ) || ( $parse['host'] == 'www.youtube.com' ) ) {
		$video_type = 'youtube';
		wp_parse_str( $parse['query'], $output );
		$video_id = $output['v'];	
		if ( !empty( $feature ) )
			$video_id = end( explode( 'v=', $parse['query'] ) );
		if ( strpos( $parse['path'], 'embed' ) == 1 )
			$video_id = end( explode( '/', $parse['path'] ) );
	}
		// Url is http://www.vimeo.com
	if ( ( $parse['host'] == 'vimeo.com' ) || ( $parse['host'] == 'www.vimeo.com' ) ) {
		$video_type = 'vimeo';
		$video_id = ltrim( $parse['path'],'/' );	
	}
		// Url is http://www.facebook.com
	if ( ( $parse['host'] == 'facebook.com' ) || ( $parse['host'] == 'www.facebook.com' ) ) {
		$video_type = 'facebook';
		$video_id = $url;	
	}
		// Url is http://www.soundcloud.com
	if ( ( $parse['host'] == 'soundcloud.com' ) || ( $parse['host'] == 'www.soundcloud.com' ) ) {
		$video_type = 'soundcloud';
		$track_id = WPTime_get_soundcloud_track($url);		
		$video_id = $track_id;	
	}			
		// If recognised type return video array
	if ( !empty( $video_type ) ) {
		$video_array = array(
			'type' => $video_type,
			'id' => $video_id
		);
		return $video_array;
	} else {
		return false;
	}
}

/**
 * Get Soundcloud Track ID
 *
 * @param [type] $url [description]
 */
function WPTime_get_soundcloud_track( $url ) {
	$transient_name = md5($url);
	$get_transient = "KqmJoxaVYyE4XT0XQqFUUQ";
	$client_id = get_option('wptime_theme_soundcloud_api');
	$get = wp_remote_get("https://api.soundcloud.com/resolve.json?url=$url&client_id=KqmJoxaVYyE4XT0XQqFUUQ");
	$retrieve = wp_remote_retrieve_body($get);
	$result = json_decode($retrieve, true);
	$track_id = isset($result['id']) ? $result['id'] : '';
	return $track_id;

}
/**
 * Grabs featured image or the first attached image for the post
 *
 */
function king_get_post_image_metadata() {
	$post_image_meta = null;
	$post_image_id = false;

	if ( has_post_thumbnail() ) {
		$post_image_id = get_post_thumbnail_id();
	} else {
		$attached_image_ids = get_posts( array(
			'post_parent' => get_the_ID(),
			'post_type' => 'attachment',
			'post_mime_type' => 'image',
			'posts_per_page' => 1,
			'orderby' => 'menu_order',
			'order' => 'ASC',
			'fields' => 'ids',
			'suppress_filters' => false,
		) );

		if ( ! empty( $attached_image_ids ) ) {
			$post_image_id = array_shift( $attached_image_ids );
		}
	}

	if ( ! $post_image_id ) {
		return false;
	}

	$post_image_src = wp_get_attachment_image_src( $post_image_id, 'full' );

	if ( is_array( $post_image_src ) ) {
		$post_image_meta = array(
			'@type' => 'ImageObject',
			'url' => $post_image_src[0],
			'width' => $post_image_src[1],
			'height' => $post_image_src[2],
		);
	}

	return $post_image_meta;
}	