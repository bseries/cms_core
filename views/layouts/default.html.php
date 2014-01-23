<?php

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

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<!--[if lt IE 9]>>
			<script src="<?= $this->assets->url('/core/js/compat/html5shiv.js') ?>"></script>
		<![endif]-->

		<?php echo $this->assets->style([
			'/core/css/reset',
			'/site/css/base'
		]) ?>
		<?php echo $this->assets->script([
			'/core/js/require',
			'/core/js/base',
			'/media/js/base',
			'/site/js/base'
		]) ?>
		<?php
			// Load corresponding view scripts automatically.
			$view = $this->_config['controller'] . '/' . $this->_config['template'];

			$file  = parse_url(Assets::base('file'), PHP_URL_PATH);
			$file .= '/site/js/views/' . $view . '.js';

			if (file_exists($file)) {
				echo $this->assets->script(['/site/js/views/' . $view]);
			}
		?>
		<?php echo $this->styles() ?>
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
				data-flash-level="<?= isset($flash['attr']['level']) ? $flash['attr']['level'] : 'neutral' ?>"
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
		<footer>
			<?=$this->view()->render(['element' => 'footer'], [], [
				'library' => 'app'
			]) ?>
		</footer>
	</body>
</html>