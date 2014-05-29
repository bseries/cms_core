<?php

$this->set([
	'page' => [
		'type' => 'single',
		'title' => false,
		'empty' => false,
		'object' => $t('address')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<?=$this->form->create($item) ?>
		<?= $this->form->field('id', ['type' => 'hidden']) ?>

		<div class="grid-row">
			<div class="grid-column-left">
				<div class="combined-users-fields">
					<?= $this->form->field('user_id', [
						'type' => 'select',
						'label' => $t('User'),
						'list' => $users
					]) ?>
					<div class="help">
						<?= $this->html->link($t('Create new user.'), [
							'controller' => 'Users',
							'action' => 'add',
							'library' => 'cms_core'
						]) ?>
					</div>
					<?= $this->form->field('virtual_user_id', [
						'type' => 'select',
						'label' => $t('Virtual user'),
						'list' => $virtualUsers
					]) ?>
					<div class="help">
						<?= $this->html->link($t('Create new virtual user.'), [
							'controller' => 'VirtualUsers',
							'action' => 'add',
							'library' => 'cms_core'
						]) ?>
					</div>
				</div>
			</div>
		</div>

		<div class="grid-row grid-row-last">
			<section class="grid-column-left">
				<?= $this->form->field('name', [
					'type' => 'text',
					'label' => $t('Name')
				]) ?>
				<?= $this->form->field('company', [
					'type' => 'text',
					'label' => $t('Company')
				]) ?>
				<?= $this->form->field('street', [
					'type' => 'text',
					'label' => $t('Street')
				]) ?>
				<?= $this->form->field('city', [
					'type' => 'text',
					'label' => $t('City')
				]) ?>
				<?= $this->form->field('zip', [
					'type' => 'text',
					'label' => $t('ZIP')
				]) ?>
				<?= $this->form->field('country', [
					'type' => 'select',
					'label' => $t('Country'),
					'list' => $countries
				]) ?>
			</section>

			<section class="grid-column-right">
				<?= $this->form->field('phone', [
					'type' => 'phone',
					'label' => $t('Phone')
				]) ?>
			</section>
		</div>
		<div class="bottom-actions">
			<?= $this->form->button($t('save'), ['type' => 'submit', 'class' => 'large save']) ?>
		</div>
	<?=$this->form->end() ?>
</article>