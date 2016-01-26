<?php
/**
 * CMS Core
 *
 * Copyright (c) 2013 Atelier Disko - All rights reserved.
 *
 * Licensed under the AD General Software License v1.
 *
 * This software is proprietary and confidential. Redistribution
 * not permitted. Unless required by applicable law or agreed to
 * in writing, software distributed on an "AS IS" BASIS, WITHOUT-
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *
 * You should have received a copy of the AD General Software
 * License. If not, see http://atelierdisko.de/licenses.
 */

namespace cms_core\extensions\helper;

use Exception;
use base_media\models\Media;
use base_core\extensions\cms\Settings;

/**
 * Editor helper works in tandem with the WYSIWYG editor and
 * some editor.js.
 */
class Editor extends \lithium\template\Helper {

	// Generates form field HTML with appropriate classes so that
	// editor.js and the CSS can hook into. It is possible to use
	// feature sets by providing a feature set name as `features`.
	public function field($name, array $options = []) {
		$options += [
			'features' => null,
			'size' => 'beta'
		];
		$classes = [];

		$classes[] = 'use-editor';
		$classes[] = 'editor-size--' . $options['size'];

		if (is_string($options['features'])) {
			$options['features'] = Settings::read('editor.features.' . $options['features']);
		}
		foreach ($options['features'] as $feature) {
			$classes[] = 'editor-' . $feature;
		}

		$options['type'] = 'textarea';
		$options['wrap'] = ['class' => implode(' ', $classes)];
		unset($options['features']);
		unset($options['size']);
		return $this->_context->form->field($name, $options);
	}

	// Parses HTML saved via the editor. Media placeholders can
	// be dynamically replaced. Provide a version string as `'mediaVersion'`,
	// that will be used to replace and generate images only. Provide
	// a callable to dynamcially decide what to do. The callable must return
	// the replacement HTML.
	// ```
	// function($medium) {
	//	return $this->_context->media->image($medium->version('fix10'));
	// }
	// ```
	public function parse($html, array $options = []) {
		$options += [
			'mediaVersion' => null
		];
		$regex = '#(<img.*data-media-id="([0-9]+)".*?>)#iU';

		if (!$options['mediaVersions']) {
			throw new Exception('No media version provided.');
		}
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
			if (is_callable($options['mediaVersion'])) {
				$replace = $options['mediaVersion']($medium);
			} else {
				$replace = $this->_context->media->image(
					$medium->version($options['mediaVersion'])
				);
			}
			$html = str_replace($match[0], $replace, $html);
		}
		return $html;
	}
}

?>