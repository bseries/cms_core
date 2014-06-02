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
				['element' => 'widgets/' . $item['type']],
				['item' => $item['inner']()],
				['library' => 'cms_core']
			) ?>
		<?php endforeach ?>
	</div>
</article>