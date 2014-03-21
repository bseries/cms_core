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

class ReferenceNumber extends \li3_behaviors\data\model\Behavior {

	protected static $_defaults = [
		'field' => 'number',
		// Patterns for prefix of the number and the number itself. Parsed
		// with strftime() and insterted using sprintf.
		'pattern' => ['%Y-', '%04.d'],
		// Other models to use when calculating the next reference number.
		// Other models must have the ReferenceNumber behavior attached and
		// should have the same setting for `pattern` otherwise this may
		// lead to unwanted results.
		'models' => []
	];

	protected static function _config($model, $behavior, $config, $defaults) {
		$config += $defaults;
		$config['models'] = array_merge($config['models'], [$model]);

		return $config;
	}

	protected static function _filters($model, $behavior) {
		$model::applyFilter('save', function($self, $params, $chain) use ($model, $behavior) {
			$field = $behavior->config('field');

			if (!$params['entity']->exists()) {
				$params['entity']->$field = static::_nextReferenceNumber($model, $behavior);
			}
			return $chain->next($self, $params, $chain);
		});
	}

	protected static function _nextReferenceNumber($model, $behavior) {
		$data = [];

		foreach ($models as $model) {
			$behavior = $model::behavior(__CLASS__);

			$field = $behavior->config('field');
			list($prefix, $number) = $behavior->config('pattern');

			$item = $model::find('first', [
				'conditions' => [
					'number' => [
						'LIKE' => strftime($prefix) . '%'
					]
				],
				'order' => [$field => 'DESC'],
				'fields' => [$field]
			]);
			if ($item) {
				$data[] = $item;
			}
		}
		if (!$data) {
			return strftime($prefix) . sprintf($number, 1);
		}
		sort($data);

		// Do not modify the object as it's passed by ref.
		$value = array_pop($data)->$field;
		return $value++;
	}
}

?>