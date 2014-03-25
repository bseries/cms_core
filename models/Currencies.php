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

use cms_core\extensions\cms\Settings;
use lithium\g11n\Catalog;
use Collator;
use lithium\util\Collection;
use lithium\core\Environment;

class Currencies extends \cms_core\models\Base {

	protected $_meta = [
		'connection' => false
	];

	public static function find($type, array $options = []) {
		$options += ['locale' => Environment::get('locale')];
		$available = Settings::read('availableCurrencies');

		$data = [];
		$results = Catalog::read(true, 'currency', $options['locale']);

		foreach ($results as $key => $value) {
			if (is_numeric($key)) {
				continue;
			}
			$data[$key] = $value;
		}
		if ($available) {
			$all = $data;
			$data = [];

			foreach ($available as $currency) {
				$data[$currency] = $all[$currency];
			}
		}
		$collator = new Collator($options['locale']);
		$collator->asort($data);

		if ($type == 'all') {
			foreach ($data as $key => &$item) {
				$item = static::create([
					'id' => $key,
					'name' => $item
				]);
			}
			return new Collection(['data' => $data]);
		} elseif ($type == 'list') {
			return array_combine(array_keys($data), array_keys($data));
		} elseif ($type == 'first') {
			$item = $data[$key = $options['conditions']['id']];
			return static::create(['id' => $key, 'name' => $item]);
		}
	}
}

?>