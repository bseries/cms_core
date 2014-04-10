<article class="widget widget-alpha widget-count widget-single widget-count-single-alpha">
	<?php $data = $item['data']() ?>

	<div class="h-beta title"><?= $data['title'] ?></div>
	<div class="count"><?= $this->money->format($data['data'], 'money') ?></div>
</article>