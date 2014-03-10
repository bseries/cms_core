<?php

use cms_core\extensions\cms\Panes;
use lithium\g11n\Message;
use cms_core\extensions\cms\Settings;

extract(Message::aliases());

Panes::register('cms_core', 'users', [
	'title' => $t('Users'),
	'group' =>  Panes::GROUP_ACCESS,
	'url' => $base = ['controller' => 'users', 'action' => 'index', 'library' => 'cms_core', 'admin' => true],
	'actions' => [
		$t('List Users') => ['action' => 'index'] + $base,
		$t('New User') => ['action' => 'add'] + $base
	]
]);
Panes::register('cms_core', 'tokens', [
	'title' => $t('Tokens'),
	'group' => Panes::GROUP_ACCESS,
	'url' => $base = ['controller' => 'tokens', 'action' => 'index', 'library' => 'cms_core', 'admin' => true],
	'actions' => [
		$t('List Tokens') => ['action' => 'index'] + $base,
		$t('Generate Token') => ['action' => 'generate'] + $base
	]
]);
Panes::register('cms_core', 'addresses', [
	'title' => $t('Addresses'),
	'group' =>  Panes::GROUP_ACCESS,
	'url' => $base = ['controller' => 'addresses', 'action' => 'index', 'library' => 'cms_core', 'admin' => true],
	'actions' => [
		$t('List Addresses') => ['action' => 'index'] + $base,
		$t('New Address') => ['action' => 'add'] + $base
	]
]);
Panes::register('cms_core', 'settings', [
	'title' => $t('Settings & Features'),
	'group' => Panes::GROUP_MANAGE,
	'url' => ['controller' => 'settings', 'action' => 'index', 'library' => 'cms_core', 'admin' => true]
]);
Panes::register('cms_core', 'google_analytics', [
	'title' => $t('Google Analytics'),
	'group' => Panes::GROUP_MANAGE,
	'url' => function() {
		return 'https://www.google.com/analytics/web/#report/visitors-overview/' . Settings::read('googleAnalytics.default.propertyId');
	}
]);
Panes::register('cms_core', 'styleguide', [
	'title' => $t('Styleguide'),
	'group' => Panes::GROUP_MANAGE,
	'url' => ['controller' => 'pages', 'action' => 'styleguide', 'admin' => true, 'library' => 'cms_core'],
]);
Panes::register('cms_core', 'support', [
	'title' => $t('Support'),
	'group' => Panes::GROUP_MANAGE,
	'url' => ['controller' => 'pages', 'action' => 'support', 'library' => 'cms_core', 'admin' => true]
]);

?>