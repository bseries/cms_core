<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1><?= $t('Tokens') ?></h1>

	<nav class="actions">
		<?= $this->html->link($t('generate new token'), array('action' => 'generate', 'library' => 'cms_core')) ?>
	</nav>

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
				<td><?= $item->token ?>
				<td><?= $item->expires ?>
				<td>
					<nav class="actions">
						<?= $this->html->link($t('void'), array('token' => $item->token, 'action' => 'void', 'library' => 'cms_core')) ?>
					</nav>
			<?php endforeach ?>
		</tbody>
	</table>
</article>