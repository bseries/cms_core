<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title($t('Dashboard')) ?></h1>

	<?php foreach ($widgets as $item): ?>
		<?=$this->view()->render(
			['element' => 'widget_' . $item['type']],
			['item' => $item],
			['library' => 'cms_core']
		) ?>
	<?php endforeach ?>

</article>