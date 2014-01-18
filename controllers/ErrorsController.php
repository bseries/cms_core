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

class ErrorsController extends \lithium\action\Controller {

	public function fourohthree() {
		$this->_render['layout'] = 'error';
		$this->_render['template'] = '403';
		$this->response->status(403);
	}

	public function fourohfour() {
		$this->_render['layout'] = 'error';
		$this->_render['template'] = '404';
		$this->response->status(404);
	}

	public function fiveohoh() {
		$this->_render['layout'] = 'error';
		$this->_render['template'] = '500';
		$this->response->status(500);
	}

	public function fiveohthree() {
		$this->_render['layout'] = 'error';
		$this->_render['template'] = '503';
		$this->response->status(503);
	}

	public function browser() {
		$this->_render['layout'] = 'error';
		$this->_render['template'] = 'browser';
		$this->response->status(400);
	}

	public function maintenance() {
		$this->_render['layout'] = 'error';
		$this->_render['template'] = 'maintenance';
		$this->response->status(503);
		$this->response->headers['Retry-After'] = 3600; // s; 1 hour
	}
}

?>