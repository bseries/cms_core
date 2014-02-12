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

use cms_core\models\Tokens;
use li3_flash_message\extensions\storage\FlashMessage;

class TokensController extends \cms_core\controllers\BaseController {

	use \cms_core\controllers\AdminIndexTrait;

	public function admin_generate() {
		Tokens::generate();

		FlashMessage::write('Token generated.');
		return $this->redirect(['action' => 'index', 'library' => 'cms_core']);
	}

	public function admin_void() {
		Tokens::void($token = $this->request->token);

		FlashMessage::write("Voided token `{$token}`.");
		return $this->redirect(['action' => 'index', 'library' => 'cms_core']);
	}
}

?>