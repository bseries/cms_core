<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

namespace cms_core\models;

class Assets extends \cms_core\models\Base {

	protected $_meta = array(
		'connection' => false
	);

	protected static $_schemes = [];

	public static function base($scheme) {
		return static::$_schemes[$scheme]['base'];
	}

	public static function registerScheme($scheme, array $options = []) {
		static::$_schemes[$scheme] = $options + [
			'base' => false
		];
	}
}

?>