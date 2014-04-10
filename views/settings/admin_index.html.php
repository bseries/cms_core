<?php

use lithium\util\Set;
use lithium\core\Environment;
use cms_core\extensions\cms\Settings;

$project = Settings::read('project');

$settings = Set::flatten($settings);
ksort($settings);

?>
<article class="view-<?= $this->_config['controller'] . '-' . str_replace('_', '-', $this->_config['template']) ?>">
	<h1 class="alpha"><?= $this->title($t('Settings & Features')) ?></h1>

	<section class="project">
		<h1 class="beta"><?= $t('Project') ?></h1>
		<table>
			<tbody>
			<?php foreach ($project as $name => $value): ?>
				<tr>
					<td><?= ucfirst($name) ?>
					<td><?= $value ?: $t('n/a') ?>
			<?php endforeach ?>
				<tr>
					<td><?= $t('Environment') ?>
					<td><?= Environment::get() ?>
			</tbody>
		</table>
	</section>

	<section class="features">
		<h1 class="beta"><?= $t('Features') ?></h1>
		<table>
			<tbody>
			<?php foreach ($features as $name => $value): ?>
				<tr>
					<td class="title"><?= $name ?></td>
					<td class="value"><?= $value ? $t('enabled') : $t('disabled') ?></td>
			<?php endforeach ?>
			</tbody>
		</table>
	</section>

	<section class="settings">
		<h1 class="beta"><?= $t('Settings') ?></h1>
		<table>
			<tbody>
			<?php foreach ($settings as $name => $value): ?>
				<tr>
					<td class="title"><?= $name ?></td>
					<td class="value fixed"><?= $value ?></td>
			<?php endforeach ?>
			</tbody>
		</table>
	</section>
</article>