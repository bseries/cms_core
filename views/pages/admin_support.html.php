<?php

use cms_core\extensions\cms\Settings;

$this->set([
	'page' => [
		'type' => 'standalone',
		'object' => $t('Support')
	]
]);

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<?=$this->view()->render(['element' => 'contact'], ['item' => Settings::read('contact.exec')], [
		'library' => 'cms_core'
	]) ?>
</article>