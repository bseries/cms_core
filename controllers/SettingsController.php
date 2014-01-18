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

namespace cms_core\controllers;

use cms_core\extensions\cms\Settings;
use cms_core\extensions\cms\Features;

class SettingsController extends \lithium\action\Controller {

	public function admin_index() {
		$settings = Settings::read();
		$features = Features::read();
		return compact('settings', 'features');
	}
}

?>