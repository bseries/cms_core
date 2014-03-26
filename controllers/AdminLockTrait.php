<?php
/**
 * Bureau
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

namespace cms_core\controllers;

use lithium\g11n\Message;
use li3_flash_message\extensions\storage\FlashMessage;

trait AdminLockTrait {

	public function admin_lock() {
		extract(Message::aliases());
		$model = $this->_model;

		$result = $model::first($this->request->id)->save(
			['is_locked' => true],
			[
				'whitelist' => ['is_locked'],
				'validate' => false,
				'lockWriteThrough' => true
			]
		);
		if ($result) {
			FlashMessage::write($t('Successfully locked.'), ['level' => 'success']);
		} else {
			FlashMessage::write($t('Failed to lock.'), ['level' => 'error']);
		}
		return $this->redirect($this->request->referer());
	}

	public function admin_unlock() {
		extract(Message::aliases());
		$model = $this->_model;

		$result = $model::first($this->request->id)->save(
			['is_locked' => false],
			[
				'whitelist' => ['is_locked'],
				'validate' => false,
				'lockWriteThrough' => true
			]
		);
		if ($result) {
			FlashMessage::write($t('Successfully unlocked.'), ['level' => 'success']);
		} else {
			FlashMessage::write($t('Failed to unlock.'), ['level' => 'error']);
		}
		return $this->redirect($this->request->referer());
	}
}

?>