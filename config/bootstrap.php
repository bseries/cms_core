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
use cms_core\extensions\cms\Features;
use cms_core\models\Assets;
use lithium\net\http\Media as HttpMedia;

Libraries::add('li3_behaviors', [
	'path' => dirname(__DIR__) . '/libraries/li3_behaviors'
]);
Libraries::add('li3_taggable', [
	'path' => dirname(__DIR__) . '/libraries/li3_taggable'
]);
Libraries::add('li3_cldr', [
	'path' => dirname(__DIR__) . '/libraries/li3_cldr',
	'bootstrap' => false
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

Libraries::add('Finite', array(
	'path' => dirname(__DIR__) . '/libraries/finite/src/Finite',
	'prefix' => 'Finite\\'
));
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

Features::register('cms_core', 'useNewGoogleAnalyticsTrackingCode', true);
Features::register('cms_core', 'useBilling', false);
Features::register('cms_core', 'sendUserActivationMail', false);

// Register "empty" schemes, base must be set
// through app. Cannot provide sane defaults here.
Assets::registerScheme('file');
Assets::registerScheme('http');
Assets::registerScheme('https');

HttpMedia::type('binary', 'application/octet-stream', [
	'cast' => false,
	'encode' => function($data) {
		return $data;
	}
]);

?>