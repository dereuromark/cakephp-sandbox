 <?php echo ($active_system=='windows'?'<b>windows</b>':$this->Html->link('windows', array('action'=>'change_system_ajax','windows'), array()));?>
 | 
<?php echo ($active_system=='mac'?'<b>mac</b>':$this->Html->link('mac', array('action'=>'change_system_ajax','mac')));
?> 