<?php

namespace cms_core\extensions\helper;

class Nav extends \lithium\template\Helper {

	const COMPLETE_MATCH = 10;
	const PARTIAL_MATCH = 5;
	const PARTIAL_MISMATCH = -5;
	const COMPLETE_MISMATCH = -10;

	public $helpers = array('Html');

	private $_items = array();

	/**
	 * For accessibility purposes.
	 *
	 * @param string $to
	 * @return string HTML
	 */
	public function skip($to = 'content') {
		$html  = '<p class="hide">';
		$html .= $this->_context->html->link('Skip navigation.', "#{$to}");
		$html .= '</p>';

		return $html;
	}

	public function add($section, $title, $url = null, array $options = []) {
		if (is_array($title)) {
			foreach($title as $item) {
				$this->add($section, $item['title'], $item['url'], (array) $url);
			}
			return null;
		}
		$default = array(
			'id' => null,
			'class' => null,
			'escape' => true,
			'active' => null,
			'title' => null,
			'rel' => null,
			'target' => null
		);
		$options = array_merge($default, $options);
		$this->_items[$section][] = array(
			'link' => array(
				'rel' => $options['rel'],
				'target' => $options['target']
			),
			'title' => $title,
			'url' => $url,
			'id' => $options['id'],
			'class' => $options['class'],
			'escape' => $options['escape'],
			'active' => $options['active'],
			'_title' => $options['title'] // This obviously is a hack :)
		);
	}

	// match: strict, loose, diff, item
	public function generate($section, $options = array(), array $items = array()) {
		$default = array(
			'match' => 'item',
			'reset' => false,
			'class' => 'nav',
			'tag' => 'ul',
			'itemTag' => 'li',
			'id' => null
		);
		$options += $default;
		$out = null;

		if (empty($items)) {
			if (!isset($this->_items[$section])) {
				return null;
			}
			$items = $this->_items[$section];
		}

		$active = array('key' => null, 'match' => null);

		foreach ($items as $key => &$item) {
			if (isset($item['url'])) {
				$url = $this->url($item['url']);
				$url = strtok($url, '?');

				switch ($options['match']) {
					case 'contain':
					case 'loose':
						$url = strtok($url, ':');
					case 'strict':
						$match = $this->_matchContain($url, $this->here);

						if ($options['match'] === 'strict') {
							$requireMatch = self::COMPLETE_MATCH;
						} else {
							$requireMatch = self::PARTIAL_MATCH;
						}
						if ($match >= $requireMatch || ($match > $active['match'] && $active['match'])) {
							$active = array('key' => $key, 'match' => $match);
						}
						break;
					case 'diff':
						$count = $this->_countDiffUrls($url, $this->here);

						if ($count < $active['match'] || $active['match']) {
							$active = array('key' => $key, 'match' => $count);
						}
						break;
					case 'option':
						if ($item['active']) {
							$active = array('key' => $key, 'match' => true);
						}
						break;
				}
				$item['url'] = $this->_context->html->link($item['title'], $item['url'], array(
					'escape' => $item['escape'],
					'title' => $item['_title']
				) + Set::filter($item['link']));
			} else {
				$url = null;
				$item['url'] = $item['title'];
			}
		}
		unset($item);

		if (isset($active['key'])) {
			$items[$active['key']] = $this->addClass($items[$active['key']], 'active');
		}

		/* Format */
		$out = null;
		foreach ($items as $item) {
			if ($options['itemTag']) {
				$attributes = array('class' => $item['class'], 'id' => $item['id']);
				$out .= $this->_context->html->tag($options['itemTag'], $item['url'], Set::filter($attributes));
			} else {
				$out .= $item['url'];
			}
		}

		if ($options['reset']) {
			unset($this->_items[$section]);
		}

		if ($options['tag']) {

			$attributes = array(
				'class' => $options['class'],
				'id' => $options['id']
			);
			return $this->_context->html->tag($options['tag'], $out, Set::filter($attributes));
		} else {
			return $out;
		}
	}

	public function instant($title, $url, $options = array()) {
		$options = array_merge(array('tag' => false, 'itemTag' => false), $options);

		$item = array(
			'title' 	=> $title,
			'url' 		=> $url,
			'class' 	=> null,
		);
		return $this->generate(null, $options, array($item));
	}

	protected function _matchContain($subject, $object) {
		if (empty($subject)) {
			return self::COMPLETE_MISMATCH;
		}
		if ($subject === $object) {
			return self::COMPLETE_MATCH;
		}

		$matchPosition = strpos($object, $subject);

		if ($matchPosition === 0) {
			return self::PARTIAL_MATCH;
		}
		if ($matchPosition === false) {
			return self::COMPLETE_MISMATCH;
		}
		return self::PARTIAL_MISMATCH;
	}

	protected function _matchDiff($subject, $object) {
		return count(array_diff_assoc(explode('/', $subject), explode('/', $object)));
	}

}
?>