<?php

use lithium\storage\Session;
use lithium\security\Auth;
use lithium\action\Dispatcher;
use lithium\action\Response;
use lithium\core\Environment;

$name = basename(LITHIUM_APP_PATH);
Session::config(array(
	// 'cookie' => array('adapter' => 'Cookie', 'name' => $name),
	'default' => array('adapter' => 'Php', 'session.name' => $name)
));

Dispatcher::applyFilter('_call', function($self, $params, $chain) {
	// late...
	Auth::config(array(
		'http' => array(
			'adapter' => 'Http',
			'realm' => 'Application Administration',
			'method' => 'digest',
			'users' => Environment::get('users')
		)
	));

	$url = $params['request']->url;

	$granted = strpos($url, 'admin') !== 0;
	$granted = $granted || Auth::check('http', $params['request']);

	if (!$granted) {
		return new Response(array('status' => 401, 'body' => 'Access denied.'));
	}
	return $chain->next($self, $params, $chain);
});

?>