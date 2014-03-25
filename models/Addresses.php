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

use lithium\core\Environment;
use cms_core\models\Users;
use cms_core\models\VirtualUsers;
use cms_core\models\Countries;

class Addresses extends \cms_core\models\Base {

	protected static $_actsAs = [
		'cms_core\extensions\data\behavior\Timestamp'
	];

	public function user($entity) {
		if ($entity->user_id) {
			return Users::findById($entity->user_id);
		}
		return VirtualUsers::findById($entity->virtual_user_id);
	}

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
			if (strpos($field, 'user_') !== false) {
				$item[$field] = $value;
				continue;
			}
			if (strpos($field, $prefix) !== false) {
				$field = str_replace($prefix, '', $field);
				$item[$field] = $value;
				continue;
			}
		}
		return static::create($item);
	}

	public function format($entity, $type, $locale = null) {
		if (!$locale) {
			$locale = ($user = $entity->user()) ? $user->locale : Environment::get('locale');
		}

		if ($type == 'oneline') {
			$result = [];

			$result[] = $entity->name;
			$result[] = $entity->street;
			$result[] = $entity->city;

			return implode(', ', $result);
		}
		if ($type == 'postal') {
			$result = [];

			$result[] = $entity->name;
			$result[] = $entity->street;
			$result[] = $entity->zip . ' ' . $entity->city;
			$result[] = Countries::find('first', [
				'conditions' => [
					'id' => $entity->country
				],
				'locale' => $locale
			])->name;
			return implode("\n", $result);
		}
	}
}

?>