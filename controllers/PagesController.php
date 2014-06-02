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

namespace cms_core\controllers;

use cms_core\extensions\cms\Widgets;

class PagesController extends \cms_core\controllers\BaseController {

	public function admin_home() {
		$widgets = Widgets::read()->find(function($item) {
			return $item['group'] === 'dashboard';
		});
		return compact('widgets');
	}

	public function admin_support() {}

	public function admin_styleguide() {
		$this->_render['layout'] = 'default';
	}
}

?>