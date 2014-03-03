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
use lithium\g11n\Message;
use cms_core\extensions\cms\Panes;
use cms_core\extensions\cms\Features;
use cms_core\extensions\cms\Settings;
use cms_core\models\Assets;

extract(Message::aliases());

Libraries::add('li3_behaviors', [
	'path' => dirname(__DIR__) . '/libraries/li3_behaviors'
]);
Libraries::add('li3_taggable', [
	'path' => dirname(__DIR__) . '/libraries/li3_taggable'
]);
Libraries::add('li3_lldr', [
	'path' => dirname(__DIR__) . '/libraries/li3_lldr'
]);
Libraries::add('li3_flash_message', [
	'path' => dirname(__DIR__) . '/libraries/li3_flash_message'
]);
Libraries::add('li3_access', [
	'path' => dirname(__DIR__) . '/libraries/li3_access'
]);
Libraries::add('li3_mailer', [
	'path' => dirname(__DIR__) . '/libraries/li3_mailer'
]);

Libraries::add('Faker', [
	'path' => dirname(__DIR__) . '/libraries/faker/src/Faker'
]);
Libraries::add('temporary', [
	'path' => dirname(__DIR__) . '/libraries/temporary/src'
]);
Libraries::add('textual', array(
	'path' => dirname(__DIR__) . '/libraries/textual/src'
));
Libraries::add('jsend', array(
	'path' => dirname(__DIR__) . '/libraries/jsend/src'
));
Libraries::add('mobile_detect', array(
	'path' => dirname(__DIR__) . '/libraries/mobile_detect',
	'prefix' => 'Mobile_Detect',
	'transform' => function($class, $config) {
		return $config['path'] . '/' . $class . '.php';
	}
));
require dirname(__DIR__) . '/libraries/guzzle/vendor/autoload.php';
// Libraries::add('guzzle', [
//	'path' => dirname(__DIR__) . '/libraries/guzzle/src',
// ]);

require __DIR__ . '/bootstrap/errors.php';
require __DIR__ . '/bootstrap/action.php';

if (PHP_SAPI !== 'cli') {
	require __DIR__ . '/bootstrap/cache.php';
}
require __DIR__ . '/bootstrap/session.php';
require __DIR__ . '/bootstrap/g11n.php';
require __DIR__ . '/bootstrap/media.php';

require __DIR__ . '/bootstrap/settings.php';

if (PHP_SAPI === 'cli') {
	require __DIR__ . '/bootstrap/console.php';
}

require __DIR__ . '/bootstrap/auth.php';

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

Features::register('cms_core', 'useNewGoogleAnalyticsTrackingCode', true);

// Register "empty" schemes, base must be set
// through app. Cannot provide sane defaults here.
Assets::registerScheme('file');
Assets::registerScheme('http');
Assets::registerScheme('https');

?>