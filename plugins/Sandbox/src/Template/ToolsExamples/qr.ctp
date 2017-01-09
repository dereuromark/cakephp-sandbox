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
use Cake\Validation\Validation;

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
		echo $this->Form->input('type', ['options' => $types]);
		echo $this->Form->input('size', ['options' => ['Auto']]);
	?>

	<div id="cardBox">
		<br>
	<?php
		echo $this->Form->input('Card.name', []);
		//echo $this->Form->input('Card.sound', array());
		echo $this->Form->input('Card.nickname', []);
		echo $this->Form->input('Card.tel', []);
		//echo $this->Form->input('Card.video', array());
		echo $this->Form->input('Card.email', []);
		echo $this->Form->input('Card.address', []);
		echo $this->Form->input('Card.url', ['placeholder' => 'http://']);
		echo $this->Form->input('Card.birthday', ['type' => 'date', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 90, 'empty' => true, 'maxYear' => date('Y')]);

		echo $this->Form->input('Card.note', ['rows' => 10]);

	?>
	</div>
	<div id="textBox">
		<br>
	<?php
		echo $this->Form->input('content', ['rows' => 10]);

	?>
	</div>
		<br>
	<div id="smsBox">
	<?php
		echo $this->Form->input('Sms.number', []);
		echo $this->Form->input('Sms.content', ['rows' => 10]);

	?>
	</div>
	</fieldset>

<?php echo $this->Form->submit(__('Submit')); echo $this->Form->end();?>
</div>
