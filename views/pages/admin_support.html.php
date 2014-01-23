<?php

use cms_core\extensions\cms\Settings;

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title($t('Support')) ?></h1>

	<p>
		<strong>Wir freuen uns über Ihre Fragen und Ideen.</strong>
	</p>

	<?=$this->view()->render(['element' => 'contact'], ['item' => Settings::read('contact.exec')], [
		'library' => 'cms_core'
	]) ?>
</article>