<?php
/**
 * @var \App\View\AppView $this
 * @var string|null $result
 * @var array $options
 * @var string[] $types
 * @var string $ext
 */

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/qr_code'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Complex Usage</h3>
	<p>Here we use a controller action to allow rendering also <?php echo strtoupper($ext);?> directly</p>

	<div class="col-md-6" style="margin-bottom: 16px;">
		<?php if ($result) { ?>
		<h4>Result</h4>
		<?php
		echo $this->QrCode->$ext($result, $options);
		?>

		<details style="margin-top: 10px;">
			<summary>Show text</summary>
			<code><?php echo h($result); ?></code>
		</details>

		<?php } ?>
	</div>

	<h4>Generate QR Code</h4>

	<?php echo $this->Form->create(null, ['novalidate' => true]);?>
	<p>Enter some text (URL, ...)</p>

	<?php
	echo $this->Form->control('type', ['options' => $types, 'default' => $this->request->getQuery('type')]);
	echo $this->Form->control('size', ['options' => ['Auto']]);
	?>

	<div id="cardBox">
		<br>
		<?php
		echo $this->Form->control('Card.name', []);
		echo $this->Form->control('Card.nickname', []);
		echo $this->Form->control('Card.tel', []);
		echo $this->Form->control('Card.email', []);
		echo $this->Form->control('Card.address', []);
		echo $this->Form->control('Card.url', ['placeholder' => 'http://']);
		echo $this->Form->control('Card.birthday', ['type' => 'date', 'dateFormat' => 'DMY', 'minYear' => date('Y') - 90, 'empty' => true, 'maxYear' => date('Y')]);

		echo $this->Form->control('Card.note', ['rows' => 5]);

		?>
	</div>
	<div id="textBox">
		<br>
		<?php
		echo $this->Form->control('content', ['rows' => 5]);

		?>
	</div>
	<br>
	<div id="smsBox">
		<?php
		echo $this->Form->control('Sms.number', []);
		echo $this->Form->control('Sms.content', ['rows' => 5]);

		?>
	</div>
	<div id="wifiBox">
		<?php
		$types = [
			'WPA' => 'WPA',
			'WPE' => 'WPE',
		];
		echo $this->Form->control('Wifi.type', ['options' => $types]);
		echo $this->Form->control('Wifi.network', ['placeholder' => 'SSID']);
		echo $this->Form->control('Wifi.key', ['placeholder' => 'Password']);
		?>
	</div>

	<div class="col-md-offset-2 col-md-6">
		<?php echo $this->Form->button(__('Go'), ['class' => 'btn btn-success']);?>
	</div>
	<?php echo $this->Form->end(); ?>


</div>


<?php $this->append('script');?>
	<script type="text/javascript">
		$(document).ready(function() {

			$("#type").change(function () {
				var selvalue = $(this).val();
				if (selvalue === 'card') {
					$("#textBox").hide(50);
					$("#smsBox").hide(50);
					$("#wifiBox").hide(50);
					$("#cardBox").show(50);
				} else if (selvalue === 'sms') {
					$("#textBox").hide(50);
					$("#cardBox").hide(50);
					$("#wifiBox").hide(50);
					$("#smsBox").show(50);
				} else if (selvalue === 'wifi') {
					$("#textBox").hide(50);
					$("#cardBox").hide(50);
					$("#smsBox").hide(50);
					$("#wifiBox").show(50);
				} else {
					$("#cardBox").hide(50);
					$("#smsBox").hide(50);
					$("#wifiBox").hide(50);
					$("#textBox").show(50);
				}
			}).change();

		});

	</script>
<?php $this->end();
