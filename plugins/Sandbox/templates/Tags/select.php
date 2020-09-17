<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Entity $category
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tags'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Tags and Add/Edit Forms</h3>

<h4>As select input using select2 JS functionality and "array" strategy</h4>

<?php
$this->loadHelper('Tags.Tag');

echo $this->Form->create($category);
echo $this->Form->control('title');

echo $this->Tag->control(['id' => 'tags-select-list', 'help' => 'This can even provide existing tags to quick-select.']);

echo $this->Form->submit('Save');

echo $this->Form->end();
?>
</div>

<?php $this->Html->script('/assets/select2/dist/js/select2.js', ['block' => true]); ?>
<?php $this->Html->css('/assets/select2/dist/css/select2.css', ['block' => true]); ?>

<?php $this->append('script');?>
<script>
	$("#tags-select-list").select2({
		tags: true,
		tokenSeparators: [',']
	})
</script>
<?php $this->end();
