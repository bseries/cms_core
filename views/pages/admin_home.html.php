<?php

$this->set([
	'page' => [
		'type' => 'standalone',
		'object' => $t('Dashboard')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<?php foreach ($widgets as $item): ?>
		<?=$this->view()->render(
			['element' => 'widget_' . $item['type']],
			['item' => $item],
			['library' => 'cms_core']
		) ?>
	<?php endforeach ?>

</article>