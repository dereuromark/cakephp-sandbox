<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h1>Working with Referer Redirects</h1>
	<p>Using the Tools.RefererRedirect component</p>

	<p>Note how this will redirect you back to the referer specified in the query strings if possible.</p>

	<h3>Let's try it out</h3>
	<p>
		We now link to an edit page using query string
		<br>
		<code><?php echo h('\'?\' => [\'ref\' => $this->getRequest()->getRequestTarget()');?></code>
	</p>

	<p>
	<?php echo $this->Html->link(
		$this->Icon->render('edit') . ' Edit demo category',
		['action' => 'fakeEdit', 1, '?' => ['ref' => $this->getRequest()->getRequestTarget()]],
		['escape' => false]
	); ?>
	</p>

	<h3>Details</h3>
	<p>
		If you want to try out if it also keeps query strings, go to this action as e.g.
		<?php echo $this->Html->link('this URL', ['?' => ['foo' => 'bar', 'x' => 'y']]);?>
		and see if it still works.
	</p>
	<p>Also see how you can refresh the edit form and it still works. With hidden inputs you usually lose the value.</p>


</div></div>
