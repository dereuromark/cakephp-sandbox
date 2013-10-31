<div class="page index">
<h2><?php echo __('Full Currency Table');?></h2>

<?php
	echo pre($currencies);
?>


</div>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Add %s', __('Currency')), array('action'=>'add')); ?></li>
	</ul>
</div>