<?php

use lithium\core\Environment;

$site = Environment::get('site');
$locale = Environment::get('locale');

?>
<!doctype html>
<html lang="<?= strtolower(str_replace('_', '-', $locale)) ?>">
	<head>
		<?php echo $this->html->charset() ?>
		<title><?php echo ($title = $this->title()) ? "{$title} - " : null ?><?= $site['title'] ?></title>
		<link rel="icon" href="<?= $this->assets->url('/site/ico/site.png') ?>">

		<!--[if lt IE 9]>>
			<script src="<?= $this->assets->url('/core/js/compat/html5shiv.js') ?>"></script>
		<![endif]-->

		<?php echo $this->assets->style([
			'/core/css/reset',
			'/site/css/error'
		]) ?>
		<?php echo $this->styles() ?>
		<?php echo $this->scripts() ?>
		<?php if (!empty($service['googleAnalytics'])): ?>
			<?=$this->view()->render(['element' => 'ga'], $service['googleAnalytics'], [
				'library' => 'cms_core'
			]) ?>
		<?php endif ?>
	</head>
	<body class="layout-error">
		<div id="container">
			<div id="content">
				<?php echo $this->content() ?>
			</div>
		</div>
	</body>
</html>