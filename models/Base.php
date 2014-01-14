<?php

namespace cms_core\models;

class Base extends \lithium\data\Model {

	public static function enum($field, array $options = []) {
		$options += ['map' => true];

		if (!isset(static::$enum[$field])) {
			return false;
		}
		$result = [];

		if ($options['map']) {
			foreach (static::$enum[$field] as $value) {
				if (is_array($options['map']) && isset($options['map'][$value])) {
					$result[$value] = $options['map'][$value];
				} else {
					$result[$value] = $value;
				}
			}
		}
		return $result;
	}
}

?>