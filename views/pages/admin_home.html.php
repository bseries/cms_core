<?php

$this->set([
	'page' => [
		'type' => 'standalone',
		'object' => $t('Dashboard')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . str_replace('_', '-', $this->_config['template']) ?>">
	<div class="widgets">
		<?php foreach ($widgets as $item): ?>
			<?=$this->view()->render(
				['element' => 'widget_' . $item['type']],
				['item' => $item['data']()],
				['library' => 'cms_core']
			) ?>
		<?php endforeach ?>
	</div>
</article>