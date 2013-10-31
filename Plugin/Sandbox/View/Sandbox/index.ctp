<h2>Sandbox</h2>

<h3>CakePHP Core</h3>
Code @ github: <a href="https://github.com/cakephp/cakephp">CakePHP 2.x</a>
<ul>
<li><?php echo $this->Html->link('Core examples', array('controller'=>'cake_examples', 'action'=>'index')); ?></li>
</ul>

<h3>Tools Plugin</h3>
Code @ github: <a href="https://github.com/dereuromark/tools">Tools</a>
<ul>
<li><?php echo $this->Html->link('Tools examples', array('controller'=>'tools_examples', 'action'=>'index')); ?></li>

<?php if (false) { ?>
<li><?php echo $this->Html->link('Helpers', array('controller'=>'helpers', 'action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Behaviors', array('controller'=>'behaviors', 'action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Datasources', array('controller'=>'datasources', 'action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Libs', array('controller'=>'libs', 'action'=>'index')); ?></li>
<?php } ?>
</ul>

<h3>Examples</h3>
<ul>
<li><?php echo $this->Html->link('JS', array('controller'=>'js_examples', 'action'=>'index')); ?></li>
<li><?php echo $this->Html->link('Jquery', array('controller'=>'jquery_examples', 'action'=>'index')); ?></li>
</ul>

<h3>Tryouts</h3>
Playing around...
<ul>
<li><?php echo $this->Html->link('Misc. tryouts', array('controller'=>'tryouts', 'action'=>'index')); ?></li>
</ul>