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

// use \Exception;

class Timestamp extends \li3_behaviors\data\model\Behavior {

	protected $_defaults = [
		'fields' => ['created' => 'created', 'modified' => 'modified']
	];

	protected function _filters($model, $behavior, $config) {
		$model::applyFilter('save', function($self, $params, $chain) use ($behavior) {
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