<?php

use lithium\core\Environment;
use li3_flash_message\extensions\storage\FlashMessage;
use lithium\security\Auth;
use \DateTime;
use \IntlDateFormatter;
use cms_core\extensions\cms\Panes;
use cms_core\extensions\cms\Settings;
use cms_core\models\Assets;

$site = Settings::read('site');
$locale = Environment::get('locale');

$flash = FlashMessage::read();
FlashMessage::clear();

// Rich page title.
$map = [
	'add' => $t('creating'),
	'edit' => $t('editing'),
	'index' => $t('listing'),
];
$page += [
	'action' => isset($map[$this->_request->action]) ? $map[$this->_request->action] : null,
	'empty' => $t('untitled')
];
if ($page['type'] == 'multiple') {
	$this->title("{$page['object']}");
} elseif ($page['type'] == 'single') {
	$this->title("{$page['title']} - {$page['object']}");
} elseif ($page['type'] == 'standalone') {
	$this->title("{$page['object']}");
}

?>
<!doctype html>
<html lang="<?= strtolower(str_replace('_', '-', $locale)) ?>">
	<head>
		<?php echo $this->html->charset() ?>
		<title><?php echo ($title = $this->title()) ? "{$title} - " : null ?>Admin – <?= $site['title'] ?></title>
		<link rel="icon" href="<?= $this->assets->url('/cms-core/ico/admin.png') ?>">

		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<?php echo $this->assets->style([
			'/cms-core/css/reset',
			'/cms-core/css/admin',
			'/app/css/admin'
		]) ?>
		<?php echo $this->styles() ?>
		<?=$this->view()->render(['element' => 'head_app_defines'], [], ['library' => 'cms_core']) ?>
		<?php
			$scripts = array_merge(
				['/cms-core/js/jquery'],
				['/cms-core/js/require'],
				$this->assets->availableScripts('base', ['admin' => true]),
				$this->assets->availableScripts('view', ['admin' => true]),
				$this->assets->availableScripts('layout', ['admin' => true])
			);
		?>
		<?php echo $this->assets->script($scripts) ?>
		<?php echo $this->scripts() ?>
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
			<div class="controls"><div class="close">╳</div></div>
			<div class="content"></div>
		</div>
		<div id="modal-overlay" class="hide"></div>

		<div id="container">
			<header class="main">
				<h1>
					<?= $this->html->link($site['title'], ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
				</h1>
				<h2 class="h-alpha rich-page-title">
					<?php if ($page['type'] != 'standalone'): ?>
						<span class="action"><?= $page['action'] ?></span>
					<?php endif ?>
					<span class="object"><?= $page['object'] ?></span>
					<?php if ($page['type'] == 'single'): ?>
						<span class="title" data-empty="<?= $page['empty'] ?>">
							<?= $page['title'] ?>
						</span>
					<?php endif ?>
				</h2>
				<div class="nav-top">
					<?php if ($authedUser = Auth::check('default')): ?>
						<div class="welcome">
							<?php echo $t('Moin {:name}!', [
								'name' => '<span class="name">' . strtok($authedUser['name'], ' ') . '</span>'
							]) ?>
							<?php if (isset($authedUser['original'])): ?>
								<span class="name-original">
									(<?= $t('actually') ?>
									<?= $authedUser['original']['name'] ?>)
								</span>
							<?php endif ?>
						</div>

						<div class="date">
							<?php $today = new DateTime(); ?>
							<time class="today" datetime="<?= $this->date->format($today, 'w3c') ?>">
								<?= $this->date->format($today, 'full-date') ?>
							</time>
						</div>

						<?= $this->html->link($t('Logout'), ['controller' => 'users', 'action' => 'logout', 'library' => 'cms_core', 'admin' => true]) ?>
						<?php if (isset($authedUser['original'])): ?>
							<?= $this->html->link($t('Debecome'), ['controller' => 'users', 'action' => 'debecome', 'library' => 'cms_core', 'admin' => true]) ?>
						<?php endif ?>
					<?php endif ?>
				</div>
			</header>
			<nav class="nav-left">
				<?php foreach (Panes::groups($this->_request) as $group): ?>
					<?= $this->html->link($group['title'], $group['url'], [
						'class' => $group['active'] ? 'active' : null
					]) ?>
				<?php endforeach ?>
			</nav>
			<div id="content">
				<?php echo $this->content(); ?>
			</div>
		</div>
		<footer class="main">
			<?php echo $t('A webapplication by {:name}.', [
				'name' => $this->html->link('Atelier Disko', 'http://atlierdisko.de', ['target' => 'new'])
			]) ?>
			© <?= date('Y') ?> Atelier Disko
		</footer>
	</body>
</html>