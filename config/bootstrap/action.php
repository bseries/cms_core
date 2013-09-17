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

use lithium\core\Libraries;
use lithium\core\Environment;
use lithium\action\Dispatcher;
use lithium\net\http\Router;
use lithium\net\http\Media;

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

// Inject environment variables into templates; remember variables are only
// injected into the original template, for elements variables must be passed
// manually.
// Dispatcher::applyFilter('run', function($self, $params, $chain) {
// 	Media::applyFilter('_handle', function($self, $params, $chain) {
// 		if ($params['handler']['type'] == 'html') {
// 			$params['data']['site'] = Environment::get('site');
// 			$params['data']['service'] = Environment::get('service');
// 		}
// 		return $chain->next($self, $params, $chain);
// 	});
//
// 	return $chain->next($self, $params, $chain);
// });

?>