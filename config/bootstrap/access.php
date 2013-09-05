<?php

use lithium\security\Auth;
use lithium\action\Dispatcher;
use li3_access\security\Access;
use li3_access\security\AccessDeniedException;

Access::config(array(
	'default' => array('adapter' => 'Rules')
));
$rules = Access::adapter('default');

// Restrict admin access to users from group admin.
$rules->add('admin', function($user, $request, $options) {
	// Which resources to protect. Restrict only certain URLs all others pass.
	if (strpos($request->url, 'admin/') === false) {
		return true;
	}
	return $user['group'] == 'admin';
});

// Restrict access to logged in users for authoring.
$rules->add('userAuthoring', function($user, $request, $options) {
	// Which resources to protect. Restrict only certain URLs all others pass.
	if (!preg_match('#(edit|add|delete)/#', $request->url)) {
		return true;
	}
	// We don't care about the role of the user here.
	return (boolean) $user;
});

// Actually run the checks on each and every request.
Dispatcher::applyFilter('run', function($self, $params, $chain) {
	$access = Access::check('default', Auth::check('default'), $params['request'], array(
		'rules' => array('admin', 'userAuthoring')
	));
	// Caution: $access is empty when access is _granted_.
	// @todo: Better error page, can this be handled automatically by the Accesss class?
	if ($access) {
		throw new AccessDeniedException('FORBIDDEN');
	}
	return $chain->next($self, $params, $chain);
});


?>