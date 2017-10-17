<?php
/**
 * Copyright 2014 David Persson. All rights reserved.
 * Copyright 2016 Atelier Disko. All rights reserved.
 *
 * Use of this source code is governed by a BSD-style
 * license that can be found in the LICENSE file.
 */

namespace cms_core\config;

use base_core\extensions\cms\Widgets;

Widgets::register('authoring',  function() {
	return [
		'data' => []
	];
}, [
	'type' => Widgets::TYPE_TABLE,
	'group' => Widgets::GROUP_DASHBOARD,
	'weight' => Widgets::WEIGHT_HIGH
]);

?>