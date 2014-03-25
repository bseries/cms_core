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
use li3_flash_message\extensions\storage\FlashMessage;
use lithium\g11n\Message;
use lithium\security\Auth;
use cms_core\extensions\cms\Features;

class UsersController extends \cms_core\controllers\BaseController {

	use \cms_core\controllers\AdminDeleteTrait;
	use \cms_core\controllers\AdminActivateTrait;

	public function admin_index() {
		$data = Users::find('all', [
			'order' => ['name' => 'ASC']
		]);
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
				FlashMessage::write($t('Successfully saved.'), ['level' => 'success']);
				return $this->redirect(['action' => 'index', 'library' => 'cms_core']);
			} else {
				FlashMessage::write($t('Failed to save.'), ['level' => 'error']);
			}
		}
		$this->_render['template'] = 'admin_form';
		return compact('item') + $this->_selects($item);
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
				FlashMessage::write($t('Successfully saved.'), ['level' => 'success']);
				return $this->redirect(['action' => 'index', 'library' => 'cms_core']);
			} else {
				FlashMessage::write($t('Failed to save.'), ['level' => 'error']);
			}
		}
		$this->_render['template'] = 'admin_form';
		return compact('item') + $this->_selects($item);
	}

	protected function _selects($item) {
		extract(Message::aliases());

		$roles = Users::enum('role');
		$timezones = [
			'Europe/Berlin' => 'Europe/Berlin',
			'UTC' => 'UTC'
		];
		$currencies = [
			'EUR' => 'EUR',
			'USD' => 'USD'
		];
		$locales = [
			'de' => 'Deutsch',
			'en' => 'English'
		];
		if ($item) {
			$results = Addresses::find('all', [
				'conditions' => [
					'user_id' => $item->id
				]
			]);
			$addresses = [
				null => '-- ' . $t('no address') . ' --'
			];

			foreach ($results as $result) {
				$addresses[$result->id] = $result->format('oneline');
			}
		}
		return compact('roles', 'timezones', 'currencies', 'locales', 'addresses');
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

	// We don't need to check if current user is admin, as
	// anybody who can access the admin is an admin already.
	public function admin_change_role() {
		extract(Message::aliases());

		$item = Users::findById($this->request->id);
		$item->role = $this->request->role;

		if ($item->save(null, ['validate' => false, 'whitelist' => ['role']])) {
			FlashMessage::write($t("Assigned role `{$item->role}`."), ['level' => 'success']);
		} else {
			FlashMessage::write($t("Failed to assign role `{$item->role}`."), ['level' => 'error']);
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
				FlashMessage::write($t('Authenticated.'), ['level' => 'success']);
				return $this->redirect('/admin');
			}
			FlashMessage::write($t('Failed to authenticate.'), ['level' => 'error']);
			return $this->redirect($this->request->referer());
		}
	}

	public function admin_logout() {
		extract(Message::aliases());

		Auth::clear('default');

		FlashMessage::write($t('Successfully logged out.'), ['level' => 'success']);
		return $this->redirect('/admin/session');
	}

	// Overridden from trait.
	public function admin_activate() {
		extract(Message::aliases());

		$model = $this->_model;
		$model::pdo()->beginTransaction();
		$item = $model::first($this->request->id);

		$result = $item->save(
			['is_active' => true],
			['whitelist' => ['is_active'], 'validate' => false]
		);
		if (Features::read('user.sendActivationMail')) {
			$result = $result && Mailer::deliver('user_activated', [
				'to' => $item->email,
				'subject' => 'Ihr Konto wurde aktiviert.',
				'data' => [
					'user' => $item
				]
			]);
		}
		if ($result) {
			$model::pdo()->commit();
			FlashMessage::write($t('Activated.'), ['level' => 'success']);
		} else {
			$model::pdo()->rollback();
			FlashMessage::write($t('Failed to activate.'), ['level' => 'error']);
		}
		return $this->redirect($this->request->referer());
	}

}

?>