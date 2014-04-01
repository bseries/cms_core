<?php

use lithium\core\Environment;
use li3_flash_message\extensions\storage\FlashMessage;
use lithium\security\Auth;
use \DateTime;
use \IntlDateFormatter;
use cms_core\extensions\cms\Settings;

$site = Settings::read('site');
$locale = Environment::get('locale');

$flash = FlashMessage::read();
FlashMessage::clear();

?>
<!doctype html>
<html lang="<?= strtolower(str_replace('_', '-', $locale)) ?>">
	<head>
		<?php echo $this->html->charset() ?>
		<title><?php echo ($title = $this->title()) ? "{$title} - " : null ?>Admin – <?= $site['title'] ?></title>
		<link rel="icon" href="<?= $this->assets->url('/core/ico/admin.png') ?>">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<?php echo $this->assets->style([
			'/core/css/reset',
			'/core/css/admin',
			'/site/css/admin'
		]) ?>
		<?php echo $this->styles() ?>
		<?=$this->view()->render(['element' => 'head_app_defines'], [], ['library' => 'cms_core']) ?>
		<?php
			$scripts = array_merge(
				['/core/js/jquery'],
				['/core/js/require'],
				$this->assets->availableScripts('base', ['admin' => true]),
				$this->assets->availableScripts('view', ['admin' => true]),
				$this->assets->availableScripts('layout', ['admin' => true])
			);
		?>
		<?php echo $this->assets->script($scripts) ?>
		<?php echo $this->scripts() ?>
		<?php if (Settings::read('googleAnalytics.default')): ?>
			<?=$this->view()->render(['element' => 'ga'], [], [
				'library' => 'cms_core'
			]) ?>
		<?php endif ?>
	</head>
	<body class="layout-admin">
		<div
			id="messages"
			<?php if ($flash): ?>
				data-flash-message="<?= $flash['message'] ?>"
				data-flash-level="<?= isset($flash['attrs']['level']) ? $flash['attrs']['level'] : 'neutral' ?>"
			<?php endif ?>
		>
		</div>

		<div id="modal" class="hide">
			<div class="controls"></div>
			<div class="content"></div>
		</div>
		<div id="modal-overlay" class="hide"></div>

		<div id="container">
			<header class="main">
				<h1>
					<?= $this->html->link($site['title'], ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
				</h1>
			</header>
			<div id="content">
				<?php echo $this->content(); ?>
			</div>
		</div>
		<footer class="main">
			<?=$this->view()->render(['element' => 'copyright'], [
				'holder' => $this->html->link(
					'Atelier Disko',
					'http://atelierdisko.de',
					['target' => 'new']
				)
			], ['library' => 'cms_core']) ?>

			<div class="credits">
				<?php echo $t('Powered by {:name}.', [
					'name' => $this->html->link('Bureau', 'http://atlierdisko.de', ['target' => 'new'])
				]) ?>
			</div>
		</footer>
	</body>
</html>