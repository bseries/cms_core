<?php
/**
 * CMS Base
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * Licensed under the AD General Software License v1.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *
 * You should have received a copy of the AD General Software
 * License. If not, see http://atelierdisko.de/licenses.
 */

namespace cms_core\config;

use base_core\extensions\cms\Settings;

Settings::register('editor.features', [
	'full' => [
		'basic',
		'headline',
		'size',
		// 'line',
		'link',
		'list',
		// 'media',
		// 'history',
		// 'quote',
		// 'aside',
	],
	'minimal' => [
		'basic',
		'link'
	]
]);

?>