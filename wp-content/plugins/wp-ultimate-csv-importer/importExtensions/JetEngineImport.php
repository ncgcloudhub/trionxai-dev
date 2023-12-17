<?php
/******************************************************************************************
 * Copyright (C) Smackcoders. - All Rights Reserved under Smackcoders Proprietary License
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * You can contact Smackcoders at email address info@smackcoders.com.
 *******************************************************************************************/

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

class JetEngineImport {

	private static $instance = null;

	public static function getInstance() {		
		if (JetEngineImport::$instance == null) {
			JetEngineImport::$instance = new JetEngineImport;
		}
		return JetEngineImport::$instance;
	}

    function set_jet_engine_values($header_array ,$value_array , $map, $post_id , $type , $mode, $hash_key,$line_number){
		$post_values = [];
		$helpers_instance = ImportHelpers::getInstance();
		$post_values = $helpers_instance->get_header_values($map , $header_array , $value_array);
		$this->jet_engine_import_function($post_values,$type, $post_id, $mode, $hash_key,$line_number,$header_array,$value_array);
	}

    public function jet_engine_import_function($data_array, $type, $pID ,$mode, $hash_key,$line_number,$header_array,$value_array) 
	{
		global $wpdb;
		$helpers_instance = ImportHelpers::getInstance();
		$jet_data = $this->JetEngineFields($type);
		foreach ($data_array as $dkey => $dvalue) {
			if(array_key_exists($dkey,$jet_data['JE'])){
				if($jet_data['JE'][$dkey]['type'] == 'datetime-local'){					
					$dateformat = 'Y-m-d\TH:m';
					if(!empty($dvalue)){
						$dt_var = trim($dvalue);						
						$datetime = str_replace('/', '-', "$dt_var");

						if($jet_data['JE'][$dkey]['is_timestamp']){
							if(is_numeric($datetime)){
								$date_time_of = $datetime;
							}
							else{
								$date_time_of = strtotime($datetime);
							}
							
						}else{														
							$date_time_of = $helpers_instance->validate_datefield($dt_var,$dkey,$dateformat,$line_number);						
						}
						$darray[$jet_data['JE'][$dkey]['name']] = $date_time_of;
					}
					else{
						$darray[$jet_data['JE'][$dkey]['name']] = '';
					}
				}
				elseif($jet_data['JE'][$dkey]['type'] == 'date'){					
					$dateformat = 'Y-m-d';
					if(!empty($dvalue)){
						$var = trim($dvalue);
						$date = str_replace('/', '-', "$var");
						
						if($jet_data['JE'][$dkey]['is_timestamp']){
							if(is_numeric($date)){
								$date_of = $date;
							}
							else{								
								$date_of = strtotime($date);
							}
						}else{							
							$date_of = $helpers_instance->validate_datefield($var,$dkey,$dateformat,$line_number);
						}
						$darray[$jet_data['JE'][$dkey]['name']] = $date_of;
					}
					else{
						$darray[$jet_data['JE'][$dkey]['name']] = '';
					}
				}
				elseif($jet_data['JE'][$dkey]['type'] == 'time'){
					$var = trim($dvalue);
					$time = date('H:i', strtotime($var));
					$darray[$jet_data['JE'][$dkey]['name']] = $time;
				}
				elseif($jet_data['JE'][$dkey]['type'] == 'checkbox'){
					
					if($jet_data['JE'][$dkey]['is_array'] == 1){
						$arr = explode(',' , $dvalue);
						$darray[$jet_data['JE'][$dkey]['name']] = $arr;
					}
					else{
						$options = $jet_data['JE'][$dkey]['options'];
						$arr = [];
						$opt = [];
						$dvalexp = explode(',' , $dvalue);
						foreach($options as $option_key => $option_val){
							$arr[$option_val['key']] = 'false';
						}
						foreach($dvalexp as $dvalkey => $dvalueval){
							$dvalueval = trim($dvalueval);
							$keys = array_keys($arr);
							foreach($keys as $keys1){
								if($dvalueval == $keys1){
									$arr[$keys1] = 'true';
								}
							}

							//added new checkbox values
							if(!in_array($dvalueval, $keys)){
							
								//$get_meta_fields = $wpdb->get_results("SELECT id, meta_fields FROM {$wpdb->prefix}jet_post_types WHERE slug = '$type' AND status IN ('publish','built-in')");
								$get_meta_fields = $wpdb->get_results( $wpdb->prepare("SELECT option_value FROM {$wpdb->prefix}options WHERE option_name=%s",'jet_engine_meta_boxes'));

								if(isset($get_meta_fields[0])){
									$unserialized_meta = maybe_unserialize($get_meta_fields[0]->option_value);
					
									if(!empty($unserialized_meta)){
										foreach($unserialized_meta as $jet_keys => $jet_values){
											foreach($jet_values['meta_fields'] as $meta_keys => $meta_values){
												$count_jetvalues = 0;
												if($meta_values['type'] == 'checkbox' && $meta_values['name'] == $dkey){
													$count_jetvalues = count($meta_values['options']);
											
													$unserialized_meta[$jet_keys]['meta_fields'][$meta_keys]['options'][$count_jetvalues]['key'] = $dvalueval;
													$unserialized_meta[$jet_keys]['meta_fields'][$meta_keys]['options'][$count_jetvalues]['value'] = $dvalueval;
													$unserialized_meta[$jet_keys]['meta_fields'][$meta_keys]['options'][$count_jetvalues]['id'] = $meta_values['options'][$count_jetvalues - 1]['id'] + 1;	
												}
											}
										}
									
										update_option('jet_engine_meta_boxes', $unserialized_meta);
										$arr[$dvalueval] = 'true';
									}
								}		
							}
						}
						$darray[$jet_data['JE'][$dkey]['name']] = $arr;
					}
				}
				elseif($jet_data['JE'][$dkey]['type'] == 'select'){
					$dselect = [];
					if($jet_data['JE'][$dkey]['is_multiple'] == 0){
						$darray[$jet_data['JE'][$dkey]['name']] = $dvalue;	
					}
					else{
						$exp = explode(',',$dvalue);
						foreach($exp as $exp_values){
							$dselect[] = trim($exp_values);
						}
						//$dselect = $exp;
						$darray[$jet_data['JE'][$dkey]['name']] = $dselect;
					}
				}
                else{
					if($jet_data['JE'][$dkey]['type'] != 'repeater'){
						$darray[$jet_data['JE'][$dkey]['name']] = $dvalue;
					}
				}
				$listTaxonomy = get_taxonomies();
				if($darray){
					if($type == 'Users'){
						foreach($darray as $mkey => $mval){
							update_user_meta($pID, $mkey, $mval);
						}
					}
					elseif(in_array($type, $listTaxonomy)){
						foreach($darray as $mkey => $mval){
							update_term_meta($pID, $mkey, $mval);
						}
					}
					else{
						foreach($darray as $mkey => $mval){
							update_post_meta($pID, $mkey, $mval);
						}
					}

				}
			}
		}
	}

