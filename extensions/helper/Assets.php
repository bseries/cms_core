<?php

namespace cms_core\extensions\helper;

use lithium\core\Environment;

class Assets extends \lithium\template\Helper {

	public function image($path, array $options = array()) {
		$path = $this->url($path);
		return $this->_context->html->image($path, $options);
	}

	public function style($path, array $options = array()) {
		$defaults = array('type' => 'stylesheet', 'inline' => true);
		list($scope, $options) = $this->_options($defaults, $options);

		if (is_array($path)) {
			foreach ($path as $i => $item) {
				$item = $this->url($item . '.css');
				$path[$i] = $this->_context->html->style($item, $scope);
			}
			return ($scope['inline']) ? join("\n\t", $path) . "\n" : null;
		}
		$path = $this->url($path . '.css');
		return $this->_context->html->style($path, $options);
	}

	public function script($path, array $options = array()) {
		$defaults = array('inline' => true);
		list($scope, $options) = $this->_options($defaults, $options);

		if (is_array($path)) {
			foreach ($path as $i => $item) {
				$item = $this->url($item . '.js');
				$path[$i] = $this->script($item, $scope);
			}
			return ($scope['inline']) ? join("\n\t", $path) . "\n" : null;
		}
		if (strpos($path, '://') === false) {
			$path = $this->url($path . '.js');
		}
		return $this->_context->html->script($path, $options);
	}

	public function url($path) {
		if (strpos($path, '://') !== false) {
			return $path;
		}
		$version = Environment::get('project.version');
		$base = Environment::get('assets.http');
		return $base . '/v' . $version . $path;
	}
}

?>