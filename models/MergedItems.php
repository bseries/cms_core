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

namespace cms_core\models;

// use cms_article\models\Articles;
use lithium\data\collection\RecordSet;
use DateTime;

class MergedItems extends \lithium\data\Model {

	const PER_PAGE = 10;

	protected $_meta = [
		'connection' => false
	];

	protected static $_models = [];

	public static function registerModel($model) {
		static::$_models[] = $model;
	}

	public static function find($type, array $options = []) {
		if ($type == 'all') {
			$options += ['page' => null]; // pages are *not* zero based

			$lookup = static::_lookup();
			$results = [];

			if ($options['page']) {
				$lookup = array_slice(
					$lookup,
					$options['page'] > 1 ? static::PER_PAGE * $options['page'] : 0,
					static::PER_PAGE
				);
			}
			return static::_convertLookup($lookup);
		} elseif ($type == 'first') {

			$model = static::_modelForType($options['type']);
			unset($options['type']);

			if (!$result = $model::find('first', $options)) {
				return $result;
			}
			return static::_convert($result);
		}
	}

	public static function neighbors($item) {
		$results = array_values(static::_lookup());
		$next = $prev = null;

		for ($k = 0, $c = count($results); $k <= $c; $k++) {
			list($model, $id) = $results[$k];

			if ($item->id !== $id || $model !== $item->original->model()) {
				continue;
			}
			if (isset($results[$k + 1])) {
				list($model, $id) = $results[$k + 1];
				$next = static::_convert($model::find($id));
			}
			if (isset($results[$k - 1])) {
				list($model, $id) = $results[$k - 1];
				$prev = static::_convert($model::find($id));
			}
			break;
		}
		return compact('prev', 'next');
	}

	public static function count() {
		$result = 0;

		foreach (static::$_models as $model) {
			$result += $model::find('count');
		}
		return $result;
	}

	public static function pages() {
		return floor(static::count() / static::PER_PAGE);
	}

	public function __call($method, $args) {
		$entity = array_shift($args);
		return call_user_func_array([$entity->original, $method], $args);
	}

	public static function type($item) {
		list(, $type) = explode('\models\\', strtolower($item->original->model()));
		return $type;
	}

	// @fixme cache this
	/*
	public static function listTags() {
		$results = [];

		foreach (static::$_models as $model) {
			$data = $model::find('all', ['fields' => ['tags']]);

			foreach ($data as $item) {
				$results = array_merge($results, $item->tags(['serialized' => false]));
			}
		}

		$results = array_unique($results);
		sort($results);
		return $results;
	}
	*/

	// @fixme Cache this.
	// @fixme Allow fields config.
	protected static function _lookup() {
		$data = [];

		foreach (static::$_models as $model) {
			if ($model == 'cms_event\models\Events') {
				$fields = ['id', 'start'];
			} else {
				$fields = ['id', 'created'];
			}
			$results = $model::find('all', compact($fields));

			foreach ($results as $result) {
				$data[$model . ':' . $result->id] = [$model, $result->id, $result->date()];
			}
		}

		// Sort by created field descending.
		uasort($data, function($a, $b) {
			return $a[2] > $b[2] ? -1 : 1;
		});
		return $data;
	}

	protected static function _convertLookup($lookup) {
		$map = [];
		foreach ($lookup as $item) {
			list($model, $id) = $item;
			$map[$model][] = $id;
		}
		foreach ($map as $model => $ids) {
			$prefix = basename(str_replace('\\', '/', $model));
			$results = $model::find('all', [
				'conditions' => [$prefix . '.id' => $ids]
			]);

			foreach ($results as $result) {
				$lookup[$model . ':' . $result->id] = static::_convert($result);
			}
		}
		$results = array_values($lookup);
		return new RecordSet(['data' => $results, 'model' => __CLASS__]);
	}

	protected static function _convert($item) {
		$data = $item->data();

		$data['original'] = $item;
		return parent::create($data);
	}

	protected static function _modelForType($type) {
		$map = [
			'articles' => 'cms_article\models\Articles',
			'events' => 'cms_event\models\Events',
			'tutorials' => 'cms_tutorial\models\Tutorials'
		];
		return $map[$type];
	}
}


?>