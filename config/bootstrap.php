<?php

use lithium\core\Libraries;
use lithium\core\Environment;

Libraries::add('temporary', array(
	'path' => dirname(__DIR__) . '/libraries/temporary/src'
));
Libraries::add('li3_lldr', array(
	'path' => dirname(__DIR__) . '/libraries/li3_lldr'
));
Libraries::add('li3_flash_message', array(
	'path' => dirname(__DIR__) . '/libraries/li3_flash_message'
));
Libraries::add('li3_access', array(
	'path' => dirname(__DIR__) . '/libraries/li3_access'
));
Libraries::add('li3_mailer', array(
	'path' => dirname(__DIR__) . '/libraries/li3_mailer'
));

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

Environment::set(true, array(
	'modules' => array(
		'tokens' => array(
			'library' => 'cms_core', 'title' => 'Tokens', 'name' => 'tokens', 'slug' => 'tokens'
		)
	)
));

?>