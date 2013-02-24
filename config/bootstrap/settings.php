<?php

use lithium\core\Environment;

$config = array(
	'site' => array(
		'email' => 'mail@atelierdisko.de',
		'phone' => '+49 123 4567'
	),
	'service' => array(
		'googleAnalytics' => array(
			'account' => ''
		),
		'facebook' => array(
			'pageUrl' => 'https://www.facebook.com/AtelierDisko'
		),
		'twitter' => array(
			'username' => 'atelierdisko'
		),
		'tumblr' => array(
			'username' => 'atelierdisko'
		)
	)
);
Environment::set('production', $config);
Environment::set('development', $config);

?>