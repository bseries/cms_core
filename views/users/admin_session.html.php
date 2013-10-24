<?php

use lithium\core\Environment;

$site = Environment::get('site');
$features = Environment::get('features');

$this->title($t('Session'));

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $t('Login') ?></h1>

	<?=$this->form->create(null, ['url' => ['action' => 'login']]) ?>
		<?=$this->form->field('email', ['type' => 'email', 'label' => 'E–Mail']) ?>
		<?=$this->form->field('password', ['type' => 'password', 'label' => 'Passwort']) ?>
		<?=$this->form->button($t('Login'), ['type' => 'submit']) ?>
	<?=$this->form->end() ?>
</article>