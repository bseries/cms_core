<?php

use lithium\core\Libraries;
use lithium\core\Environment;
use lithium\g11n\Message;

extract(Message::aliases());

Libraries::add('temporary', [
	'path' => dirname(__DIR__) . '/libraries/temporary/src'
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

Environment::set(true, [
	'features' => [
		'registerWithTokenOnly' => true
	],
	'modules' => [
		'tokens' => [
			'library' => 'cms_core', 'title' => $t('Tokens'), 'name' => 'tokens', 'slug' => 'tokens'
		],
		'users' => [
			'library' => 'app', 'title' => $t('Users'), 'name' => 'users', 'slug' => 'users'
		]
	]
]);

?>