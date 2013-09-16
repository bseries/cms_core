<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1><?= $t('Users') ?></h1>
	<table>
		<thead>
			<tr>
				<td><?= $t('Active?') ?>
				<td><?= $t('Name') ?>
				<td><?= $t('Email') ?>
				<td><?= $t('Role') ?>
				<td><?= $t('Created') ?>
				<td><?= $t('Modified') ?>
				<td>
		</thead>
		<tbody>
			<?php foreach ($data as $item): ?>
			<tr>
				<td><?= $item->is_active ? '✓ ' : '╳' ?>
				<td><?= $item->name ?>
				<td><?= $item->email ?>
				<td><?= $item->role ?>
				<td><?= $item->created ?>
				<td><?= $item->modified ?>
				<td>
					<nav class="actions">
						<?= $this->html->link($t('delete'), ['id' => $item->id, 'action' => 'delete', 'library' => 'cms_core']) ?>
						<?php if ($item->is_active): ?>
							<?= $this->html->link($t('deactivate'), ['id' => $item->id, 'action' => 'deactivate', 'library' => 'cms_core']) ?>
						<?php else: ?>
							<?= $this->html->link($t('activate'), ['id' => $item->id, 'action' => 'activate', 'library' => 'cms_core']) ?>
						<?php endif ?>
					</nav>
			<?php endforeach ?>
		</tbody>
	</table>
</article>