<?php

use cms_core\extensions\cms\Features;

$this->set([
	'page' => [
		'type' => 'single',
		'title' => $item->name,
		'empty' => $t('unnamed'),
		'object' => $t('user')
	],
	'meta' => [
		'status' => $item->is_active ? $t('activated') : $t('deactivated')
	]
]);

?>
<?php ob_start() ?>
<script>
require(['jquery', 'modal', 'domready!'], function($, modal) {
	$('.actions .generate-passwords').on('click', function(ev) {
		ev.preventDefault();
		var req = $.getJSON($(this).attr('href'));

		req.done(function(data) {
			var html = '';

			$.each(data.data.passwords, function(k, v) {
				html += '<div class="fixed">' + v + '</div>';
			});
			modal.init();
			modal.fill(html, 'passwords filled');
			modal.ready();
		});
	});
});
</script>
<?php $this->scripts(ob_get_clean()) ?>

<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?> section-spacing">

	<nav class="actions">
		<?php if ($item->is_active): ?>
			<?= $this->html->link($t('deactivate'), ['id' => $item->id, 'action' => 'deactivate', 'library' => 'cms_core'], ['class' => 'button']) ?>
		<?php else: ?>
			<?= $this->html->link($t('activate'), ['id' => $item->id, 'action' => 'activate', 'library' => 'cms_core'], ['class' => 'button']) ?>
		<?php endif ?>

		<?= $this->html->link($t('generate random password'), [
			'action' => 'generate_passwords', 'type' => 'json', 'library' => 'cms_core'
		], ['class' => 'button generate-passwords']) ?>
	</nav>

	<?=$this->form->create($item) ?>
		<section>
			<?= $this->form->field('id', ['type' => 'hidden']) ?>
			<?= $this->form->field('name', ['type' => 'text', 'label' => $t('Name'), 'class' => 'use-for-title']) ?>
			<?php if (Features::enabled('useBilling')): ?>
				<?= $this->form->field('number', [
					'type' => 'text',
					'label' => $t('Number')
				]) ?>
				<div class="help"><?= $t('Leave empty to autogenerate number.') ?></div>
			<?php endif ?>
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
				<div class="help">
					<?= $this->html->link($t('Create new address.'), ['controller' => 'Addresses', 'action' => 'add', 'library' => 'cms_core']) ?>
				</div>

				<?= $this->form->field('shipping_address_id', [
					'type' => 'select',
					'label' => $t('Shipping Address'),
					'list' => $addresses
				]) ?>
				<div class="help">
					<?= $this->html->link($t('Create new address.'), ['controller' => 'Addresses', 'action' => 'add', 'library' => 'cms_core']) ?>
				</div>
			</section>
		<?php endif ?>
		<section>
			<?=$this->form->field('password', ['type' => 'password', 'label' => 'Neues Passwort', 'autocomplete' => 'off']) ?>
			<?=$this->form->field('password_repeat', ['type' => 'password', 'label' => 'Neues Passwort (wiederholen)', 'autocomplete' => 'off']) ?>
		</section>
		<?= $this->form->button($t('save'), ['type' => 'submit', 'class' => 'large']) ?>
	<?=$this->form->end() ?>
</article>