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

trait AdminPublishTrait {

	public function admin_publish() {
		extract(Message::aliases());
		$model = $this->_model;

		$item = $model::find($this->request->id);
		$item->save(['is_published' => true]);
		FlashMessage::write($t('Successfully published.'));

		return $this->redirect($this->request->referer());
	}

	public function admin_unpublish() {
		extract(Message::aliases());
		$model = $this->_model;

		$item = $model::find($this->request->id);
		$item->save(['is_published' => false]);
		FlashMessage::write($t('Successfully unpublished.'));

		return $this->redirect($this->request->referer());
	}
}

?>