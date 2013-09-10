<?php

use lithium\security\Auth;

Auth::config([
	'default' => [
		'adapter' => 'Form',
		'model' => 'Users',
		'fields' => ['email', 'password'],
		'scope' => ['is_active' => true]
	]
]);

?>