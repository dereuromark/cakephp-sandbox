<div class="index">
<h2><?php echo __('Tryouts');?></h2>

<h3>Icon Fonts</h3>
They mainly just need CSS assets added.
<?php echo $this->element('Sandbox.actions')?>

<h3>PHP Libraries</h3>
These are included using composer.

<ul>
	<li><?php echo $this->Html->link('Carbon', array('controller' => 'carbon', 'action' => 'index')); ?></li>
</ul>

</div>