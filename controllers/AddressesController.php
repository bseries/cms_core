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

use cms_core\models\Users;
use cms_core\models\Addresses;
use lithium\core\Environment;

class AddressesController extends \cms_core\controllers\BaseController {

	use \cms_core\controllers\AdminAddTrait;
	use \cms_core\controllers\AdminEditTrait;
	use \cms_core\controllers\AdminDeleteTrait;

	public function admin_index() {
		$data = Addresses::find('all', [
			'order' => ['id' => 'DESC']
		]);
		return compact('data');
	}

	protected function _selects($item) {
		$users = Users::find('list');
		$countries = Addresses::countries(Environment::get('locale'));

		return compact('users', 'countries');
	}
}

?>