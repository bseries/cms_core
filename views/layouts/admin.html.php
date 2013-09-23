<?php

use lithium\core\Environment;
use li3_flash_message\extensions\storage\FlashMessage;
use lithium\security\Auth;
use \DateTime;
use \IntlDateFormatter;

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
		<?php echo $this->styles() ?>
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
					<?= $this->html->link($site['title'], ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
				</h1>
				<div id="user">
					<?php if ($authedUser = Auth::check('default')): ?>
						<div class="left">
							<img class="avatar" src="<?= $this->assets->url('/core/img/bureau_logo.png') ?>"></span>
						</div>
						<div class="right">
							<div class="welcome">
								<?php echo $t('Moin {:name}!', [
									'name' => '<span class="name">' . strtok($authedUser['name'], ' ') . '</span>'
								]) ?>
							</div>
							<?php
								$today = new DateTime();
								$formatter = new IntlDateFormatter(
									'de_DE',
									IntlDateFormatter::FULL,
									IntlDateFormatter::NONE
								);
							?>
							<time class="today" datetime="<?= $today->format(DateTime::W3C) ?>">
								<?= $formatter->format($today) ?>
							</time>
						</div>
					<?php endif ?>
				</div>
			</header>
			<nav id="main">
				<?= $this->html->link($t('Dashboard'), ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
				<?= $this->html->link($t('Site'), '/', ['target' => 'new']) ?>
				<?php foreach ($modules as $module): ?>
					<?= $this->html->link($module['title'], [
						'controller' => $module['name'], 'action' => 'index', 'library' => $module['library']
					]) ?>
				<?php endforeach ?>
			</nav>
			<div id="content">
				<?php echo $this->content(); ?>
			</div>
		</div>
	</body>
</html>