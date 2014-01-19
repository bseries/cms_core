<?php

use lithium\util\Set;

$settings = Set::flatten($settings);
ksort($settings);

?>
<article class="view-<?= $this->_config['controller'] . '-' . str_replace('_', '-', $this->_config['template']) ?>">
	<h1 class="alpha"><?= $this->title($t('Settings & Features')) ?></h1>

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