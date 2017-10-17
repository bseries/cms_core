<?php
/**
 * Copyright 2013 David Persson. All rights reserved.
 * Copyright 2016 Atelier Disko. All rights reserved.
 *
 * Use of this source code is governed by a BSD-style
 * license that can be found in the LICENSE file.
 */

namespace cms_core\config;

use base_core\extensions\cms\Panes;
use lithium\g11n\Message;

extract(Message::aliases());

Panes::register('cms', [
	'title' => $t('Bureau', ['scope' => 'cms_core']),
	'weight' => 10
]);

?>