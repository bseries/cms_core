<?php $data = $item['data']() ?>
<article class="widget widget-beta widget-multiple">
	<a href="<?= $this->url($item['url']) ?>">
	<?php foreach ($data['data'] as $title => $count): ?>
		<div class="count-group">
			<div class="h-gamma title"><?= $title ?></div>
			<div class="count"><?= $count ?></div>
		</div>
	<?php endforeach ?>
	</a>
</article>