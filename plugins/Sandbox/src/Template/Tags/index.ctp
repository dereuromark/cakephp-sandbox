<?php
/**
 * @var \App\View\AppView $this
 */
?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/tags'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

<?php $this->Html->script('/assets/select2/dist/js/select2.js', ['block' => true]); ?>
<?php $this->Html->css('/assets/select2/dist/css/select2.css', ['block' => true]); ?>


<h3>Tags and Add/Edit Forms</h3>

<h4>As basic text input (comma separated list) and "string" strategy (default)</h4>
<?php
$this->loadHelper('Tags.Tag');

echo $this->Form->create($category);
echo $this->Form->control('title');
echo $this->Tag->control(['help' => 'Use comma (,) for separation.']);
echo $this->Form->submit('Save');

echo $this->Form->end();
?>

</div>
