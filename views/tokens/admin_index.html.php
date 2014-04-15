<?php

$this->set([
	'page' => [
		'type' => 'multiple',
		'object' => $t('tokens')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<?php if ($data->count()): ?>
		<table>
			<thead>
				<tr>
					<td class="emphasize"><?= $t('Token') ?>
					<td class="date expires"><?= $t('Expires') ?>
					<td class="actions">
			</thead>
			<tbody>
				<?php foreach ($data as $item): ?>
				<tr>
					<td class="emphasize"><code><?= $item->token ?></code>
					<td class="date expires">
						<time datetime="<?= $this->date->format($item->expires, 'w3c') ?>">
							<?= $this->date->format($item->expires, 'datetime') ?>
						</time>
					<td class="actions">
						<?= $this->html->link($t('void'), ['token' => $item->token, 'action' => 'void', 'library' => 'cms_core'], ['class' => 'button']) ?>
				<?php endforeach ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="none-available"><?= $t('No tokens available, yet.') ?></div>
	<?php endif ?>
</article>