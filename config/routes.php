<?php

use lithium\net\http\Router;
use lithium\core\Environment;

Router::connect(
	'/admin/{:args}',
	array('admin' => true),
	array(
		'continue' => true,
		'persist' => array('admin', 'controller')
	)
);

Router::connect('/dashboard', array(
	'controller' => 'pages', 'action' => 'home', 'library' => 'cms_core'
));

Router::connect('/tokens/{:action}/{:token:[0-9a-f]{8,16}}', array(
	'controller' => 'tokens', 'library' => 'cms_core'
));
Router::connect('/tokens/{:action}/{:args}', array(
	'controller' => 'tokens', 'library' => 'cms_core'
));

?>