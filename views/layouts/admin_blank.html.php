<?php

use lithium\core\Environment;
use li3_flash_message\extensions\storage\FlashMessage;
use lithium\security\Auth;
use \DateTime;
use \IntlDateFormatter;

$site = Environment::get('site');
$modules = Environment::get('modules');
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

		<?php echo $this->assets->style([
			'/core/css/reset',
			'/core/css/admin'
		]) ?>
		<?php echo $this->assets->script([
			'/core/js/underscore',
			'/core/js/jquery',
			'/core/js/require',
			'/core/js/base',
			'/media/js/base'
		]) ?>
		<?php echo $this->styles() ?>
		<?php echo $this->scripts() ?>
		<?php if (!empty($service['googleAnalytics'])): ?>
			<?=$this->view()->render(['element' => 'ga'], $service['googleAnalytics'], [
				'library' => 'cms_core'
			]) ?>
		<?php endif ?>
	</head>
	<body class="layout-admin">
		<div
			id="messages"
			<?php if ($flash): ?>
				data-flash-message="<?= $flash['message'] ?>"
				data-flash-level="<?= isset($flash['attr']['level']) ? $flash['attr']['level'] : 'neutral' ?>"
			<?php endif ?>
		>
		</div>

		<div id="modal" class="hide">
			<div class="controls"></div>
			<div class="content"></div>
		</div>
		<div id="modal-overlay" class="hide"></div>

		<div id="container">
			<header>
				<h1>
					<?= $this->html->link($site['title'], ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
				</h1>
			</header>
			<div id="content">
				<?php echo $this->content(); ?>
			</div>
		</div>
		<footer>
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