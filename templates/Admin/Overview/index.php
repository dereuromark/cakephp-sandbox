<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Admin Backend</h2>

<div class="row">
	<div class="col-md-6">

		<h3><?php echo __('Public Lists')?></h3>
		<ul>
			<li><?php echo $this->Html->link(__('Continents'), ['plugin' => 'Data', 'controller' => 'Continents', 'action' => 'index'])?></li>
			<li><?php echo $this->Html->link(__('Countries'), ['plugin' => 'Data', 'controller' => 'Countries', 'action' => 'index'])?></li>
			<li><?php echo $this->Html->link(__('States'), ['plugin' => 'Data', 'controller' => 'States', 'action' => 'index'])?></li>
			<li><?php echo $this->Html->link(__('Postal Codes'), ['plugin' => 'Data', 'controller' => 'PostalCodes', 'action' => 'index'])?></li>

			<li><?php echo $this->Html->link(__('Currencies'), ['plugin' => 'Data', 'controller' => 'Currencies', 'action' => 'index'])?></li>
			<li><?php echo $this->Html->link(__('Languages'), ['plugin' => 'Data', 'controller' => 'Languages', 'action' => 'index'])?></li>
			<li><?php echo $this->Html->link(__('Smileys'), ['plugin' => 'Data', 'controller' => 'Smileys', 'action' => 'index'])?></li>
			<li><?php echo $this->Html->link(__('Mime Types'), ['plugin' => 'Data', 'controller' => 'mime_types', 'action' => 'index'])?></li>
		</ul>


	</div>

	<div class="col-md-6">

		<h3><?php echo __('Content')?></h3>
		<ul>
			<li><?php echo $this->Html->link(__('Feedback'), ['plugin' => 'Feedback', 'controller' => 'Feedback', 'action' => 'index'])?></li>

			<li><?php echo $this->Html->link(__('Examples'), ['prefix' => false, 'plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'index'])?></li>
			<li><?php echo $this->Html->link(__('Jquery Examples'), ['prefix' => false, 'plugin' => 'Sandbox', 'controller' => 'Examples', 'action' => 'index'])?></li>

		</ul>

		<h3>Management</h3>
		<ul>
			<li><?php echo $this->Html->link(__('Users'), ['prefix' => 'Admin', 'controller' => 'Users'])?></li>
			<li><?php echo $this->Html->link(__('Icons'), ['prefix' => 'Admin', 'plugin' => 'Templating', 'controller' => 'Icons'])?></li>
		</ul>

		<h3>System</h3>
		<ul>
			<?php if (false) { ?>
				<li><?php echo $this->Html->link(__('Translations'), ['admin' => false, 'plugin' => 'Translate', 'controller' => 'Translate', 'action' => 'index'])?></li>
			<?php } ?>

			<li><?php echo $this->Html->link(__('Setup'), ['prefix' => 'Admin', 'plugin' => 'Setup', 'controller' => 'Setup'])?></li>
			<li><?php echo $this->Html->link(__('Tools'), ['prefix' => 'Admin', 'plugin' => 'Tools', 'controller' => 'Tools'])?></li>
			<li><?php echo $this->Html->link(__('Queue'), ['prefix' => 'Admin', 'plugin' => 'Queue', 'controller' => 'Queue'])?></li>
			<li><?php echo $this->Html->link(__('Logs'), ['prefix' => 'Admin', 'plugin' => 'DatabaseLog', 'controller' => 'Logs'])?></li>
		</ul>

	</div>
</div>

