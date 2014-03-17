<?php

use cms_core\extensions\cms\Features;

$title = [
	'action' => ucfirst($this->_request->action === 'add' ? $t('creating') : $t('editing')),
	'title' => $item->name ?: $t('untitled'),
	'object' => [ucfirst($t('virtual user')), ucfirst($t('virtual users'))]
];
$this->title("{$title['title']} - {$title['object'][1]}");

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?> section-spacing">
	<h1 class="alpha">
		<span class="action"><?= $title['action'] ?></span>
		<span class="title" data-untitled="<?= $t('Unnamed') ?>"><?= $title['title'] ?></span>
	</h1>

	<?=$this->form->create($item) ?>
		<section>
			<?= $this->form->field('id', ['type' => 'hidden']) ?>
			<?= $this->form->field('name', ['type' => 'text', 'label' => $t('Name'), 'class' => 'use-for-title']) ?>
			<?= $this->form->field('email', ['type' => 'email', 'label' => $t('E–mail')]) ?>
			<?= $this->form->field('role', [
				'type' => 'select',
				'label' => $t('Role'),
				'list' => $roles
			]) ?>
			<?= $this->form->field('is_active', ['type' => 'checkbox', 'label' => $t('Aktiv?')]) ?>
		</section>
		<section>
			<?= $this->form->field('locale', [
				'type' => 'select',
				'label' => $t('Locale'),
				'list' => $locales
			]) ?>
			<?= $this->form->field('timezone', [
				'type' => 'select',
				'label' => $t('Timezone'),
				'list' => $timezones
			]) ?>
		</section>
		<?php if (Features::enabled('useBilling')): ?>
			<section>
				<?= $this->form->field('billing_currency', [
					'type' => 'select',
					'label' => $t('Billing Currency'),
					'list' => $currencies
				]) ?>
				<?= $this->form->field('billing_vat_reg_no', [
					'type' => 'text',
					'autocomplete' => 'off',
					'label' => $t('Billing VAT Reg. No.')
				]) ?>
			</section>
		<?php endif ?>
		<?php if (Features::enabled('useBilling')): ?>
			<section>
				<?= $this->form->field('billing_address_id', [
					'type' => 'select',
					'label' => $t('Billing Address'),
					'list' => $addresses
				]) ?>
				<?= $this->form->field('shipping_address_id', [
					'type' => 'select',
					'label' => $t('Shipping Address'),
					'list' => $addresses
				]) ?>
			</section>
		<?php endif ?>
		<?= $this->form->button($t('save'), ['type' => 'submit', 'class' => 'large']) ?>
	<?=$this->form->end() ?>
</article>