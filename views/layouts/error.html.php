<?php

use lithium\core\Environment;
use lithium\util\Inflector;
use cms_core\extensions\cms\Settings;

$site = Settings::read('site');
$locale = Environment::get('locale');

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
		<noscript>
			<link rel="stylesheet" type="text/css" href="<?= $this->assets->url('/site/css/compat/noscript.css') ?>">
		</noscript>
		<!--[if lt IE 10]>
			<link rel="stylesheet" type="text/css" href="<?= $this->assets->url('/site/css/compat/ie9.css') ?>">
		<![endif]-->

		<?php echo $this->assets->style([
			'/core/css/reset',
			'/site/css/base'
		]) ?>
		<?php echo $this->styles() ?>
		<?php echo $this->scripts() ?>
		<?=$this->view()->render(['element' => 'head_app_defines'], [], ['library' => 'cms_core']) ?>
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
		$classes = ['layout-error'];

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
		<div id="container">
			<div id="content">
				<?php echo $this->content() ?>
			</div>
		</div>
	</body>
</html>