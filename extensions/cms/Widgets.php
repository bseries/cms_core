<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

namespace cms_core\extensions\cms;

use lithium\util\Set;

class Widgets extends \lithium\core\StaticObject {

	protected static $_data = [];

	protected static $_sources = [];

	public static function register($library, $name, $default) {
		static::$_sources[$name] = $library;
		static::$_data[$name] = $default;
	}

	public static function write($name, $data) {
		static::$_data[$name] = $data;
	}

	public static function read($name = null) {
		if (!$name) {
			return static::$_data;
		}
		return static::$_data[$name];
	}
}

?>