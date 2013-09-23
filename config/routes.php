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

/*
Router::connect(
	'/admin/{:args}',
	['admin' => true],
	[
		'continue' => true,
		'persist' => ['admin', 'controller']
	]
);
*/

$persist = ['persist' => ['admin', 'controller']];

Router::connect('/admin', [
	'controller' => 'pages', 'action' => 'home', 'library' => 'cms_core', 'admin' => true
], $persist);

if (Environment::get('features.registerWithTokenOnly')) {
	Router::connect('/admin/tokens/{:action}/{:token:[0-9a-f]{8,16}}', [
		'controller' => 'tokens', 'library' => 'cms_core', 'admin' => true
	], $persist);
}
Router::connect('/admin/tokens/{:action}/{:args}', [
	'controller' => 'tokens', 'library' => 'cms_core', 'admin' => true
], $persist);

Router::connect('/admin/users/{:action}/{:id:[0-9]+}', [
	'controller' => 'users', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/users/{:action}/{:args}', [
	'controller' => 'users', 'library' => 'cms_core', 'admin' => true
], $persist);

?>