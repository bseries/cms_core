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

Libraries::add('jsend', array(
	'path' => dirname(__DIR__) . '/libraries/jsend/src'
));

require_once dirname(__DIR__) . '/libraries/autoload.php';

Features::register('cms_core', 'useNewGoogleAnalyticsTrackingCode', true);
Features::register('cms_core', 'useBilling', false);
Features::register('cms_core', 'user.sendActivationMail', false);

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