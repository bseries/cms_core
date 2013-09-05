<?php

use lithium\storage\Session;
use lithium\action\Dispatcher;
use lithium\core\Environment;

Dispatcher::applyFilter('_call', function($self, $params, $chain) {
	// late... plugin comes before app
	Session::config(array(
		'default' => array('adapter' => 'Php', 'session.name' => Environment::get('project.name'))
		// 'default' => array(
		// 	'adapter' => 'Cookie',
		// 	'strategies' => array(
		// 		'Hmac' => array('secret' => Environment::get('security.cookieSecret'))
		// 	)
		// )
	));
	return $chain->next($self, $params, $chain);
});

?>