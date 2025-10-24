<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/bootstrap'); ?>
</nav>
<div class="page post-link col-sm-8 col-12">

<h3>Post Links</h3>

<p>POST button demo using <?php echo h('$this->Form->postLink()');?>.</p>

<p>
<?php
echo $this->Form->postLink(
	'A POST Link',
	[],
	['confirm' => 'Sure?']
);
?>
</p>

<p>
<?php
echo $this->Form->postLink(
	'A POST Link as Button',
	[],
	['confirm' => 'Sure?', 'class' => 'btn btn-primary']
);

?>
</p>

<p>Both use normal links and a JS form to post to the same action.</p>

</div>
</div>
