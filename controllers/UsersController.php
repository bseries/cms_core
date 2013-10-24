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
use lithium\g11n\Message;
use lithium\security\Auth;

class UsersController extends \lithium\action\Controller {

	public function admin_index() {
		$data = Users::find('all');
		return compact('data');
	}

	public function admin_delete() {
		extract(Message::aliases());

		$item = Users::findById($this->request->id);

		if ($item->delete()) {
			FlashMessage::write($t('Deleted.'));
		} else {
			FlashMessage::write($t('Failed to delete.'));
		}
		$this->redirect($this->request->referer());
	}

	public function admin_activate() {
		extract(Message::aliases());

		$item = Users::findById($this->request->id);

		if ($item->activate()) {
			FlashMessage::write($t('Activated.'));
		} else {
			FlashMessage::write($t('Failed to activate.'));
		}
		$this->redirect($this->request->referer());
	}

	public function admin_deactivate() {
		$item = Users::findById($this->request->id);

		if ($item->deactivate()) {
			FlashMessage::write($t('Deactivated.'));
		} else {
			FlashMessage::write($t('Failed to deactivate.'));
		}
		$this->redirect($this->request->referer());
	}

	public function admin_change_role() {
		extract(Message::aliases());

		$item = Users::findById($this->request->id);
		$item->role = $this->request->role;

		if ($item->save(null, ['validate' => false, 'whitelist' => ['role']])) {
			FlashMessage::write($t("Assigned role `{$item->role}`."));
		} else {
			FlashMessage::write($t("Failed to assign role `{$item->role}`."));
		}
		$this->redirect($this->request->referer());
	}

	public function admin_session() {}

	public function admin_login() {
		extract(Message::aliases());

		if ($this->request->data) {
			if (Auth::check('default', $this->request)) {
				FlashMessage::write($t('Authenticated.'));
				return $this->redirect('/');
			}
			FlashMessage::write($t('Failed to authenticate.'));
			return $this->redirect($this->request->referer());
		}
	}

	public function admin_logout() {
		extract(Message::aliases());

		Auth::clear('default');

		FlashMessage::write('Successfully logged out.');
		return $this->redirect('/');
	}

	public function admin_change_password() {
		extract(Message::aliases());

		$user = Auth::check('default');

		$item = Users::find('first', [
			'conditions' => [
				'id' => $user['id'],
				'role' => 'admin'
			]
		]);

		if ($this->request->data) {
			// Re-auth; here for additional security; password changes should always be re-authed.
			$result = Users::checkPassword(
				$this->request->data['password_old'],
				$item->password
			);
			if (!$result) {
				$item->errors('password_old', $t('Invalid password.'));
				return compact('item');
			}

			// Try to replace existing password.
			$item->password = Users::hashPassword($this->request->data['password']);
			$item->password_repeat = $this->request->data['password_repeat'];
			$result = $item->save(null, [
				'events' => ['passwordChange'],
				'whitelist' => ['password']
			]);
			if ($result) {
				FlashMessage::write($t('Password changed.'));
				return $this->redirect('/');
			}
		}
		return compact('item');
	}
}

?>