<?php

use lithium\core\Environment;

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $this->title($t('Support')) ?></h1>

	<p>
		<strong>Wir freuen uns über Ihre Fragen und Ideen.</strong>
	</p>

	<?=$this->view()->render(['element' => 'contact_atelier_disko'], [], [
		'library' => 'cms_core'
	]) ?>
</article>