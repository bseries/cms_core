<?php

$item += [
	'type' => null,
	'name' => null,
	'street_address' => null,
	'postal_code' => null,
	'city' => null,
	'phone' => null,
	'email' => null
];

?>
<?php if ($item['type'] == 'organization'): ?>
	<article itemscope itemtype="http://data-vocabulary.org/Organization">
<?php else: ?>
	<article itemscope itemtype="http://data-vocabulary.org/Person">
<?php endif ?>
	<p>
		<span itemprop="name"><?= $item['name'] ?></span><br/>
		<div itemprop="address" itemtype="http://data-vocabulary.org/Address" itemscope>
			<span itemprop="street-address"><?= $item['street_address'] ?></span><br/>
			<span itemprop="postal-code"><?= $item['postal_code']?></span>
			<span itemprop="locality"><?= $item['city'] ?></span>
		</div>
	</p>
	<p>
		<?php if ($item['phone']): ?>
			<label><?= $t('Phone')?>:</label> <span itemprop="tel"><?= $item['phone'] ?></span><br/>
		<?php endif ?>
		<label><?= $t('E–Mail') ?>:</label> <?= $this->html->link($item['email'], "mailto:{$item['email']}") ?>
	</p>
</article>