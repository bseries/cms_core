<?php

use Faker\Factory as Faker;
use lithium\core\Environment;

$faker = Faker::create(Environment::get('locale'));
$faker->seed(1234);

?>
<article class="styleguide view-<?= $this->_config['controller'] . '-' . $this->_config['template'] ?>">
	<h1 class="alpha"><?= $t('Styleguide') ?></h1>

	<section id="headlines">
		<h1 class="beta"><?= $t('Headlines') ?></h1>
		<div class="sandbox">
			<p><?= $faker->paragraph() ?></p>
			<h1 class="alpha">Lorem Ipsum - alpha</h1>
			<p><?= $faker->paragraph() ?></p>
			<h1 class="beta">Lorem Ipsum - beta</h1>
			<p><?= $faker->paragraph() ?></p>
			<h1 class="gamma">Lorem Ipsum - gamma</h1>
			<p><?= $faker->paragraph() ?></p>
			<h1 class="delta">Lorem Ipsum - delta</h1>
			<p><?= $faker->paragraph() ?></p>
			<h1 class="epsilon">Lorem Ipsum - epsilon</h1>
			<p><?= $faker->paragraph() ?></p>
		</div>
	</section>
	<section id="basics">
		<h1 class="beta"><?= $t('Basics') ?></h1>
		<div class="sandbox">
			<em>stress emphasized text</em><br>
			<strong>strong text</strong><br>
			<del>deleted text</del><br>
		</div>
	</section>
	<section id="paragraphs">
		<h1 class="beta"><?= $t('Paragraphs') ?></h1>
		<div class="sandbox">
			<p><?= $faker->paragraph(5) ?></p>
			<p><?= $faker->paragraph(8) ?></p>
			<p><?= $faker->paragraph(9) ?></p>
		</div>
	</section>
	<section id="quotes">
		<h1 class="beta"><?= $t('Quotes') ?></h1>
		<div class="sandbox">
			<p><?= $faker->paragraph(4) ?></p>
			<blockquote>blockquote - <?= $faker->paragraph(5) ?></blockquote>
			<p><?= $faker->paragraph(4) ?></p>
			<p><?= $faker->paragraph(1) ?><q>inline quotation</q> <?= $faker->paragraph(1) ?></p>
			<p>Luke continued, <q>And then she called him a <q>scruffy-looking nerf-herder</q>! I think I’ve got a chance!</q> The poor naive fool…</p>
		</div>
	</section>
	<section id="hyphenation">
		<h1 class="beta"><?= $t('Hyphenation') ?></h1>
		<div class="sandbox">
			<p class="hyphenate" style="text-align:justify;">hyphenated in justified text- <?= $faker->paragraph(9) ?></p>
			<p class="hyphenate-hard" style="text-align:justify;">hyphenated (hard/always) in justified text - <?= $faker->paragraph(9) ?></p>
			<div class="hyphenate" style="width: 80px;">hyphenated - <?= $faker->sentence(2) ?></div>
			<div class="hyphenate-hard" style="width: 80px;">hyphenated (hard/always) - <?= $faker->sentence(1) ?></div>
		</div>
	</section>
	<section id="hyperlinks">
		<h1 class="beta"><?= $t('Hyperlinks') ?></h1>
		<div class="sandbox">
			<a href="#"><?= $faker->sentence(2) ?></a><br/>
			<a href="#"><?= $faker->sentence(2) ?></a><br/>
			<p>
				Ab qui et omnis pariatur. <a href="#">Link within Pargraph</a> quae doloremque dolorum libero nam placeat quaerat saepe. Omnis vel dolor autem omnis doloribus. Laboriosam expedita deserunt iusto. Sed et optio consequatur tenetur deleniti necessitatibus. Alias itaque sit quae blanditiis et omnis. Fugit quam doloremque repellat deserunt nihil quidem commodi quia. Accusamus quam temporibus <a href="#">Link within Pargraph</a> doloribus quaerat deserunt. Eius et rem numquam modi cumque.
			</p>
		</div>
	</section>
	<section id="lists">
		<h1 class="beta"><?= $t('Lists') ?></h1>
		<div class="sandbox">
			<ul>
				<li>this is
				<li>an unordered
				<li>list
			</ul>
			<ol>
				<li>this is
				<li>an ordered
				<li>list
			</ol>
		</div>
	</section>
	<section id="buttons">
		<h1 class="beta"><?= $t('Buttons') ?></h1>
		<div class="sandbox">
			<a href="#" class="button">neutral button</a>
			<br/><br/>
			<a href="#" class="button small">neutral button (small)</a>
			<br/><br/>
			<a href="#" class="button large">neutral button (large)</a>
			<br/><br/>
			<a href="#" class="button cancel">cancel button</a>
			<br/><br/>
			<a href="#" class="button confirm">confirm button</a>
		</div>
	</section>
	<section id="forms">
		<h1 class="beta"><?= $t('Forms') ?></h1>
		<div class="sandbox">
			<?= $this->form->create(null) ?>
				<?= $this->form->field('text', [
					'type' => 'text',
					'label' => 'label for text input',
					'value' => 'text input field - ' . $faker->word
				]); ?>
				<?= $this->form->field('password', [
					'type' => 'password',
					'label' => 'label for password input',
					'value' => 'password input - ' . $faker->word
				]); ?>
				<?= $this->form->field('date', [
					'type' => 'date',
					'label' => 'label for date input'
				]); ?>
				<?= $this->form->field('select', [
					'type' => 'select',
					'label' => 'label for select',
					'list' => $faker->words(10)
				]); ?>
				<?= $this->form->field('multiselect', [
					'type' => 'select',
					'multiple' => true,
					'label' => 'label for multiple select',
					'list' => $faker->words(10)
				]); ?>
				<?= $this->form->field('textarea', [
					'type' => 'textarea',
					'label' => 'label for textarea',
					'value' => 'textarea - ' . $faker->text
				]); ?>
				<?= $this->form->field('checkbox', [
					'type' => 'checkbox',
					'label' => 'label for checkbox'
				]); ?>
				<?= $this->form->field('checkbox', [
					'type' => 'checkbox',
					'checked' => true,
					'label' => 'label for checked checkbox'
				]); ?>
				<?= $this->form->field('radio', [
					'type' => 'radio',
					'label' => 'label for radio'
				]); ?>
				<?= $this->form->field('radio', [
					'type' => 'radio',
					'checked' => true,
					'label' => 'label for selected radio'
				]); ?>
				<?= $this->form->button('large submit button', ['type' => 'submit', 'class' => 'button large']) ?>
			<?= $this->form->end() ?>
		</div>
	</section>
	<section id="help">
		<h1 class="beta"><?= $t('Help') ?></h1>
		<div class="sandbox">
			<article>
				<h1 class="beta">Lorem Ipsum</h1>
				<p class="help">
					help text below headling at the beginning - <?= $faker->text ?>
				</p>
			</article>
			<?= $this->form->create(null) ?>
				<?= $this->form->field('text', [
					'type' => 'text',
					'label' => 'lorem ipsum'
				]); ?>
				<div class="help">help text for form element above - <?= $faker->paragraph(5) ?></div>
				<?= $this->form->field('text', [
					'type' => 'text',
					'label' => 'lorem ipsum'
				]); ?>
			<?= $this->form->end() ?>
		</div>
	</section>
	<section id="nav-jump-boxes">
		<h1 class="beta"><?= $t('Navigation: Jump Boxes') ?></h1>
		<div class="sandbox">
			<div class="jump-boxes">
				<a class="jump-box" href="#"><?= $faker->sentence(2) ?></a>
				<a class="jump-box" href="#"><?= $faker->sentence(2) ?></a>
				<a class="jump-box" href="#"><?= $faker->sentence(2) ?></a>
			</div>
		</div>
	</section>
	<section id="nav-dropdown">
		<h1 class="beta"><?= $t('Navigation: Dropdown') ?></h1>
		<div class="sandbox">
			<nav class="dropdown">
				<a href="#" class="primary button">Direktlink</a>
				<div class="secondary">
					<a href="#">Neuheiten</a>
					<a href="#">Tickets</a>
					<a href="#">Shirts</a>
				</div>
			</nav>
		</div>
	</section>
</article>