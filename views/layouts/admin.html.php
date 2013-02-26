<?php

use lithium\core\Environment;

$site = Environment::get('site');
$modules = Environment::get('modules');

?>
<!doctype html>
<html>
	<head>
		<?php echo $this->html->charset() ?>
		<title><?php echo ($title = $this->title()) ? "{$title} - " : null ?>Admin – <?= $site['title'] ?></title>
		<link rel="icon" href="<?= $this->url('assets/ico/site.png') ?>">

		<?php echo $this->html->style(array(
			'/assets/core/css/reset',
			'/assets/core/css/admin'
		)) ?>
		<?php echo $this->html->script(array(
			'/assets/core/js/underscore',
			'/assets/core/js/jquery',
			'/assets/core/js/require'
		)) ?>
		<?php echo $this->scripts() ?>
	</head>
	<body>
	<div id="container">
		<header>
			<h1>
				<?= $site['title'] ?> –
				<?= $this->html->link('Administration', array('controller' => 'pages', 'action' => 'home', 'library' => 'cms_core')) ?>
			</h1>
			<nav>
				<?php foreach ($modules as $module): ?>
					<?= $this->html->link($module['title'], array(
						'controller' => $module['name'], 'action' => 'index', 'library' => $module['library']
					)) ?>
				<?php endforeach ?>
				<?= $this->html->link('View Site', '/', array('target' => 'new')) ?>
				<?= $this->html->link('Dashboard', array('controller' => 'pages', 'action' => 'home', 'library' => 'cms_core')) ?>
			</nav>
		</header>
		<div id="content">
			<?php echo $this->content(); ?>
		</div>
	</div>
	</body>
</html>