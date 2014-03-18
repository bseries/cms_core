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

namespace cms_core\extensions\data\behavior;

use Exception;
use lithium\core\Environment;
use NumberFormatter;

class Localizable extends \li3_behaviors\data\model\Behavior {

	protected static $_defaults = [
		'fields' => [],
	];

	protected static function _filters($model, $behavior) {
		$model::applyFilter('save', function($self, $params, $chain) use ($behavior) {
			foreach ($behavior->config('fields') as $field => $type) {
				if (!isset($params['entity']->$field)) {
					continue;
				}
				$params['entity']->$field = static::_normalize($params['entity']->$field, $type);
			}
			return $chain->next($self, $params, $chain);
		});
	}

	protected static function _normalize($value, $type) {
		switch ($type) {
			case 'decimal':
				$formatter = new NumberFormatter(static::_locale(), NumberFormatter::DECIMAL);
				return $value = $formatter->parse($value);
			case 'money':
				$formatter = new NumberFormatter(static::_locale(), NumberFormatter::DECIMAL);
				return (integer) ($formatter->parse($value) * 100);
		}
		throw new Exception('Field value is in unsupported format.');
	}

	protected static function _locale() {
		return Environment::get('locale');
	}

	protected static function _normalizeLocale() {
		return 'en_US';
	}
}

?>