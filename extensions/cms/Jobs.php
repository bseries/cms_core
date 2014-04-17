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

use lithium\analysis\Logger;

class Jobs extends \lithium\core\StaticObject {

	const FREQUENCY_HIGH = 'high';
	const FREQUENCY_MEDIUM = 'medium';
	const FREQUENCY_LOW = 'low';

	protected static $_recurring = [];

	public static function recur($library, $name, $run, array $options = []) {
		$options += [
			'frequency' => null
		];
		if (isset($options['frequency'])) {
			static::$_recurring[$options['frequency']][$name] = compact('library', 'name', 'run');
		}
	}

	public static function runFrequency($frequency) {
		Logger::write('debug', "Running all jobs with frequency `{$frequency}`.");

		foreach (static::$_recurring[$frequency] as $item) {
			Logger::write('debug', "Running job `{$item['name']}`.");
			$start = microtime(true);

			$item['run']();

			$took = round((microtime(true) - $start), 2);
			Logger::write('debug', "Finished running job `{$item['name']}`; took {$took}ms.");
		}

		Logger::write('debug', "Finished running all jobs with frequency `{$frequency}`.");
	}
}

?>