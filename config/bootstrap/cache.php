<?php

use lithium\storage\Cache;
use lithium\core\Libraries;
use lithium\core\Environment;
use lithium\action\Dispatcher;
use lithium\storage\cache\adapter\Apc;

$cachePath = Libraries::get(true, 'resources') . '/tmp/cache';

if (!(($apcEnabled = Apc::enabled()) || PHP_SAPI === 'cli') && !is_writable($cachePath)) {
	return;
}

Cache::config(array('default' => $apcEnabled ? array('adapter' => 'Apc') : array(
	'adapter' => 'File', 'strategies' => array('Serializer')
)));

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

	$hash = md5($response->body());
	$condition = trim($request->get('http:if_none_match'), '"');

	if ($condition === $hash) {
		$response->status(304);
		$response->body = array();
	}

	$response->headers['ETag'] = "\"{$hash}\"";;
	return $response;
});

?>