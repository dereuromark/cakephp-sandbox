<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
<div class="col-12">

<h2>Your account</h2>

	<p>
Logged in as <b><?php echo h($this->AuthUser->user('username')); ?></b>
	</p>

<?php if (false) { ?>
<ul>
<li><?php //echo $this->Html->link(__('Edit'), ['plugin' => false, 'admin' => false, 'action' => 'edit']); ?></li>
</ul>
<?php } ?>

	<p>
	<?php if ($this->AuthUser->id()) { ?>
		<?php echo $this->Html->link('Log out', ['action' => 'logout'], ['class' => 'btn btn-danger']); ?>
	<?php } ?>
	</p>

</div>
</div>
