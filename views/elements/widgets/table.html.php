<?php

ksort($item['data']);

?>
<article class="widget widget-table <?= $item['class'] ?>">
	<?php if($item['url']): ?>
		<a href="<?= $this->url($item['url']) ?>">
	<?php endif ?>
		<?php foreach ($item['data'] as $title => $count): ?>
		<div>
			<span class="title"><?= $title ?></span>
			<span class="count"><?= $count ?></span>
		</div>
		<?php endforeach ?>
	<?php if ($item['url']): ?>
		</a>
	<?php endif ?>
</article>