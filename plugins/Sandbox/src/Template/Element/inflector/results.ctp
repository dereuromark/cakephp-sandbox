<?php
/**
 * @var \App\View\AppView $this
 * @var string[] $results
 */
?>
<table class="table" id="inflections">
	<thead>
		<tr>
			<th colspan="2"><?php echo __('Method'); ?></th>
			<th><?php echo __('Result'); ?></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($results as $method => $result) {
			echo $this->element('Sandbox.inflector/result-row', compact('method', 'result'));
		}
		?>
	</tbody>
</table>
