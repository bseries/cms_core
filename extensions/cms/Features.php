<?php

namespace cms_core\extensions\cms;

class Features extends \lithium\core\StaticObject {

	protected static $_data = [];

	public static function register($name, $default) {
		if (isset(static::$_data[$name])) {
			return;
		}
		static::$_data[$name] = $default;
	}

	public static function set($data) {
		foreach ($data as $name => $flag) {
			if (!isset(static::$_data[$name])) {
				throw new \Exception("Unkown feature `{$name}`.");
			}
			static::$_data[$name] = $flag;
		}
	}

	public static function enabled($name) {
		if (!isset(static::$_data[$name])) {
			throw new \Exception("Unkown feature `{$name}`.");
		}
		return static::$_data[$name];
	}

	public static function all() {
		return static::$_data;
	}
}

?>