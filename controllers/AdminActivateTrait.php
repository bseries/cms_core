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

trait AdminActivateTrait {

	public function admin_activate() {
		extract(Message::aliases());

		$model = $this->_model;

		$result = $model::first($this->request->id)->save(
			['is_active' => true],
			['whitelist' => ['is_active'], 'validate' => false]
		);
		if ($result) {
			FlashMessage::write($t('Activated.'), ['level' => 'success']);
		} else {
			FlashMessage::write($t('Failed to activate.'), ['level' => 'error']);
		}
		return $this->redirect($this->request->referer());
	}

	public function admin_deactivate() {
		extract(Message::aliases());
		$model = $this->_model;

		$result = $model::first($this->request->id)->save(
			['is_active' => false],
			['whitelist' => ['is_active'], 'validate' => false]
		);
		if ($result) {
			FlashMessage::write($t('Deactivated.'), ['level' => 'success']);
		} else {
			FlashMessage::write($t('Failed to deactivate.'), ['level' => 'error']);
		}
		return $this->redirect($this->request->referer());
	}
}

?>