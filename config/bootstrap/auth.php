<?php

use lithium\security\Auth;

Auth::config(array(
	'default' => array(
		'adapter' => 'Form',
		'model' => 'Users',
		'fields' => array('email', 'password'),
		'scope' => array('is_active' => true)
	)
));

?>
