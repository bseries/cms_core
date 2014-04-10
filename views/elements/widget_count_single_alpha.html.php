<?php $data = $item['data']() ?>
<article class="widget widget-alpha">
	<a href="<?= $this->url($item['url']) ?>">
		<div class="h-beta title"><?= $data['title'] ?></div>
		<div class="count">
			<?php if (is_object($data['value'])): ?>
				<?= $this->money->format($data['value'], 'money') ?>
			<?php else: ?>
				<?= $data['value'] ?>
			<?php endif ?>
		</div>
	</a>
</article>