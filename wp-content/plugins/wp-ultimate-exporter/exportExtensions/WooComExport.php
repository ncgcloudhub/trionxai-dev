<?php
/**
 * WP Ultimate Exporter plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\SMEXP;

if ( ! defined( 'ABSPATH' ) )
	exit; // Exit if accessed directly

/**
 * Class WooCommerceExport
 * @package Smackcoders\WCSV
 */
require_once ABSPATH . 'wp-content/plugins/wp-ultimate-exporter/exportExtensions/ElementorExport.php';
class WooCommerceExport extends ExportExtension{

	protected static $instance = null,$mapping_instance,$export_handler,$export_instance,$post_export;
	private $offset = 0;	
	public $limit = 1000;	
	public $totalRowCount;	
	public static function getInstance() {
		if ( null == self::$instance ) {
			self::$instance = new self;
			WooCommerceExport::$export_instance = ExportExtension::getInstance();
			WooCommerceExport::$post_export = PostExport::getInstance();
		}
		return self::$instance;
	}

	/**
	 * WooCommerceExport constructor.
	 */
	public function __construct() {
		$this->plugin = Plugin::getInstance();
	}

	/**
	 * Export woocommerce orders
	 * @param $id
	 * @param $type
	 * @param $optional
	 * @return bool
	 */
	public function getWooComOrderData($id, $type, $optional)
	{
		//	return true;
		global $wpdb;
		$orderid = self::$export_instance->data[$id]['ID'];
		$table1 = $wpdb->prefix."woocommerce_order_items";
		$table2 = $wpdb->prefix."woocommerce_order_itemmeta";
		$query = $wpdb->prepare("SELECT * FROM $table1 where order_id = %d", $orderid);
		$result = $wpdb->get_results($query);
		$order_itemname = $order_itemtype = $product_id = $var_id = $line_subtotal = $line_subtotal_tax = $line_total_tax = $line_total = $line_tax_data = $qty = $tx_cls = "";
		$feename = $feetype = $fee_subtotal = $fee_subtotal_tax = $fee_total_tax = $fee_total = $fee_tax_data = $fee_tx_cls = "";
		$shipname = $method_id = $cost = $taxes = "";
		if(!empty($result)){
			foreach ($result as $key => $value) {
				$orderitem = $value->order_item_id;
				if($value->order_item_type != 'fee' && $value->order_item_type != 'shipping' && $value->order_item_type != ' fee'){
					$order_itemname .= $value->order_item_name.',';
					$order_itemtype .= $value->order_item_type.',';
				}
				if($value->order_item_type == 'fee'){
					$feename .= $value->order_item_name.',';
					$feetype .= $value->order_item_type.',';
				}
				if($value->order_item_type == 'shipping'){
					$shipname .= $value->order_item_name.',';
				}
				$query2 = $wpdb->prepare("SELECT * FROM $table2 where order_item_id = %d", $orderitem);
				$result2 = $wpdb->get_results($query2);
				foreach ($result2 as $key2 => $value2) {
					if($value->order_item_type != 'fee' && $value->order_item_type != 'shipping' && $value->order_item_type != ' fee' ){
						if($value2->meta_key == '_product_id'){
							$product_id .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_variation_id'){
							$var_id .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_subtotal'){
							$line_subtotal .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_subtotal_tax'){
							$line_subtotal_tax .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_total'){
							$line_total .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_tax'){
							$line_total_tax .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_tax_data'){
							$line_tax_data .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_qty'){
							$qty .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_tax_class'){
							$tx_cls .= $value2->meta_value.',';
						}
					}
					if($value->order_item_type == 'fee'){
						if($value2->meta_key == '_line_subtotal'){
							$fee_subtotal .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_subtotal_tax'){
							$fee_subtotal_tax .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_total'){
							$fee_total .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_tax'){
							$fee_total_tax .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_line_tax_data'){
							$fee_tax_data .= $value2->meta_value.',';
						}
						if($value2->meta_key == '_tax_class'){
							$fee_tx_cls .= $value2->meta_value.',';
						}
					}
					if($value->order_item_type == 'shipping'){
						if($value2->meta_key == 'method_id'){
							$method_id .= $value2->meta_value.',';
						}
						if($value2->meta_key == 'cost'){
							$cost .= $value2->meta_value.',';
						}
						if($value2->meta_key == 'taxes'){
							$taxes .= $value2->meta_value.',';
						}
					}
				}
			}
		}
		//itemdata
		self::$export_instance->data[$id]['item_name'] = substr($order_itemname, 0, -1);
		self::$export_instance->data[$id]['item_type'] = substr($order_itemtype, 0, -1);
		self::$export_instance->data[$id]['item_product_id'] = substr($product_id, 0, -1);
		self::$export_instance->data[$id]['item_variation_id'] = substr($var_id, 0, -1);
		self::$export_instance->data[$id]['item_line_subtotal'] = substr($line_subtotal, 0, -1);
		self::$export_instance->data[$id]['item_line_subtotal_tax'] = substr($line_subtotal_tax, 0, -1);
		self::$export_instance->data[$id]['item_line_total'] = substr($line_total, 0, -1);
		self::$export_instance->data[$id]['item_line_tax'] = substr($line_total_tax, 0, -1);
		self::$export_instance->data[$id]['item_line_tax_data'] = substr($line_tax_data, 0, -1);	
		self::$export_instance->data[$id]['item_qty'] = substr($qty, 0, -1);	
		self::$export_instance->data[$id]['item_tax_class'] = substr($tx_cls, 0, -1);
		//fee data
		self::$export_instance->data[$id]['fee_name'] = substr($feename, 0, -1);
		self::$export_instance->data[$id]['fee_type'] = substr($feetype, 0, -1);
		self::$export_instance->data[$id]['fee_line_subtotal'] = substr($fee_subtotal, 0, -1);
		self::$export_instance->data[$id]['fee_line_subtotal_tax'] = substr($fee_subtotal_tax, 0, -1);
		self::$export_instance->data[$id]['fee_line_total'] = substr($fee_total, 0, -1);
		self::$export_instance->data[$id]['fee_line_tax'] = substr($fee_total_tax, 0, -1);
		self::$export_instance->data[$id]['fee_line_tax_data'] = substr($fee_tax_data, 0, -1);	
		self::$export_instance->data[$id]['fee_tax_class'] = substr($fee_tx_cls, 0, -1);
		// shipment data
		self::$export_instance->data[$id]['shipment_name'] = substr($shipname, 0, -1);
		self::$export_instance->data[$id]['shipment_method_id'] = substr($method_id, 0, -1);
		self::$export_instance->data[$id]['shipment_cost'] = substr($cost, 0, -1);	
		self::$export_instance->data[$id]['shipment_taxes'] = substr($taxes, 0, -1);
	}

