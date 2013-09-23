<?php

use lithium\core\Environment;

$services = Environment::get('service');
$site = Environment::get('site');
$features = Environment::get('features');
$project = Environment::get('project');

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title($t('Dashboard')) ?></h1>

	<h2 class="beta"><?= $t('Site') ?></h2>
	<dl>
	<?php foreach ($site as $name => $value): ?>
		<dt><?= $name ?></dt>
		<dd><?= $value ?></dd>
	<?php endforeach ?>
	</dl>

	<h2 class="beta"><?= $t('Project') ?></h2>
	<dl>
	<?php foreach ($project as $name => $value): ?>
		<dt><?= $name ?></dt>
		<dd><?= $value ?></dd>
	<?php endforeach ?>
	</dl>
	<!--
	<h2 class="beta"><?= $t('Features') ?></h2>
	<dl>
	<?php foreach ($features as $name => $value): ?>
		<dt><?= $name ?></dt>
		<dd><?= $value ? $t('enabled') : $t('disabled')	 ?></dd>
	<?php endforeach ?>
	</dl>

	<h2 class="beta"><?= $t('Services') ?></h2>
	<?php foreach ($services as $name => $service): ?>
	<h3 class="gamma"><?= $name ?></h3>
<pre>
<?php echo json_encode($service) ?>
</pre>
	<?php endforeach ?>
	-->

</article>