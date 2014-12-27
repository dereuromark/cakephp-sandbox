<h1>Convert Text</h1>
Sometimes you need to escape the text in order to post somewhere. Sometimes you need exactly the opposite.<br />
Example: If a blog already escapes characters like &amp; (result is <?php echo h('&amp;'); ?>) and you would pass already escaped characters, you would end up with double-escaped characters (<?php echo h('&amp;amp;'); ?>) which are not readable anymore.
<br /><br />
Use this converter to get the text in the appropriate format.


<h2>Converter</h2>

<div class="examples form">
<?php echo $this->Form->create('Tool');?>
	<fieldset>
 		<legend><?php echo __('Enter Text');?></legend>
	<?php
		echo $this->Form->input('Form.text', array('type' => 'textarea', 'class' => 'halfSize'));
		echo $this->Form->input('Form.type', array('empty' => array('0' => '- [auto-detect] -')));
		echo $this->Form->input('Form.prevent_trim', array('type' => 'hidden', 'value' => 1));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>

<h2>Result</h2>
<?php
echo $this->Form->input('Form.result', array('type' => 'textarea', 'class' => 'halfSize'));

if (!empty($this->request->data) && !empty($this->request->data['Form']['result'])) {
	echo '<div class="">';
	echo '<label>Result h()ed</label>';
	echo nl2br(h($this->request->data['Form']['result']));
	echo '</div>';
	/*
	echo '<br class="clear">';
	echo '<div class="">';
	echo '<label>Result double-h()ed</label>';
	echo nl2br(h(h($this->request->data['Form']['result'])));
	echo '</div>';

	echo '<br class="clear">';
	echo '<div class="">';
	echo '<label>Result hDec()ed</label>';
	echo nl2br(hDec($this->request->data['Form']['result']));
	echo '</div>';

	echo '<br class="clear">';
	echo '<div class="">';
	echo '<label>Result double-hDec()ed</label>';
	echo nl2br(hDec(hDec($this->request->data['Form']['result'])));
	echo '</div>';
	*/
}

?>

<br /><br />

<div class="actions">
	<ul>
		<li><?php echo $this->Html->link(__('Back'), array('action' => 'index'));?></li>
	</ul>
</div>