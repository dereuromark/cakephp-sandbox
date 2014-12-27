<script type="text/javascript">
$(document).ready(function() {

	$("#MiscType").change(function () {
		var selvalue = $(this).val();
		if (selvalue == 'card') {
			$("#textBox").hide(100);
			$("#smsBox").hide(100);
			$("#cardBox").show(100);
		} else if (selvalue == 'sms') {
			$("#textBox").hide(100);
			$("#cardBox").hide(100);
			$("#smsBox").show(100);
		} else {
			$("#cardBox").hide(100);
			$("#smsBox").hide(100);
			$("#textBox").show(100);
		}
	}).change();

});

</script>

<h3>QR Codes</h3>
Too lazy to type text messages via cellphone? This is the smart way.
<br />
Just write it via keyboard, scan it and send it.

<h3>Result</h3>
<?php
	if (!empty($result)) {
		$this->QrCode->setSize(300);
		if ($this->request->data['Misc']['type'] === 'card') {
			if (!Validation::date($result['birthday'])) {
				unset($result['birthday']);
			}
			foreach ($result as $key => $val) {
				if (empty($val)) {
					unset($result[$key]);
				}
			}
			$string = $this->QrCode->formatCard($result);
		} else {
			$string = $this->QrCode->formatText($result, $this->request->data['Misc']['type']);
		}

		echo $this->QrCode->image($string);
	}
?>

<h3>Generate QR Code</h3>
<div class="boardPosts form">
<?php echo $this->Form->create('Misc');?>
	<fieldset>
		<legend><?php echo __('New {0}', __('QR Code')); ?></legend>
	<?php
		echo $this->Form->input('type', array('options' => $types));
		echo $this->Form->input('size', array('options' => array('Auto')));
	?>

	<div id="cardBox">
	<?php
		echo BR;
		echo $this->Form->input('Card.name', array());
		//echo $this->Form->input('Card.sound', array());
		echo $this->Form->input('Card.nickname', array());
		echo $this->Form->input('Card.tel', array());
		//echo $this->Form->input('Card.video', array());
		echo $this->Form->input('Card.email', array());
		echo $this->Form->input('Card.address', array());
		echo $this->Form->input('Card.url', array('placeholder' => 'http://'));
		echo $this->Form->input('Card.birthday', array('type' => 'date', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 90, 'empty' => true, 'maxYear' => date('Y')));

		echo $this->Form->input('Card.note', array('rows' => 10));

	?>
	</div>
	<div id="textBox">
	<?php
		echo BR;
		echo $this->Form->input('content', array('rows' => 10));

	?>
	</div>
	<div id="smsBox">
	<?php
		echo BR;
		echo $this->Form->input('Sms.number', array());
		echo $this->Form->input('Sms.content', array('rows' => 10));

	?>
	</div>
	</fieldset>

<?php echo $this->Form->end(__('Submit'));?>
</div>