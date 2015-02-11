<h2>Working with Slugs</h2>
Using the SluggedBehavior

<div class="page form">
<?php echo $this->Form->create($user);?>
	<fieldset>
 		<legend><?php echo 'Slug Demo'; ?></legend>
	<?php
		echo $this->Form->input('username', array('size' => 50, ));
		//echo $this->Form->input('slug', array('size' => 50, 'placeholder' => 'Leave empty to auto-generate using the behavior'));
	?>
	<?php echo $this->Form->submit(__('Submit'));?>
	</fieldset>
<?php echo $this->Form->end();?>
</div>

<h3>Info</h3>
<?php if ($slug = $user->get('slug')) { ?>
</p>The generated slug that is saved along with the username: <b><?php echo h($slug); ?></b><p>
<?php } ?>

<?php
pr($user->toArray());
?>