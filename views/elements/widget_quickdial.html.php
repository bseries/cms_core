<?php $data = $item['data']() ?>
<article class="widget widget-quickdial">
	<a href="<?= $this->url($data['url']) ?>">
		<div class="h-beta title"><?= $data['title'] ?></div>
	</a>
</article>