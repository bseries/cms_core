<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title('Passwort ändern') ?></h1>

	<?=$this->form->create($item) ?>
		<?=$this->form->field('password_old', ['type' => 'password', 'label' => 'Bisheriges Passwort (reauth)']) ?>
		<?=$this->form->field('password', ['type' => 'password', 'label' => 'Neues Passwort']) ?>
		<?=$this->form->field('password_repeat', ['type' => 'password', 'label' => 'Neues Passwort (wiederholen)']) ?>
		<?=$this->form->button($t('OK'), ['type' => 'submit']) ?>
	<?=$this->form->end() ?>
</article>