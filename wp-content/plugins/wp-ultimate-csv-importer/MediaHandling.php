<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class MediaHandling{
	private static $instance=null,$smack_instance;
	public $header_array;
	public $value_array;

	public function __construct(){
		
		include_once(ABSPATH . 'wp-admin/includes/image.php');		
		add_action('wp_ajax_image_options', array($this , 'imageOptions'));
		add_action('wp_ajax_delete_image' , array($this , 'deleteImage'));
	}

	public static function imageOptions(){	
		check_ajax_referer('smack-ultimate-csv-importer', 'securekey');
		$media_settings['media_handle_option'] = sanitize_text_field($_POST['media_handle_option']);
		$media_settings['use_ExistingImage'] = sanitize_text_field($_POST['use_ExistingImage']);
		$media_settings['enable_postcontent_image'] = sanitize_text_field($_POST['postContent_image_option']);
		$image_info = array(
			'media_settings'  => $media_settings
		);
		update_option( 'smack_image_options', $image_info );
		$result['success'] = 'true';
		echo wp_json_encode($result);
		wp_die();
	}
	public static function getInstance() {
		if (MediaHandling::$instance == null) {
			MediaHandling::$instance = new MediaHandling;
			return MediaHandling::$instance;
		}
		return MediaHandling::$instance;
	}

	public function deleteImage(){
		check_ajax_referer('smack-ultimate-csv-importer', 'securekey');
		$image = sanitize_text_field($_POST['image']);
		$media_dir = wp_get_upload_dir();
		$names = glob($media_dir['path'].'/'.'*.*');
		foreach($names as $values){
			if (strpos($values, $image) !== false) {
				unlink($values);
			}
		}   
		$result['success'] = 'true';
		echo wp_json_encode($result);
		wp_die();     
	}
	public function media_handling($img_url , $post_id , $data_array = null  ,$module = null, $image_type = null ,$hash_key = null,$templatekey = null){
		$encodedurl = urlencode($img_url);
		$img_url = urldecode($encodedurl);
		$url = parse_url($img_url);
		if($hash_key == null)
			$hash_key = "";
		$media_handle = get_option('smack_image_options');	
		if(isset($url['scheme']) && $url['scheme'] == 'http' || $url['scheme'] == 'https' ){		
			$image_name = basename($img_url);
			$image_title = sanitize_file_name( pathinfo( $image_name, PATHINFO_FILENAME ) );
		}else{
			$image_title=preg_replace('/\\.[^.\\s]{3,4}$/', '', $img_url);
		}
		global $wpdb;
		if($media_handle['media_settings']['use_ExistingImage'] == 'true'){
			if(is_numeric($img_url)){
				$attach_id=$img_url;
				if(!empty($data_array['featured_image'])) {
					set_post_thumbnail( $post_id, $attach_id );
				}
				return $attach_id;
			}
			else{
				$attachment_id = $wpdb->get_results("select ID from {$wpdb->prefix}posts where post_title= '$image_title'" ,ARRAY_A);

			}

			if(!empty($attachment_id)){
				foreach($attachment_id as $value){
					$attach_id = $value['ID'];
					if(!wp_get_attachment_url($attach_id)){
						$attach_id = $this->image_function($img_url , $post_id , $data_array);	
					}else{
						if(!empty($data_array['featured_image'])) {
							set_post_thumbnail( $post_id, $attach_id );
						}
					}
				}
			}
			else{
				$attach_id = $this->image_function($img_url , $post_id , $data_array,'','use_existing_image');
			}

		}
		else{
			$attach_id = $this->image_function( $img_url , $post_id ,$data_array);
			if($attach_id !=null){
				$image_table = $wpdb->prefix . "ultimate_csv_importer_media";
				$wpdb->get_results("INSERT INTO $image_table (image_url , attach_id , post_id,hash_key,templatekey,module,image_type,status) VALUES ( '{$img_url}', $attach_id , $post_id  ,'{$hash_key}','{$templatekey}','{$module}','{$image_type}','Completed')");
			}

		}
		return $attach_id;
	}

	public function image_function($f_img , $post_id , $data_array = null,$option_name = null, $use_existing_image = false,$header_array = null , $value_array = null){
		
		global $wpdb;
		$f_img = urldecode($f_img);
		$image = explode("?", $f_img);
		$f_img=$image[0];
	
		$media_handle = get_option('smack_image_options');
		if(!empty($header_array) && !empty($value_array) ){
			$media_settings = array_combine($header_array,$value_array);
		}
		if(isset($media_handle['media_settings']['alttext'])) {
			$alttext ['_wp_attachment_image_alt'] = isset($media_settings[$media_handle['media_settings']['alttext']]) ? $media_settings[$media_handle['media_settings']['alttext']] :'';
		} 

		if(preg_match_all('/\b(?:(?:https?|http|ftp|file):\/\/|www\.|ftp\.)[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $f_img , $matchedlist, PREG_PATTERN_ORDER)) {
			$f_img = $f_img;
		}   
		else{
			$media_dir = wp_get_upload_dir();
			$names = glob($media_dir['path'].'/'.'*.*');
			foreach($names as $values){
				if (strpos($values, $f_img) !== false) {
					$f_img = $media_dir['url'].'/'.$f_img;
				}
			}            
		}

		$image_name = pathinfo($f_img);
		if(!empty($media_handle['media_settings']['file_name'])){	
			$file_type = wp_check_filetype( $f_img, null );
			$ext = '.'. $file_type['ext'];
			$fimg_name = $media_settings[$media_handle['media_settings']['file_name']].$ext;
		}		
		else{
			$fimg_name = $image_name['basename'];
		}
		$file_type = wp_check_filetype( $fimg_name, null );
		if($use_existing_image){
			if(empty($file_type['ext'])){
				$fimg_name = @basename($f_img);
				$fimg_name = str_replace(' ', '-', trim($fimg_name));
				$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
			}
			$attachment_id = $wpdb->get_var("SELECT ID FROM ".$wpdb->prefix."posts WHERE post_type = 'attachment' AND guid LIKE '%$fimg_name'");

			if($attachment_id){
				if(!empty($data_array['featured_image'])){
					set_post_thumbnail( $post_id, $attachment_id );
					return $attachment_id;
				}else{
					return $attachment_id;
				}
			}
		}

		$attachment_title = sanitize_file_name( pathinfo( $fimg_name, PATHINFO_FILENAME ) );
		$file_type = wp_check_filetype( $fimg_name, null ); 
		$dir = wp_upload_dir();
		$dirname = date('Y') . '/' . date('m');
		$uploads_use_yearmonth = get_option('uploads_use_yearmonth_folders');
        if($uploads_use_yearmonth == 1){
            $uploaddir_paths = $dir ['basedir'] . '/' . $dirname ;
            $uploaddir_url = $dir ['baseurl'] . '/' . $dirname;
        }
        else{
            $uploaddir_paths = $dir ['basedir'];
            $uploaddir_url = $dir ['baseurl'];
        }
		$f_img = str_replace(" ","%20",$f_img);
		if(empty($file_type['ext'])){
			$fimg_name = @basename($f_img);
			$fimg_name = str_replace(' ', '-', trim($fimg_name));
			$fimg_name = preg_replace('/[^a-zA-Z0-9._\-\s]/', '', $fimg_name);
		}
		if ($uploaddir_paths != "" && $uploaddir_paths) {
			$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;
		}
	
			if($file_type['ext'] == 'jpeg'){
				$response = wp_safe_remote_get($f_img, array( 'timeout' => 30));		
			}else{
				$response = wp_safe_remote_get($f_img, array( 'timeout' => 10));		
			}	
			if(is_wp_error($response))	{
				return null;
			}
			$rawdata =  wp_remote_retrieve_body($response);
		
		$http_code = wp_remote_retrieve_response_code($response);
		if($http_code == 404){
			return null;
		}

		if ( $http_code != 200 && strpos( $rawdata, 'Not Found' ) != 0 ) {
			return null;
		}
		if(is_plugin_active('exmage-wp-image-links/exmage-wp-image-links.php')){
			$guid =$fimg_name;
		}
		if ($rawdata == false) {
			return null;
		} else {		
			if(is_plugin_active('exmage-wp-image-links/exmage-wp-image-links.php')){
				$link = new \EXMAGE_WP_IMAGE_LINKS;
				$postID = $link->add_image($data_array['featured_image'],$value);
				wp_update_post(array(
					'ID'           => $postID['id'],
					'post_title'   => $data_array['title'],
					'post_content' => $data_array['description'],
					'post_excerpt' => $data_array['caption']
				));
				//if($postID['id'] != null && isset($alttext['_wp_attachment_image_alt'])){  
					//update_post_meta($postID['id'], '_wp_attachment_image_alt', $alttext['_wp_attachment_image_alt']);
				//}
                if($postID['id'] != null && isset($data_array['alt_text'])){  
					update_post_meta($postID['id'], '_wp_attachment_image_alt', $data_array['alt_text']);
				}
			}
			else{
				if (file_exists($uploaddir_path)) {
					$i = 1;
					$exist = true;
					while($exist){
						$fimg_name = $attachment_title . "-" . $i . "." . $file_type['ext'];        
						$uploaddir_path = $uploaddir_paths . "/" . $fimg_name;

						if (file_exists($uploaddir_path)) {
							$i = $i + 1;
						}
						else{
							$exist = false;
						}
					}
				}
				$fp = fopen($uploaddir_path, 'x');
				fwrite($fp, $rawdata);
				fclose($fp);
			}
		}
		if(empty($file_type['type'])){
			$file_type['type'] = 'image/jpeg';
		}
		if(is_plugin_active('exmage-wp-image-links/exmage-wp-image-links.php')){
			$guids =$data_array['featured_image'];
		}
		else{
			$guids=$uploaddir_url . "/" .  $fimg_name;
		}
		
		$post_info = array(
			'guid'           => $guids,
			'post_mime_type' => $file_type['type'],
			'post_title'     => $attachment_title,
			'post_content'   => '',
			'post_status'    => 'inherit',
		);
		if(!is_plugin_active('exmage-wp-image-links/exmage-wp-image-links.php')){
			$attach_id = wp_insert_attachment( $post_info,$uploaddir_path, $post_id );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $uploaddir_path );
			wp_update_attachment_metadata( $attach_id,  $attach_data );
		}
		if(isset($media_handle['media_settings']['description'])){
			$media_handle['media_settings']['description'] = isset($media_settings[$media_handle['media_settings']['description']]) ?  $media_settings[$media_handle['media_settings']['description']] :'';
		}
		if(isset($media_handle['media_settings']['caption'])){
			$media_handle['media_settings']['caption'] = isset($media_settings[$media_handle['media_settings']['caption']]) ? $media_settings[$media_handle['media_settings']['caption']] :'';
		}
		if(isset($media_handle['media_settings']['title'])){
			$media_handle['media_settings']['title'] = isset($media_settings[$media_handle['media_settings']['title']]) ? $media_settings[$media_handle['media_settings']['title']] :'';
		}
		if(isset($media_handle['media_settings']['caption']) || isset($media_handle['media_settings']['description'])){
			wp_update_post(array(
				'ID'           =>$attach_id,
				'post_content' =>$media_handle['media_settings']['description'],
				'post_excerpt' =>$media_handle['media_settings']['caption']
			));
		}
		if(!empty($media_handle['media_settings']['title'])){
			wp_update_post(array(
				'ID'           =>$attach_id,
				'post_title'   =>$media_handle['media_settings']['title']
			));
		}
		if($attach_id != null && isset($alttext['_wp_attachment_image_alt'])){  
			update_post_meta($attach_id, '_wp_attachment_image_alt', $alttext['_wp_attachment_image_alt']);
		}
		if(!empty($data_array['featured_image'])) {
			set_post_thumbnail( $post_id, $attach_id );
		}

		return $attach_id;
	}

}