<?php
/**
 * @var \App\View\AppView $this
 * @var array $result
 * @var string[] $types
 */

use Cake\Validation\Validation;

?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

<h3>QR Codes</h3>
Too lazy to type text messages via cellphone? This is the smart way.
<br />
Just write it via keyboard, scan it and send it.

<h3>Result</h3>
<?php

if (!empty($result)) {
		$this->QrCode->setSize(300);
		if ($this->request->data['type'] === 'card') {
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
			$string = $this->QrCode->formatText($result, $this->request->data['type']);
		}

		echo $this->QrCode->image($string);
	}
?>

<h3>Generate QR Code</h3>
<div class="boardPosts form">
<?php echo $this->Form->create();?>
	<fieldset>
		<legend><?php echo __('New {0}', __('QR Code')); ?></legend>
	<?php
		echo $this->Form->control('type', ['options' => $types]);
		echo $this->Form->control('size', ['options' => ['Auto']]);
	?>

	<div id="cardBox">
		<br>
	<?php
		echo $this->Form->control('Card.name', []);
		//echo $this->Form->control('Card.sound', array());
		echo $this->Form->control('Card.nickname', []);
		echo $this->Form->control('Card.tel', []);
		//echo $this->Form->control('Card.video', array());
		echo $this->Form->control('Card.email', []);
		echo $this->Form->control('Card.address', []);
		echo $this->Form->control('Card.url', ['placeholder' => 'http://']);
		echo $this->Form->control('Card.birthday', ['type' => 'date', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 90, 'empty' => true, 'maxYear' => date('Y')]);

		echo $this->Form->control('Card.note', ['rows' => 10]);

	?>
	</div>
	<div id="textBox">
		<br>
	<?php
		echo $this->Form->control('content', ['rows' => 10]);

	?>
	</div>
		<br>
	<div id="smsBox">
	<?php
		echo $this->Form->control('Sms.number', []);
		echo $this->Form->control('Sms.content', ['rows' => 10]);

	?>
	</div>
	</fieldset>

<?php echo $this->Form->submit(__('Submit'));
echo $this->Form->end();?>
</div>

</div>


<?php $this->append('script');?>
<script type="text/javascript">
	$(document).ready(function() {

		$("#type").change(function () {
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
<?php $this->end();
