<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1>
		<span class="code"><?= $this->_response->status['code'] ?></span>
		<?= $this->title($t('Unsupported Browser')) ?>
	</h1>
	<div class="reason">
		<p>
			<?= $t("Your browser is too old to be used with this site.") ?>
		</p>
	</div>
	<div class="try">
		<p>
			<?= $t('Install a more recent browser.') ?>
		</p>
	</div>
</article>
