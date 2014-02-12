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

trait AdminAddTrait {

	public function admin_add() {
		extract(Message::aliases());
		$model = $this->_model;

		$item = $model::create();

		if ($this->request->data) {
			if ($item->save($this->request->data)) {
				FlashMessage::write($t('Successfully saved.'), ['level' => 'success']);

				return $this->redirect(['action' => 'index', 'library' => $this->_library]);
			} else {
				FlashMessage::write($t('Failed to save.'), ['level' => 'error']);
			}
		}
		$this->_render['template'] = 'admin_form';
		return compact('item');
	}
}

?>