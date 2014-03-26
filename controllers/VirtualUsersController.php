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

use cms_core\models\VirtualUsers;
use cms_core\models\Currencies;
use cms_core\models\Addresses;
use li3_flash_message\extensions\storage\FlashMessage;
use lithium\g11n\Message;
use lithium\security\Auth;

class VirtualUsersController extends \cms_core\controllers\BaseController {

	use \cms_core\controllers\AdminDeleteTrait;
	use \cms_core\controllers\AdminActivateTrait;
	use \cms_core\controllers\AdminAddTrait;
	use \cms_core\controllers\AdminEditTrait;

	public function admin_index() {
		$data = VirtualUsers::find('all', [
			'order' => ['name' => 'ASC']
		]);
		return compact('data');
	}

	protected function _selects($item) {
		extract(Message::aliases());

		$roles = VirtualUsers::enum('role');
		$timezones = [
			'Europe/Berlin' => 'Europe/Berlin',
			'UTC' => 'UTC'
		];
		$currencies = Currencies::find('list');
		$locales = [
			'de' => 'Deutsch',
			'en' => 'English'
		];
		if ($item) {
			$addresses = [
				null => '-- ' . $t('no address') . ' --'
			];
			$addresses += Addresses::find('list', [
				'conditions' => [
					'virtual_user_id' => $item->id
				]
			]);
		}
		return compact('roles', 'timezones', 'currencies', 'locales', 'addresses');
	}
}

?>