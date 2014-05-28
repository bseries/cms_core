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

// Remove when every page uses new rich page title.
if (!isset($page)) {
	$page = [];
}

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
	$this->title(ucfirst($page['object']));
} elseif ($page['type'] == 'single') {
	if ($page['title']) {
		$this->title(ucfirst($page['action']) . " {$page['title']} - " . ucfirst($page['object']));
	} else {
		$this->title(ucfirst($page['action']) . " {$page['empty']} - " . ucfirst($page['object']));
	}
} elseif ($page['type'] == 'standalone') {
	$this->title("{$page['object']}");
}

// Ensure meta is set, some pages may not yet use it.
if (!isset($meta)) {
	$meta = [];
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
		<link href='http://fonts.googleapis.com/css?family=Anonymous+Pro:400,700' rel='stylesheet' type='text/css'>
		<?php echo $this->styles() ?>
		<?=$this->view()->render(['element' => 'head_app_defines'], ['admin' => true], ['library' => 'cms_core']) ?>
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
	<?php
		$classes = ['layout-admin'];

		if (isset($extraBodyClasses)) {
			$classes = array_merge($classes, $extraBodyClasses);
		}
	?>
	<body class="<?= implode(' ', $classes) ?>">
		<div
			id="messages"
			<?php if ($flash): ?>
				data-flash-message="<?= $flash['message'] ?>"
				data-flash-level="<?= isset($flash['attrs']['level']) ? $flash['attrs']['level'] : 'neutral' ?>"
			<?php endif ?>
		>
		</div>

		<div id="modal" class="hide">
			<div class="controls"><div class="close">×</div></div>
			<div class="content"></div>
		</div>
		<div id="modal-overlay" class="hide"></div>

		<div id="container">
			<header class="main">
				<h1 class="t-alpha">
					<?= $this->html->link($site['title'], ['controller' => 'pages', 'action' => 'home', 'library' => 'cms_core']) ?>
				</h1>
				<h2 class="t-alpha rich-page-title">
					<?php if ($page['type'] != 'standalone'): ?>
						<span class="action"><?= $page['action'] ?></span>
					<?php endif ?>
					<span class="object"><?= $page['object'] ?></span>
					<?php if ($page['type'] == 'single'): ?>
						<span class="title" data-empty="<?= $page['empty'] ?>">
							<?= $page['title'] ?: $page['empty'] ?>
						</span>
					<?php endif ?>
					<?php foreach ($meta as $name => $value): ?>
						<span class="meta"><?= $value ?></span>
					<?php endforeach ?>
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
			<div class="content-wrapper clearfix">
				<nav class="nav-panes-actions">
					<?php foreach (Panes::actions(true, $this->_request) as $action): ?>
						<?= $this->html->link($action['title'], $action['url'], [
							'class' => $action['active'] ? 'active' : null
						]) ?>
					<?php endforeach ?>
				</nav>
				<nav class="nav-panes-groups">
					<?php foreach (Panes::groups($this->_request) as $group): ?>
						<?= $this->html->link($group['title'], $group['url'], [
							'class' => 'pane-group pane-group-' . str_replace('_', '-', $group['name']) .  ($group['active'] ? ' active' : null)
						]) ?>
					<?php endforeach ?>
				</nav>
				<div id="content">
					<?php echo $this->content(); ?>
				</div>
			</div>
		</div>
		<footer class="main">
			<div class="nav-bottom">
				<div>
				<?php if (defined('ECOMMERCE_CORE_VERSION')):?>
					AD Boutique <?= ECOMMERCE_CORE_VERSION ?>
				<?php else: ?>
					AD Bureau <?= CMS_CORE_VERSION ?>
				<?php endif ?>
				</div>
				<div class="copyright">
					© <?= date('Y') ?> <?= $this->html->link('Atelier Disko', 'http://atelierdisko.de', ['target' => 'new']) ?>
				</div>
			</div>
		</footer>
	</body>
</html>