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