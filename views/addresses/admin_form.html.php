<?php

use cms_core\extensions\cms\Features;

$title = [
	'action' => ucfirst($this->_request->action === 'add' ? $t('creating') : $t('editing')),
	'title' => $item->name ?: $t('untitled'),
	'object' => [ucfirst($t('address')), ucfirst($t('addresses'))]
];
$this->title("{$title['title']} - {$title['object'][1]}");

?>

<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha">
		<span class="action"><?= $title['action'] ?></span>
		<span class="title" data-untitled="<?= $t('Untitled') ?>"><?= $title['title'] ?></span>
	</h1>
	<?=$this->form->create($item) ?>
		<?= $this->form->field('id', ['type' => 'hidden']) ?>

		<?= $this->form->field('user_id', [
			'type' => 'select',
			'label' => $t('User'),
			'list' => $users
		]) ?>

		<?= $this->form->field('name', [
			'type' => 'text',
			'label' => $t('Name')
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

		<?= $this->form->button($t('save'), ['type' => 'submit', 'class' => 'large']) ?>
	<?=$this->form->end() ?>
</article>