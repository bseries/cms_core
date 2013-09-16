<?php

use lithium\net\http\Router;
use lithium\core\Environment;

Router::connect('/404', array(
	'controller' => 'Errors', 'action' => 'fourohfour', 'library' => 'cms_core'
));
Router::connect('/500', array(
	'controller' => 'Errors', 'action' => 'fiveohoh', 'library' => 'cms_core'
));
Router::connect('/503', array(
	'controller' => 'Errors', 'action' => 'fiveohthree', 'library' => 'cms_core'
));
Router::connect('/maintenance', array(
	'controller' => 'Errors', 'action' => 'maintenance', 'library' => 'cms_core'
));
Router::connect('/browser', array(
	'controller' => 'Errors', 'action' => 'browser', 'library' => 'cms_core'
));

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