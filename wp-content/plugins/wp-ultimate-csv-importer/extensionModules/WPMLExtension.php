<?php
/**
 * WP Ultimate CSV Importer plugin file.
 *
 * Copyright (C) 2010-2020, Smackcoders Inc - info@smackcoders.com
 */

namespace Smackcoders\FCSV;

if ( ! defined( 'ABSPATH' ) )
exit; // Exit if accessed directly

class WPMLExtension extends ExtensionHandler{
	private static $instance = null;

	public static function getInstance() {
		if (WPMLExtension::$instance == null) {
			WPMLExtension::$instance = new WPMLExtension;
		}
		return WPMLExtension::$instance;
	}

	public function processExtension($data) {
		global $uci_wpmlfunction_instance;
		$result = $uci_wpmlfunction_instance->processExtensionFunction($data);
		return $result;
	}

	/**
	 * WPML extension supported import types
	 * @param string $import_type - selected import type
	 * @return boolean
	 */
	public function extensionSupportedImportType($import_type){
		global $sitepress;
		if($sitepress != null && is_plugin_active('wpml-ultimate-importer/wpml-ultimate-importer.php')){
			global $uci_wpmlfunction_instance;
			$result = $uci_wpmlfunction_instance->extensionSupportedImportTypeFunction($import_type);
			if($result == 'true'){
				return true;
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
	}
}