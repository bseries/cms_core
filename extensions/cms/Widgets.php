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
use lithium\util\Inflector;

class Widgets extends \lithium\core\StaticObject {

	const GROUP_NONE = 'none';
	const GROUP_DASHBOARD = 'dashboard';

	const TYPE_COUNT_SINGLE_ALPHA = 'count_single_alpha';
	const TYPE_COUNT_MULTIPLE_BETA = 'count_multiple_beta';
	const TYPE_QUICKDIAL = 'quickdial';

	protected static $_data = [];

	protected static $_sources = [];

	public static function register($library, $name, array $options = []) {
		$options += [
			'type' => null,
			'group' => static::GROUP_NONE,
			'data' => function($renderer) {

			}
		];
		static::$_sources[$name] = $library;
		static::$_data[$name] = compact('name', 'library') + $options;
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