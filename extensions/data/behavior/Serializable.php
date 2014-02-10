<?php
/**
 * Bureau
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
use lithium\util\Set;

class Serializable extends \li3_behaviors\data\model\Behavior {

	protected function _config($config, $defaults) {
		$config += ['fields' => []];

		foreach (Set::normalize($config['fields']) as $field => &$pass) {
			if (!$pass) {
				$pass = 'json';
			}
		}
		$this->_config = $config;
	}

	protected function _filters($model, $behavior, $config) {
		$model::applyFilter('save', function($self, $params, $chain) use ($behavior, $config) {
			$model = $self;

			foreach ($config['fields'] as $field => $type) {
				if (!isset($params['data'][$field])) {
					continue;
				}
				$params['data'][$field] = $behavior::invokeMethod('_normalize', [
					$params['data'][$field], $type
				]);
				$params['data'][$field] = $behavior::invokeMethod('_serialize', [
					$params['data'][$field], $type
				]);
			}
			return $chain->next($self, $params, $chain);
		});

		$methods = [];
		foreach ($this->_config['fields'] as $field => $pass) {
			$methods[$field] = function($entity, array $options = []) use ($behavior, $field, $pass) {
				$options += ['serialized' => true];

				$result = $entity->{$field};
				$result = $behavior::invokeMethod('_normalize', [$result, $pass]);

				if (!$options['serialized']) {
					return $result;
				}
				return $behavior::invokeMethod('_serialize', [$result, $pass]);
			};
		}
		$model::instanceMethods($methods);
	}

	protected static function _normalize($value, $pass) {
		$normalize = function($values) {
			$values = array_filter(array_map('trim', $values));
			sort($values);

			return $values;
		};

		if (is_object($value)) {
			return $normalize($value->data());
		} elseif ($value === null) {
			return [];
		} elseif (is_string($value)) {
			return $normalize(static::_unserialize($value, $pass));
		} elseif (is_array($value)) {
			return $normalize($value);
		}
		throw new Exception('Field value is in unsupported format.');
	}

	protected static function _serialize($value, $type) {
		switch ($type) {
			case 'php':
				return serialize($value);
			case 'json':
				return json_encode($value);
			default:
				return is_array($value) ? implode($type, $value) : $value;
		}
	}

	protected static function _unserialize($value, $type) {
		switch ($type) {
			case 'php':
				return unserialize($value);
			case 'json':
				return json_decode($value, true);
			default:
				if (!is_string($value)) {
					return $value;
				}
				return explode($type, $value);
		}
	}
}

?>