<h1>Generate DTO Schema from JSON/Structure</h1>

<div class="float-end">
	<?php echo $this->Html->link('Restart', ['action' => 'schema', '?' => $this->request->getQuery()]); ?>
</div>

<?php if (!empty($result)) { ?>

	<h2>Result</h2>

	<pre><?php echo h($result); ?></pre>

<?php } elseif (!empty($schema)) { ?>

	<p>Define which DTOs and fields should be present</p>

	<?php echo $this->Form->create(); ?>

	<?php foreach ($schema as $dtoName => $fields) { ?>
		<?php echo $this->Form->control('dto.' . h($dtoName) . '._include', ['type' => 'checkbox', 'default' => true, 'label' => '<b>' . h($dtoName) . '</b>', 'escape' => false]); ?>
		<ul class="">
		<?php foreach ($fields as $fieldName => $details) { ?>
			<li class="list-unstyled">
			<?php
			$label = $fieldName;
			$label .= ' [' . $details['type'] .']';
			if (!empty($details['required'])) {
				$label.=' (required)';
			}
			?>
			<?php echo $this->Form->control('dto.' . $dtoName . '.' . $fieldName . '._include', ['type' => 'checkbox', 'default' => true, 'label' => $label]); ?>
			<?php echo $this->Form->hidden('dto.' . $dtoName . '.' . $fieldName . '.type', ['value' => $details['type']]); ?>
			<?php echo $this->Form->hidden('dto.' . $dtoName . '.' . $fieldName . '.singular', ['value' => $details['singular'] ?? null]); ?>
			<?php echo $this->Form->hidden('dto.' . $dtoName . '.' . $fieldName . '.associative', ['value' => $details['associative'] ?? null]); ?>
			<?php echo $this->Form->hidden('dto.' . $dtoName . '.' . $fieldName . '.required', ['value' => $details['required'] ?? null]); ?>
			</li>
		<?php } ?>
		</ul>
	<?php } ?>

	<?php echo $this->Form->hidden('namespace'); ?>

	<?php echo $this->Form->button('Generate'); ?>
	<?php echo $this->Form->end(); ?>

<?php } else { ?>

	<p>Enter your JSON data/structure (example API result or JSON schema):</p>

	<?php echo $this->Form->create(); ?>

	<?php
	$inputDefault = $this->request->getQuery('input', '');
	$compressed = $this->request->getQuery('compressed');
	?>
	<?php echo $this->Form->control('input', [
		'type' => 'textarea',
		'rows' => 20,
		'default' => $compressed ? '' : $inputDefault,
		'id' => 'input-field',
		'data-compressed' => $compressed ? $inputDefault : '',
	]); ?>
	<?php echo $this->Form->control('type', ['type' => 'select', 'options' => \PhpCollective\Dto\Importer\Parser\Config::typeLabels(), 'empty' => ['' => 'Auto-Detect'], 'default' => $this->request->getQuery('type')]); ?>
	<?php echo $this->Form->control('namespace', ['type' => 'text', 'placeholder' => 'Optional namespace prefix', 'label' => 'DTO namespace', 'default' => $this->request->getQuery('namespace')]); ?>

	<?php echo $this->Form->button('Parse'); ?>
	<?php echo $this->Form->end(); ?>

	<?php if ($compressed) { ?>
	<?php echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/pako/2.1.0/pako.min.js'); ?>
	<script>
	document.addEventListener('DOMContentLoaded', function() {
		var field = document.getElementById('input-field');
		var compressed = field.dataset.compressed;
		if (compressed) {
			try {
				var binary = atob(compressed);
				var bytes = new Uint8Array(binary.length);
				for (var i = 0; i < binary.length; i++) {
					bytes[i] = binary.charCodeAt(i);
				}
				var decompressed = pako.inflate(bytes, { to: 'string' });
				field.value = decompressed;
			} catch (e) {
				console.error('Failed to decompress:', e);
				field.value = compressed;
			}
		}
	});
	</script>
	<?php } ?>

<?php } ?>
