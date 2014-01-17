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
use lithium\g11n\Message;
use cms_core\extensions\cms\Modules;
use cms_core\extensions\cms\Features;
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

Libraries::add('temporary', [
	'path' => dirname(__DIR__) . '/libraries/temporary/src'
]);
Libraries::add('guzzle', [
	'path' => dirname(__DIR__) . '/libraries/guzzle/src'
]);

require __DIR__ . '/bootstrap/errors.php';
require __DIR__ . '/bootstrap/action.php';

if (PHP_SAPI !== 'cli') {
	require __DIR__ . '/bootstrap/cache.php';
}
require __DIR__ . '/bootstrap/session.php';
require __DIR__ . '/bootstrap/g11n.php';
require __DIR__ . '/bootstrap/media.php';

if (PHP_SAPI === 'cli') {
	require __DIR__ . '/bootstrap/console.php';
}

require __DIR__ . '/bootstrap/auth.php';

Modules::register('cms_core', 'tokens', ['title' => $t('Tokens')]);
Modules::register('cms_core', 'users', ['title' => $t('Users')]);

Features::register('useNewGoogleAnalyticsTrackingCode', true);
Features::register('registerWithTokenOnly', true);

// Register "empty" schemes, base must be set
// through app. Cannot provide sane defaults here.
Assets::registerScheme('file');
Assets::registerScheme('http');
Assets::registerScheme('https');

// Settings::register('service.googleAnalytics.account');
// Settings::register('service.googleAnalytics.domain');

?>