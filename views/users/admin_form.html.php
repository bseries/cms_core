
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

<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title($t('User')) ?></h1>

	<nav class="actions">
		<?= $this->html->link($t('generate random password'), [
			'action' => 'generate_passwords', 'type' => 'json', 'library' => 'cms_core'
		], ['class' => 'button generate-passwords']) ?>
	</nav>

	<?=$this->form->create($item) ?>
		<?= $this->form->field('id', ['type' => 'hidden']) ?>
		<?= $this->form->field('name', ['type' => 'text', 'label' => $t('Name')]) ?>
		<?= $this->form->field('email', ['type' => 'email', 'label' => $t('E–mail')]) ?>
		<?= $this->form->field('role', [
			'type' => 'select',
			'label' => $t('Role'),
			'list' => $roles
		]) ?>
		<?= $this->form->field('is_active', ['type' => 'checkbox', 'label' => $t('Aktiv?')]) ?>

		<?=$this->form->field('password', ['type' => 'password', 'label' => 'Neues Passwort']) ?>
		<?=$this->form->field('password_repeat', ['type' => 'password', 'label' => 'Neues Passwort (wiederholen)']) ?>
		<?= $this->form->button($t('save'), ['type' => 'submit']) ?>
	<?=$this->form->end() ?>
</article>