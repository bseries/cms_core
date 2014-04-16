<?php

use cms_core\extensions\cms\Panes;
use lithium\g11n\Message;
use cms_core\extensions\cms\Settings;

extract(Message::aliases());

Panes::registerGroup('cms_core', 'dashboard', [
	'title' => $t('Dashboard'),
	'url' => ['controller' => 'Pages', 'action' => 'home', 'admin' => true, 'library' => 'cms_core'],
	'actions' => false,
	'order' => 100
]);
Panes::registerGroup('cms_core', 'access', [
	'title' => $t('Access'),
	'order' => 20
]);
Panes::registerGroup('cms_core', 'external', [
	'title' => $t('External'),
	'order' => 15
]);
Panes::registerGroup('cms_core', 'development', [
	'title' => $t('Development'),
	'order' => 0
]);
Panes::registerGroup('cms_core', 'authoring', [
	'title' => $t('Authoring'),
	'order' => 90
]);
Panes::registerGroup('cms_core', 'view_site', [
	'title' => $t('Site'),
	'order' => 5,
	'url' => '/',
	'actions' => false
]);

$base = ['controller' => 'users', 'action' => 'index', 'library' => 'cms_core', 'admin' => true];
Panes::registerActions('cms_core', 'access', [
	$t('List Users') => ['action' => 'index'] + $base,
	$t('New User') => ['action' => 'add'] + $base,
	$t('List Virtual Users') => ['controller' => 'VirtualUsers', 'action' => 'index'] + $base,
	$t('New Virtual User') => ['controller' => 'VirtualUsers', 'action' => 'add'] + $base,
	$t('List Addresses') => ['controller' => 'Addresses', 'action' => 'index'] + $base,
	$t('New Address') => ['controller' => 'Addresses', 'action' => 'add'] + $base,
	$t('List Tokens') => ['controller' => 'tokens', 'action' => 'index'] + $base,
	$t('Generate Token') => ['controller' => 'tokens', 'action' => 'generate'] + $base,
]);

Panes::registerActions('cms_core', 'external', [
	$t('Contact Support') => ['controller' => 'Pages', 'action' => 'support', 'library' => 'cms_core'],
	$t('Google Analytics') => function() {
		return 'https://www.google.com/analytics/web/#report/visitors-overview/' . Settings::read('googleAnalytics.default.propertyId');
	}
]);

/*
Panes::registerActions('cms_core', 'development', [
	$t('Styleguide') => ['controller' => 'pages', 'action' => 'styleguide', 'admin' => true, 'library' => 'cms_core'],
	$t('Settings & Features') => ['controller' => 'settings', 'action' => 'index', 'library' => 'cms_core', 'admin' => true]
]);
 */

?>