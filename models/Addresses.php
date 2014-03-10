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

class Addresses extends \cms_core\models\Base {

	protected static $_actsAs = [
		'cms_core\extensions\data\behavior\Timestamp'
	];

	public static function countries() {
		return [
			'DE' => 'Germany'
		];
	}

	/*
	public $belongsTo = [
		'UserBilling' => [
			'class' => 'cms_core\models\Users',
			'key' => 'billing_address_id'
		],
		'UserShipping' => [
			'class' => 'cms_core\models\Users',
			'key' => 'billing_shipping_id'
		]
	];
	*/

	public function format($entity, $type) {
		if ($type == 'oneline') {
			$result = [];
			$result[] = $entity->name;
			$result[] = $entity->street;
			$result[] = $entity->city;

			return implode(', ', $result);
		}
	}
}

?>