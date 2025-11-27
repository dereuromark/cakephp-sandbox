<?php
/**
 * @var \App\View\AppView $this
 * @var \Tools\Form\ContactForm $contact
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?= $this->element('navigation/captchas') ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>Passive Captcha</h2>
<p>An invisible honeypot-style captcha for model-less forms. No user interaction required.</p>

<div id="demo-form">
<?= $this->Form->create($contact, ['novalidate' => true]) ?>
<fieldset>
	<legend><?= __('Send Message') ?></legend>
	<?php
	echo $this->Form->control('name');
	echo $this->Form->control('body', ['label' => 'Message', 'type' => 'textarea']);
	echo $this->Captcha->passive();
	?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
</div>

<h3 class="mt-4">How it works</h3>
<p>
	A bot will usually fill out the hidden "email_homepage" field. You can simulate that by clicking this button:
</p>
<p>
	<button class="btn btn-warning" id="pretend">Pretend to be a bot</button>
	<a href="<?= $this->request->getUri()->getPath() ?>" class="btn btn-outline-secondary">Reset</a>
</p>

<h3>Key Benefits</h3>
<ul>
	<li>Simple and without bothering normal users</li>
	<li>No image or challenge to solve</li>
	<li>Works with model-less forms</li>
</ul>

</div>

<?php $this->append('script'); ?>
<script>
$(function() {
	$('#pretend').click(function() {
		var form = $('#demo-form');
		form.find('input').val(function() {
			return 'some-bot-input';
		});
		form.find('textarea').val(function() {
			return 'some-bot-input';
		});
	});
});
</script>
<?php $this->end(); ?>
