<?php

use lithium\core\Libraries;
use lithium\core\Environment;
use li3_flash_message\extensions\storage\FlashMessage;
use cms_core\extensions\cms\Settings;
use cms_core\models\Assets;

$site = Settings::read('site');
$locale = Environment::get('locale');

$flash = FlashMessage::read();
FlashMessage::clear();

?>
<!doctype html>
<html lang="<?= strtolower(str_replace('_', '-', $locale)) ?>">
	<head>
		<?php echo $this->html->charset() ?>
		<title><?php echo ($title = $this->title()) ? "{$title} - " : null ?><?= $site['title'] ?></title>
		<link rel="icon" href="<?= $this->assets->url('/site/ico/site.png') ?>">
		<?php if (isset($seo['description'])): ?>
			<meta name="description" content="<?= $seo['description'] ?>">
		<?php endif ?>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!--[if lt IE 9]>>
			<script src="<?= $this->assets->url('/core/js/compat/html5shiv.js') ?>"></script>
		<![endif]-->
		<noscript>
			<link rel="stylesheet" type="text/css" href="<?= $this->assets->url('/site/css/compat/noscript.css') ?>">
		</noscript>
		<!--[if lt IE 10]>
			<link rel="stylesheet" type="text/css" href="<?= $this->assets->url('/site/css/compat/ie9.css') ?>">
		<![endif]-->

		<?php echo $this->assets->style([
			'/core/css/reset',
			'/site/css/base'
		]) ?>
		<?php
			$scripts = [
				'/core/js/require',
			];

			// Filter out any non-cms libraries, then sort.
			$libraries = Libraries::get();
			$libraries = array_filter($libraries, function($a) {
				return strpos($a['name'], 'cms_') === 0 || $a['name'] === 'app';
			});
			uasort($libraries, function($a, $b) {
				// Keep app last...
				if ($a['name'] === 'app') {
					return 1;
				}
				if ($b['name'] === 'app') {
					return -1;
				}
				// ... and core first.
				if ($a['name'] === 'cms_core') {
					return -1;
				}
				if ($b['name'] === 'cms_core') {
					return 1;
				}
				return strcmp($a['name'] ,$b['name']);
			});

			// Load base js files in cms_* assets/js.
			foreach ($libraries as $name => $library) {
				if (file_exists($library['path'] . '/assets/js/base.js')) {
					$library = $name == 'app' ? 'site' : str_replace('cms_', '', $name);
					$scripts[] = "/{$library}/js/base";
				}
			}
			$scripts[] = '/site/js/base';

			// Load corresponding layout script.
			// $scripts[] = "/core/js/views/layouts/{$this->_config['layout']}";

			// Load corresponding view scripts automatically.
			$view = $this->_config['controller'] . '/' . $this->_config['template'];
			$library = str_replace('cms_', '', $this->_config['library']);
			$library = $library == 'app' ? 'site' : $library;

			$file  = parse_url(Assets::base('file'), PHP_URL_PATH);
			$file .= "/{$library}/js/views/{$view}.js";

			if (file_exists($file)) {
				$scripts[] = "/{$library}/js/views/{$view}";
			}
		?>
		<?php echo $this->styles() ?>
		<?php echo $this->assets->script($scripts) ?>
		<?php echo $this->scripts() ?>
		<?php if (Settings::read('googleAnalytics.default')): ?>
			<?=$this->view()->render(['element' => 'ga'], [], [
				'library' => 'cms_core'
			]) ?>
		<?php endif ?>
		<?=$this->view()->render(['element' => 'head'], [], [
			'library' => 'app'
		]) ?>
	</head>
	<?php
		$classes = ['layout-default'];
		if (isset($extraBodyClasses)) {
			$classes = array_merge($classes, $extraBodyClasses);
		}
	?>
	<body class="<?= implode(' ', $classes) ?>">
		<div id="fb-root"></div>

		<div
			id="messages"
			<?php if ($flash): ?>
				data-flash-message="<?= $flash['message'] ?>"
				data-flash-level="<?= isset($flash['attrs']['level']) ? $flash['attrs']['level'] : 'neutral' ?>"
			<?php endif ?>
		></div>

		<div id="modal" class="hide">
			<div class="controls"><div class="close">╳</div></div>
			<div class="content"></div>
		</div>
		<div id="modal-overlay" class="hide"></div>

		<div id="container">
			<header class="main">
				<?=$this->view()->render(['element' => 'header'], [], [
					'library' => 'app'
				]) ?>
			</header>
			<div id="content">
				<?php echo $this->content() ?>
			</div>
		</div>
		<footer class="main">
			<?=$this->view()->render(['element' => 'footer'], [], [
				'library' => 'app'
			]) ?>
		</footer>
	</body>
</html>