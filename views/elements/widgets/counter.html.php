<article class="widget widget-counter <?= $item['class'] ?>">
	<?php if ($item['url']): ?>
		<a href="<?= $this->url($item['url']) ?>">
	<?php endif ?>
		<h1 class="title"><?= $item['title'] ?></h1>

		<?php if (count($item['data']) > 1): ?>
			<div class="count-groups">
			<?php foreach ($item['data'] as $title => $count): ?>
				<div class="count-group">
					<div class="title"><?= $title ?></div>
					<div class="count">
						<?php if (is_object($count)): ?>
							<?= $this->money->format($count, 'money') ?>
						<?php else: ?>
							<?= $count ?>
						<?php endif ?>
					</div>
				</div>
			<?php endforeach ?>
			</div>
		<?php else: ?>
			<div class="no-count-groups">
				<div class="title"><?= $title ?></div>
				<div class="count">
					<?php if (is_object($item['data'])): ?>
						<?= $this->money->format($item['data'], 'money') ?>
					<?php else: ?>
						<?= $item['data'] ?>
					<?php endif ?>
				</div>
			</div>
		<?php endif ?>
	<?php if ($item['url']): ?>
		</a>
	<?php endif ?>
</article>