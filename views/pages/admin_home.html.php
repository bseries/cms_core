<?php

$this->set([
	'page' => [
		'type' => 'standalone',
		'object' => $t('Dashboard')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . str_replace('_', '-', $this->_config['template']) ?>">
	<div class="widgets loading">
		<?php foreach ($widgets as $item): ?>
			<div
				class="widget loading"
				data-widget-name="<?= $item['name'] ?>"
				data-widget-type="<?= $item['type']?>"
			></div>
		<?php endforeach ?>
	</div>
</article>