<?php

use lithium\core\Environment;

$config = [
	'site' => [
		'email' => 'mail@atelierdisko.de',
		'phone' => '+49 123 4567'
	],
	'service' => [
		'googleAnalytics' => [
			'account' => ''
		],
		'facebook' => [
			'pageUrl' => 'https://www.facebook.com/AtelierDisko'
		],
		'twitter' => [
			'username' => 'atelierdisko'
		],
		'tumblr' => [
			'username' => 'atelierdisko'
		]
	]
];
Environment::set('production', $config);
Environment::set('development', $config);

?>