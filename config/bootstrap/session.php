<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

use lithium\storage\Session;
use lithium\core\Environment;

Session::config([
	'default' => ['adapter' => 'Php', 'session.name' => Environment::get('project.name')]
	// 'default' => array(
	// 	'adapter' => 'Cookie',
	// 	'strategies' => array(
	// 		'Hmac' => array('secret' => Environment::get('security.cookieSecret'))
	// 	)
	// )
]);

?>