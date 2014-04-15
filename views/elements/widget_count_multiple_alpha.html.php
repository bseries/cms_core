<article class="widget widget-alpha widget-multiple <?= $item['class'] ?>">
	<a href="<?= $this->url($item['url']) ?>">
		<h1 class="h-beta title"><?= $item['title'] ?></h1>
		<?php foreach ($item['data'] as $title => $count): ?>
			<div class="count-group">
				<div class="h-beta title"><?= $title ?></div>
				<div class="t-alpha count"><?= $count ?></div>
			</div>
		<?php endforeach ?>
	</a>
</article>