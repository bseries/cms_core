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
				<div id="user">
					<?php if ($authedUser = Auth::check('default')): ?>
						<div class="inner">
							<div class="left">
								<img class="avatar" src="https://www.gravatar.com/avatar/<?= md5($authedUser['email'] )?>.jpg?s=200&d=retro"></span>
							</div>
							<div class="right">
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
								<?php $today = new DateTime(); ?>
								<time class="today" datetime="<?= $this->date->format($today, 'w3c') ?>">
									<?= $this->date->format($today, 'full-date') ?>
								</time>
							</div>
						</div>
						<div class="actions">
							<?= $this->html->link($t('Site'), '/', ['target' => 'new']) ?>
							<?= $this->html->link($t('Dashboard'), ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
							<?= $this->html->link($t('Logout'), ['controller' => 'users', 'action' => 'logout', 'library' => 'cms_core', 'admin' => true]) ?>
							<?php if (isset($authedUser['original'])): ?>
								<?= $this->html->link($t('Debecome'), ['controller' => 'users', 'action' => 'debecome', 'library' => 'cms_core', 'admin' => true]) ?>
							<?php endif ?>
						</div>
					<?php endif ?>
				</div>
			</header>
			<div class="content-wrap">
				<nav class="main">
					<?php foreach (Panes::grouped() as $group => $panes): ?>
						<div class="group group-<?= $group ?>">
							<?php foreach ($panes as $pane): ?>
								<div class="pane">
									<?= $this->html->link($pane['title'], $pane['url'] ?: '#') ?>
									<ul class="actions">
									<?php foreach ($pane['actions'] as $title => $url): ?>
										<li><?= $this->html->link($title, $url) ?>
									<?php endforeach ?>
									</ul>
								</div>
							<?php endforeach ?>
						</div>
					<?php endforeach ?>
				</nav>
				<div id="content">
					<?php echo $this->content(); ?>
				</div>
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