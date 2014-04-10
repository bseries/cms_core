<article class="widget widget-beta widget-count widget-multiple widget-count-multiple-beta">
	<?php $data = $item['data']() ?>
	<?php foreach ($data['data'] as $title => $count): ?>
		<div class="count-group">
			<div class="h-beta title"><?= $title ?></div>
			<div class="count"><?= $count ?></div>
		</div>
	<?php endforeach ?>
</article>