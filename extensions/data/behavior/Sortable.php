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

/**
 * Allows for storing a sequential weight value with your entities. And
 * manipulating these if required.
 *
 * By default - when order by weight descending - new entities will
 * receive the highest weight possible and thus be placed at the very
 * beginning of the order.
 *
 * @fixme Currently is tied to sources using database adapters.
 */
class Sortable extends \li3_behaviors\data\model\Behavior {

	/**
	 * Default options.
	 *
	 * `'descend'`: When `true` a highest weight indicates top order position, use it
	 *              when sorting by weight descending and want new entities to be
	 *              inserted at the very top.
	 *              When `false` a highest weight indicates bottom order position, use
	 *              it when sorting by weight asceding and want new entities to
	 *              be inserted at the very bottom.
	 */
	protected $_defaults = [
		'field' => 'order',
		'cluster' => [],
		'descend' => true
	];

	protected function _filters($model, $behavior, $config) {
		$behavior = $this;

		$model::applyFilter('save', function($self, $params, $chain) use ($behavior, $config) {
			if (!$params['entity']->exists()) {
				$cluster = $behavior->_cluster(null, false, $params['data']);
				$params['data'][$config['field']] = $behavior->_highestWeight($cluster) + 1;
			}
			return $chain->next($self, $params, $chain);
		});
	}

	protected function _highestWeight($cluster = []) {
		$model = $this->_model;
		$field = $this->_config['field'];
		$fieldEscaped = $model::connection()->name($field);

		$conditions = $cluster;

		$result = $model::find('first', compact('conditions') + array(
			'fields' => 'MAX(' . $fieldEscaped . ') AS `highest_weight`',
		));
		return current($result->data());
	}

	/**
	 * Updates the weights giving a sequence of ids. Allows for sparse
	 * set. The order of the ids in the sequence dictates the final
	 * order of the corresponding entities _relative_ to each other.
	 *
	 * When `descend` is true, first ID will get the highest weight,
	 * else first ID will get lowest weight.
	 *
	 * Uses transactions automatically for isolation.
	 *
	 * @param array $ids
	 * @return boolean
	 */
	public static function weightSequence($model, $ids) {
		if ($this->_config['descend']) {
			$ids = array_revers($ids);
		}
		$connection = $model::connection()->connection;

		$connection->beginTransaction();
		$cluster = $behavior->_cluster($previous = array_shift($ids));

		foreach (array_reverse($ids) as $id) {
			if (!static::_moveBelow($id, $previous, $cluster)) {
				$connection->rollback();
				return false;
			}
			$previous = $id;
		}
		$connection->commit();
		return true;
	}

	/**
	 * Retrieves missing cluster values, good for using in conditions when updating order.
	 *
	 * @param mixed $id ID of the entity to find exemplaric cluster values for. May be `null`
	 *              if $data already contains all cluster values.
	 * @param boolean $forceFind Forces all cluster values to be retrieved even if contained
	 *                already in $data.
	 * @param array $data Data that already contains (parts of) cluster fields.
	 * @return array Cluster fields with values for $id usable as conditions.
	 */
	protected function _cluster($id = null, $forceFind = false, array $data = []) {
		$model = $this->_model;
		$field = $this->_config['field'];
		$cluster = $this->_config['cluster'];

		$missing = [];
		$conditions = [];

		foreach ($cluster as $field) {
			if (empty($data[$field]) || $forceFind) {
				$missing[] = $field;
			} else {
				$conditions[$field] = $data[$field];
			}
		}
		if ($missing) {
			if (!$id) {
				throw new Exception('Could not determine cluster values.');
			}
			$result = $model::find('first', array(
				'conditions' => compact('id'),
				'fields' => $missing,
				'order' => false
			));
			if (!$result) {
				throw new Exception('Could not determine cluster values.');
			}
			$conditions += $result->data();
			unset($conditions['id']);
		}
		return $conditions;
	}

	/**
	 * Moves an entity below another. Checks if action is required at all first.
	 * Opens a gap, sets weight of entity, filling the gap, then ensuring the gap
	 * is closed correctly.
	 */
	protected static function _moveBelow($id, $belowId, $cluster = []) {
		$field = $this->_config['field'];
		$model = $this->_model;

		$weights = $model::find('list', array(
			'conditions' => array('id' => array($id, $belowId)),
			'fields' => array('id', $field),
			'order' => false
		));
		if (count($weights) != 2) {
			throw new Exception("Could not retrieve weights for id `{$id}` and ``{$belowId}`");
		}

		if ($weights[$id] > $weights[$belowId]) {
			return true;
		}

		if (!static::_openGap($weights[$belowId], $cluster)) {
			return false;
		}
		$result = $model::update(
			[$field => $weights[$belowId] + 1],
			compact('id')
		);
		if (!$result) {
			return false;
		}
		return static::_closeGap($weights[$id], $cluster);
	}

	protected static function _openGap($atWeight, $cluster = []) {
		$model = $this->_model;
		$field = $this->_config['field'];
		$fieldEscaped = $model::connection()->name($field);

		$result = $model::update(
			array($field => $fieldEscaped . ' + 1'),
			array($field . ' >' => $atWeight) + $cluster
		);

		if (!$result) {
			throw new Exception("Failed to create gap below id `{$belowId}`");
		}
		return $result;
	}

	protected static function _closeGap($atWeight, $cluster = []) {
		$model = $this->_model;
		$field = $this->_config['field'];
		$fieldEscaped = $model::connection()->name($field);

		return $model::update(
			array($field => $fieldEscaped . ' - 1'),
			array($fieldEscaped . ' >' => $atWeight) + $cluster
		);
	}
}

?>