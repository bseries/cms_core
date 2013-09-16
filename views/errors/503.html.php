<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1>
		<span class="code"><?= $this->_response->status['code'] ?></span>
		<?= $this->title($t('Service Unavailable')) ?>
	</h1>
	<div class="reason">
		<p>
			<?= $t('The service is currently offline and will be back online soon.') ?>
		</p>
	</div>
	<div class="try">
		<p><?= $t('Refresh this page after a few minutes.') ?></p>
	</div>
</article>
