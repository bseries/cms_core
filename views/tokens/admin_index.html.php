<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title($t('Tokens')) ?></h1>

	<?php if ($data->count()): ?>
		<table>
			<thead>
				<tr>
					<td class="emphasize"><?= $t('Token') ?>
					<td class="date expires"><?= $t('Expires') ?>
					<td>
			</thead>
			<tbody>
				<?php foreach ($data as $item): ?>
				<tr>
					<td class="emphasize"><code><?= $item->token ?></code>
					<td class="date expires">
						<time datetime="<?= $this->date->format($item->expires, 'w3c') ?>">
							<?= $this->date->format($item->expires, 'datetime') ?>
						</time>
					<td>
						<nav class="actions">
							<?= $this->html->link($t('void'), ['token' => $item->token, 'action' => 'void', 'library' => 'cms_core'], ['class' => 'button']) ?>
						</nav>
				<?php endforeach ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="none-available"><?= $t('No tokens available, yet.') ?></div>
	<?php endif ?>
</article>