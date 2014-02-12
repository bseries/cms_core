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

trait AdminOrderTrait {

	public function admin_order() {
		extract(Message::aliases());
		$model = $this->_model;

		$ids = $this->request->data['ids'];
		$model::weightSequence($ids);
		FlashMessage::write($t('Successfully updated order.'));

		return $this->render(['head' => true]);
	}
}

?>