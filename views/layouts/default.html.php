<?php

use lithium\util\Inflector;
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
		<title><?php echo ($title = $this->title()) ? "{$title} – " : null ?><?= $site['title'] ?></title>
		<link rel="icon" href="<?= $this->assets->url('/app/ico/app.png') ?>">
		<?php if (isset($seo['description'])): ?>
			<meta name="description" content="<?= $seo['description'] ?>">
		<?php endif ?>

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!--[if lt IE 9]>>
			<script src="<?= $this->assets->url('/cms-core/js/compat/html5shiv.js') ?>"></script>
		<![endif]-->
		<noscript>
			<link rel="stylesheet" type="text/css" href="<?= $this->assets->url('/app/css/compat/noscript.css') ?>">
		</noscript>
		<!--[if lt IE 10]>
			<link rel="stylesheet" type="text/css" href="<?= $this->assets->url('/app/css/compat/ie9.css') ?>">
		<![endif]-->

		<?php echo $this->assets->style([
			'/cms-core/css/reset',
			'/app/css/base'
		]) ?>
		<?php echo $this->styles() ?>
		<?=$this->view()->render(['element' => 'head_app_defines'], [], ['library' => 'cms_core']) ?>
		<?php
			$scripts = array_merge(
				['/cms-core/js/require'],
				$this->assets->availableScripts('base'),
				$this->assets->availableScripts('view'),
				$this->assets->availableScripts('layout')
			);
		?>
		<?php echo $this->assets->script($scripts) ?>
		<?php echo $this->scripts() ?>
		<?php if (Settings::read('service.googleAnalytics.default')): ?>
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

		foreach ($ua as $name => $flag) {
			if (is_bool($flag) && $flag ) {
				$classes[] = strtolower(Inflector::slug($name));
			} elseif (is_string($flag)) {
				$classes[] = strtolower(Inflector::slug($name)) . '-' . strtolower($flag);
			}
		}

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