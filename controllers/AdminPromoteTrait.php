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

trait AdminPromoteTrait {

	public function admin_promote() {
		extract(Message::aliases());
		$model = $this->_model;

		$result = $model::first($this->request->id)->save(
			['is_promoted' => true],
			['whitelist' => ['is_promoted'], 'validate' => false]
		);
		if ($result) {
			FlashMessage::write($t('Successfully promoted.'), ['level' => 'success']);
		} else {
			FlashMessage::write($t('Failed to promote.'), ['level' => 'error']);
		}
		return $this->redirect($this->request->referer());
	}

	public function admin_unpromote() {
		extract(Message::aliases());
		$model = $this->_model;

		$result = $model::first($this->request->id)->save(
			['is_promoted' => false],
			['whitelist' => ['is_promoted'], 'validate' => false]
		);
		if ($result) {
			FlashMessage::write($t('Successfully unpromoted.'), ['level' => 'success']);
		} else {
			FlashMessage::write($t('Failed to unpromote.'), ['level' => 'error']);
		}
		return $this->redirect($this->request->referer());
	}
}

?>