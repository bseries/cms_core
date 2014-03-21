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

class ReferenceNumber extends \li3_behaviors\data\model\Behavior {

	protected static $_defaults = [
		'field' => 'number',
		// Patterns for prefix of the number and the number itself. Parsed
		// with strftime() and insterted using sprintf.
		'pattern' => ['%Y-', '%04.d'],
		// Models to use when calculating the next reference number. If empty
		// will use the current model only.
		//
		// Models must all have the ReferenceNumber behavior attached and
		// should have the same setting for `pattern` otherwise this may
		// lead to unwanted results.
		'models' => []
	];

	protected static function _config($model, $behavior, $config, $defaults) {
		$config = parent::_config($model, $behavior, $config, $defaults);

		if (!$config['models']) {
			$config['models'] = array_merge($config['models'], [$model]);
		}
		return $config;
	}

	protected static function _filters($model, $behavior) {
		$model::applyFilter('save', function($self, $params, $chain) use ($model, $behavior) {
			$field = $behavior->config('field');

			if (!$params['entity']->exists() && empty($params['data'][$field])) {
				$params['data'][$field] = static::_nextReferenceNumber($model, $behavior, $params['entity']);
			}
			return $chain->next($self, $params, $chain);
		});
	}

	protected static function _nextReferenceNumber($model, $behavior, $entity) {
		$data = [];

		foreach ($behavior->config('models') as $model) {
			$behavior = $model::behavior(__CLASS__);

			$field = $behavior->config('field');
			list($prefix, $number) = $behavior->config('pattern');

			$like = static::_buildLike($pattern, $entity);

			if (is_callable($prefix)) {
				$prefix = $prefix($entity);
			} else {
				$prefix = strftime($prefix);
			}

			$item = $model::find('first', [
				'conditions' => [
					'number' => [
						'LIKE' => $prefix . '%'
					]
				],
				'order' => [$field => 'DESC'],
				'fields' => [$field]
			]);
			if ($item) {
				$data[] = $item->$field;
			}
		}
		if (!$data) {
			return $prefix . sprintf($number, 1);
		}
		sort($data);

		$value = array_pop($data);
		$value++; // Cannot use + 1 as PHP behaves differntly then.
		return $value;
	}

	protected static function _buildLike($pattern, $entity) {
		$result = '';

		foreach ($pattern as $p) {
			if (!$p['match']) {
				$result .= $p['regex'];
			} else {
				$result .= $p['value']($entity);
			}
		}
		return $result;
	}

	protected static function _buildLike($pattern, $entity) {
		$result = '';

		foreach ($pattern as $p) {
			if (!$p['match']) {
				$result .= $p['regex'];
			} else {
				$result .= $p['value']($entity);
			}
		}
		return $result;
	}
}

?>