<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1>
		<span class="code"><?= $this->_response->status['code'] ?></span>
		<?= $this->title($t('Unsupported Browser')) ?>
	</h1>
	<ul class="reason">
		<li><?= $t("Your browser is too old to be used with this site.") ?></li>
	</ul>
	<ul class="try">
		<li><?= $t('Install a more recent browser.') ?></li>
	</ul>
</article>