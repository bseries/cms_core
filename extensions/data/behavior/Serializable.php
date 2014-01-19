<?php

namespace cms_core\extensions\data\behavior;

use Exception;
use lithium\util\Set;

class Serializable extends \li3_behaviors\data\model\Behavior {

	protected $_methods = [];

	protected $_defaults = [
		'fields' => []
	];

	protected function _init() {
		parent::_init();

		$this->_config += $this->_defaults;

		$behavior = $this;
		$model = $this->_model;

		if (isset($this->_config['fields'])) {
			$config['fields'] = Set::normalize($this->_config['fields']);

			foreach ($config['fields'] as $field => &$pass) {
				if (!$pass) {
					$pass = 'json';
				}
			}
		}
		$this->_config = $config;

		$model::applyFilter('save', function($self, $params, $chain) use ($behavior, $config) {
			$model = $self;

			foreach ($config['fields'] as $field => $type) {
				if (!isset($params['data'][$field])) {
					continue;
				}
				$params['data'][$field] = $behavior->invokeMethod('_normalize', [
					$params['data'][$field], $type
				]);
				$params['data'][$field] = $behavior->invokeMethod('_serialize', [
					$params['data'][$field], $type
				]);
			}
			return $chain->next($self, $params, $chain);
		});

		foreach ($this->_config['fields'] as $field => $pass) {
			$this->_methods[$field] = function($entity, array $options = []) use ($behavior, $field, $pass) {
				$options += ['serialized' => true];

				$result = $entity->{$field};
				$result = $behavior->invokeMethod('_normalize', [$result, $pass]);

				if (!$options['serialized']) {
					return $result;
				}
				return $behavior->invokeMethod('_serialize', [$result, $pass]);
			};
		}
	}

	public function respondsTo($method, $internal = false) {
		if (isset($this->_methods[$method])) {
			return true;
		}
		return parent::respondsTo($method, $internal);
	}

	public function __call($method, $params) {
		if (isset($this->_methods[$method])) {
			return $this->_methods[$method]($params[0]);
		}
		parent::__call($method, $params);
	}

	protected function _normalize($value, $pass) {
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
			return $normalize($this->_unserialize($value, $pass));
		} elseif (is_array($value)) {
			return $normalize($value);
		}
		throw new Exception('Field value is in unsupported format.');
	}

	protected function _serialize($value, $type) {
		switch ($type) {
			case 'php':
				return serialize($value);
			case 'json':
				return json_encode($value);
			default:
				return is_array($value) ? implode($type, $value) : $value;
		}
	}

	protected function _unserialize($value, $type) {
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