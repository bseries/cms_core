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
use lithium\core\Environment;

class Modules extends \lithium\core\StaticObject {

	public static function register($library, $name, array $options = []) {
		$options += [
			'title' => Inflector::humanize($name),
			'slug' => strtolower(Inflector::slug($name))
		];
		Environmet::set(compact('name', 'library') + $options);
	}

	public static function read($name = null) {
		return Environment::get($name ? 'modules.' . $name : 'modules');
	}
}

?>