	/**
	 * Code for Woocommerce Refund export
	 * @param $id
	 * @param $type
	 * @param $optionalType
	 */
	public function getWooComCustomerUser($id, $type, $optionalType)
	{
		global $wpdb;
		$parent = WooCommerceExport::$export_instance->data[$id]['post_parent'];
		$query = $wpdb->prepare("SELECT post_id,meta_key,meta_value FROM {$wpdb->prefix}postmeta where post_id = %d", $parent);
		$result = $wpdb->get_results($query);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				if($value->meta_key == '_customer_user'){
					$cus_user = $value->meta_value;
				}
			}
		}
		WooCommerceExport::$export_instance->data[$id]['customer_user'] = $cus_user;
	}

	/**
	 * Export woocommerce product and variation
	 * @param $id
	 * @param $type
	 * @param $optionalType
	 */
	public function getProductData($id, $type, $optionalType)
	{
		global $wpdb;

		$query = $wpdb->prepare("SELECT post_id,meta_key,meta_value FROM {$wpdb->prefix}postmeta where post_id = %d", $id);
		$result = $wpdb->get_results($query);

		$term_relationship_arr = [];
		$term_relationship = $wpdb->get_results("SELECT term_taxonomy_id FROM {$wpdb->prefix}term_relationships WHERE object_id = $id");
		foreach($term_relationship as $relationship_value){
			$term_relationship_arr[] = $relationship_value->term_taxonomy_id;
		}

		$attname = $attvalue = $attvisible = $attvar = $atttype = $attpos = "";
		$attlabel = $atttaxo = "";

		if(!empty($result)){
			foreach ($result as $key => $value) {

				if($value->meta_key == '_product_attributes'){
					$attArray = unserialize($value->meta_value);

					foreach ($attArray as $key1 => $value1) {

						$pa_value = get_term( $value1['name'] );   
						$result = $wpdb->get_results("SELECT term_id FROM {$wpdb->prefix}term_taxonomy where taxonomy = '{$value1['name']}'",ARRAY_A);
						$attvalues = $attrmeta = '';
						foreach ($result as $key => $value) {
							$value = $value['term_id'];

							if(in_array($value , $term_relationship_arr)){
								$querys = $wpdb->get_results("SELECT name FROM {$wpdb->prefix}terms where  term_id =$value ",ARRAY_A);
								if(!empty($querys['0']['name'])){
									$attvalues .= $querys['0']['name'].'|';
									if (is_plugin_active('variation-swatches-for-woocommerce/variation-swatches-for-woocommerce.php')) {
										$term_meta_id = $wpdb->get_col($wpdb->prepare("select term_id from {$wpdb->prefix}terms where name = %s",$querys['0']['name']));

										$attr_con = $wpdb->get_col($wpdb->prepare("select meta_value from {$wpdb->prefix}termmeta where term_id = %s GROUP BY meta_key HAVING meta_key NOT LIKE 'order_pa%' ",$term_meta_id[0]));
										$meta_value = $attr_con[0];
										if(is_numeric($meta_value)){
											$get_guid =$wpdb->get_results("select guid from {$wpdb->prefix}posts where ID= '$attr_con[0]'" ,ARRAY_A);
											$link =$get_guid[0]['guid'];
											if(!empty($link)){
												$attrmeta .= $link.'|';
											}
											else{
												$attrmeta .= $attr_con[0].'|';

											}
										}
										else{
											$attrmeta .= $attr_con[0].'|';
										}
									}
								}
							}
						}

						if(!empty($attvalues)){
							if (is_plugin_active('variation-swatches-for-woocommerce/variation-swatches-for-woocommerce.php')) {									
								$attvalue .= rtrim($attvalues , '|') . '>'. rtrim($attrmeta , '|'). ',';
							}
							else{
								$attvalue .= rtrim($attvalues , '|') . ',';	
							}
						}

						$get_all_taxonomies =  $wpdb->get_results($query);

						$attriname = substr($value1['name'] , 3);
						$attr_name = $wpdb->get_var("SELECT attribute_label FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = '$attriname' ");

						$attname .= $attr_name.'|';
						$attr_type = $wpdb->get_var("SELECT attribute_type FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = '$attriname' ");	
						$atttype .= $attr_type.'|';
						$attvisible .= $value1['is_visible'].'|';
						$attvar .= $value1['is_variation'].'|';
						$attpos .= $value1['position'].'|';
						$atttaxo .= $value1['is_taxonomy'].'|';

						$attlabel .= $value1['name'].'|';
					}
				}
				if($value->meta_key == '_low_stock_amount'){
					WooCommerceExport::$export_instance->data[$id]['low_stock_threshold'] = $value->meta_value; 
				}
				if($value->meta_key == '_sku'){
					WooCommerceExport::$export_instance->data[$id]['PARENTSKU'] = $value->meta_value; 
				}
				if($value->meta_key == '_sku'){
					WooCommerceExport::$export_instance->data[$id]['PARENTSKU'] = $value->meta_value; 
				}
				if($value->meta_key == '_thumbnail_id'){
					$get_attachment = $wpdb->prepare("select guid from {$wpdb->prefix}posts where ID = %d AND post_type = %s", $value->meta_value, 'attachment');
					$attachment = $wpdb->get_results($get_attachment);
					$value->meta_value = $attachment[0]->guid;
					WooCommerceExport::$export_instance->data[$id]['thumbnail_id'] = $value->meta_value; 
				}
				if($value->meta_key == '_stock'){
					WooCommerceExport::$export_instance->data[$id]['stock_qty'] = $value->meta_value; 
				}
				if($value->meta_key == '_regular_price'){
					WooCommerceExport::$export_instance->data[$id]['regular_price'] = $value->meta_value; 
				}
				if($value->meta_key == '_price'){
					WooCommerceExport::$export_instance->data[$id]['price'] = $value->meta_value; 
				}
				if($value->meta_key == '_sale_price'){
					WooCommerceExport::$export_instance->data[$id]['sale_price'] = $value->meta_value; 
				}
				if($value->meta_key == '_wc_pb_base_regular_price'){
					WooCommerceExport::$export_instance->data[$id]['pb_regular_price'] = $value->meta_value; 
				}
				if($value->meta_key == '_wc_pb_base_sale_price'){
					WooCommerceExport::$export_instance->data[$id]['pb_sale_price'] = $value->meta_value; 
				}
				if($value->meta_key == '_wc_pb_layout_style'){
					$layout = $value->meta_value;
					if($layout == 'default'){
						WooCommerceExport::$export_instance->data[$id]['layout'] = 'Standard';
					}elseif($layout == 'tabular'){
						WooCommerceExport::$export_instance->data[$id]['layout'] = 'Tabular';
					}elseif($layout == 'grid'){
						WooCommerceExport::$export_instance->data[$id]['layout'] = 'Grid';
					}
				}
				if($value->meta_key == '_wc_pb_add_to_cart_form_location'){
					$form_location = $value->meta_value;
					if($form_location == 'default'){
						WooCommerceExport::$export_instance->data[$id]['form_location'] = 'Default';
					}elseif($form_location == 'after_summary'){
						WooCommerceExport::$export_instance->data[$id]['form_location'] = 'Before Tabs';
					}
				}
				if($value->meta_key == '_wc_pb_group_mode'){
					$group_mode = $value->meta_value;
					if($group_mode == 'parent'){
						WooCommerceExport::$export_instance->data[$id]['item_grouping'] = 'Grouped';
					}elseif($group_mode == 'noindent'){
						WooCommerceExport::$export_instance->data[$id]['item_grouping'] = 'Flat';
					}elseif($group_mode == 'none'){
						WooCommerceExport::$export_instance->data[$id]['item_grouping'] = 'None';
					}
				}
				if($value->meta_key == '_wc_pb_edit_in_cart'){
					$edit_cart = $value->meta_value;
					if($edit_cart == 'yes'){
						WooCommerceExport::$export_instance->data[$id]['edit_in_cart'] = 'Yes';
					}elseif($edit_cart == 'no'){
						WooCommerceExport::$export_instance->data[$id]['edit_in_cart'] = 'No';
					}
				}

			}
		}
		if(is_plugin_active('woocommerce-product-bundles/woocommerce-product-bundles.php')){
			$bundle_query = $wpdb->prepare("SELECT product_id FROM {$wpdb->prefix}woocommerce_bundled_items where bundle_id = %d", $id);
			$bundle_results = $wpdb->get_results($bundle_query);

			if(!empty($bundle_results)){
				foreach($bundle_results as $bundle_value){
					$product_bundle_query = $wpdb->prepare("SELECT post_title FROM {$wpdb->prefix}posts where id = %d", $bundle_value->product_id);
					$product_bundle_value=$wpdb->get_results($product_bundle_query);
					$bundle_item[] = $product_bundle_value[0]->post_title;
				}

				$bundle_items = implode('|', $bundle_item);
				WooCommerceExport::$export_instance->data[$id]['product_bundle_items'] = $bundle_items; 
			}

			$bundle_meta = $wpdb->prepare("SELECT bundled_item_id FROM {$wpdb->prefix}woocommerce_bundled_items where bundle_id = %d", $id);
			$bundle_meta_result = $wpdb->get_results($bundle_meta);

			if(!empty($bundle_meta_result)){
				foreach($bundle_meta_result as $bundle_meta_value){
					$bundle_fields = $bundle_meta_value->bundled_item_id;

					$bundle_field = $wpdb->prepare("SELECT meta_key,meta_value FROM {$wpdb->prefix}woocommerce_bundled_itemmeta where bundled_item_id = %d", $bundle_fields);
					$bundle_field_result = $wpdb->get_results($bundle_field);
					if(!empty($bundle_field_result)){
						foreach($bundle_field_result as $bundle_field_value){
							if($bundle_field_value->meta_key == 'optional'){
								$optional = $bundle_field_value->meta_value;
								if($optional == 'yes'){
									$optional_value[] = 'Yes';
								}elseif($optional == 'no'){
									$optional_value[] = 'No';
								}
							}
							if($bundle_field_value->meta_key == 'quantity_min'){
								$q_min[] = $bundle_field_value->meta_value;
							}
							if($bundle_field_value->meta_key == 'quantity_max'){
								$q_max[] = $bundle_field_value->meta_value;
							}
							if($bundle_field_value->meta_key == 'priced_individually'){
								$priced_individually = $bundle_field_value->meta_value;
								if($priced_individually == 'yes'){
									$price_value[] = 'Yes';
								}elseif($priced_individually == 'no'){
									$price_value[] = 'No';
								}
							}
							if($bundle_field_value->meta_key == 'discount'){
								$discount_value[] = $bundle_field_value->meta_value;
							}
							if($bundle_field_value->meta_key == 'single_product_visibility'){
								$single_product_visibility = $bundle_field_value->meta_value;
								if($single_product_visibility == 'visible'){
									$product_value[] = 'Yes';
								}elseif($single_product_visibility == 'hidden'){
									$product_value[] = 'No';
								}
							}
							if($bundle_field_value->meta_key == 'cart_visibility'){
								$cart_visibility = $bundle_field_value->meta_value;
								if($cart_visibility == 'visible'){
									$cart[] = 'Yes';
								}elseif($cart_visibility == 'hidden'){
									$cart[] = 'No';
								}
							}
							if($bundle_field_value->meta_key == 'order_visibility'){
								$order_visibility = $bundle_field_value->meta_value;
								if($order_visibility == 'visible'){
									$order[] = 'Yes';
								}elseif($order_visibility == 'hidden'){
									$order[] = 'No';
								}
							}
							if($bundle_field_value->meta_key == 'hide_thumbnail'){
								$hide_thumbnail = $bundle_field_value->meta_value;
								if($hide_thumbnail == 'yes'){
									$thumb[] = 'Yes';
								}elseif($hide_thumbnail == 'no'){
									$thumb[] = 'No';
								}
							}
							if($bundle_field_value->meta_key == 'override_title'){
								$override_title = $bundle_field_value->meta_value;
								if($override_title == 'yes'){
									$override[] = 'Yes';
								}elseif($override_title == 'no'){
									$override[] = 'No';
								}
							}
							if($bundle_field_value->meta_key == 'override_description'){
								$override_description = $bundle_field_value->meta_value;
								if($override_description == 'yes'){
									$description[] = 'Yes';
								}elseif($override_description == 'no'){
									$description[] = 'No';
								}
							}
							if($bundle_field_value->meta_key == 'title'){
								$override_title_value[] = $bundle_field_value->meta_value;
							}
							if($bundle_field_value->meta_key == 'description'){
								$override_description_value[] = $bundle_field_value->meta_value;
							}
						}
					}
				}

				$optionals = implode('|', $optional_value);
				WooCommerceExport::$export_instance->data[$id]['optional'] = $optionals;
				$q_minimum = implode('|', $q_min);
				WooCommerceExport::$export_instance->data[$id]['quantity_min'] = $q_minimum;
				$q_maximum = implode('|', $q_max);
				WooCommerceExport::$export_instance->data[$id]['quantity_max'] = $q_maximum;
				$price_values = implode('|', $price_value);
				WooCommerceExport::$export_instance->data[$id]['priced_individually'] = $price_values;
				$discount_values = implode('|', $discount_value);
				WooCommerceExport::$export_instance->data[$id]['discount'] = $discount_values;
				$product_values = implode('|', $product_value);
				//WooCommerceExport::$export_instance->data[$id]['product_details'] = $product_values;
				WooCommerceExport::$export_instance->data[$id]['single_product_visibility'] = $product_values;
				$cart_values = implode('|', $cart);
				//WooCommerceExport::$export_instance->data[$id]['cart_checkout'] = $cart_values;
				WooCommerceExport::$export_instance->data[$id]['cart_visibility'] = $cart_values;
				$order_values = implode('|', $order);
				//WooCommerceExport::$export_instance->data[$id]['order_details'] = $order_values;
				WooCommerceExport::$export_instance->data[$id]['order_visibility'] = $order_values;
				$thumbs = implode('|', $thumb);
				WooCommerceExport::$export_instance->data[$id]['hide_thumbnail'] = $thumbs;
				$overrides = implode('|', $override);
				WooCommerceExport::$export_instance->data[$id]['override_title'] = $overrides;
				$descriptions = implode('|', $description);
				WooCommerceExport::$export_instance->data[$id]['override_description'] = $descriptions;
				$override_titles = implode('|', $override_title_value);
				WooCommerceExport::$export_instance->data[$id]['override_title_value'] = $override_titles;
				$override_descriptions = implode('|', $override_description_value);
				WooCommerceExport::$export_instance->data[$id]['override_description_value'] = $override_descriptions;

			}
		}
		WooCommerceExport::$export_instance->data[$id]['product_attribute_name'] = substr($attname, 0, -1);
		WooCommerceExport::$export_instance->data[$id]['product_attribute_type'] = substr($atttype, 0, -1);
		WooCommerceExport::$export_instance->data[$id]['product_attribute_value'] = substr($attvalue, 0, -1);
		WooCommerceExport::$export_instance->data[$id]['product_attribute_visible'] = substr($attvisible, 0, -1);
		WooCommerceExport::$export_instance->data[$id]['product_attribute_variation'] = substr($attvar, 0, -1);
		WooCommerceExport::$export_instance->data[$id]['product_attribute_position'] = substr($attpos, 0, -1);
		WooCommerceExport::$export_instance->data[$id]['product_attribute_taxonomy'] = substr($atttaxo, 0, -1);
		if(!empty($attlabel)){
			$cus = explode('|', substr($attlabel, 0, -1));		
			$cusAttr = "";
			if(!empty($cus[0])){
				foreach ($cus as $cus1) {
					$cusnew =str_replace(' ','-',$cus1);
					$name = 'attribute_'.$cusnew;
					$custname = substr($cus1 , 3);
					$cust_name = $wpdb->get_var("SELECT attribute_label FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = '$custname' ");
					$slug = WooCommerceExport::$export_instance->data[$id][$name];
					$cust_val = $wpdb->get_var("SELECT name FROM {$wpdb->prefix}terms WHERE slug = '$slug' ");
					$cusAttr .= $cust_name.'|'.$cust_val.','; 
				}
			}
			WooCommerceExport::$export_instance->data[$id]['custom_attributes'] = substr($cusAttr, 0, -1);
		}
		$query = $wpdb->prepare("SELECT post_id,meta_key,meta_value FROM {$wpdb->prefix}postmeta where post_id = %d", $id);
		$result = $wpdb->get_results($query);
		if(!empty($result)){
			foreach ($result as $key => $value) {
				if($value->meta_key == '_sale_price_dates_from'){
					$woo_sales_price_dates_value = '';
					if(!empty($value->meta_value)){
						$woo_sales_price_dates_value = date('Y-m-d', $value->meta_value);
					}
					WooCommerceExport::$export_instance->data[$id]['sale_price_dates_from'] =  $woo_sales_price_dates_value;
				}
				if($value->meta_key == '_sale_price_dates_to'){
					$woo_sales_price_datesto_value = '';
					if(!empty($value->meta_value)){
						$woo_sales_price_datesto_value = date('Y-m-d', $value->meta_value);
					}
					WooCommerceExport::$export_instance->data[$id]['sale_price_dates_to'] = $woo_sales_price_datesto_value;
				}
				if($value->meta_key == '_downloadable_files'){
					$downfiles = unserialize($value->meta_value);
					$down_file = '';
					if(!empty($downfiles)){
						foreach($downfiles as $dk => $dv){
							$down_file .= $dv['name'].','.$dv['file'].'|';
						}
					}
					WooCommerceExport::$export_instance->data[$id]['downloadable_files'] = rtrim($down_file,"|");
				}
				if($value->meta_key == '_variation_description'){
					WooCommerceExport::$export_instance->data[$id]['description'] = $value->meta_value;
				}
				if($value->meta_key == '_sku'){
					WooCommerceExport::$export_instance->data[$id]['sku'] = $value->meta_value;
				}
			}
		}
		if($type == 'WooCommerce'){
			$product = new \WC_Product($id);
			$get_catalog_visibility = $product->get_catalog_visibility();
			if($get_catalog_visibility == 'visible'){
				WooCommerceExport::$export_instance->data[$id]['visibility'] = '1';
			}
			elseif($get_catalog_visibility == 'catalog'){
				WooCommerceExport::$export_instance->data[$id]['visibility'] = '2';
			}
			elseif($get_catalog_visibility == 'search'){
				WooCommerceExport::$export_instance->data[$id]['visibility'] = '3';
			}
			elseif($get_catalog_visibility == 'hidden'){
				WooCommerceExport::$export_instance->data[$id]['visibility'] = '4';
			}
			$result = $wpdb->get_results("SELECT *
				FROM {$wpdb->prefix}terms as t
				JOIN {$wpdb->prefix}term_taxonomy AS tt ON t.term_id = tt.term_id
				JOIN {$wpdb->prefix}term_relationships AS tr ON tt.term_taxonomy_id = tr.term_taxonomy_id
				WHERE t.name = 'featured'
				AND tr.object_id = $id");
			if(!empty($result)){
				WooCommerceExport::$export_instance->data[$id]['featured_product'] = '1';
			}
		}

		$product_type = WooCommerceExport::$export_instance->data[$id]['product_type'];
		if($product_type == 'simple'){
			WooCommerceExport::$export_instance->data[$id]['product_type'] = '1';
		}elseif($product_type == 'grouped'){
			WooCommerceExport::$export_instance->data[$id]['product_type'] = '2';
		}elseif($product_type == 'external'){
			WooCommerceExport::$export_instance->data[$id]['product_type'] = '3';
		}elseif($product_type == 'variable'){
			WooCommerceExport::$export_instance->data[$id]['product_type'] = '4';
		}elseif($product_type == 'bundle'){
			WooCommerceExport::$export_instance->data[$id]['product_type'] = '7';
		}
	}

	/**
	 * Fetch Terms & Taxonomies
	 * @param $mode
	 * @param $module
	 * @param $optionalType
	 * @return array
	 */
	public function FetchTaxonomies($module, $optionalType, $mode = null) {

		global $wpdb;
		$terms_table = $wpdb->prefix."terms";
		$terms_taxo_table = $wpdb->prefix."term_taxonomy";
		self::$export_instance->generateHeaders($module, $optionalType);
		$taxonomy = $optionalType;
		$query = $wpdb->prepare("SELECT * FROM $terms_table t INNER JOIN $terms_taxo_table tax ON `tax`.term_id = `t`.term_id WHERE `tax`.taxonomy = %s ", $taxonomy);

		$get_all_taxonomies =  $wpdb->get_results($query);
		self::$export_instance->totalRowCount = count($get_all_taxonomies);
		if(!empty($get_all_taxonomies)) {
			foreach( $get_all_taxonomies as $termKey => $termValue ) {
				$termID = $termValue->term_id;
				$termMeta = get_term_meta($termID);
				//wpsc_meta data starts
				if(in_array('wp-e-commerce/wp-shopping-cart.php', self::$export_instance->get_active_plugins())) {
					$wpsc_query = $wpdb->prepare("select meta_key,meta_value from {$wpdb->prefix}wpsc_meta where object_id = %d AND object_type = %s", $termID, 'wpsc_category');
					$wpsc_meta = $wpdb->get_results($wpsc_query,ARRAY_A);
					foreach($wpsc_meta as $mk => $mv){
						if($mv['meta_key'] == 'image'){
							if($mv['meta_value']){
								$udir = wp_upload_dir();
								$img_path = $udir['baseurl'] . "/wpsc/category_images/".$mv['meta_value'];
								self::$export_instance->data[$termID]['category_image'] = $img_path; 
							}else{
								self::$export_instance->data[$termID]['category_image'] = ''; 
							}
						}elseif($mv['meta_key'] == 'display_type'){
							self::$export_instance->data[$termID]['catelog_view'] = $mv['meta_value'];
						}elseif($mv['meta_key'] == 'uses_billing_address'){
							self::$export_instance->data[$termID]['address_calculate'] = $mv['meta_value'];                                           			       }elseif($mv['meta_key'] == 'image_width'){
							self::$export_instance->data[$termID]['category_image_width'] = $mv['meta_value'];                                                                      }elseif($mv['meta_key'] == 'image_height'){
							self::$export_instance->data[$termID]['category_image_height'] = $mv['meta_value'];                                                                     }else{
							self::$export_instance->data[$termID][$mv['meta_key']] = $mv['meta_value'];
						}
					}
				}
				//wpsc_meta data ends
				//woocommerce meta data starts
				if(in_array('woocommerce/woocommerce.php', self::$export_instance->get_active_plugins())){
					if(isset($termMeta['thumbnail_id'][0])){
						$thum_id = $termMeta['thumbnail_id'][0];
						self::$export_instance->data[$termID]['image'] = self::$export_instance->getAttachment($thum_id);
					}
					if(!empty($termMeta['display_type'][0])){
						self::$export_instance->data[$termID]['display_type'] = $termMeta['display_type'][0];
					}
					if(!empty($termMeta['cat_meta'][0])){
						$cat_meta = unserialize($termMeta['cat_meta'][0]);
						self::$export_instance->data[$termID]['top_content'] = $cat_meta['cat_header'];
						self::$export_instance->data[$termID]['bottom_content'] = $cat_meta['cat_footer'];
					}
				}
				//woocommerce meta data ends
				$termName = $termValue->name;
				$termSlug = $termValue->slug;
				$termDesc = $termValue->description;
				$termParent = $termValue->parent;
				if($termParent == 0) {
					self::$export_instance->data[$termID]['name'] = $termName;
				} else {
					$termParentName = get_cat_name( $termParent );
					self::$export_instance->data[$termID]['name'] = $termParentName . '|' . $termName;
				}
				self::$export_instance->data[$termID]['slug'] = $termSlug;
				self::$export_instance->data[$termID]['description'] = $termDesc;
				self::$export_instance->data[$termID]['TERMID'] = $termID;
				self::$export_instance->data[$termID]['parent'] = $termParent;
				self::$export_instance->getWPMLData($termID,$optionalType,$module);

				WooCommerceExport::$post_export->getPostsMetaDataBasedOnRecordId($termID, $module, $optionalType);

				if(in_array('wordpress-seo/wp-seo.php', self::$export_instance->get_active_plugins())) {
					$seo_yoast_taxonomies = get_option( 'wpseo_taxonomy_meta' );
					if ( isset( $seo_yoast_taxonomies[$optionalType] ) ) {
						self::$export_instance->data[ $termID ]['title'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_title'];
						self::$export_instance->data[ $termID ]['meta_desc'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_desc'];
						self::$export_instance->data[ $termID ]['canonical'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_canonical'];
						self::$export_instance->data[ $termID ]['bctitle'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_bctitle'];
						self::$export_instance->data[ $termID ]['meta-robots-noindex'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_noindex'];
						self::$export_instance->data[ $termID ]['sitemap-include'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_sitemap_include'];
						self::$export_instance->data[ $termID ]['opengraph-title'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_opengraph-title'];
						self::$export_instance->data[ $termID ]['opengraph-description'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_opengraph-description'];
						self::$export_instance->data[ $termID ]['opengraph-image'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_opengraph-image'];
						self::$export_instance->data[ $termID ]['twitter-title'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_twitter-title'];
						self::$export_instance->data[ $termID ]['twitter-description'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_twitter-description'];
						self::$export_instance->data[ $termID ]['twitter-image'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_twitter-image'];
						self::$export_instance->data[ $termID ]['focus_keyword'] = $seo_yoast_taxonomies[$optionalType][$termID]['wpseo_focuskw'];

					}
				}
			}
		}

		$result = self::$export_instance->finalDataToExport(self::$export_instance->data , $module);
		if($mode == null)
			self::$export_instance->proceedExport($result);
		else
			return $result;
	}

	public function getCourseData($id)
	{
		global $wpdb;

		$get_section_details = $wpdb->get_results("SELECT section_id, section_name, section_description FROM {$wpdb->prefix}learnpress_sections WHERE section_course_id = $id ", ARRAY_A);
		$section_names = '';
		$section_descriptions = '';
		$get_lesson_name = '';
		$get_lesson_description = '';
		$get_lesson_duration = '';
		$get_lesson_preview = '';
		$get_quiz_name = '';
		$get_quiz_description = '';
		$get_quiz_meta = [];

		foreach($get_section_details as $section_details){
			$section_names .= $section_details['section_name'] . '|';
			$section_descriptions .= $section_details['section_description'] . '|';

			$section_id = $section_details['section_id'];
			$get_section_item_details = $wpdb->get_results("SELECT item_id, item_type FROM {$wpdb->prefix}learnpress_section_items WHERE section_id = $section_id ", ARRAY_A);

			$lesson_name = '';
			$lesson_description = '';
			$quiz_name = '';
			$quiz_description = '';
			$lesson_duration = '';
			$lesson_preview = '';
			$quiz_metas = [];

			foreach($get_section_item_details as $section_item_details){
				$section_item_id = $section_item_details['item_id'];
				if($section_item_details['item_type'] == 'lp_lesson'){
					$lesson_name .= $wpdb->get_var("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = $section_item_id ") . ', ';
					$lesson_description .= $wpdb->get_var("SELECT post_content FROM {$wpdb->prefix}posts WHERE ID = $section_item_id "). ', ';
					$lesson_duration .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $section_item_id AND meta_key = '_lp_duration' ") . ', ';
					$lesson_preview .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $section_item_id AND meta_key = '_lp_preview' ") . ', ';
				}
				elseif($section_item_details['item_type'] == 'lp_quiz'){
					$quiz_name .= $wpdb->get_var("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = $section_item_id ") . ', ';
					$quiz_description .= $wpdb->get_var("SELECT post_content FROM {$wpdb->prefix}posts WHERE ID = $section_item_id "). ', ';

					$quiz_meta = $wpdb->get_results("SELECT meta_key, meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $section_item_id AND meta_key LIKE '_lp_%' ", ARRAY_A);
					foreach($quiz_meta as $quiz_meta_values){
						$quiz_key = $quiz_meta_values['meta_key'];
						$quiz_value = $quiz_meta_values['meta_value'] . ', ';

						if($quiz_key != '_lp_hidden_questions'){
							if($quiz_key == '_lp_retake_count'){
								$quiz_key = '_lp_quiz_retake_count';
							}
							$quiz_metas[$quiz_key] = $quiz_value;
						}
					}
				}
			}

			$get_lesson_name .= rtrim($lesson_name, ', ') . '|';
			$get_lesson_description .= rtrim($lesson_description, ', ') . '|';
			$get_quiz_name .= rtrim($quiz_name, ', ') . '|';
			$get_quiz_description .= rtrim($quiz_description, ', ') . '|';
			$get_lesson_duration .= rtrim($lesson_duration, ', ') . '|';
			$get_lesson_preview .= rtrim($lesson_preview, ', ') . '|';

			foreach($quiz_metas as $quiz_meta_keys => $quiz_meta_values){	
				$get_quiz_meta[$quiz_meta_keys] = rtrim($quiz_meta_values, ', ') . '|';
			}
		}

		WooCommerceExport::$export_instance->data[$id]['curriculum_name'] = rtrim($section_names, '|');
		WooCommerceExport::$export_instance->data[$id]['curriculum_description'] = rtrim($section_descriptions, '|');
		WooCommerceExport::$export_instance->data[$id]['lesson_name'] = rtrim($get_lesson_name, '|');
		WooCommerceExport::$export_instance->data[$id]['lesson_description'] = rtrim($get_lesson_description, '|');
		WooCommerceExport::$export_instance->data[$id]['quiz_name'] = rtrim($get_quiz_name, '|');
		WooCommerceExport::$export_instance->data[$id]['quiz_description'] = rtrim($get_quiz_description, '|');
		WooCommerceExport::$export_instance->data[$id]['_lp_lesson_duration'] = rtrim($get_lesson_duration, '|');
		WooCommerceExport::$export_instance->data[$id]['_lp_preview'] = rtrim($get_lesson_preview, '|');

		foreach($get_quiz_meta as $get_quiz_meta_keys => $get_quiz_meta_values){
			WooCommerceExport::$export_instance->data[$id][$get_quiz_meta_keys] = rtrim($get_quiz_meta_values, '|');
		}
	}

	public function getLessonData($id){
		global $wpdb;
		$lesson_duration = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id AND meta_key = '_lp_duration' ");
		WooCommerceExport::$export_instance->data[$id]['_lp_lesson_duration'] = $lesson_duration;

		$get_section_id = $wpdb->get_var("SELECT section_id FROM {$wpdb->prefix}learnpress_section_items WHERE item_id = $id AND item_type = 'lp_lesson' ");
		if(!empty($get_section_id)){
			$get_section_name = $wpdb->get_var("SELECT section_name FROM {$wpdb->prefix}learnpress_sections WHERE section_id = $get_section_id ");
			$get_section_course_id = $wpdb->get_var("SELECT section_course_id FROM {$wpdb->prefix}learnpress_sections WHERE section_id = $get_section_id ");

			WooCommerceExport::$export_instance->data[$id]['curriculum_name'] = $get_section_name;
			WooCommerceExport::$export_instance->data[$id]['course_id'] = $get_section_course_id;
		}
	}

	public function getQuizData($id){
		global $wpdb;
		$quiz_retake_count = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id AND meta_key = '_lp_retake_count' ");
		WooCommerceExport::$export_instance->data[$id]['_lp_quiz_retake_count'] = $quiz_retake_count;

		$get_section_id = $wpdb->get_var("SELECT section_id FROM {$wpdb->prefix}learnpress_section_items WHERE item_id = $id AND item_type = 'lp_quiz' ");
		if(!empty($get_section_id)){
			$get_section_name = $wpdb->get_var("SELECT section_name FROM {$wpdb->prefix}learnpress_sections WHERE section_id = $get_section_id ");
			$get_section_course_id = $wpdb->get_var("SELECT section_course_id FROM {$wpdb->prefix}learnpress_sections WHERE section_id = $get_section_id ");

			WooCommerceExport::$export_instance->data[$id]['curriculum_name'] = $get_section_name;
			WooCommerceExport::$export_instance->data[$id]['course_id'] = $get_section_course_id;
		}

		$get_question_title = '';
		$get_question_content = '';
		$get_question_mark = '';
		$get_question_explanation = '';
		$get_question_hint = '';
		$get_question_type = '';
		$get_option_value = '';

		$get_question_ids = $wpdb->get_results("SELECT question_id FROM {$wpdb->prefix}learnpress_quiz_questions WHERE quiz_id = $id ", ARRAY_A);
		foreach($get_question_ids as $question_ids){
			$question_id = $question_ids['question_id'];
			$get_question_title .= $wpdb->get_var("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = $question_id ") . ',';
			$get_question_content .= $wpdb->get_var("SELECT post_content FROM {$wpdb->prefix}posts WHERE ID = $question_id ") . ',';

			$get_question_mark .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $question_id AND meta_key = '_lp_mark' ") . ', ';	
			$get_question_explanation .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $question_id AND meta_key = '_lp_explanation' ") . ',';	
			$get_question_hint .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $question_id AND meta_key = '_lp_hint' ") . ',';	
			$get_question_type .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $question_id AND meta_key = '_lp_type' ") . ',';	

			$get_question_options = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}learnpress_question_answers WHERE question_id = $question_id ", ARRAY_A);
			$option_value = '';
			foreach($get_question_options as $question_option){
				if(empty($question_option['is_true'])){
					$question_option['is_true'] = 'no';
				}

				$option_value .= $question_option['title'] .'|'. $question_option['is_true'] . '->';
			}
			$get_option_value .=  rtrim($option_value, '->') . ',';
		}

		WooCommerceExport::$export_instance->data[$id]['question_title'] = rtrim($get_question_title, ',');
		WooCommerceExport::$export_instance->data[$id]['question_description'] = rtrim($get_question_content, ',');
		WooCommerceExport::$export_instance->data[$id]['_lp_mark'] = rtrim($get_question_mark, ', ');
		WooCommerceExport::$export_instance->data[$id]['_lp_explanation'] = rtrim($get_question_explanation, ',');
		WooCommerceExport::$export_instance->data[$id]['_lp_hint'] = rtrim($get_question_hint, ',');
		WooCommerceExport::$export_instance->data[$id]['_lp_type'] = rtrim($get_question_type, ',');
		WooCommerceExport::$export_instance->data[$id]['question_options'] = rtrim($get_option_value, ',');

	}

	public function getQuestionData($id){
		global $wpdb;
		$get_quiz_id = $wpdb->get_var("SELECT quiz_id FROM {$wpdb->prefix}learnpress_quiz_questions WHERE question_id = $id ");

		$get_question_options = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}learnpress_question_answers WHERE question_id = $id ", ARRAY_A);
		$option_value = '';
		foreach($get_question_options as  $question_options){
			if(empty($question_options['is_true'])){
				$question_options['is_true'] = 'no';
			}
			$option_value .= $question_options['title'] .'|'. $question_options['is_true'] . '->';
		}

		if(!empty($get_quiz_id)){
			$get_section_id = $wpdb->get_var("SELECT section_id FROM {$wpdb->prefix}learnpress_section_items WHERE item_id = $get_quiz_id AND item_type = 'lp_quiz' ");
			if(!empty($get_section_id)){
				$get_section_name = $wpdb->get_var("SELECT section_name FROM {$wpdb->prefix}learnpress_sections WHERE section_id = $get_section_id ");
				$get_section_course_id = $wpdb->get_var("SELECT section_course_id FROM {$wpdb->prefix}learnpress_sections WHERE section_id = $get_section_id ");

				WooCommerceExport::$export_instance->data[$id]['curriculum_name'] = $get_section_name;
				WooCommerceExport::$export_instance->data[$id]['course_id'] = $get_section_course_id;
			}
			WooCommerceExport::$export_instance->data[$id]['quiz_id'] = $get_quiz_id;
		}

		WooCommerceExport::$export_instance->data[$id]['question_options'] = rtrim($option_value, '->');
	}

	public function getOrderData($id){
		global $wpdb;

		$order_status = $wpdb->get_var("SELECT post_status FROM {$wpdb->prefix}posts WHERE ID = $id ");
		$order_date = $wpdb->get_var("SELECT post_date FROM {$wpdb->prefix}posts WHERE ID = $id ");
		$order_total = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id AND meta_key = '_order_total' ");
		$order_subtotal = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id AND meta_key = '_order_subtotal' ");
		$user_id = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id AND meta_key = '_user_id' ");

		$get_order_items = $wpdb->get_results("SELECT order_item_id FROM {$wpdb->prefix}learnpress_order_items WHERE order_id = $id ",ARRAY_A);
		$course_id = '';
		$item_quantity = '';
		$item_total = '';
		$item_subtotal = '';
		foreach($get_order_items as $get_order_values){
			$order_item_id = $get_order_values['order_item_id'];

			$course_id .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}learnpress_order_itemmeta WHERE learnpress_order_item_id = $order_item_id AND meta_key = '_course_id' ") . ', ';
			$item_quantity .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}learnpress_order_itemmeta WHERE learnpress_order_item_id = $order_item_id AND meta_key = '_quantity' ") . ', ';
			$item_total .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}learnpress_order_itemmeta WHERE learnpress_order_item_id = $order_item_id AND meta_key = '_subtotal' ") . ', ';
			$item_subtotal .= $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}learnpress_order_itemmeta WHERE learnpress_order_item_id = $order_item_id AND meta_key = '_total' ") . ', ';
		}

		WooCommerceExport::$export_instance->data[$id]['order_status'] = $order_status;
		WooCommerceExport::$export_instance->data[$id]['order_date'] = $order_date;
		WooCommerceExport::$export_instance->data[$id]['_order_total'] = $order_total;
		WooCommerceExport::$export_instance->data[$id]['_order_subtotal'] = $order_subtotal;
		WooCommerceExport::$export_instance->data[$id]['user_id'] = $user_id;
		WooCommerceExport::$export_instance->data[$id]['item_id'] = rtrim($course_id, ', ');
		WooCommerceExport::$export_instance->data[$id]['item_quantity'] = rtrim($item_quantity, ', ');
		WooCommerceExport::$export_instance->data[$id]['_item_total'] = rtrim($item_total, ', ');
		WooCommerceExport::$export_instance->data[$id]['_item_subtotal'] = rtrim($item_subtotal, ', ');	
	}

	public function elementor_export($id){
		$elementorExport = new ElementorExport;
		$variable= $elementorExport->templateExport();
		if(!empty($variable)){
			foreach($variable as $key=>$value){
				if ($value['ID'] == $id) {
					WooCommerceExport::$export_instance->data[$id]['ID'] = $id;
					WooCommerceExport::$export_instance->data[$id]['Template title'] = $value['Template title'];
					WooCommerceExport::$export_instance->data[$id]['Template content'] = $value['Template content'];
					WooCommerceExport::$export_instance->data[$id]['Style'] = $value['Style'];
					WooCommerceExport::$export_instance->data[$id]['Template type'] = $value['Template type'];
					WooCommerceExport::$export_instance->data[$id]['Created time'] = $value['Created time'];
					WooCommerceExport::$export_instance->data[$id]['Created by'] = $value['Created by'];
					WooCommerceExport::$export_instance->data[$id]['Template status'] = $value['Template status'];
					WooCommerceExport::$export_instance->data[$id]['Category'] = $value['Category'];
				}
			}
		}
	}

	public function getCourseDataMasterLMS($id) {
		global $wpdb;

		$get_item_details = $wpdb->get_results("SELECT  item_id, item_title
			FROM {$wpdb->prefix}stm_lms_curriculum_log WHERE course_id = $id", ARRAY_A);


		$curicullam = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='curriculum' ");
		$curicullam_array = explode(',', $curicullam);
		foreach ($curicullam_array as &$value) {
			if (ctype_digit($value)) {
				$value = '';
			}
		}
		$curicullam = implode(',', $curicullam_array);
		$curicullam = trim($curicullam, ',');	
		$curicullam_withoutId = preg_replace('/,{2,}/', ',', $curicullam);

		$faq = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='faq' ");
		$faq_array = json_decode($faq, true);
		$faq_output = '';
		foreach ($faq_array as $faq_item) {
			$faq_output .= 'question:' . $faq_item['question'] . ',answer:' . $faq_item['answer'] . ' | ';
		}
		$faq_output = rtrim($faq_output, ' | ');


		$course_files_pack = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='course_files_pack' ");
		$course_files_pack_array = json_decode($course_files_pack, true);
		$course_files_pack_output = '';
		foreach ($course_files_pack_array as $course_files_pack_item) {
			$course_files_pack_output .= 'course_files_label:' . $course_files_pack_item['course_files_label'];
		}
		$status_dates = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='status_dates' ");
		$status_dates_start = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='status_dates_start' ");
		$views = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='views'");
		$duration_info = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='duration_info'");
		$featured = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='featured'");
		$level = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='level'");
		$current_students = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='current_students'");
		$video_duration = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='video_duration'");
		$price = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='price'");
		$sale_price = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='sale_price'");
		$status = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='status'");
		$expiration_course = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='expiration_course'");		
		$not_membership = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='not_membership'");
		$end_time = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='end_time'");
		$announcement = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='announcement'");
		$course_files_pack = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='course_files_pack'");
		$status_dates_end = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='status_dates_end' ");
		$status_dates_start = date('Y-m-d', $status_dates_start/1000);
		$status_dates_end = date('Y-m-d', $status_dates_end/1000);
		$status_dates_array = explode(',', $status_dates);
		$status_dates_formatted = array();

		foreach ($status_dates_array as $date) {
			$status_dates_formatted[] = date('Y-m-d', $date/1000);
		}

		$status_dates_formatted_str = implode(',', $status_dates_formatted);

		$get_lesson_id = '';
		$get_lesson_name = '';
		$get_quiz_id = '';
		$get_quiz_name = '';

		foreach ($get_item_details as $item_details) {
			$item_id = $item_details['item_id'];

			$lesson_id = '';
			$lesson_name = '';
			$quiz_id = '';
			$quiz_name = '';

			$get_section_item_details = $wpdb->get_results("SELECT distinct item_id, item_type FROM {$wpdb->prefix}stm_lms_curriculum_log WHERE item_id = $item_id ", ARRAY_A);

			foreach ($get_section_item_details as $section_item_details) {
				if ($section_item_details['item_type'] == 'stm-lessons') {
					$lesson_id .= $item_id . ', ';
					$lesson_name .= $wpdb->get_var("SELECT distinct post_title FROM {$wpdb->prefix}posts WHERE ID = $item_id ") . ',';
				} else if ($section_item_details['item_type'] == 'stm-quizzes') {
					$quiz_id .= $item_id . ', ';
					$quiz_name .= $wpdb->get_var("SELECT  distinct post_title FROM {$wpdb->prefix}posts WHERE ID = $item_id ") . ',';
				}
			}

			$get_lesson_id .= rtrim($lesson_id, ', ') . '|';
			$get_lesson_name .= rtrim($lesson_name, ',') . '|';
			$get_quiz_id .= rtrim($quiz_id, ', ') . '|';
			$get_quiz_name .= rtrim($quiz_name, ',') . '|';

			$get_lesson_id = str_replace('||', '|', $get_lesson_id);
			$get_lesson_name = str_replace('||', '|', $get_lesson_name);
			$get_quiz_id = str_replace('||', '|', $get_quiz_id);
			$get_quiz_name = str_replace('||', '|', $get_quiz_name);
		}

		WooCommerceExport::$export_instance->data[$id]['lesson_id'] = $get_lesson_id;
		WooCommerceExport::$export_instance->data[$id]['lesson_name'] = $get_lesson_name;
		WooCommerceExport::$export_instance->data[$id]['quiz_id'] = $get_quiz_id;
		WooCommerceExport::$export_instance->data[$id]['quiz_name'] = $get_quiz_name;
		WooCommerceExport::$export_instance->data[$id]['status_dates'] = $status_dates_formatted_str;
		WooCommerceExport::$export_instance->data[$id]['status_dates_start'] = $status_dates_start;
		WooCommerceExport::$export_instance->data[$id]['status_dates_end'] = $status_dates_end;
		WooCommerceExport::$export_instance->data[$id]['curriculum'] = $curicullam_withoutId;
		WooCommerceExport::$export_instance->data[$id]['video_duration'] = $video_duration;
		WooCommerceExport::$export_instance->data[$id]['views'] = $views;
		WooCommerceExport::$export_instance->data[$id]['price'] = $price;
		WooCommerceExport::$export_instance->data[$id]['sale_price'] = $sale_price;
		WooCommerceExport::$export_instance->data[$id]['status'] = $status;
		WooCommerceExport::$export_instance->data[$id]['expiration_course'] = $expiration_course;
		WooCommerceExport::$export_instance->data[$id]['not_membership'] = $not_membership;
		WooCommerceExport::$export_instance->data[$id]['end_time'] = $end_time;
		WooCommerceExport::$export_instance->data[$id]['announcement'] = $announcement;
		WooCommerceExport::$export_instance->data[$id]['course_files_pack'] = $course_files_pack;
		WooCommerceExport::$export_instance->data[$id]['duration_info'] = $duration_info;
		WooCommerceExport::$export_instance->data[$id]['featured'] = $featured;
		WooCommerceExport::$export_instance->data[$id]['level'] = $level;
		WooCommerceExport::$export_instance->data[$id]['current_students'] = $current_students;
		WooCommerceExport::$export_instance->data[$id]['faq'] = $faq_output;
		WooCommerceExport::$export_instance->data[$id]['course_files_pack'] = $course_files_pack_output;	

	}

	public function getQuestionDataMasterLMS($id) {

		global $wpdb;
		$type = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='type' ");
		$answers = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='answers' ");
		$question_explanation = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='question_explanation' ");
		$question = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='question' ");
		$question_hint = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='question_hint' ");
		$question_view_type = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='question_view_type' ");
		$image = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='image' ");
		$answers = unserialize($answers);
		$answers_string = '';
		foreach ($answers as $answer) {
			$answers_string .= $answer['text'] . ',' . $answer['isTrue'] . '|';
		}

		WooCommerceExport::$export_instance->data[$id]['type'] = $type;
		WooCommerceExport::$export_instance->data[$id]['answers'] = rtrim($answers_string);
		WooCommerceExport::$export_instance->data[$id]['question_explanation'] = $question_explanation;
		WooCommerceExport::$export_instance->data[$id]['question'] = $question;
		WooCommerceExport::$export_instance->data[$id]['question_hint'] = $question_hint;
		WooCommerceExport::$export_instance->data[$id]['question_view_type'] = $question_view_type;
		WooCommerceExport::$export_instance->data[$id]['image'] = $image;		
	}	
	public function orderDataMasterLMS($id) {
		global $wpdb;
		$status = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='status' ");

		WooCommerceExport::$export_instance->data[$id]['status'] = $status;
	}
	public function quizzDataMasterLMS($id) {
		global $wpdb;
		$duration = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='duration' ");
		$thumbnail_id = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='thumbnail_id' ");
		$lesson_excerpt = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_excerpt' ");
		$quiz_style = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='quiz_style' ");
		$correct_answer = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='correct_answer' ");
		$passing_grade = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='passing_grade' ");
		$re_take_cut = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='re_take_cut' ");
		$random_questions = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='random_questions' ");
		$questions = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='questions' ");

		WooCommerceExport::$export_instance->data[$id]['duration'] = $duration;
		WooCommerceExport::$export_instance->data[$id]['thumbnail_id'] = $thumbnail_id;
		WooCommerceExport::$export_instance->data[$id]['lesson_excerpt'] = $lesson_excerpt;
		WooCommerceExport::$export_instance->data[$id]['quiz_style'] = $quiz_style;
		WooCommerceExport::$export_instance->data[$id]['correct_answer'] = $correct_answer;
		WooCommerceExport::$export_instance->data[$id]['passing_grade'] = $passing_grade;
		WooCommerceExport::$export_instance->data[$id]['re_take_cut'] = $re_take_cut;
		WooCommerceExport::$export_instance->data[$id]['random_questions'] = $random_questions;
		WooCommerceExport::$export_instance->data[$id]['questions'] = $questions;
	}	

	public function getLessonDataMasterLMS($id)
	{
		global $wpdb;
		$type = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='type'");
		$duration = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='duration' ");
		$preview = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='preview' ");
		$lesson_excerpt = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_excerpt' ");
		$_thumbnail_id = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='_thumbnail_id' ");
		$video_type = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='video_type' ");
		$lesson_youtube_url = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_youtube_url' ");
		$presto_player_idx = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='presto_player_idx' ");
		$lesson_video = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_video' ");
		$lesson_video_poster = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_video_poster' ");
		$lesson_video_width = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_video_width' ");
		$lesson_shortcode = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_shortcode' ");
		$lesson_embed_ctx = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_embed_ctx' ");
		$lesson_stream_url = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_stream_url' ");
		$lesson_vimeo_url = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_vimeo_url' ");
		$lesson_ext_link_url = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_ext_link_url' ");
		$lesson_files_pack = $wpdb->get_var("SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $id and meta_key='lesson_files_pack' ");

		$lesson_files_pack_array = json_decode($lesson_files_pack, true);
		$lesson_files_pack_output = '';
		foreach ($lesson_files_pack_array as $lesson_files_pack_item) {
			if (!empty($lesson_files_pack_item['closed_tab'])) {
				$lesson_files_pack_output .= 'closed_tab:' . $lesson_files_pack_item['closed_tab'] . ',';
			}
			$lesson_files_pack_output .= 'lesson_files_label:' . $lesson_files_pack_item['lesson_files_label'] . ',';
			$lesson_files_pack_output = rtrim($lesson_files_pack_output, ',');		}
	
			WooCommerceExport::$export_instance->data[$id]['type'] = $type;
			WooCommerceExport::$export_instance->data[$id]['duration'] = $duration;
			WooCommerceExport::$export_instance->data[$id]['preview'] = $preview;
			WooCommerceExport::$export_instance->data[$id]['lesson_excerpt'] = $lesson_excerpt;
			WooCommerceExport::$export_instance->data[$id]['_thumbnail_id'] = $_thumbnail_id;
			WooCommerceExport::$export_instance->data[$id]['video_type'] = $video_type;
			WooCommerceExport::$export_instance->data[$id]['lesson_youtube_url'] = $lesson_youtube_url;
			WooCommerceExport::$export_instance->data[$id]['presto_player_idx'] = $presto_player_idx;
			WooCommerceExport::$export_instance->data[$id]['lesson_video'] = $lesson_video;
			WooCommerceExport::$export_instance->data[$id]['lesson_video_poster'] = $lesson_video_poster;
			WooCommerceExport::$export_instance->data[$id]['lesson_video_width'] = $lesson_video_width;
			WooCommerceExport::$export_instance->data[$id]['lesson_shortcode'] = $lesson_shortcode;
			WooCommerceExport::$export_instance->data[$id]['lesson_embed_ctx'] = $lesson_embed_ctx;
			WooCommerceExport::$export_instance->data[$id]['lesson_stream_url'] = $lesson_stream_url;
			WooCommerceExport::$export_instance->data[$id]['lesson_vimeo_url'] = $lesson_vimeo_url;
			WooCommerceExport::$export_instance->data[$id]['lesson_ext_link_url'] = $lesson_ext_link_url;
			WooCommerceExport::$export_instance->data[$id]['lesson_files_pack'] = $lesson_files_pack_output;
	}


	public function getMenuData($term_id){
		global $wpdb;
		$term_name = get_term( $term_id )->name;
		$get_object_ids = $wpdb->get_results("SELECT p.* FROM {$wpdb->prefix}posts AS p 
			LEFT JOIN {$wpdb->prefix}term_relationships AS tr ON tr.object_id = p.ID
			LEFT JOIN {$wpdb->prefix}term_taxonomy AS tt ON tt.term_taxonomy_id = tr.term_taxonomy_id
			WHERE p.post_type = 'nav_menu_item'
			AND tt.term_id = $term_id ", ARRAY_A);

		$menu_item_types = '';	
		$menu_object_ids = '';
		$menu_objects = '';
		$menu_urls = '';
		foreach($get_object_ids as $object_ids){
			$object_id = $object_ids['ID'];

			$get_object_meta = $wpdb->get_results("SELECT meta_key , meta_value FROM {$wpdb->prefix}postmeta WHERE post_id = $object_id", ARRAY_A);
			$object_meta_key  = array_column($get_object_meta, 'meta_key');
			$object_meta_value  = array_column($get_object_meta, 'meta_value');
			$object_array = array_combine($object_meta_key, $object_meta_value);

			$menu_item_type = $object_array['_menu_item_type'];
			$menu_item_object = $object_array['_menu_item_object'];
			$menu_object_item_id = $object_array['_menu_item_object_id'];

			if(($menu_item_type == 'post_type') && ($menu_item_object == 'post' || $menu_item_object == 'page')){
				$menu_object_item_title = $wpdb->get_var("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = $menu_object_item_id AND post_type = '$menu_item_object' ");
			}
			elseif($menu_item_type == 'custom' && $menu_item_object == 'custom'){
				$menu_object_item_title = $wpdb->get_var("SELECT post_title FROM {$wpdb->prefix}posts WHERE ID = $menu_object_item_id AND post_type = 'nav_menu_item' ");
			}
			elseif($menu_item_type == 'taxonomy'){
				$category_data = get_term_by('id', $menu_object_item_id, $menu_item_object);
				$menu_object_item_title = $category_data->name;
			}
			else{
				$menu_object_item_title = $menu_object_item_id;
			}

			$menu_item_types .= $menu_item_type . ',';
			$menu_object_ids .= $menu_object_item_title . ','; 
			$menu_objects .= $menu_item_object . ','; 
			$menu_urls .= $object_array['_menu_item_url'] . ','; 
		}	

		WooCommerceExport::$export_instance->data[$term_id]['menu_title'] = $term_name;
		WooCommerceExport::$export_instance->data[$term_id]['_menu_item_type'] = rtrim($menu_item_types, ',');
		WooCommerceExport::$export_instance->data[$term_id]['_menu_item_object_id'] = rtrim($menu_object_ids, ',');
		WooCommerceExport::$export_instance->data[$term_id]['_menu_item_object'] = rtrim($menu_objects, ',');
		WooCommerceExport::$export_instance->data[$term_id]['_menu_item_url'] = rtrim($menu_urls, ',');

		$get_nav_options = get_option("nav_menu_options");
		if(!empty($get_nav_options['auto_add'])){
			if(in_array($term_id, $get_nav_options['auto_add'])){
				WooCommerceExport::$export_instance->data[$term_id]['menu_auto_add'] = 'yes';
			}else{
				WooCommerceExport::$export_instance->data[$term_id]['menu_auto_add'] = 'no';
			}
		}
		else{
			WooCommerceExport::$export_instance->data[$term_id]['menu_auto_add'] = 'no';
		}

		$get_navigation_locations = get_nav_menu_locations();
		foreach($get_navigation_locations as $nav_keys => $nav_values){
			if($nav_values == $term_id){
				WooCommerceExport::$export_instance->data[$term_id][$nav_keys] = 'yes';
			}else{
				WooCommerceExport::$export_instance->data[$term_id][$nav_keys] = 'no';
			}
		}
	}

}

global $woocom_exp_class;
$woocom_exp_class = WooCommerceExport::getInstance();
