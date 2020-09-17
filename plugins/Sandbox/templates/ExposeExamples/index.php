<?php
/**
 * @var \App\View\AppView $this
 * @var string[] $exposedUsers !
 */
?>
<h2>CakePHP Expose Examples</h2>

<a href="https://github.com/dereuromark/cakephp-expose" target="_blank">[Source]</a>

<div style="float: right">
	<p>The database field type is <code>binary</code> with a length of 16 (byte).</p>
	<p>
		UUID shortening enabled: <?php echo $this->Format->yesNo($this->request->getSession()->read('Expose.short'))?>
		<?php echo $this->request->getSession()->read('Expose.short') ? '(display with char length of 22)' : '(display with char length of 36)'; ?>
	</p>
	<p>You can switch the database Type class used here:</p>
	<?php echo $this->Html->link('BinaryUuid (char 36)', ['?' => ['short' => false]], ['class' => 'btn btn-secondary']); ?>
	<?php echo $this->Html->link('ShortUuid (char 22)', ['?' => ['short' => true]], ['class' => 'btn btn-primary']); ?>
</div>


<h3>Table overview</h3>
<p>
<?php echo $this->Html->link('List all exposed users in paginated list', ['action' => 'users']); ?>
</p>

<h3>Check a specific one</h3>

<p>The following are ordered by name:</p>
<ul>
	<?php foreach ($exposedUsers as $exposedId => $exposedUser) { ?>
	<li><?php echo $this->Html->link($exposedUser, ['action' => 'view', $exposedId]); ?> [ID <?php echo h($exposedId); ?>]</li>
	<?php } ?>
</ul>

<p>It is now not possible anymore to see the primary key, and thus the order of creation or linking of those to a count of records per time-frame.</p>

<h3>Superimposed behavior</h3>

<p>In some cases you don't want to modify all public actions and their templates. In that case you can use the superimpose functionality to map UUIDs to the  primary key field on read, and the other way around on write.</p>

<p>
	<?php echo $this->Html->link('CRUD actions through superimposed exposure', ['action' => 'superimposedIndex']); ?>
</p>
