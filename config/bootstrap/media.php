<?php

use lithium\util\Collection;
use lithium\net\http\Media;
use lithium\core\Libraries;

Collection::formats('lithium\net\http\Media');

Media::type('html', 'text/html', [
	'view' => 'lithium\template\View',
	'paths' => [
		'template' => '{:library}/views/{:controller}/{:template}.{:type}.php',
		'layout'   => [
			Libraries::get('cms_core', 'path') . '/views/layouts/{:layout}.{:type}.php',
			Libraries::get('app', 'path') . '/views/layouts/{:layout}.{:type}.php',
			'{:library}/views/layouts/{:layout}.{:type}.php'
		],
		'element'  => '{:library}/views/elements/{:template}.{:type}.php'
	]
]);

?>