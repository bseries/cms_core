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

Libraries::add('jsend', array(
	'path' => dirname(__DIR__) . '/libraries/jsend/src'
));

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