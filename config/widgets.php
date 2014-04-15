<?php
/**
 * Bureau Core
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

use lithium\g11n\Message;
use cms_core\extensions\cms\Widgets;

extract(Message::aliases());

Widgets::register('cms_core', 'support', function() use ($t) {
	return [
		'class' => null,
		'url' => [
			'controller' => 'Pages', 'action' => 'support',
			'library' => 'cms_core', 'admin' => true
		],
		'title' => $t('Contact Support')
	];
}, [
	'type' => Widgets::TYPE_QUICKDIAL,
	'group' => Widgets::GROUP_DASHBOARD,
]);

?>