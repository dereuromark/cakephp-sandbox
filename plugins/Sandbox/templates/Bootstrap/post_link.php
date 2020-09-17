<?php
/**
 * @var \App\View\AppView $this
 * @var App\Model\Entity\Entity $animal
 */
?>

<div class="row">
	<div class="col-md-12">

<h2>Post Links</h2>

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
