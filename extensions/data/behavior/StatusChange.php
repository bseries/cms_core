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

class StatusChange extends \li3_behaviors\data\model\Behavior {

	protected static $_defaults = [
		'field' => 'status'
	];

	protected static function _filters($model, $behavior) {
		$model::applyFilter('save', function($self, $params, $chain) use ($model, $behavior) {
			$field = $behavior->config('field');

			if (empty($params['data'][$field])) {
				return $chain->next($self, $params, $chain);
			}
			$old = null;

			if ($params['entity']->exists()) {
				// @fixme modified method does not work, why?
				$old = $model::find('first', [
					'conditions' => ['id' => $params['entity']->id],
					'fields' => [$field]
				]);
				if ($old->$field == $params['data'][$field]) {
					return $chain->next($self, $params, $chain);
				}
			}
			if (!$result = $chain->next($self, $params, $chain)) {
				return false;
			}
			return $params['entity']->statusChange(
				$old ? $old->$field : null,
				$params['data'][$field]
			);
		});
	}
}

?>