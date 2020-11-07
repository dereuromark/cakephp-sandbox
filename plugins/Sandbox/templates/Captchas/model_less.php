<?php
/**
 * @var \App\View\AppView $this
 * @var \Tools\Form\ContactForm $contact
 */
?>
<div class="page index">


<h2>Model-less Forms and Passive Captchas</h2>

	<div id="demo-form">
	<?= $this->Form->create($contact, ['novalidate' => true]) ?>
	<fieldset>
		<legend><?= __('Send') ?></legend>
		<?php
		echo $this->Form->control('name');
		echo $this->Form->control('body', ['label' => 'Message', 'type' => 'textarea']);

		echo $this->Captcha->passive();
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
	</div>

	<br><br>
	<p>Note: A bot will usually fill out the "email_homepage" field. You can simulate that clicking this button:
		<br>
		<button class="btn btn-warning" id="pretend">Pretent to be a bot</button>
		<a href="<?php echo $this->request->getUri()->getPath();?>"><button class="btn btn-primary">Reset</button></a>
	</p>

<h3>Key Goals</h3>
<ul>
	<li>Simple and without bothering normal users</li>
	<li>Without much dependencies or requirements</li>
	<li>Highly extendable</li>
</ul>


<?php $this->append('script'); ?>
<script>
	$(function() {
		$('#pretend').click(function() {
			var form = $('#demo-form');

			form.find('input').val(function () {
				return 'some-bot-input';
			});
			form.find('textarea').val(function () {
				return 'some-bot-input';
			});
		});
	});
</script>
<?php $this->end(); ?>

