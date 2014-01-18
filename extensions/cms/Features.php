<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

namespace cms_core\extensions\cms;

use lithium\core\Environment;

class Features extends \lithium\core\StaticObject {

	protected static $_sources = [];

	public static function register($source, $name, $default) {
		static::$_sources[$name] = $source;
		Environment::set('features.' . $name, $default);
	}

	public static function write($name, $data) {
		Environment::set('features.' . $name, $data);
	}

	public static function enabled($name) {
		return Environment::get('features.' . $name);
	}

	public static function read($name = null) {
		return Environment::get($name ? 'features.' . $name : 'features');
	}
}

?>