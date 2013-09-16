<?php

namespace cms_core\controllers;

class ErrorsController extends \lithium\action\Controller {

	public function fourohfour() {
		$data = array_filter($this->request->data) + [
			'code' => 404,
			'reason' => null
		];

		$this->_render['layout'] = 'error';
		$this->_render['template'] = '404';
		$this->response->status(404);

		return $data;
	}

	public function fiveohoh() {
		$data = array_filter($this->request->data) + [
			'code' => 500,
			'reason' => null
		];

		$this->_render['layout'] = 'error';
		$this->_render['template'] = '500';
		$this->response->status(500);

		return $data;
	}

	public function fiveohthree() {
		$data = array_filter($this->request->data) + [
			'code' => 503,
			'reason' => null
		];

		$this->_render['layout'] = 'error';
		$this->_render['template'] = '503';
		$this->response->status(503);

		return $data;
	}

	public function browser() {
		$data = array_filter($this->request->data) + [
			'code' => 400,
			'reason' => null
		];

		$this->_render['layout'] = 'error';
		$this->_render['template'] = 'browser';
		$this->response->status(400);

		return $data;
	}

	public function maintenance() {
		$this->_render['layout'] = 'error';
		$this->_render['template'] = 'maintenance';
		$this->response->status(503);
		$this->response->headers['Retry-After'] = 3600; // s; 1 hour

		return $this->request->data;
	}
}

?>