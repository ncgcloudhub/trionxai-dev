<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class CoreFieldsImport {
	private static $core_instance = null,$media_instance;
	public $detailed_log;
	public static function getInstance() {

		if (CoreFieldsImport::$core_instance == null) {
			CoreFieldsImport::$core_instance = new CoreFieldsImport;
			CoreFieldsImport::$media_instance = new MediaHandling;
			return CoreFieldsImport::$core_instance;
		}
		return CoreFieldsImport::$core_instance;
	}

	function set_core_values($header_array ,$value_array , $map , $type , $mode , $line_number , $check , $hash_key, $unmatched_row, $gmode, $templatekey, $wpml_array = null){
		global $wpdb;
		global $uci_woocomm_instance;
		global $userimp_class;
		global $sitepress;

		$helpers_instance = ImportHelpers::getInstance();
		CoreFieldsImport::$media_instance->header_array = $header_array;
		CoreFieldsImport::$media_instance->value_array = $value_array;
		$log_table_name = $wpdb->prefix ."import_detail_log";

		$unikey_name = 'hash_key';
		$unikey_value = $hash_key;

		if($gmode == 'CLI'){ //Exchange the hashkey value with template key
			$unikey_name = 'templatekey';
			$unikey_value = ($templatekey != null) ? $templatekey : '';
		}	
		
		$taxonomies = get_taxonomies();
		if (in_array($type, $taxonomies)) {
			$import_type = $type;
			if($import_type == 'category' || $import_type == 'product_category' || $import_type == 'product_cat' || $import_type == 'wpsc_product_category' || $import_type == 'event-categories'):
				$type = 'Categories';
			elseif($import_type == 'product_tag' || $import_type == 'event-tags' || $import_type == 'post_tag'):
				$type = 'Tags';
			else:
			$type = 'Taxonomies';
		endif;
		}
		$post_id = isset($result['ID']) ? $result['ID'] :'';
		if($type == 'elementor_library'){
			$elementor_import=new ElementorImport;
			$elementor_import->set_elementor_values($header_array ,$value_array , $map, $post_id , $type, $mode, $line_number , $hash_key);
			wp_die();
		}
		if(($type == 'WooCommerce Product') || ($type == 'WooCommerce Product Variations')|| ($type == 'Categories') || ($type == 'Tags') || ($type == 'Taxonomies') || ($type == 'Comments') || ($type == 'Users') || ($type == 'Customer Reviews') || ($type == 'lp_order') || ($type == 'nav_menu_item') || ($type == 'widgets')){

			$comments_instance = CommentsImport::getInstance();
			$customer_reviews_instance = CustomerReviewsImport::getInstance();
			$learnpress_instance = LearnPressImport::getInstance();
			$taxonomies_instance = TaxonomiesImport::getInstance();
			
			$post_values = [];
			$post_values = $helpers_instance->get_header_values($map , $header_array , $value_array);
			$wpml_values = $helpers_instance->get_header_values($wpml_array , $header_array , $value_array);
			if($type == 'WooCommerce Product'){
				$result = $uci_woocomm_instance->woocommerce_product_import($post_values , $mode , $check , $unikey_value , $unikey_name , $hash_key, $line_number, $unmatched_row, $wpml_values);
			}
			if($type == 'WooCommerce Orders'){
				$result = $woocommerce_core_instance->woocommerce_orders_import($post_values , $mode , $check , $unikey_value ,$unikey_name, $line_number);
			}
			if($type == 'WooCommerce Product Variations'){
				$result = $uci_woocomm_instance->woocommerce_variations_import($post_values , $mode , $check ,$unikey_value ,  $unikey_name, $line_number, $variation_count);
			}
			if($type == 'WooCommerce Coupons'){
				$result = $woocommerce_core_instance->woocommerce_coupons_import($post_values , $mode , $check , $unikey_value , $unikey_name, $line_number);
			}
			if($type == 'WooCommerce Refunds'){
				$result = $woocommerce_core_instance->woocommerce_refunds_import($post_values , $mode , $check , $unikey_value , $unikey_name, $line_number);
			}
			if(($type == 'Categories') || ($type == 'Tags')){
				$result = $taxonomies_instance->taxonomies_import_function($post_values , $mode , $import_type , $unmatched_row, $check , $unikey_value , $unikey_name ,$line_number ,$header_array ,$value_array);
			}
			if($type == 'Users'){
				$result = $userimp_class->users_import_function($post_values , $mode ,$unikey_value , $unikey_name , $line_number);
			}
			if($type == 'Comments'){
				$result = $comments_instance->comments_import_function($post_values , $mode ,$unikey_value , $unikey_name , $line_number);
			}
			if($type == 'Customer Reviews'){
				$result = $customer_reviews_instance->customer_reviews_import($post_values , $mode , $check ,$unikey_value , $unikey_name , $line_number);
			}
			if($type == 'lp_order'){
				$result = $learnpress_instance->learnpress_orders_import($post_values , $mode ,$unikey_value , $unikey_name , $line_number);
			}
			if($type == 'nav_menu_item'){
				$comments_instance->menu_import_function($post_values , $mode ,$unikey_value , $unikey_name, $line_number);
			}
			if($type == 'widgets'){
				$comments_instance->widget_import_function($post_values , $mode ,$unikey_value , $unikey_name , $line_number);
			}

			$last_import_id = isset($result['ID']) ? $result['ID'] : '';
			$post_id = isset($result['ID']) ? $result['ID'] :'';
			if($gmode != 'CLI')
			$helpers_instance->get_post_ids($post_id ,$hash_key);

			if((isset($post_values['featured_image'])) && !is_plugin_active('featured-image-from-url/featured-image-from-url.php')) {	
				if (strpos($post_values['featured_image'], '|') !== false) {
					$featured_img = explode('|', $post_values['featured_image']);
					$featured_image=$featured_img[0];					
				}
				else if (strpos($post_values['featured_image'], ',') !== false) {
					$feature_img = explode(',', $post_values['featured_image']);
					$featured_image=$feature_img[0];
				}
				else{
					$featured_image=$post_values['featured_image'];
				}
				if ( preg_match_all( '/\b[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $featured_image, $matchedlist, PREG_PATTERN_ORDER ) ) {	
					$image_type = 'Featured';		
					$attach_id = CoreFieldsImport::$media_instance->media_handling( $featured_image , $post_id ,$post_values,$type,$image_type,$hash_key,$templatekey,$header_array,$value_array);	
				}
			}	

			if(preg_match("(Can't|Skipped|Duplicate)", $this->detailed_log[$line_number]['Message']) === 0) {  
				if ( $type == 'WooCommerce Product') {
					if ( ! isset( $post_values['post_title'] ) ) {
						$post_values['post_title'] = '';
					}
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_permalink( $post_id ) . "' target='_blank' title='" . esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $post_values['post_title'] ) ) . "'rel='permalink'>Web View</a> | <a href='" . get_edit_post_link( $post_id, true ) . "'target='_blank' title='" . esc_attr( 'Edit this item' ) . "'>Admin View</a>";
				}
				elseif( $type == 'Users'){
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_edit_user_link( $post_id , true ) . "' target='_blank' title='" . esc_attr( 'Edit this item' ) . "'> User Profile </a>";
				}
				elseif($type == 'Tags' || $type == 'Categories' || $type == 'post_tag' || $type =='Post_category'){
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_edit_term_link( $post_id, $import_type ) . "'target='_blank' title='" . esc_attr( 'Edit this item' ) . "'>Admin View</a>";
				}
				elseif($type == 'lp_order'){
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_edit_post_link( $post_id, true ) . "'target='_blank' title='" . esc_attr( 'Edit this item' ) . "'>Admin View</a>";
				}
				elseif($type == 'WooCommerce Product Variations' ){
					$post_values['post_title']=isset($post_values['post_title'])?$post_values['post_title']:'';
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_permalink( $post_id ) . "' target='_blank' title='" . esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $post_values['post_title'] ) ) . "'rel='permalink'>Web View</a> ";
				}
				elseif($type != 'nav_menu_item' && isset($post_values['post_title'])){
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_permalink( $post_id ) . "' target='_blank' title='" . esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $post_values['post_title'] ) ) . "'rel='permalink'>Web View</a> | <a href='" . get_edit_post_link( $post_id, true ) . "'target='_blank' title='" . esc_attr( 'Edit this item' ) . "'>Admin View</a>";
				}
				elseif($type == 'Comments'){					
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_comment_link( $post_id ) . "' target='_blank' title='" . esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $post_values['post_title'] ) ) . "'rel='permalink'>Web View</a> | <a href='" . get_edit_comment_link( $post_id, true ) . "'target='_blank' title='" . esc_attr( 'Edit this item' ) . "'>Admin View</a>";
				}
				if(isset($post_values['post_status'])){

					$this->detailed_log[$line_number]['  Status'] = $post_values['post_status'];
				}	
			}

			return $post_id;

		}
		else{
			$current_user = wp_get_current_user();
		    $current_user_role = $current_user->roles[0];
			if($current_user_role == 'administrator'){
			$post_values = [];
			$get_result = null;
			$post_values['post_content'] = '';
			
			$trim_content = array(
				'->static' => '', 
				'->math' => '', 
				'->cus1' => ''
			);

			foreach($map as $header_keys => $value){
				if( strpos($header_keys, '->cus2') !== false) {
					if(!empty($value)){
						$helpers_instance->write_to_customfile($value, $header_array, $value_array);
						unset($map[$header_keys]);
					}
				}
				else{
					$header_trim = strtr($header_keys, $trim_content);
					if($header_trim != $header_keys){
						unset($map[$header_keys]);
					}
					$map[$header_trim] = $value;
				}
			}
		
			foreach($map as $key => $value){
				$csv_value= trim($map[$key]);
				$extension_object = new ExtensionHandler;
				$import_type = $extension_object->import_type_as($type);
				$import_as = $extension_object->import_post_types($import_type );
				if(!empty($csv_value)){

					//$pattern = "/({([a-z A-Z 0-9 | , _ -]+)(.*?)(}))/";
					$pattern1 = '/{([^}]*)}/';
					$pattern2 = '/\[([^\]]*)\]/';

					if(preg_match_all($pattern1, $csv_value, $matches, PREG_PATTERN_ORDER)){	
						
						//check for inbuilt or custom function call -> enclosed in []
						if(preg_match_all($pattern2, $csv_value, $matches2)){
							$matched_element = $matches2[1][0];
							
							foreach($matches[1] as $value){
								$get_value = $helpers_instance->replace_header_with_values($value, $header_array, $value_array);
								$values = '{'.$value.'}';
								$get_value = "'".$get_value."'";
								$matched_element = str_replace($values, $get_value, $matched_element);
							}
						
							$csv_element = @eval("return " . $matched_element . ";" );
						}
						else{

							$csv_element = $csv_value;
							//foreach($matches[2] as $value){
							foreach($matches[1] as $value){
								$get_key = array_search($value , $header_array);
								if(isset($value_array[$get_key])){
									$csv_value_element = $value_array[$get_key];	
									$value = '{'.$value.'}';
									$csv_element = str_replace($value, $csv_value_element, $csv_element);
								}
							}

							$math = 'MATH';
							if (strpos($csv_element, $math) !== false) {	
								$equation = str_replace('MATH', '', $csv_element);
								$csv_element = $helpers_instance->evalmath($equation);
							}
						}
						$wp_element= trim($key);
						if(!empty($csv_element) && !empty($wp_element)){
							$post_values[$wp_element] = $csv_element;
							$post_values['post_type'] = $import_as;
							//$post_values = $this->import_core_fields($post_values);
						}
					}
					// for custom function without headers in it
					elseif(preg_match_all($pattern2, $csv_value, $matches2)){
						$matched_element = $matches2[1][0];

						$wp_element= trim($key);
						$csv_element1 = @eval("return " . $matched_element . ";" );
						$post_values[$wp_element] = $csv_element1;
					}
					elseif(!in_array($csv_value , $header_array)){
						$wp_element= trim($key);
						$post_values[$wp_element] = $csv_value;
						$post_values['post_type'] = $import_as;
						//$post_values = $this->import_core_fields($post_values,$mode);
					}

					else{

						$get_key= array_search($csv_value , $header_array);
						if(isset($value_array[$get_key])){
							$csv_element = $value_array[$get_key];	
							$wp_element= trim($key);
							$extension_object = new ExtensionHandler;
							$import_type = $extension_object->import_type_as($type);
							$import_as = $extension_object->import_post_types($import_type );
							if(!empty($csv_element) && !empty($wp_element)){
								$post_values[$wp_element] = $csv_element;
								$post_values['post_type'] = $import_as;
							//	$post_values = $this->import_core_fields($post_values);
								//if(!is_numeric($post_values['post_parent'])&&!empty($post_values['post_parent'])){
								if( (isset($post_values['post_parent'])) && (!is_numeric($post_values['post_parent'])) && (!empty($post_values['post_parent']))){
									$p_type=$post_values['post_type'];
									$parent_title=$post_values['post_parent'];
									$parent_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_title = '$parent_title' and post_status !='trash' and post_type='$p_type'" );
									$post_values['post_parent']=$parent_id;
								}
							}
						}
					}
				}
			}
			$post_values = $this->import_core_fields($post_values);
			if($check == 'ID'){	
				$ID = $post_values['ID'];	
				$get_result =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE ID = '$ID' AND post_type = '$import_as' AND post_status != 'trash' order by ID DESC ");			
			}
			if($check == 'post_title'){
				$title = $post_values['post_title'];
				$title = $wpdb->_real_escape($title);
				
				if($sitepress != null && is_plugin_active('wpml-ultimate-importer/wpml-ultimate-importer.php')){
					$get_result =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_title = '$title' AND post_type = '$import_as' AND post_status != 'trash' order by ID DESC ");		
					foreach($get_result as $wpml_result){
						$wpml_id[] = $wpml_result->ID;
					}	
					$template_table_name = $wpdb->prefix . "ultimate_csv_importer_mappingtemplate";
					$background_values = $wpdb->get_results("SELECT mapping FROM $template_table_name WHERE `eventKey` = '$hash_key' ");
					foreach ($background_values as $values) {
						$mapped_fields_values = $values->mapping;
					}
					$map_wpml = unserialize($mapped_fields_values);
					
					$wpml_values = $helpers_instance->get_header_values($map_wpml['WPML'], $header_array , $value_array);
					$get_results =array();
					$w = 0;
					foreach($wpml_id as $w_id){
						$languagecode =  $wpdb->get_var("SELECT language_code FROM {$wpdb->prefix}icl_translations WHERE element_id = '$w_id'");		
						if($wpml_values['language_code'] == $languagecode){
							$get_results[$w]['ID']= $w_id;

							$w++;
						}
					}
					foreach($get_results as $g_result){
						$getresult[] = (object) $g_result;
					}
				}
				else{
					$get_result =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_title = '$title' AND post_type = '$import_as' AND post_status != 'trash' order by ID DESC ");		
				}		
			}
			if($check == 'post_name'){
				$name = $post_values['post_name'];
				$get_result =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_name = '$name' AND post_type = '$import_as' AND post_status != 'trash' order by ID DESC ");	
			}
			if($check == 'post_content'){
				$content = $post_values['post_content'];
				$get_result =  $wpdb->get_results("SELECT ID FROM {$wpdb->prefix}posts WHERE post_content = '$content' AND post_type = '$import_as' AND post_status != 'trash' order by ID DESC ");	
			}

			$updated_row_counts = $helpers_instance->update_count($unikey_value,$unikey_name);
			$created_count = $updated_row_counts['created'];
			$updated_count = $updated_row_counts['updated'];
			$skipped_count = $updated_row_counts['skipped'];

			if($mode == 'Insert'){
				$orig_img_src = [];
				if (is_array($get_result) && !empty($get_result)) {
					$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey_value'");
					$this->detailed_log[$line_number]['Message'] =  "Skipped, Due to duplicate found!.";
				}else{

					$media_handle = get_option('smack_image_options');
					if($media_handle['media_settings']['media_handle_option'] == 'true' 
					&& isset($media_handle['media_settings']['enable_postcontent_image'])
					&& $media_handle['media_settings']['enable_postcontent_image'] == 'true'){
						if(preg_match("/<img/", $post_values['post_content'])) {

							$content = "<p>".$post_values['post_content']."</p>";
							$doc = new \DOMDocument();
							if(function_exists('mb_convert_encoding')) {
								@$doc->loadHTML( mb_convert_encoding( $content, 'HTML-ENTITIES', 'UTF-8' ), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
							}else{
								@$doc->loadHTML( $content);
							}
							$searchNode = $doc->getElementsByTagName( "img" );
							if ( ! empty( $searchNode ) ) {
								foreach ( $searchNode as $searchNode ) {
									$orig_img_src[] = $searchNode->getAttribute( 'src' ); 			
									$media_dir = wp_get_upload_dir();
									$names = $media_dir['url'];

									$shortcode_img[] = $orig_img_src;

									$temp_img = plugins_url("../assets/images/loading-image.jpg", __FILE__);
									$searchNode->setAttribute( 'src', $temp_img);
									//	$searchNode->setAttribute( 'alt', $shortcode_img );

									$orig_img_alt = $searchNode->getAttribute( 'alt' );
									if(!empty($orig_img_alt)){
										$media_handle['postcontent_image_alt'] = $orig_img_alt;
										update_option('smack_image_options', $media_handle);
									}

								}
								$post_content              = $doc->saveHTML();
								$post_values['post_content'] = $post_content;
								$update_content['ID']           = $post_id;
								$update_content['post_content'] = $post_content;
								wp_update_post( $update_content );
							}
						}
					}
					
					if($post_values['post_status']!='delete'){
						if(is_plugin_active('multilanguage/multilanguage.php')) {
							$post_id = $this->multiLang($post_values);
						}
						else if($sitepress != null && is_plugin_active('wpml-ultimate-importer/wpml-ultimate-importer.php')){
							$post_values['post_content']=isset($post_values['post_content'])?$post_values['post_content']:'';
							$post_values['post_content'] = html_entity_decode($post_values['post_content']);
							$active_languages = $wpdb->get_results("SELECT tag FROM {$wpdb->prefix}icl_languages where active = 1");
							foreach($active_languages as $lang){
								$active [] =$lang->tag;
							}
							$template_table_name = $wpdb->prefix . "ultimate_csv_importer_mappingtemplate";
							$background_values = $wpdb->get_results("SELECT mapping FROM $template_table_name WHERE `eventKey` = '$hash_key' ");
							foreach ($background_values as $values) {
								$mapped_fields_values = $values->mapping;
							}
							$map_wpml = unserialize($mapped_fields_values);
							
							$wpml_values = $helpers_instance->get_header_values($map_wpml['WPML'], $header_array , $value_array);
							if(in_array($wpml_values['language_code'],$active)){
								$post_id = wp_insert_post($post_values);
								$status = $post_values['post_status'];
								$update=$wpdb->get_results("UPDATE {$wpdb->prefix}posts set post_status = '$status' where id = $post_id");
							}
							else{
								$wpml_message = "The given language code not configured in WPML";
							}
						}
						else{
							$post_values['post_content']=isset($post_values['post_content'])?$post_values['post_content']:'';
							$post_values['post_content'] = html_entity_decode($post_values['post_content']);													
							$post_id = wp_insert_post($post_values);
						}

						if(!empty($post_values['wp_page_template']) && $type == 'Pages'){
							update_post_meta($post_id, '_wp_page_template', $post_values['wp_page_template']);
						}
					}

					if($unmatched_row == 'true'){
						global $wpdb;
						$post_entries_table = $wpdb->prefix ."ultimate_post_entries";
						$file_table_name = $wpdb->prefix."smackcsv_file_events";
						$get_id  = $wpdb->get_results( "SELECT file_name  FROM $file_table_name WHERE `hash_key` = '$hash_key'");	
						$file_name = $get_id[0]->file_name;
						$wpdb->get_results("INSERT INTO $post_entries_table (`ID`,`type`, `file_name`,`status`) VALUES ( '{$post_id}','{$type}', '{$file_name}','Inserted')");
					}

					if(isset($post_values['post_format'])){
						$format=str_replace("post-format-","",$post_values['post_format']);
						set_post_format($post_id ,$format );
					}

					if(is_plugin_active('post-expirator/post-expirator.php')) {
						$this->postExpirator($post_id,$post_values);
					}

					$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE $unikey_name = '$unikey_value'");
					if(preg_match("/<img/", $post_values['post_content'])) {
				
						$shortcode_table = $wpdb->prefix . "ultimate_csv_importer_shortcode_manager";
						
						if(!empty($orig_img_src)){						
							foreach ($orig_img_src as $img => $img_val){
								//$shortcode  = $shortcode_img[$img][$img];
								$shortcode  = 'inline';
								$wpdb->get_results("INSERT INTO $shortcode_table (image_shortcode , original_image , post_id,hash_key,templatekey) VALUES ( '{$shortcode}', '{$img_val}', $post_id  ,'{$hash_key}','{$templatekey}')");
							}
						}
				
						$doc = new \DOMDocument();
						$searchNode = $doc->getElementsByTagName( "img" );
						
						if ( ! empty( $searchNode ) ) {
							foreach ( $searchNode as $searchNode ) {
								$orig_img_src = $searchNode->getAttribute( 'src' ); 
							}
						}			
						
						$media_dir = wp_get_upload_dir();
						$names = $media_dir['url'];
					}
					if(is_wp_error($post_id) || $post_id == '') {
						if(is_wp_error($post_id)) {
							$this->detailed_log[$line_number]['Message'] = "Can't insert this " . $post_values['post_type'] . ". " . $post_id->get_error_message();
						}
						else {
							$wpml_message  = isset($wpml_message )?$wpml_message:'';
							if($sitepress != null && is_plugin_active('wpml-ultimate-importer/wpml-ultimate-importer.php')){
								$this->detailed_log[$line_number]['Message'] =  "Can't insert this " . $post_values['post_type'].'. '.$wpml_message;
							}
							else{
								$this->detailed_log[$line_number]['Message'] =  "Can't insert this " . $post_values['post_type'];
							}
						}
						$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey_value'");
					}	
					else{
						$post_values['specific_author'] = isset($post_values['specific_author'])?$post_values['specific_author']:'';
						$this->detailed_log[$line_number]['Message'] = 'Inserted ' . $post_values['post_type'] . ' ID: ' . $post_id . ', ' . $post_values['specific_author'];
					}
				}
			}

			if($mode == 'Update'){
				if (is_array($get_result) && !empty($get_result)) {
					$post_id = $get_result[0]->ID;	
					$post_values['ID'] = $post_id;
					wp_update_post($post_values);

					if(isset($post_values['post_format'])){
						$format=str_replace("post-format-","",$post_values['post_format']);
						set_post_format($post_id , $format);
					}	

					if($unmatched_row == 'true'){
						global $wpdb;
						$post_entries_table = $wpdb->prefix ."ultimate_post_entries";
						$file_table_name = $wpdb->prefix."smackcsv_file_events";
						$get_id  = $wpdb->get_results( "SELECT file_name  FROM $file_table_name WHERE `hash_key` = '$hash_key'");	
						$file_name = $get_id[0]->file_name;
						$wpdb->get_results("INSERT INTO $post_entries_table (`ID`,`type`, `file_name`,`status`) VALUES ( '{$post_id}','{$type}', '{$file_name}','Updated')");
					}

					$fields = $wpdb->get_results("UPDATE $log_table_name SET updated = $updated_count WHERE $unikey_name = '$unikey_value'");
					$this->detailed_log[$line_number]['Message'] = 'Updated' . $post_values['post_type'] . ' ID: ' . $post_id . ', ' . $post_values['specific_author'];
				}else{

					unset($post_values['ID']);
					$post_id = wp_insert_post($post_values);
					if(isset($post_values['post_format'])){
						$format=str_replace("post-format-","",$post_values['post_format']);
						set_post_format($post_id , $format);
					}
					$fields = $wpdb->get_results("UPDATE $log_table_name SET created = $created_count WHERE $unikey_name = '$unikey_value'");
					if(is_wp_error($post_id) || $post_id == '') {
						if(is_wp_error($post_id)) {
							$this->detailed_log[$line_number]['Message'] = "Can't insert this " . $post_values['post_type'] . ". " . $post_id->get_error_message();
						}
						else {
							$this->detailed_log[$line_number]['Message'] =  "Can't insert this " . $post_values['post_type'];
						}
						$fields = $wpdb->get_results("UPDATE $log_table_name SET skipped = $skipped_count WHERE $unikey_name = '$unikey_value'");
					}
					else{
						$this->detailed_log[$line_number]['Message'] = 'Inserted ' . $post_values['post_type'] . ' ID: ' . $post_id . ', ' . $post_values['specific_author'];
					}
				}
			}

			if(preg_match("(Can't|Skipped|Duplicate)", $this->detailed_log[$line_number]['Message']) === 0) {  
				if ( $type == 'Posts' || $type == 'CustomPosts' || $type == 'Pages') {
					if ( ! isset( $post_values['post_title'] ) ) {
						$post_values['post_title'] = '';
					}
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_permalink( $post_id ) . "' target='_blank' title='" . esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $post_values['post_title'] ) ) . "'rel='permalink'>Web View</a> | <a href='" . get_edit_post_link( $post_id, true ) . "'target='_blank' title='" . esc_attr( 'Edit this item' ) . "'>Admin View</a>";
				}
				else{
					$this->detailed_log[$line_number]['VERIFY'] = "<b> Click here to verify</b> - <a href='" . get_permalink( $post_id ) . "' target='_blank' title='" . esc_attr( sprintf( __( 'View &#8220;%s&#8221;' ), $post_values['post_title'] ) ) . "'rel='permalink'>Web View</a> | <a href='" . get_edit_post_link( $post_id, true ) . "'target='_blank' title='" . esc_attr( 'Edit this item' ) . "'>Admin View</a>";
				}
				$this->detailed_log[$line_number]['  Status'] = $post_values['post_status'];
			}

			if((isset($post_values['featured_image'])) && !is_plugin_active('featured-image-from-url/featured-image-from-url.php')) {
				if (strpos($post_values['featured_image'], '|') !== false) {
					$featured_img = explode('|', $post_values['featured_image']);
					$featured_image=$featured_img[0];					
				}
				else if (strpos($post_values['featured_image'], ',') !== false) {
					$feature_img = explode(',', $post_values['featured_image']);
					$featured_image=$feature_img[0];
				}
				else{
					$featured_image=$post_values['featured_image'];
				}

				if ( preg_match_all( '/\b[-A-Z0-9+&@#\/%=~_|$?!:,.]*[A-Z0-9+&@#\/%=~_|$]/i', $featured_image, $matchedlist, PREG_PATTERN_ORDER ) ) {	
					$image_type = 'Featured';		
					$attach_id = CoreFieldsImport::$media_instance->media_handling( $featured_image , $post_id ,$post_values,$type,$image_type,$hash_key,$header_array,$value_array);	
				}
			}
		}
			return $post_id;
		}
	}

	public function multiLang($post_values){
		global $wpdb;
		if (strpos($post_values['post_title'], '|') !== false) {
			$exploded_title = explode('|', $post_values['post_title']);
			$post_values['post_title'] = $exploded_title[0];
			$lang_title = $exploded_title[1];

		}
		if (strpos($post_values['post_content'], '|') !== false) {
			$exploded_content = explode('|', $post_values['post_content']);
			$post_values['post_content'] = $exploded_content[0];
			$lang_content = $exploded_content[1];
		}
		if (strpos($post_values['post_excerpt'], '|') !== false) {
			$exploded_excerpt = explode('|', $post_values['post_excerpt']);
			$post_values['post_excerpt'] = $exploded_excerpt[0];
			$lang_excerpt = $exploded_excerpt[1];
		}
		$lang_code = $post_values['lang_code'];
		$post_id = wp_insert_post($post_values);
		$wpdb->get_results("INSERT INTO {$wpdb->prefix}mltlngg_translate (post_ID , post_content , post_excerpt, post_title,`language`) VALUES ( $post_id, '{$lang_content}', '{$lang_excerpt}' , '{$lang_title}', '{$lang_code}')");
		return $post_id;
	}

	public function postExpirator($post_id,$post_values){
		if(!empty($post_values['post_expirator_status'])){
			$post_values['post_expirator_status'] = array('expireType' => $post_values['post_expirator_status'],'id' => $post_id);
		}
		else{
			$post_values['post_expirator_status'] = array('expireType' => 'draft' ,'id' => $post_id);
		}

		if(!empty($post_values['post_expirator'])){
			update_post_meta($post_id, '_expiration-date-status', 'saved');
			$estimate_date = $post_values['post_expirator'];
			$estimator_date = get_gmt_from_date("$estimate_date",'U');
			update_post_meta($post_id, '_expiration-date', $estimator_date);
			update_post_meta($post_id, '_expiration-date-options', $post_values['post_expirator_status']);			
		}	
	}

	function image_handling($id){
		global $wpdb;	
		$post_values = [];
		$get_result =  $wpdb->get_results("SELECT post_content FROM {$wpdb->prefix}posts where ID = $id",ARRAY_A);   	
		$post_values['post_content']=htmlspecialchars_decode($get_result[0]['post_content']);
		$get_result =  $wpdb->get_results("SELECT original_image FROM {$wpdb->prefix}ultimate_csv_importer_shortcode_manager where post_id = $id",ARRAY_A);   
		foreach($get_result as $result){
			$orig_img_src[] = $result['original_image'];
		}	

		$get_results =  $wpdb->get_results("SELECT image_shortcode FROM {$wpdb->prefix}ultimate_csv_importer_shortcode_manager where post_id = $id",ARRAY_A);

		foreach ($get_results as $results){
			$origs_img_src[] = $results['image_shortcode'];
		}

		$image_type = 'Inline' ;

		foreach($orig_img_src as $src){
			$attach_id[] = CoreFieldsImport::$media_instance->media_handling($src , $id ,$post_values,'',$image_type,'');	
		}
		if(is_array($attach_id)){
			foreach($attach_id as $att_key => $att_val){
				$get_guid[] = $wpdb->get_results("SELECT `guid` FROM {$wpdb->prefix}posts WHERE post_type = 'attachment' and ID =  $att_val ",ARRAY_A);
				foreach($origs_img_src as $img_src){
					$result  = str_replace($img_src , ' ' , $post_values['post_content']);
				}
			}
		}
		$image_name = $result;
		$doc = new \DOMDocument();
		if(function_exists('mb_convert_encoding')) {
			@$doc->loadHTML( mb_convert_encoding( $image_name, 'HTML-ENTITIES', 'UTF-8' ), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD );
		}else{
			@$doc->loadHTML( $image_name);
		}
		$img_tags = $doc->getElementsByTagName('img');
		$i=0;
		foreach ($img_tags as $t )
		{
			$savepath = $get_guid[$i][0]['guid'];	
			$t->setAttribute('src',$savepath);
			$i++;
		}
		$result = $doc->saveHTML();
		$update_content['ID']           = $id;
		$update_content['post_content'] = $result;
		wp_update_post( $update_content );
		return $id;
	}


	function import_core_fields($data_array){
		$helpers_instance = ImportHelpers::getInstance();

		if(!isset( $data_array['post_date'] )) {
			$data_array['post_date'] = current_time('Y-m-d H:i:s');
		} else {
			if(strtotime( $data_array['post_date'] )) {
				$data_array['post_date'] = date( 'Y-m-d H:i:s', strtotime( $data_array['post_date'] ) );
			} else {
				$data_array['post_date'] = current_time('Y-m-d H:i:s');
			}
		}

		if(!isset($data_array['post_author'])) {
			$data_array['post_author'] = 1;
		} else {
			if(isset( $data_array['post_author'] )) {
				$user_records = $helpers_instance->get_from_user_details( $data_array['post_author'] );
				$data_array['post_author'] = $user_records['user_id'];
				$data_array['specific_author'] = $user_records['message'];
			}
		}
		if ( !empty($data_array['post_status']) ) {

			$data_array = $helpers_instance->assign_post_status( $data_array );
		}else{
			$data_array['post_status'] = 'publish';
		}

		return $data_array;
	}

}
