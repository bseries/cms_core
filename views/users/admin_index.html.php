<?php

use cms_core\extensions\cms\Features;

$this->set([
	'page' => [
		'type' => 'multiple',
		'object' => $t('users')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?> use-list">

	<div class="help">
	<?php if (Features::enabled('user.sendActivationMail')): ?>
		<?= $t('The user will be notified by e-mail when her account is activated.') ?>
	<?php endif ?>
	</div>

	<table>
		<thead>
			<tr>
				<td data-sort="is-active" class="is-active flag list-sort"><?= $t('Active?') ?>
				<td>
				<?php if (Features::enabled('useBilling')): ?>
					<td data-sort="number" class="number list-sort"><?= $t('Number') ?>
				<?php endif ?>
				<td data-sort="name" class="name emphasize list-sort"><?= $t('Name') ?>
				<td data-sort="email" class="email list-sort"><?= $t('Email') ?>
				<td data-sort="role" class="role list-sort"><?= $t('Role') ?>
				<td class="date created"><?= $t('Created') ?>
				<td class="actions">
					<?= $this->form->field('search', [
						'type' => 'search',
						'label' => false,
						'placeholder' => $t('Filter'),
						'class' => 'list-search'
					]) ?>
		</thead>
		<tbody class="list">
			<?php foreach ($data as $item): ?>
			<tr>
				<td class="is-active flag"><?= $item->is_active ? '✓ ' : '×' ?>
				<td>
					<img class="avatar" src="https://www.gravatar.com/avatar/<?= md5($item->email)?>.jpg?s=30&d=retro" />
				<?php if (Features::enabled('useBilling')): ?>
					<td class="number emphasize"><?= $item->number ?>
				<?php endif ?>
				<td class="name emphasize"><?= $item->name ?>
				<td class="email"><?= $item->email ?>
				<td class="role"><?= $item->role ?>
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
					<?= $this->html->link($t('open'), ['id' => $item->id, 'action' => 'edit', 'library' => 'cms_core'], ['class' => 'button']) ?>
			<?php endforeach ?>
		</tbody>
	</table>
</article>