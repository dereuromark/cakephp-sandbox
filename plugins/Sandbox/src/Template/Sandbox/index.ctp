<h2>Sandbox</h2>

<h3>CakePHP Core</h3>
Code @ github: <a href="https://github.com/cakephp/cakephp" target="_blank">CakePHP 2.x</a>
<ul>
<li><?php echo $this->Html->link('Core examples', ['controller' => 'cake_examples', 'action' => 'index']); ?></li>
</ul>

<h3>CakePHP Plugins</h3>
Some of the plugins from the <a href="https://github.com/FriendsOfCake/awesome-cakephp/tree/cake3" target="_blank">awesome-cakephp</a> list.
<ul>
<li><?php echo $this->Html->link('Plugin example usage / showcase', ['controller' => 'plugin_examples', 'action' => 'index']); ?></li>

<?php if (false) { ?>
<li><?php echo $this->Html->link('Helpers', ['controller' => 'helpers', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Behaviors', ['controller' => 'behaviors', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Datasources', ['controller' => 'datasources', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Libs', ['controller' => 'libs', 'action' => 'index']); ?></li>
<?php } ?>
</ul>

<h3>Examples</h3>
JavaScript related.
<ul>
<li><?php echo $this->Html->link('JS', ['controller' => 'js_examples', 'action' => 'index']); ?></li>
<li><?php echo $this->Html->link('Jquery', ['controller' => 'jquery_examples', 'action' => 'index']); ?></li>
</ul>

<h3>Tryouts</h3>
Playing around...
<ul>
<li><?php echo $this->Html->link('Misc. tryouts', ['controller' => 'tryouts', 'action' => 'index']); ?></li>
</ul>