    public function JetEngineFields($type){
		global $wpdb;	
		$jet_field = array();


		$get_meta_box_fields = $wpdb->get_results( $wpdb->prepare("SELECT option_value FROM {$wpdb->prefix}options WHERE option_name=%s",'jet_engine_meta_boxes'));
		$unserialized_meta = maybe_unserialize($get_meta_box_fields[0]->option_value);
		$arraykeys = array_keys($unserialized_meta);

		foreach($arraykeys as $val){
			$values = explode('-',$val);
			$v = $values[1];
		}
		for($i=1 ; $i<=$v ; $i++){
			$meta['meta_fields'] = isset($unserialized_meta['meta-'.$i]['meta_fields']) ? $unserialized_meta['meta-'.$i]['meta_fields'] : '';
			$fields = $meta['meta_fields'];
			if(!empty($fields)){
				foreach($fields as $jet_key => $jet_value){
					$customFields["JE"][ $jet_value['name']]['label'] = $jet_value['title'];
					$customFields["JE"][ $jet_value['name']]['name']  = $jet_value['name'];
					$customFields["JE"][ $jet_value['name']]['type']  = $jet_value['type'];
					$customFields["JE"][ $jet_value['name']]['options'] = isset($jet_value['options']) ? $jet_value['options'] : '';
					$customFields["JE"][ $jet_value['name']]['is_multiple'] = isset($jet_value['is_multiple']) ? $jet_value['is_multiple'] : ' ' ;
					$customFields["JE"][ $jet_value['name']]['value_format'] = isset($jet_value['value_format']) ? $jet_value['value_format'] : '';
					$customFields["JE"][ $jet_value['name']]['is_array'] = isset($jet_value['is_array']) ? $jet_value['is_array'] : '';
				
					if($jet_value['type'] == 'date' || $jet_value['type'] == 'datetime-local'){
						$customFields["JE"][ $jet_value['name']]['is_timestamp'] = isset($jet_value['is_timestamp']) ? $jet_value['is_timestamp'] : '';
					}
				}
			}

		}	
		return $customFields;
	}
}