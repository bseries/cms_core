<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1>
		<span class="code"><?= $code ?></span>
		<?= $this->title($t('Unsupported Browser')) ?>
	</h1>
	<div class="reason">
		<p>
			<?php if ($reason): ?>
				<?= $reason ?>
			<?php else: ?>
				<?= $t("Your browser is too old to be used with this site.") ?>
			<?php endif ?>
		</p>
	</div>
	<div class="try">
		<p>
			<?= $t('Install a more recent browser.') ?>
		</p>
	</div>
</article>