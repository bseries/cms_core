<?php

use lithium\core\Environment;

$services = Environment::get('service');
$site = Environment::get('site');

?>
<article>
	<h1><?= $this->title('Dashboard') ?></h1>

	<h2>Site</h2>
<pre>
<?php echo json_encode($site) ?>
</pre>

	<h2>Registered Services</h2>
	<?php foreach ($services as $name => $service): ?>
	<h3><?= $name ?></h3>
<pre>
<?php echo json_encode($service) ?>
</pre>
	<?php endforeach ?>

</article>