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
use lithium\net\http\Router;
use Exception;

// This class is used to generate the overall admin navigation bars.
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

	// Returns registered groups with the active one set active.
	// If an action is active inside a group the whole group itself becomes active.
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
			$found = false;

			foreach ($results as &$group) {
				if (!$group['actions']) {
					continue;
				}
				if (($key = static::_active($group['actions'], $request)) !== false) {
					// We can simplify things here as we don't need to also set the actions active.
					$found = $group['active'] = true;
					break;
				}
			}
			// As a fallback - and as there *must* be one active pane group match on
			// the pane group urls directly (not their actions) i.e. dashboard.
			if (!$found) {
				if (($key = static::_active($results, $request)) !== false) {
					$results[$key]['active'] = true;
				}
			}
		}

		// Sort groups mainly by order than library and title.
		// $results = Set::sort($results, '/title');
		// $results = Set::sort($results, '/library');
		$results = Set::sort($results, '/order', 'desc');

		return $results;
	}

	// If $group is `true` return actions for the currently active group.
	public static function actions($group, $request = null) {
		if ($group === true) {
			foreach (static::groups($request) as $item) {
				if ($item['active']) {
					$group = $item['name'];
					break;
				}
			}
			if ($group === true && $request) { // Variable seems unused.
				throw new Exception("Could not auto-detect active group.");
			}
		} elseif (!isset(static::$_data[$group])) {
			throw new Exception("Pane group `{$group}` not defined.");
		}
		if (static::$_data[$group]['actions'] === false) {
			return [];
		}
		$results = static::$_data[$group]['actions'];

		if ($request) {
			// If we have a request, try to determine current active group.
			if (($key = static::_active($results, $request)) !== false) {
				$results[$key]['active'] = true;
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

	// Best (longest) match.
	// Each item in $data must have a url under the `url` key.
	protected static function _active($data, $request) {
		$map = [];
		foreach ($data as $key => $item) {
			if (is_string($item['url']) && strpos($item['url'], 'http') !== false) {
				// Already skip external urls here to make search set smaller.
				continue;
			}
			$map[$key] = Router::match($item['url'], $request);
		}
		uasort($map, function($a, $b) {
			// Sort by length, longest comes first.
			return strlen($b) - strlen($a);
		});
		foreach ($map as $key => $value) {
			// Request URL is the more detailed URL. Item URLs may be a subset of it.
			if (strpos($request->url, $value) !== false) {
				return $key;
			}
		}
		return false;
	}
}

?>