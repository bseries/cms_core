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

use lithium\net\http\Router;
use cms_core\extensions\cms\Features;

// Errors
Router::connect('/403', array(
	'controller' => 'Errors', 'action' => 'fourohthree', 'library' => 'cms_core'
));
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

// Administration
$persist = ['persist' => ['admin', 'controller']];

Router::connect('/admin', [
	'controller' => 'pages', 'action' => 'home', 'library' => 'cms_core', 'admin' => true
], $persist);

Router::connect('/admin/session', [
	'controller' => 'users', 'action' => 'session', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/login', [
	'controller' => 'users', 'action' => 'login', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/logout', [
	'controller' => 'users', 'action' => 'logout', 'library' => 'cms_core', 'admin' => true
], $persist);

// Users
Router::connect('/admin/users/{:id:[0-9]+}/change-role/{:role}', [
	'controller' => 'users', 'action' => 'change_role', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/users/{:action}/{:id:[0-9]+}', [
	'controller' => 'users', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/users/{:action}/{:args}', [
	'controller' => 'users', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/virtual-users/{:id:[0-9]+}/change-role/{:role}', [
	'controller' => 'VirtualUsers', 'action' => 'change_role', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/virtual-users/{:action}/{:id:[0-9]+}', [
	'controller' => 'VirtualUsers', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/virtual-users/{:action}/{:args}', [
	'controller' => 'VirtualUsers', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/tokens/{:action}/{:token:[0-9a-f]{8,16}}', [
	'controller' => 'tokens', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/tokens/{:action}/{:args}', [
	'controller' => 'tokens', 'library' => 'cms_core', 'admin' => true
], $persist);

// Addresses
Router::connect('/admin/addresses/{:action}/{:id:[0-9]+}', [
	'controller' => 'addresses', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/addresses/{:action}/{:args}', [
	'controller' => 'addresses', 'library' => 'cms_core', 'admin' => true
], $persist);

// Settings, Misc
Router::connect('/admin/settings', [
	'controller' => 'settings', 'action' => 'index', 'library' => 'cms_core', 'admin' => true
], $persist);
Router::connect('/admin/support', [
	'controller' => 'pages', 'action' => 'support', 'library' => 'cms_core', 'admin' => true
], $persist);

// Administration JavaScript Environment
Router::connect('/admin/api/discover', [
	'controller' => 'app', 'action' => 'api_discover', 'library' => 'cms_core', 'admin' => true
], $persist);


?>