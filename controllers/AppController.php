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

// use lithium\core\Environment;
use cms_media\models\MediaVersions;
use cms_core\models\Assets;
use lithium\net\http\Router;

class AppController extends \cms_core\controllers\BaseController {

	public function admin_api_discover() {
		$data = [];

/*
		$scheme = $scheme ?: $this->request->is('ssl') ? 'https' : 'http';
		$data['app'] = [
			'base' => '/admin'
		];
		$data['media'] = [
			'base' => MediaVersions::base($scheme)
		];
		$data['assets'] = [
			'base' => Assets::base($scheme)
		];
		 */
		$base = ['controller' => 'media', 'library' => 'cms_media', 'admin' => true];
		$data['routes'] = [
			'media:index' => Router::match($base + ['action' => 'api_index'], $this->request),
			'media:view' => Router::match($base + ['action' => 'api_view', 'id' => '__ID__'], $this->request),
			'media:transfer' => Router::match($base + ['action' => 'api_transfer'], $this->request) . '?title=__TITLE__'
		];

		$data = $data['routes'];

		$this->render(array('type' => $this->request->accepts(), 'data' => $data));
	}
}

?>