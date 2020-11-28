<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxCategory $sandboxCategory
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h1>Working with Referer Redirects</h1>
	<p>Using the Tools.RefererRedirect component</p>

	<p>Note how this will redirect you back to the referer specified in the query strings if possible.</p>

<?php echo $this->Form->create($sandboxCategory);?>

	<fieldset>
 		<legend><?php echo 'Demo (fake save)'; ?></legend>

		<p>Enter some description to continue.</p>

		<?php
		echo $this->Form->control('description');
	?>
	<?php echo $this->Form->submit(__('Submit'));?>
	</fieldset>
<?php echo $this->Form->end();?>

</div>
