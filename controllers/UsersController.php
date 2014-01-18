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
use li3_flash_message\extensions\storage\FlashMessage;
use lithium\g11n\Message;
use lithium\security\Auth;

class UsersController extends \lithium\action\Controller {

	public function admin_index() {
		$data = Users::find('all');
		return compact('data');
	}

	public function admin_add() {
		extract(Message::aliases());

		$item = Users::create();

		if ($this->request->data) {
			$this->request->data['password'] = Users::hashPassword(
				$this->request->data['password']
			);
			$events = ['create', 'passwordInit'];

			if ($item->save($this->request->data, compact('events'))) {
				FlashMessage::write($t('Successfully saved.'));
				return $this->redirect(['action' => 'index', 'library' => 'cms_core']);
			} else {
				FlashMessage::write($t('Failed to save.'));
			}
		}
		$roles = Users::enum('role');

		$this->_render['template'] = 'admin_form';
		return compact('item', 'roles');
	}

	public function admin_edit() {
		extract(Message::aliases());

		$item = Users::find($this->request->id);

		if ($this->request->data) {
			$events = ['create'];

			if ($this->request->data['password']) {
				$events[] = 'passwordChange';

				$this->request->data['password'] = Users::hashPassword(
					$this->request->data['password']
				);
			} else {
				unset($this->request->data['password']);
			}

			if ($item->save($this->request->data)) {
				FlashMessage::write($t('Successfully saved.'));
				return $this->redirect(['action' => 'index', 'library' => 'cms_core']);
			} else {
				FlashMessage::write($t('Failed to save.'));
			}
		}
		$roles = Users::enum('role');

		$this->_render['template'] = 'admin_form';
		return compact('item', 'roles');
	}

	public function admin_generate_passwords() {
		$passwords = [];

		for ($i = 0; $i < 42; $i++) {
			$passwords[] = Users::generatePassword(10, 1);
		}
		return [
			'status' => 'success',
			'data' => compact('passwords')
		];
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

	// We don't need to check if current user is admin, as
	// anybody who can access the admin is an admin already.
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

	public function admin_session() {
		$this->_render['layout'] = 'admin_blank';
	}

	public function admin_login() {
		extract(Message::aliases());

		if ($this->request->data) {
			if (Auth::check('default', $this->request)) {
				FlashMessage::write($t('Authenticated.'));
				return $this->redirect('/admin');
			}
			FlashMessage::write($t('Failed to authenticate.'));
			return $this->redirect($this->request->referer());
		}
	}

	public function admin_logout() {
		extract(Message::aliases());

		Auth::clear('default');

		FlashMessage::write('Successfully logged out.');
		return $this->redirect('/admin/session');
	}

}

?>