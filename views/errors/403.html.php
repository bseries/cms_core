<article class="view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha">
		<span class="code"><?= $this->_response->status['code'] ?></span>
		<?= $this->title($t('Forbidden')) ?>
	</h1>
	<ul class="reason">
		<li><?= $t("You are not allowed to access this page.") ?></li>
		<?php if (!$authedUser): ?>
			<li><?= $t("You are not logged in.") ?></li>
		<?php else: ?>
			<li><?= $t("You don't have the required privileges.") ?></li>
		<?php endif ?>
	</ul>
	<ul class="try">
		<?php if (!$authedUser): ?>
			<li><?= $this->html->link('Login to your account.','Users::session') ?>
		<?php endif ?>
		<li><?php echo $t(
			'Go to the frontpage at <strong>{:url}</strong>.',
			[
				'url' => $this->html->link(
					$this->url('Pages::home', ['absolute' => true]), 'Pages::home'
				)
			]
		)?></li>
	</ul>
</article>