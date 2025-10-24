<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/bootstrap'); ?>
</nav>
<div class="page html col-sm-8 col-12">

<h3>HtmlHelper - Badges & Icons</h3>
<p>The BootstrapUI HtmlHelper provides Bootstrap-styled badge and icon components.</p>

<h4>Badges</h4>
<p>Bootstrap badges for counts and labels.</p>

<h5>Basic Badges</h5>
<div class="card mb-3">
	<div class="card-body">
		<p>
			<?= $this->Html->badge('Default') ?>
			<?= $this->Html->badge('Primary', ['class' => 'bg-primary']) ?>
			<?= $this->Html->badge('Secondary', ['class' => 'bg-secondary']) ?>
			<?= $this->Html->badge('Success', ['class' => 'bg-success']) ?>
			<?= $this->Html->badge('Danger', ['class' => 'bg-danger']) ?>
			<?= $this->Html->badge('Warning', ['class' => 'bg-warning text-dark']) ?>
			<?= $this->Html->badge('Info', ['class' => 'bg-info text-dark']) ?>
			<?= $this->Html->badge('Light', ['class' => 'bg-light text-dark']) ?>
			<?= $this->Html->badge('Dark', ['class' => 'bg-dark']) ?>
		</p>
	</div>
	<div class="card-footer">
		<code>
			$this->Html->badge('Text', ['class' => 'bg-primary'])
		</code>
	</div>
</div>

<h5>Pill Badges</h5>
<div class="card mb-3">
	<div class="card-body">
		<p>
			<?= $this->Html->badge('Rounded pill', ['class' => 'rounded-pill bg-primary']) ?>
			<?= $this->Html->badge('99+', ['class' => 'rounded-pill bg-danger']) ?>
			<?= $this->Html->badge('New', ['class' => 'rounded-pill bg-success']) ?>
		</p>
	</div>
	<div class="card-footer">
		<code>
			$this->Html->badge('Text', ['class' => 'rounded-pill bg-primary'])
		</code>
	</div>
</div>

<h5>Badges in Context</h5>
<div class="card mb-3">
	<div class="card-body">
		<h4>
			Messages <?= $this->Html->badge('4', ['class' => 'bg-primary']) ?>
		</h4>
		<h5>
			Inbox <?= $this->Html->badge('12', ['class' => 'bg-danger']) ?>
		</h5>
		<p>
			Button with badge:
			<button type="button" class="btn btn-primary">
				Notifications <?= $this->Html->badge('9', ['class' => 'bg-secondary']) ?>
			</button>
		</p>
	</div>
	<div class="card-footer">
		<code>
			Messages &lt;?= $this->Html->badge('4', ['class' => 'bg-primary']) ?&gt;
		</code>
	</div>
</div>

<h4>Icons (Bootstrap Icons)</h4>
<p>Bootstrap Icons integration for consistent iconography.</p>

<div class="alert alert-info">
	<strong>Note:</strong> Bootstrap Icons must be installed via npm. The icon component renders
	<code>&lt;i&gt;</code> tags with the appropriate Bootstrap Icons classes.
</div>

<h5>Basic Icons</h5>
<div class="card mb-3">
	<div class="card-body">
		<p style="font-size: 1.5rem;">
			<?= $this->Html->icon('house-fill') ?>
			<?= $this->Html->icon('heart-fill') ?>
			<?= $this->Html->icon('star-fill') ?>
			<?= $this->Html->icon('check-circle-fill') ?>
			<?= $this->Html->icon('x-circle-fill') ?>
			<?= $this->Html->icon('info-circle-fill') ?>
			<?= $this->Html->icon('exclamation-triangle-fill') ?>
			<?= $this->Html->icon('gear-fill') ?>
		</p>
	</div>
	<div class="card-footer">
		<code>
			$this->Html->icon('house-fill')
		</code>
	</div>
</div>

