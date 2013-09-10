<?php

namespace cms_core\controllers;

use cms_core\models\Tokens;
use li3_flash_message\extensions\storage\FlashMessage;

class TokensController extends \lithium\action\Controller {

	public function admin_index() {
		$data = Tokens::find('all');
		return compact('data');
	}

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
