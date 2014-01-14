<?php

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
}

?>