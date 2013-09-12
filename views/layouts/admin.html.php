<?php

use lithium\core\Environment;
use li3_flash_message\extensions\storage\FlashMessage;

$site = Environment::get('site');
$modules = Environment::get('modules');

$flash = FlashMessage::read();
FlashMessage::clear();

?>
<!doctype html>
<html>
	<head>
		<?php echo $this->html->charset() ?>
		<title><?php echo ($title = $this->title()) ? "{$title} - " : null ?>Admin – <?= $site['title'] ?></title>
		<link rel="icon" href="<?= $this->assets->url('/site/ico/site.png') ?>">

		<?php echo $this->assets->style([
			'/core/css/reset',
			'/core/css/admin'
		]) ?>
		<?php echo $this->assets->script([
			'/core/js/underscore',
			'/core/js/jquery',
			'/core/js/require',
			'/core/js/base'
		]) ?>
		<?php echo $this->scripts() ?>

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
		<div id="container">
			<header>
				<h1>
					<?= $site['title'] ?> –
					<?= $this->html->link($t('Administration'), ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
				</h1>
				<nav>
					<?php foreach ($modules as $module): ?>
						<?= $this->html->link($module['title'], [
							'controller' => $module['name'], 'action' => 'index', 'library' => $module['library']
						]) ?>
					<?php endforeach ?>
					<?= $this->html->link($t('View Site'), '/', ['target' => 'new']) ?>
					<?= $this->html->link($t('Dashboard'), ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
				</nav>
			</header>
			<div id="content">
				<?php echo $this->content(); ?>
			</div>
		</div>
	</body>
</html>