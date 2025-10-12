<?php
/**
 * @var \App\View\AppView $this
 * @var string $name
 * @var array $icons
 */

$iconCount = 0;
foreach ($icons as $iconSet) {
	$iconCount += count($iconSet);
}
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/templating'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Icon Sets</h2>

	<h3><?php echo h(ucfirst($name)); ?></h3>

	<p><?php echo $iconCount; ?> icons in this set.</p>

	<?php foreach ($icons as $iconSet) { ?>
	<div class="row">
		<?php foreach ($iconSet as $icon) { ?>
		<div class="col-lg-3 col-md-4 col-sm-6 card">
			<div class="card-body">
				<?php echo $this->Icon->render($name . ':' . $icon); ?>
				<br>
				<code><?php echo h($icon); ?></code>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php } ?>

	<script src="/assets/feather-icons/dist/feather.js"></script>
	<script>
		feather.replace();
	</script>
	<link rel="stylesheet" href="/assets/material-symbols/outlined.css"/>

</div>
