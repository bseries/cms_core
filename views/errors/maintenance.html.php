<?php

$duration = $this->_response->headers('Retry-After') / 60;

?>
<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1>
		<span class="code"><?= $this->_response->status['code'] ?></span>
		<?= $this->title($t('Maintenance')) ?>
	</h1>
	<div class="reason">
		<p>
			<?= $t("Some changes are made to the infrastructure and certain pages may be unavailable for a few minutes.") ?>
			<?php echo $t(
				'Maintenance is expected to be completed within a maximum of <strong>{:duration} minutes</strong>.',
				compact('duration')
			) ?>
		</p>
	</div>
	<div class="try">
		<p><?= $t('Refresh this page after a few minutes.') ?></p>
	</div>
</article>
