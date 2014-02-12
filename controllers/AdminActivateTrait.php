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

		$item = $model::create(['id' => $this->request->id, 'is_active' => true]);

		if ($item->save()) {
			FlashMessage::write($t('Activated.'));
		} else {
			FlashMessage::write($t('Failed to activate.'));
		}
		return $this->redirect($this->request->referer());
	}

	public function admin_deactivate() {
		extract(Message::aliases());
		$model = $this->_model;

		$item = $model::create(['id' => $this->request->id, 'is_active' => false]);

		if ($item->save()) {
			FlashMessage::write($t('Deactivated.'));
		} else {
			FlashMessage::write($t('Failed to deactivate.'));
		}
		return $this->redirect($this->request->referer());
	}
}

?>