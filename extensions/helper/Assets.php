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

namespace cms_core\extensions\helper;

use cms_core\extensions\cms\Settings;
use cms_core\models\Assets as AssetsModel;

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
				$item = $this->url($item, '.css');
				$path[$i] = $this->_context->html->style($item, $scope);
			}
			return ($scope['inline']) ? join("\n\t", $path) . "\n" : null;
		}
		$path = $this->url($path, '.css');
		return $this->_context->html->style($path, $options);
	}

	public function script($path, array $options = array()) {
		$defaults = array('inline' => true);
		list($scope, $options) = $this->_options($defaults, $options);

		if (is_array($path)) {
			foreach ($path as $i => $item) {
				$item = $this->url($item, '.js');
				$path[$i] = $this->script($item, $scope);
			}
			return ($scope['inline']) ? join("\n\t", $path) . "\n" : null;
		}
		if (strpos($path, '://') === false) {
			$path = $this->url($path, '.js');
		}
		return $this->_context->html->script($path, $options);
	}

	public function url($path, $suffix = null) {
		if (strpos($path, '://') !== false) {
			return $path;
		}
		$version = Settings::read('project.version');

		$base = AssetsModel::base('http');
		return $base . '/v:' . $version . $path . $suffix;
	}

	public function urls($pattern) {
		$fileBase = parse_url(AssetsModel::base('file'), PHP_URL_PATH);
		$httpBase = AssetsModel::base('http');

		$results = glob($fileBase . $pattern);

		foreach ($results as &$result) {
			$result = str_replace($fileBase, $httpBase, $result);
		}
		return $results;
	}
}

?>