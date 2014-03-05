<?php

use cms_core\extensions\cms\Features;

$title = [
	'action' => ucfirst($this->_request->action === 'add' ? $t('creating') : $t('editing')),
	'title' => $item->name ?: $t('untitled'),
	'object' => [ucfirst($t('user')), ucfirst($t('users'))]
];
$this->title("{$title['title']} - {$title['object'][1]}");

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
	<h1 class="alpha">
		<span class="action"><?= $title['action'] ?></span>
		<span class="title"><?= $title['title'] ?></span>
	</h1>

	<nav class="actions">
		<?= $this->html->link($t('generate random password'), [
			'action' => 'generate_passwords', 'type' => 'json', 'library' => 'cms_core'
		], ['class' => 'button generate-passwords']) ?>
	</nav>

	<?=$this->form->create($item) ?>
		<section>
			<?= $this->form->field('id', ['type' => 'hidden']) ?>
			<?= $this->form->field('name', ['type' => 'text', 'label' => $t('Name'), 'class' => 'title']) ?>
			<?= $this->form->field('email', ['type' => 'email', 'label' => $t('E–mail')]) ?>
			<?= $this->form->field('role', [
				'type' => 'select',
				'label' => $t('Role'),
				'list' => $roles
			]) ?>
			<?= $this->form->field('is_active', ['type' => 'checkbox', 'label' => $t('Aktiv?')]) ?>

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
		<section>
			<?=$this->form->field('password', ['type' => 'password', 'label' => 'Neues Passwort', 'autocomplete' => 'off']) ?>
			<?=$this->form->field('password_repeat', ['type' => 'password', 'label' => 'Neues Passwort (wiederholen)', 'autocomplete' => 'off']) ?>
		</section>
		<?= $this->form->button($t('save'), ['type' => 'submit', 'class' => 'large']) ?>
	<?=$this->form->end() ?>
</article>