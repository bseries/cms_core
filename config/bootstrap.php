<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

define('CMS_CORE_VERSION', '1.0.0');

use lithium\core\Libraries;
use cms_core\extensions\cms\Features;
use cms_core\models\Assets;
use lithium\net\http\Media as HttpMedia;

if (!include LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/core/Libraries.php') {
	$message  = "Lithium core could not be found.  Check the value of LITHIUM_LIBRARY_PATH in ";
	$message .= __FILE__ . ".  It should point to the directory containing your ";
	$message .= "/libraries directory.";
	throw new ErrorException($message);
}

require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/core/Object.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/core/StaticObject.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/util/Collection.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/util/collection/Filters.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/util/Inflector.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/util/String.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/core/Adaptable.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/core/Environment.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/net/Message.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/net/http/Message.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/net/http/Media.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/net/http/Request.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/net/http/Response.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/net/http/Route.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/net/http/Router.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/action/Controller.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/action/Dispatcher.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/action/Request.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/action/Response.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/template/View.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/template/view/Renderer.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/template/view/Compiler.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/template/view/adapter/File.php';
require LITHIUM_LIBRARY_PATH . '/unionofrad/lithium/lithium/storage/Cache.php';

Libraries::add('lithium');
Libraries::add('app', ['default' => true]);

require LITHIUM_APP_PATH . '/config/environment.php';
require LITHIUM_APP_PATH . '/libraries/autoload.php';

// Register any lithium libraries.
foreach (glob(LITHIUM_LIBRARY_PATH . '/li3_*') as $item) {
	Libraries::add(basename($item));
}

// Adding myself.
Libraries::add('cms_core', [
	'bootstrap' => false
]);

require LITHIUM_APP_PATH . '/config/connections.php';
require 'bootstrap/errors.php';
require 'bootstrap/action.php';

if (PHP_SAPI !== 'cli') {
	require 'bootstrap/cache.php';
}
require 'bootstrap/session.php';
require 'bootstrap/g11n.php';
require 'bootstrap/media.php';
require 'settings.php';

if (PHP_SAPI === 'cli') {
	require 'bootstrap/console.php';
}
require 'bootstrap/auth.php';
require 'panes.php';

// ------------------------------------------------------------------------------------------------

require 'media.php';
require 'widgets.php';

use li3_access\security\Access;

Access::config([
	'entity' => [
		'adapter' => 'Rules',
		'allowAny' => true // When at least one rule matches succeed.
	]
]);
$rules = Access::adapter('entity');

$rules->add('user.role:admin', function($user, $entity, $options) {
	return $user->role == 'admin';
});
$rules->add('any', function($user, $entity, $options) {
	return true;
});

// ------------------------------------------------------------------------------------------------

// Must come after cms_core but before any other libraries.
Libraries::add('cms_media');

// Register any cms_ libraries left.
foreach (glob(LITHIUM_LIBRARY_PATH . '/cms_*') as $item) {
	if (basename($item) === 'cms_core' || basename($item) === 'cms_media') {
		continue;
	}
	Libraries::add(basename($item));
}

// Register any ecommerce_ libraries.
if (is_dir(LITHIUM_LIBRARY_PATH .'/ecommerce_core')) {
	Libraries::add('ecommerce_core');

	foreach (glob(LITHIUM_LIBRARY_PATH . '/ecommerce_*') as $item) {
		if (basename($item) === 'ecommerce_core') {
			continue;
		}
		Libraries::add(basename($item));
	}
}

// TODO Refactor these into autoloaaded packages once
// they have enough contents.
Libraries::add('jsend', array(
	'path' => dirname(__DIR__) . '/libraries/jsend/src'
));
Libraries::add('avatar', array(
	'path' => dirname(__DIR__) . '/libraries/avatar/src'
));

?>