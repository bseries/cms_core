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

use cms_core\models\Users;
use li3_flash_message\extensions\storage\FlashMessage;

class UsersController extends \lithium\action\Controller {

	public function admin_index() {
		$data = Users::find('all');
		return compact('data');
	}

	public function admin_delete() {
		$item = Users::findById($this->request->id);

		if ($item->delete()) {
			FlashMessage::write('Konto gelöscht.');
		} else {
			FlashMessage::write('Das Konto konnte nicht gelöscht werden.');
		}
		$this->redirect($this->request->referer());
	}

	public function admin_activate() {
		$item = Users::findById($this->request->id);

		if ($item->activate()) {
			FlashMessage::write('Konto aktiviert.');
		} else {
			FlashMessage::write('Das Konto konnte nicht aktiviert werden.');
		}
		$this->redirect($this->request->referer());
	}

	public function admin_deactivate() {
		$item = Users::findById($this->request->id);

		if ($item->deactivate()) {
			FlashMessage::write('Konto deaktiviert.');
		} else {
			FlashMessage::write('Das Konto konnte nicht deaktiviert werden.');
		}
		$this->redirect($this->request->referer());
	}
}

?>