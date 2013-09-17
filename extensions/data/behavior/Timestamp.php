<?php

namespace cms_core\extensions\data\behavior;

class Timestamp extends \li3_behaviors\data\model\Behavior {

	protected $_defaults = [
		'fields' => ['created' => 'created', 'modified' => 'modified']
	];

	protected function _init() {
		parent::_init();

		$model = $this->_model;
		$behavior = $this;


		foreach ($this->_config['fields'] as $name => $field) {
			if (!$model::schema()->has($field)) {
				throw new Exception("Model has no {$name} field `{$field}`.");
			}
		}

		$model::applyFilter('create', function($self, $params, $chain) use ($behavior) {
			$params['data'] = $behavior->invokeMethod(
				'_timestamp', [$params['entity'], $params['data']]
			);
			return $chain->next($self, $params, $chain);
		});
	}

	protected function _timestamp($entity, $data) {
		$now = date('Y-m-d H:i:s');

		if (!$entity->exists()) {
			$data[$this->_config['fields']['created']] = $now;
		}
		$data[$this->_config['fields']['modified']] = $now;

		return $data;
	}
}

?>