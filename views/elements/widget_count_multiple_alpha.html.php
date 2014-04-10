<?php $data = $item['data']() ?>
<article class="widget widget-alpha widget-multiple">
	<a href="<?= $this->url($item['url']) ?>">
		<h1 class="h-gamma title"><?= $data['title'] ?></h1>
		<?php foreach ($data['data'] as $title => $count): ?>
			<div class="count-group">
				<div class="h-gamma title"><?= $title ?></div>
				<div class="count"><?= $count ?></div>
			</div>
		<?php endforeach ?>
	</a>
</article>