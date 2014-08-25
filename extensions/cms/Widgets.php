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

use lithium\util\Collection;
use lithium\analysis\Logger;

class Widgets extends \lithium\core\StaticObject {

	const GROUP_NONE = 'none';
	const GROUP_DASHBOARD = 'dashboard';

	const TYPE_COUNTER = 'counter';
	const TYPE_TABLE = 'table';
	const TYPE_QUICKDIAL = 'quickdial';

	protected static $_data = [];

	public static function register($name, $inner, array $options = []) {
		if (func_num_args() > 3) {
			trigger_error("Library parameter is deprecated (widget $name).", E_USER_DEPRECATED);
			return;
		}
		$options += [
			'type' => null,
			'group' => static::GROUP_NONE
		];
		$id = hash('md5', $name . $options['type'] . $options['group']);

		static::$_data[$id][] = compact('name', 'inner') +  $options;
	}

	// Returns all items wrapped in a collection object which can be
	// filtered and sorted. When an item has been registered multiple
	// times its inner data is wrapped in a single closure.
	public static function read() {
		$data = [];

		foreach (static::$_data as $id => $items) {
			$item = current($items);

			$data[$id] = [
				// group and type will be the same for all items as we grouped earlier.
				// We need both to be available "outside" as we need to filter on those
				// properities or need them to determine the widget element to load.
				'name' => $item['name'],
				'group' => $item['group'],
				'type' => $item['type'],
				// Aggregates multiple registered widgets into one.
				'inner' => function() use ($item, $items) {
					$start = microtime(true);

					$result = [
						'class' => null,
						'url' => null,
						'title' => false,
						'data' => []
					];
					foreach ($items as $i) {
						$inner = $i['inner']();

						if (isset($inner['data'])) {
							if (is_array($inner['data'])) {
								$result['data'] += $inner['data'];
							} else {
								$result['data'] = $inner['data'];
							}
							unset($inner['data']);
						}
						$result = $inner + $result;
					}

					if (($took = microtime(true) - $start) > 1) {
						$message = sprintf(
							"Widget`{$item['name']}` took very long (%4.fs) to render",
							$took
						);
						Logger::write('notice', $message);
					}
					return $result;
				}
			];
		}
		return new Collection(compact('data'));
	}
}

?>