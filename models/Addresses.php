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

use lithium\g11n\Catalog;
use Collator;

class Addresses extends \cms_core\models\Base {

	protected static $_actsAs = [
		'cms_core\extensions\data\behavior\Timestamp'
	];

	public static function findExact($data) {
		return static::find('first', [
			'conditions' => $data
		]);
	}

	public function copy($entity, $object, $prefix = null) {
		$skipFields = ['id', 'user_id', 'created', 'modified'];

		foreach ($entity->data() as $field => $value) {
			if (in_array($field, $skipFields)) {
				continue;
			}
			$field = $prefix ? $prefix . $field : $field;
			$object->{$field} = $value;
		}
		return $object;
	}

	public static function createFromPrefixed($prefix, array $data) {
		$item = [];

		foreach ($data as $field => $value) {
			if (strpos($field, $prefix) === false) {
				continue;
			}
			$field = str_replace($prefix, '', $field);
			$item[$field] = $value;
		}
		return static::create($item);
	}

	public static function countries($locale) {
		$countries = [];
		$results = Catalog::read(true, 'territory', $locale);

		foreach ($results as $key => $value) {
			if (is_numeric($key)) {
				continue;
			}
			$countries[$key] = $value;
		}
		$collator = new Collator($locale);
		$collator->asort($countries);

		return $countries;
	}

	public function format($entity, $type, $locale) {
		if ($type == 'oneline') {
			$result = [];

			$result[] = $entity->name;
			$result[] = $entity->street;
			$result[] = $entity->city;

			return implode(', ', $result);
		}
		if ($type == 'postal') {
			$result = [];

			$countries = static::countries($locale);

			$result[] = $entity->name;
			$result[] = $entity->street;
			$result[] = $entity->zip . ' ' . $entity->city;
			$result[] = $countries[$entity->country];

			return implode("\n", $result);
		}
	}
}

?>