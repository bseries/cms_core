<article class="widget widget-beta widget-multiple <?= $item['class'] ?>">
	<a href="<?= $this->url($item['url']) ?>">
	<?php foreach ($item['data'] as $title => $count): ?>
		<div class="count-group">
			<div class="h-beta title"><?= $title ?></div>
			<div class="t-alpha count"><?= $count ?></div>
		</div>
	<?php endforeach ?>
	</a>
</article>