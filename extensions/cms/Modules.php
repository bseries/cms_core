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

use lithium\util\Inflector;

class Modules extends \lithium\core\StaticObject {

	protected static $_data = [];

	public static function register($library, $name, array $options = []) {
		$options += [
			'title' => Inflector::humanize($name),
			'slug' => strtolower(Inflector::slug($name))
		];
		static::$_data[] = compact('name', 'library') + $options;
	}

	public static function all() {
		return static::$_data;
	}
}

?>