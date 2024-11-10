<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">

<nav class="actions col-md-3 col-sm-4 col-12">
	<ul class="side-nav nav nav-pills nav-stacked flex-column">
		<li class="heading"><?= __('Actions') ?></li>
	</ul>
</nav>
<div class="contactAds view col-md-9 col-sm-8 col-12">

<h2>Sandbox</h2>

<div class="row">
	<div class="col-sm-6 col-12">

<h3>CakePHP Core</h3>
Latest code @ Github: <a href="https://github.com/cakephp/cakephp" target="_blank">CakePHP</a>
<ul>
<li><?php echo $this->Html->link('Core examples', ['controller' => 'CakeExamples', 'action' => 'index']); ?></li>
</ul>

<h3>CakePHP Plugins</h3>
Some of the plugins from the <a href="https://github.com/FriendsOfCake/awesome-cakephp" target="_blank">awesome-cakephp</a> list.
<ul>
<li><?php echo $this->Html->link('Plugin example usage / showcase', ['controller' => 'PluginExamples', 'action' => 'index']); ?></li>

<?php if (false) { ?>
<li><?php echo $this->Html->link('Helpers', ['controller' => 'Helpers', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Behaviors', ['controller' => 'Behaviors', 'action' => 'index']); ?></li>
<?php } ?>
</ul>


	</div>
	<div class="col-sm-6 col-12">

<h3>PHP Libraries</h3>
<ul>
	<li><?php echo $this->Html->link('MediaEmbed', ['controller' => 'MediaEmbed', 'action' => 'index']); ?></li>
</ul>

<h3>Examples</h3>
JavaScript related.
<ul>
<li><?php echo $this->Html->link('JS', ['controller' => 'JsExamples', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Jquery', ['controller' => 'JqueryExamples', 'action' => 'index']); ?></li>
</ul>

<h3>Tryouts</h3>
Playing around...
<ul>
<li><?php echo $this->Html->link('Misc. tryouts', ['controller' => 'tryouts', 'action' => 'index']); ?></li>
</ul>

	</div>
</div>

</div>
</div>
