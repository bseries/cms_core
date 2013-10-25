<?php

$dateFormatter = new IntlDateFormatter(
	'de_DE',
	IntlDateFormatter::SHORT,
	IntlDateFormatter::SHORT
);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $t('Tokens') ?></h1>

	<nav class="actions">
		<?= $this->html->link($t('generate token'), ['action' => 'generate', 'library' => 'cms_core'], ['class' => 'button']) ?>
	</nav>
	<?php if ($data->count()): ?>
		<table>
			<thead>
				<tr>
					<td><?= $t('Token') ?>
					<td><?= $t('Expires') ?>
					<td>
			</thead>
			<tbody>
				<?php foreach ($data as $item): ?>
				<tr>
					<td><code><?= $item->token ?></code>
					<td>
						<?php $date = DateTime::createFromFormat('Y-m-d H:i:s', $item->expires) ?>
						<time datetime="<?= $date->format(DateTime::W3C) ?>"><?= $dateFormatter->format($date) ?></time>
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