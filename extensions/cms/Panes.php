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
use Exception;

class Panes extends \lithium\core\StaticObject {

	protected static $_data = [];

	public static function registerGroup($library, $name, array $options = []) {
		$options += [
			'title' => Inflector::humanize($name),
			'url' => null,
			'actions' => [],
			'active' => null,
			// The higher the weight the higher the possible position.
			// Should be a number between 0-100 inclusive.
			'order' => 0
		];
		if (is_callable($options['url'])) {
			$options['url'] = $options['url']();
		}
		static::$_data[$name] = compact('name', 'library') + $options;
	}

	public static function registerActions($library, $group, array $actions) {
		if (!isset(static::$_data[$group])) {
			throw new Exception("Pane group `{$group}` not defined.");
		}
		if (static::$_data[$group]['actions'] === false) {
			throw new Exception("Pane group `{$group}` doesn't accept actions.");
		}
		foreach ($actions as $title => $url) {
			static::$_data[$group]['actions'][] = [
				'title' => $title,
				'url' => is_callable($url) ? $url() : $url,
				'library' => $library,
				'active' => null
			];
		}
	}

	public static function groups($request = null) {
		$data = static::read();
		$results = [];

		foreach ($data as $item) {
			if ($item['actions'] === [] && !$item['url']) {
				// Skip groups which should have actions but don't have one.
				continue;
			}
			if ($item['actions'] !== false && !$item['url']) {
				// Use first action url as url for group.
				$item['url'] = $item['actions'][0]['url'];
			}

			$results[] = $item;
		}

		// If we have a request, try to determine current active group.
		if ($request) {
			foreach ($results as &$group) {
				if ($group['actions'] !== false) {
					// If an action is active the group itself is active.

					foreach ($group['actions'] as &$action) {
						if (static::_active($action, $request)) {
							$group['active'] = $action['active'] = true;
							break(2);
						}
					}
				} elseif (static::_active($group, $request)) {
					$group['active'] = true;
					break;
				}
			}
		}

		// Sort groups mainly by order than library and title.
		// $results = Set::sort($results, '/title');
		// $results = Set::sort($results, '/library');
		$results = Set::sort($results, '/order', 'desc');

		return $results;
	}

	public static function actions($group, $request = null) {
		if (!isset(static::$_data[$group])) {
			throw new Exception("Pane group `{$group}` not defined.");
		}
		if (static::$_data[$group]['actions'] === false) {
			throw new Exception("Pane group `{$group}` doesn't accept actions.");
		}
		$results = static::$_data[$group]['actions'];

		if ($request) {
			// If we have a request, try to determine current active group.
			foreach ($results as &$result) {
				$result['active'] = static::_active($result, $request);
			}
		}

		// Sort actions mainly by library than title.
		// $results = Set::sort($results, '/title');
		$results = Set::sort($results, '/library');

		return $results;
	}

	public static function read($group = null) {
		if (!$group) {
			return static::$_data;
		}
		if (!isset(static::$_data[$group])) {
			throw new Exception("Pane group `{$group}` not defined.");
		}
		return static::$_data[$group];
	}

	protected static function _active($item, $request) {
		if (is_string($item['url'])) {
			return false;
		}
		return !array_diff($item['url'], $request->params);
	}
}

?>