<h5>Icon Sizes</h5>
<div class="card mb-3">
	<div class="card-body">
		<p>
			Small: <?= $this->Html->icon('star-fill', ['style' => 'font-size: 0.75rem;']) ?>
			Normal: <?= $this->Html->icon('star-fill') ?>
			Large: <?= $this->Html->icon('star-fill', ['style' => 'font-size: 1.5rem;']) ?>
			X-Large: <?= $this->Html->icon('star-fill', ['style' => 'font-size: 2rem;']) ?>
			XX-Large: <?= $this->Html->icon('star-fill', ['style' => 'font-size: 3rem;']) ?>
		</p>
	</div>
	<div class="card-footer">
		<code>
			$this->Html->icon('star-fill', ['style' => 'font-size: 2rem;'])
		</code>
	</div>
</div>

<h5>Colored Icons</h5>
<div class="card mb-3">
	<div class="card-body">
		<p style="font-size: 1.5rem;">
			<?= $this->Html->icon('check-circle-fill', ['class' => 'text-success']) ?>
			<?= $this->Html->icon('x-circle-fill', ['class' => 'text-danger']) ?>
			<?= $this->Html->icon('info-circle-fill', ['class' => 'text-info']) ?>
			<?= $this->Html->icon('exclamation-triangle-fill', ['class' => 'text-warning']) ?>
			<?= $this->Html->icon('heart-fill', ['class' => 'text-danger']) ?>
			<?= $this->Html->icon('star-fill', ['class' => 'text-warning']) ?>
		</p>
	</div>
	<div class="card-footer">
		<code>
			$this->Html->icon('check-circle-fill', ['class' => 'text-success'])
		</code>
	</div>
</div>

<h5>Icons with Text</h5>
<div class="card mb-3">
	<div class="card-body">
		<p>
			<?= $this->Html->icon('house-fill') ?> Home
			<br>
			<?= $this->Html->icon('envelope-fill') ?> Messages
			<br>
			<?= $this->Html->icon('person-fill') ?> Profile
			<br>
			<?= $this->Html->icon('gear-fill') ?> Settings
		</p>
	</div>
	<div class="card-footer">
		<code>
			&lt;?= $this->Html->icon('house-fill') ?&gt; Home
		</code>
	</div>
</div>

<h5>Icons in Buttons</h5>
<div class="card mb-3">
	<div class="card-body">
		<p>
			<button class="btn btn-primary">
				<?= $this->Html->icon('check-circle') ?> Save
			</button>
			<button class="btn btn-danger">
				<?= $this->Html->icon('trash') ?> Delete
			</button>
			<button class="btn btn-success">
				<?= $this->Html->icon('plus-circle') ?> Add New
			</button>
			<button class="btn btn-secondary">
				<?= $this->Html->icon('arrow-left') ?> Back
			</button>
		</p>
	</div>
	<div class="card-footer">
		<code>
			&lt;button class="btn btn-primary"&gt;<br>
			&nbsp;&nbsp;&lt;?= $this->Html->icon('check-circle') ?&gt; Save<br>
			&lt;/button&gt;
		</code>
	</div>
</div>

<h4>Combined: Badges with Icons</h4>
<div class="card mb-3">
	<div class="card-body">
		<p style="font-size: 1.2rem;">
			<?= $this->Html->badge($this->Html->icon('envelope-fill') . ' 5 new', ['class' => 'bg-primary', 'escape' => false]) ?>
			<?= $this->Html->badge($this->Html->icon('bell-fill') . ' 12', ['class' => 'bg-danger', 'escape' => false]) ?>
			<?= $this->Html->badge($this->Html->icon('check-circle-fill') . ' Verified', ['class' => 'bg-success', 'escape' => false]) ?>
		</p>
	</div>
	<div class="card-footer">
		<code>
			$this->Html->badge(<br>
			&nbsp;&nbsp;$this->Html->icon('envelope-fill') . ' 5 new',<br>
			&nbsp;&nbsp;['class' => 'bg-primary', 'escape' => false]<br>
			)
		</code>
	</div>
</div>

<div class="alert alert-secondary">
	<h5>Available Bootstrap Icons</h5>
	<p>
		See the full list at <a href="https://icons.getbootstrap.com/" target="_blank">Bootstrap Icons</a>.
		Common icons include: house, heart, star, check, x, info, exclamation, gear, person, envelope,
		bell, trash, plus, minus, arrow-left, arrow-right, search, and many more.
	</p>
</div>

</div>
</div>
