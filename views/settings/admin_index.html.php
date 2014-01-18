<?php

use lithium\util\Set;

$settings = Set::flatten($settings);
ksort($settings);

?>
<article class="view-<?= $this->_config['controller'] . '-' . str_replace('_', '-', $this->_config['template']) ?>">
	<h1 class="alpha"><?= $this->title($t('Settings & Features')) ?></h1>

	<section>
		<h1 class="beta"><?= $t('Features') ?></h1>
		<table>
			<tbody>
			<?php foreach ($features as $name => $value): ?>
				<tr>
					<td><?= $name ?></td>
					<td><?= $value ? $t('enabled') : $t('disabled') ?></td>
			<?php endforeach ?>
			</tbody>
		</table>
	</section>

	<section>
		<h1 class="beta"><?= $t('Settings') ?></h1>
		<table>
			<tbody>
			<?php foreach ($settings as $name => $value): ?>
				<tr>
					<td><?= $name ?></td>
					<td class="fixed"><?= $value ?></td>
			<?php endforeach ?>
			</tbody>
		</table>
	</section>
</article>