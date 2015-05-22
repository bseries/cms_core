<?php
/**
 * CMS Core
 *
 * Copyright (c) 2013-2014 Atelier Disko - All rights reserved.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 */

namespace cms_core\extensions\helper;

use base_media\models\Media;
use base_core\extensions\cms\Settings;

class Editor extends \lithium\template\Helper {

	public function field($name, array $options = []) {
		$options += [
			'class' => null,
			'features' => null,
			'size' => 'beta'
		];
		$classes = explode(' ', $option['class']);

		$classes[] = 'use-editor';

		$classes[] = 'editor-size--' . $options['size'];

		if (is_string($options['features'])) {
			$options['features'] = Settings::read('editor.features.' . $options['features']);
		}
		foreach ($options['features'] as $feature) {
			$classes[] = 'editor-' . $feature;
		}

		$options['type'] = 'textarea';
		$options['class'] = implode(' ', $classes);
		unset($options['features']);
		unset($options['size']);
		return $this->_context->form->field($name, $options);
	}

	// Parses HTML generated with
	public function parse($html, array $options = []) {
		$options += [
			'mediaVersion' => 'fix0'
		];
		$regex = '#(<img\s+data-media-id="([0-9]+)".*?>)#i';

		if (!preg_match_all($regex, $html, $matches, PREG_SET_ORDER)) {
			return $html;
		}

		foreach ($matches as $match) {
			$medium = Media::find('first', [
				'conditions' => [
					'id' => $match[2]
				]
			]);
			if (!$medium) {
				continue;
			}
			$replace = $this->_context->media->image(
				$medium->version($options['mediaVersion'])
			);
			$html = str_replace($match[0], $replace, $html);
		}
		return $html;
	}
}

?>