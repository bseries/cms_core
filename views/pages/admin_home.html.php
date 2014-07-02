<?php

use lithium\analysis\Logger;

$this->set([
	'page' => [
		'type' => 'standalone',
		'object' => $t('Dashboard')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . str_replace('_', '-', $this->_config['template']) ?>">
	<div class="widgets">
		<?php foreach ($widgets as $name => $item): ?>
			<?php
				$start = microtime(true);
			?>
			<?=$this->view()->render(
				['element' => 'widget_' . $item['type']],
				['item' => $item['data']()],
				['library' => 'cms_core']
			) ?>
			<?php
				$took = microtime(true) - $start;
				if ($took > 1) {
					Logger::write('debug', "Widget {$name} took " . round($took, 4) . "s to render.");
				}
			?>
		<?php endforeach ?>
	</div>
</article>