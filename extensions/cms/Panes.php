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

namespace cms_core\extensions\cms;

use lithium\util\Set;
use lithium\util\Inflector;

class Panes extends \lithium\core\StaticObject {

	const GROUP_NONE = 'none';
	const GROUP_ACCESS = 'access';
	const GROUP_AUTHORING = 'authoring';
	const GROUP_MANAGE = 'manage';

	protected static $_data = [];

	protected static $_sources = [];

	public static function register($library, $name, array $options = []) {
		$options += [
			'title' => Inflector::humanize($name),
			'url' => null,
			'group' => static::GROUP_NONE,
			'actions' => []
		];
		if (is_callable($options['url'])) {
			$options['url'] = $options['url']();
		}
		static::$_sources[$name] = $library;
		static::$_data[$name] = compact('name', 'library') + $options;
	}

	public static function grouped() {
		$data = static::read();

		// Preorder manually groups.
		$results = [
			static::GROUP_AUTHORING => [],
			static::GROUP_ACCESS => [],
			static::GROUP_MANAGE => [],
			static::GROUP_NONE => []
		];
		foreach ($data as $item) {
			$results[$item['group']][] = $item;
		}
		foreach ($results as $group => &$panes) {
			// Sort mainly by library, then by title.
			$panes = Set::sort($panes, '/title');
			$panes = Set::sort($panes, '/library');
		}

		return $results;
	}

	public static function read($name = null) {
		if (!$name) {
			return static::$_data;
		}
		return static::$_data[$name];
	}
}

?>