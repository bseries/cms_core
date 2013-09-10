<?php

use lithium\net\http\Router;
use lithium\core\Environment;

Router::connect(
	'/admin/{:args}',
	['admin' => true],
	[
		'continue' => true,
		'persist' => ['admin', 'controller']
	]
);

// @fixme Making this / interferes with the non-admin /.
Router::connect('/dashboard', [
	'controller' => 'pages', 'action' => 'home', 'library' => 'cms_core'
]);

if (Environment::get('features.registerWithTokenOnly')) {
	Router::connect('/tokens/{:action}/{:token:[0-9a-f]{8,16}}', [
		'controller' => 'tokens', 'library' => 'cms_core'
	]);
}
Router::connect('/tokens/{:action}/{:args}', [
	'controller' => 'tokens', 'library' => 'cms_core'
]);

Router::connect('/users/{:action}/{:id:[0-9]+}', [
	'controller' => 'users', 'library' => 'cms_core'
]);
Router::connect('/users/{:action}/{:args}', [
	'controller' => 'users', 'library' => 'cms_core'
]);

?>