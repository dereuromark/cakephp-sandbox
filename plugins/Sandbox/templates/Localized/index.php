<?php
/**
 * @var \App\View\AppView $this
 * @var array $available
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?php echo $this->element('navigation/localized'); ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>Localized</h2>

<h3>Validation</h3>
<p>
	The following ones are available as localized versions per ISO-2 Country code:
</p>
<table class="list table table-striped">
	<?php foreach ($available as $code => $methods) { ?>
		<tr>
			<td>
				<?php echo $this->Data->countryIcon($code); ?>
				<?php echo h(strtoupper($code)); ?>
			</td>
			<td>
				<?php foreach ($methods as $method) {
					$html = \Templating\View\Html::create('<span class="badge badge-info">' . h($method) . '</span>');
					echo $this->Html->link($html, ['action' => 'basic', '?' => ['code' => strtoupper($code), 'method' => $method]]) . ' ';
				} ?>
			</td>
		</tr>
	<?php } ?>
</table>

</div>
