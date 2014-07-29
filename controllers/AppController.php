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

use lithium\net\http\Router;

class AppController extends \cms_core\controllers\BaseController {

	public function admin_api_discover() {
		$base = ['controller' => 'media', 'library' => 'cms_media', 'admin' => true];

		$data = [
			'media:index' => Router::match($base + ['action' => 'api_index'], $this->request),
			'media:view' => Router::match($base + ['action' => 'api_view', 'id' => '__ID__'], $this->request),
			'media:transfer-preflight' => Router::match($base + ['action' => 'api_transfer_preflight'], $this->request),
			'media:transfer-meta' => Router::match($base + ['action' => 'api_transfer_meta'], $this->request),
			'media:transfer' => Router::match($base + ['action' => 'api_transfer'], $this->request) . '?title=__TITLE__'
		];

		$this->render(array('type' => $this->request->accepts(), 'data' => $data));
	}
}

?>