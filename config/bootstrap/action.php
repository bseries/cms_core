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

use lithium\core\Libraries;
use lithium\core\Environment;
use lithium\action\Dispatcher;
use lithium\net\http\Router;
use lithium\net\http\Media;
use lithium\security\Auth;
use Mobile_Detect as MobileDetect;
use lithium\storage\Cache;

Dispatcher::applyFilter('run', function($self, $params, $chain) {
	$libraries = Libraries::get();

	require_once $libraries['cms_core']['path'] . '/config/routes.php';
	require_once $libraries['app']['path'] . '/config/routes.php';

	// Load other libraries.
	unset($libraries['app']);
	unset($libraries['lithium']);
	unset($libraries['cms_core']);
	foreach (array_reverse($libraries) as $name => $config) {
		$file = "{$config['path']}/config/routes.php";
		file_exists($file) ? call_user_func(function() use ($file) { include $file; }) : null;
	}
	return $chain->next($self, $params, $chain);
});

// Admin routing
Dispatcher::config([
	'rules' => ['admin' => ['action' => 'admin_{:action}']]
]);

// Admin layout.
Dispatcher::applyFilter('run', function($self, $params, $chain) {
	$parsed = Router::parse($params['request']);

	if (isset($parsed->params['admin'])) {
		$params['options']['render']['layout'] = 'admin';
	}
	return $chain->next($self, $params, $chain);
});

$retrieveUaInfo = function($request) {
	$detect = new MobileDetect();
	$headers = array_merge($detect->getUaHttpHeaders(), array_keys($detect->getMobileHeaders()));

	$cacheKey = '';

	foreach ($headers as $header) {
		if ($value = $request->env($header)) {
			$cacheKey = $header . $value;
		}
	}
	$cacheKey = 'ua_' . md5($cacheKey);

	if ($ua = Cache::read('default', $cacheKey)) {
		return $ua;
	}
	$ua = [
		'isMobile' => $detect->isMobile(),
		'isTablet' => $detect->isTablet(),
		'mobileGrade' => $detect->mobileGrade(),
		'isIos' => $detect->isiOS()
	];
	Cache::write('default', $cacheKey, $ua, '+1 week');

	return $ua;
};

// Inject environment variables into templates; remember variables are only
// injected into the original template, for elements variables must be passed
// manually.
Dispatcher::applyFilter('run', function($self, $params, $chain) use ($retrieveUaInfo) {
	$ua = $retrieveUaInfo($params['request']);

	Media::applyFilter('_handle', function($self, $params, $chain) use ($ua) {
		if ($params['handler']['type'] == 'html') {
			$params['data']['authedUser'] = Auth::check('default');

			$params['data']['ua'] = $ua;
			$params['data']['locale'] = Environment::get('locale');

			// $params['data']['site'] = Environment::get('site');
			// $params['data']['service'] = Environment::get('service');
		}
		return $chain->next($self, $params, $chain);
	});

	return $chain->next($self, $params, $chain);
});

?>