<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1>
		<span class="code"><?= $code ?></span>
		<?= $this->title($t('Service Unavailable')) ?>
	</h1>
	<div class="reason">
		<p>
			<?php if ($reason): ?>
				<?= $reason ?>
			<?php else: ?>
				<?= $t('The service is currently offline and will be back online soon.') ?>
			<?php endif ?>
		</p>
	</div>
	<div class="try">
		<p><?= $t('Refresh this page after a few minutes.') ?></p>
	</div>
</article>
