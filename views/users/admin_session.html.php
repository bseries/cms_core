<?php

$this->set([
	'page' => [
		'type' => 'standalone',
		'object' => $t('Login')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . str_replace('_', '-', $this->_config['template']) ?>">
	<?=$this->form->create(null, ['url' => ['action' => 'login', 'library' => 'cms_core']]) ?>
		<?=$this->form->field('email', ['type' => 'email', 'label' => 'E–Mail']) ?>
		<?=$this->form->field('password', ['type' => 'password', 'label' => 'Passwort']) ?>
		<?=$this->form->button($t('Login'), ['type' => 'submit', 'class' => 'large button login']) ?>
	<?=$this->form->end() ?>
</article>