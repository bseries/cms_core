<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013-2014-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

use lithium\storage\Cache;
use lithium\core\Libraries;
use lithium\core\Environment;
use lithium\action\Dispatcher;
use lithium\storage\cache\adapter\Memcache;

if (!Memcache::enabled()) {
	throw new Exception('Memcache not enabled.');
}

Cache::config([
	'default' => [
		'scope' => PROJECT_NAME,
		'adapter' => 'Memcache',
		'host' => '127.0.0.1:11211'
	]
]);

Dispatcher::applyFilter('run', function($self, $params, $chain) {
	if (!Environment::is('production')) {
		return $chain->next($self, $params, $chain);
	}
	$key = md5(LITHIUM_APP_PATH) . '.core.libraries';

	if ($cache = Cache::read('default', $key)) {
		$cache = (array) $cache + Libraries::cache();
		Libraries::cache($cache);
	}
	$result = $chain->next($self, $params, $chain);

	if ($cache != Libraries::cache()) {
		Cache::write('default', $key, Libraries::cache(), '+1 day');
	}
	return $result;
});

Dispatcher::applyFilter('run', function($self, $params, $chain) {
	$request  = $params['request'];
	$response = $chain->next($self, $params, $chain);

	// Cache only HTML responses, JSON responses come from
	// APIs and are most often highly dynamic.
	if ($response->type() !== 'html') {
		return $response;
	}

	$hash = 'W/' . md5(serialize([
		$response->body,
		$response->headers,
		PROJECT_VERSION
	]));
	$condition = trim($request->get('http:if_none_match'), '"');

	if ($condition === $hash) {
		$response->status(304);
		$response->body = [];
	}
	$response->headers['ETag'] = "\"{$hash}\"";
	return $response;
});

?>