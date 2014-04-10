<?php $data = $item['data']() ?>
<article class="widget widget-alpha">
	<a href="<?= $this->url($item['url']) ?>">
		<div class="h-beta title"><?= $data['title'] ?></div>
		<div class="count"><?= $this->money->format($data['value'], 'money') ?></div>
	</a>
</article>