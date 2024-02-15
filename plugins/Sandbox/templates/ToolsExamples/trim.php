<?php
/**
 * @var \App\View\AppView $this
 * @var array $array
 * @var array $params
 * @var array $tree
 * @var \Sandbox\Model\Entity\SandboxCategory $sandboxCategory
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Data consistency on request input</h2>

<p>
	The CommonComponent is added to all my apps by default for the last 15+ years.
	It ensures basic data integrity on request input in regards to emptiness.
	<br>
	This needs to happen in communication layer to ensure this for all other layers.
	Can be skipped for edge cases using `notrim` config on the component.
</p>

	<?php
	$dataPrint = <<<'TXT'
if ($this->request->getQuery('key')) {}
if ($this->request->getData('key')) {}
TXT;
	echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php']);
	?>
	<p>
		Imagine the behavior change if this was invoked for empty string that is actually just containing whitespace/noise.
	<br>
		The same for model validation rules that rely on not empty string input for the data to be saved to make sense .
	</p>

<h3>Form post Example</h3>
<p>Try to pass validation rule notEmpty by adding whitespace (e.g. space) into the input (or before/after a string input).</p>
	<?php echo $this->Form->create($sandboxCategory); ?>
	<?php echo $this->Form->control('name', ['label' => 'Required field']); ?>
	<?php echo $this->Form->submit(); ?>
	<?php echo $this->Form->end(); ?>

	<p>Notice how the input is trimmed before passing it on to the controller action and validation.</p>

<h3>Query String Example</h3>
<p>Especially URL input often can contain additional whitespace due to badly formed links.</p>

	<h5>Normal</h5>
	<p><?php echo $this->Html->link("'key' => 'Some value'", ['?' => ['key' => 'Some value'] + $this->request->getQuery()]); ?></p>
	<p>Value processed will be exactly the same.</p>

	<h5>Leading and trailing whitespace</h5>
	<p><?php echo $this->Html->link("'key' => ' Some value '", ['?' => ['key' => ' Some value '] + $this->request->getQuery()]); ?></p>
	<p>Notice how the data is trimmed.</p>

	<h5>Whitespace only (1 space)</h5>
	<p><?php echo $this->Html->link("['key' => ' ']", ['?' => ['key' => ' '] + $this->request->getQuery()]); ?></p>
	<p>Notice how this doesnt trigger the if clause (as it should not).</p>

	<h3>Disable trimming</h3>
	<p>
		Just to show the difference in behavior and data, you can disable the trimming in this demo by adding `notrim=1` to the URL:
		<br>
		<?php if (!$this->request->getQuery('notrim')) { ?>
			<b>Enabled</b> | <?php echo $this->Html->link('Disable', ['?' => ['notrim' => true] + $this->request->getQuery()]); ?>
		<?php } else { ?>
			<?php echo $this->Html->link('Enable', ['?' => ['notrim' => null] + $this->request->getQuery()]); ?> | <b>Disabled</b>
		<?php } ?>
		<br>
	</p>

</div>
