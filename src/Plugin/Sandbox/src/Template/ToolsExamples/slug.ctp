<h2>Working with Slugs</h2>
<p>Using the SluggedBehavior.
</p>
<p>
The following example uses unique slugs (Try saving the same username twice) and ascii chars only.<br>
So when you try to save "n/a" it will become "n-a". If that is already taken, it will increment the suffix, e.g. "n-a-1" etc.
</p>

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

<?php if ($slug = $user->get('slug')) { ?>
<h3>Info</h3>
</p>The generated slug that is saved along with the username: <b><?php echo h($slug); ?></b><p>

<br><br>

Entity data:
<pre>
<?php
print_r($user->toArray());
?>
</pre>
<?php } ?>