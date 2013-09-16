<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1>
		<span class="code"><?= $code ?></span>
		<?= $this->title($t('Internal Server Error')) ?>
	</h1>
	<div class="reason">
		<p>
			<?php if ($reason): ?>
				<?= $reason ?>
			<?php else: ?>
				<?= $t("An unexpected technical problem occurred.") ?>
			<?php endif ?>
		</p>
	</div>
	<div class="try">
		<p>
			<?php echo $t(
				'Go to the frontpage at <strong>{:url}</strong>.',
				[
					'url' => $this->html->link(
						$this->url('Pages::home', ['absolute' => true]), 'Pages::home'
					)
				]
			)?>
		</p>
	</div>
</article>