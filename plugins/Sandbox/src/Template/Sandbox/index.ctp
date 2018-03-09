<?php
/**
 * @var \App\View\AppView $this
 */
?>

<nav class="actions col-md-3 col-sm-4 col-xs-12">
	<ul class="side-nav nav nav-pills nav-stacked">
		<li class="heading"><?= __('Actions') ?></li>
		<li><?= $this->Html->link(__('List {0}', __('Events')), $this->Calendar->calendarUrlArray(['action' => 'index'], $event->beginning)) ?> </li>
	</ul>
</nav>
<div class="contactAds view col-md-9 col-sm-8 col-xs-12">

<h2>Sandbox</h2>

<div class="row">
	<div class="col-sm-6 col-xs-12">

<h3>CakePHP Core</h3>
Code @ github: <a href="https://github.com/cakephp/cakephp" target="_blank">CakePHP 3.x</a>
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
	<div class="col-sm-6 col-xs-12">

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
