<?php

$dateFormatter = new IntlDateFormatter(
	'de_DE',
	IntlDateFormatter::SHORT,
	IntlDateFormatter::SHORT
);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title($t('Addresses')) ?></h1>

	<?php if ($data->count()): ?>
	<table>
		<thead>
			<tr>
				<td><?= $t('User') ?>
				<td class="emphasize"><?= $t('Address') ?>
				<td class="date created"><?= $t('Created') ?>
				<td>
		</thead>
		<tbody>
			<?php foreach ($data as $item): ?>
				<?php $user = $item->user() ?>
			<tr>
				<?php if ($user->isVirtual()): ?>
					<td>
						<?= $this->html->link($user->name . '/' . $user->id, [
							'controller' => 'VirtualUsers', 'action' => 'edit', 'id' => $user->id, 'library' => 'cms_core'
						]) ?>
						(<?= $this->html->link('virtual', [
							'controller' => 'VirtualUsers', 'action' => 'index', 'library' => 'cms_core'
						]) ?>)
				<?php else: ?>
					<td>
						<?= $this->html->link($user->name . '/' . $user->id, [
							'controller' => 'Users', 'action' => 'edit', 'id' => $user->id, 'library' => 'cms_core'
						]) ?>
						(<?= $this->html->link('real', [
							'controller' => 'Users', 'action' => 'index', 'library' => 'cms_core'
						]) ?>)
				<?php endif ?>
				<td class="emphasize"><?= $item->format('oneline') ?>
				<td class="date created">
					<?php $date = DateTime::createFromFormat('Y-m-d H:i:s', $item->created) ?>
					<time datetime="<?= $date->format(DateTime::W3C) ?>"><?= $dateFormatter->format($date) ?></time>
				<td>
					<nav class="actions">
						<?= $this->html->link($t('delete'), ['id' => $item->id, 'action' => 'delete', 'library' => 'cms_core'], ['class' => 'button']) ?>
						<?= $this->html->link($t('edit'), ['id' => $item->id, 'action' => 'edit', 'library' => 'cms_core'], ['class' => 'button']) ?>
					</nav>
			<?php endforeach ?>
		</tbody>
	</table>
	<?php else: ?>
		<div class="none-available"><?= $t('No items available, yet.') ?></div>
	<?php endif ?>
</article>