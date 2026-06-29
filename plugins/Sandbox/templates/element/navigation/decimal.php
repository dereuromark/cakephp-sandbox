<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>Decimal Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-decimal" target="_blank">[CakeDecimal Plugin]</a>
</p>

<h3>Decimals</h3>
<p>Using ValueObject for decimals in your app.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('') ?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Basic Usage', ['action' => 'index'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Forms', ['action' => 'forms'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('Validation', ['action' => 'validation'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('API', ['action' => 'api'], ['class' => 'nav-link'])?></li>
	<li class="nav-item"><?php echo $this->Navigation->link('NumberHelper', ['action' => 'numberHelper'], ['class' => 'nav-link'])?></li>
</ul>
