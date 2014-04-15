<article class="widget widget-alpha widget-single <?= $item['class'] ?>">
	<a href="<?= $this->url($item['url']) ?>">
		<div class="h-beta title"><?= $item['title'] ?></div>
		<div class="t-alpha count">
			<?php if (is_object($item['value'])): ?>
				<?= $this->money->format($item['value'], 'money') ?>
			<?php else: ?>
				<?= $item['value'] ?>
			<?php endif ?>
		</div>
	</a>
</article>