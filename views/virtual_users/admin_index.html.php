<?php

use cms_core\extensions\cms\Features;

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title($t('Virtual Users')) ?></h1>

	<div class="help">
		<?= $t("Virtual users are users which you want to track and associated with other items (i.e. an order), These users didn't sign up directly but may have been creating a temporary account.") ?>
	</div>

	<table>
		<thead>
			<tr>
				<td class="flag"><?= $t('Active?') ?>
				<td>
				<?php if (Features::enabled('useBilling')): ?>
					<td data-sort="number" class="number list-sort"><?= $t('Number') ?>
				<?php endif ?>
				<td class="emphasize"><?= $t('Name') ?>
				<td><?= $t('Email') ?>
				<td><?= $t('Role') ?>
				<td class="date created"><?= $t('Created') ?>
				<td class="actions">
		</thead>
		<tbody>
			<?php foreach ($data as $item): ?>
			<tr>
				<td class="flag"><?= $item->is_active ? '✓ ' : '╳' ?>
				<td>
					<?php if ($item->email): ?>
						<img class="avatar" src="https://www.gravatar.com/avatar/<?= md5($item->email)?>.jpg?s=30&d=retro">
					<?php endif ?>
				<?php if (Features::enabled('useBilling')): ?>
					<td class="number emphasize"><?= $item->number ?>
				<?php endif ?>
				<td class="emphasize"><?= $item->name ?>
				<td><?= $item->email ?>
				<td><?= $item->role ?>
				<td class="date created">
					<time datetime="<?= $this->date->format($item->created, 'w3c') ?>">
						<?= $this->date->format($item->created, 'date') ?>
					</time>
				<td class="actions">
					<?= $this->html->link($t('delete'), ['id' => $item->id, 'action' => 'delete', 'library' => 'cms_core'], ['class' => 'button']) ?>
					<?php if ($item->is_active): ?>
						<?= $this->html->link($t('deactivate'), ['id' => $item->id, 'action' => 'deactivate', 'library' => 'cms_core'], ['class' => 'button']) ?>
					<?php else: ?>
						<?= $this->html->link($t('activate'), ['id' => $item->id, 'action' => 'activate', 'library' => 'cms_core'], ['class' => 'button']) ?>
					<?php endif ?>
					<?= $this->html->link($t('edit'), ['id' => $item->id, 'action' => 'edit', 'library' => 'cms_core'], ['class' => 'button']) ?>
			<?php endforeach ?>
		</tbody>
	</table>
</article>