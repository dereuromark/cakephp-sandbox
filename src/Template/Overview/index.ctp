
<h2>Welcome</h2>
This is a private website contributing to CakePHP.
I always found it difficult so "imagine" specific code snippets without demo/examples.
This site combines useful code snippets with their live result.


<h3>Conventions and help for Cake Newbies</h3>
<ul>
<li><?php echo $this->Html->link('Discover CakePHP Conventions', array('plugin' => 'Sandbox', 'controller' => 'Conventions', 'action' => 'index')); ?></li>
<li><?php echo $this->Html->link('The CakePHP Inflector at work', array('plugin' => 'Sandbox', 'controller' => 'Inflector', 'action' => 'index')); ?></li>
<li><?php echo $this->Html->link('Best practice', array('plugin' => false, 'admin' => false, 'controller' => 'Pages', 'action' => 'display', 'best-practices')); ?></li>
</ul>

<h3>Sandbox</h3>
Play around with demos and see some core and plugin tools in action:
<ul>
<li><?php echo $this->Html->link('Sandbox', array('plugin' => 'Sandbox', 'controller' => 'Sandbox', 'action' => 'index')); ?></li>
</ul>

<h3>Shared Standard data</h3>
ISO and other commonly used data:
<ul>
<li><?php echo $this->Html->link('Standard Data', array('plugin' => false, 'controller' => 'Export', 'action' => 'index')); ?></li>
</ul>
You may also contribute back by adding/editing data.

<hr />

<h3><?php echo __('Join in!') ?></h3>
There are lots of things that can be done - even for beginners. <?php echo $this->Html->link('Details', array('controller' => 'Pages', 'action' => 'display', 'contribute'));