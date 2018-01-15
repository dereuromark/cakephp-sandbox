<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Admin Backend</h2>


<h3><?php echo __('Public Lists')?></h3>
<ul>
	<li><?php echo $this->Html->link(__('Countries'), ['plugin' => 'data', 'controller' => 'countries', 'action' => 'index'])?></li>
	<li><?php echo $this->Html->link(__('States'), ['plugin' => 'data', 'controller' => 'states', 'action' => 'index'])?></li>
	<li><?php echo $this->Html->link(__('Postal Codes'), ['plugin' => 'data', 'controller' => 'postal_codes', 'action' => 'index'])?></li>

	<li><?php echo $this->Html->link(__('Currencies'), ['plugin' => 'data', 'controller' => 'currencies', 'action' => 'index'])?></li>
	<li><?php echo $this->Html->link(__('Languages'), ['plugin' => 'data', 'controller' => 'languages', 'action' => 'index'])?></li>
	<li><?php echo $this->Html->link(__('Smileys'), ['plugin' => 'data', 'controller' => 'smileys', 'action' => 'index'])?></li>
	<li><?php echo $this->Html->link(__('Mime Types'), ['plugin' => 'data', 'controller' => 'mime_types', 'action' => 'index'])?></li>
</ul>


<h3><?php echo __('Content')?></h3>
<ul>

	<li><?php echo $this->Html->link(__('Code Snippets'), ['controller' => 'CodeSnippets', 'action' => 'index'])?></li>
	<li><?php echo $this->Html->link(__('Examples'), ['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'index'])?></li>
	<li><?php echo $this->Html->link(__('Jquery Examples'), ['plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'index'])?></li>
	<li><?php echo $this->Html->link(__('Feedback'), ['plugin' => 'Feedback', 'controller' => 'Feedback', 'action' => 'index'])?></li>

</ul>


<h3>Management</h3>
<ul>
	<li><?php echo $this->Html->link(__('Users'), ['prefix' => 'admin', 'controller' => 'Users'])?></li>
</ul>

<h3>System</h3>
<ul>
	<?php if (false) { ?>
		<li><?php echo $this->Html->link(__('Translations'), ['admin' => false, 'plugin' => 'translate', 'controller' => 'translate', 'action' => 'index'])?></li>
	<?php } ?>

	<li><?php echo $this->Html->link(__('Logs'), ['prefix' => 'admin', 'plugin' => 'DatabaseLog', 'controller' => 'Logs'])?></li>
</ul>
