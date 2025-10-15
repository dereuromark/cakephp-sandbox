<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\AuditLog $auditLog
 */
?>
<div class="audit-stash partial-revert">
	<h1>Partial Revert - Select Fields</h1>

	<div class="mb-3">
		<?= $this->Html->link('← Back to Log Details', ['action' => 'viewLog', $auditLog->id], ['class' => 'btn btn-secondary']) ?>
		<?= $this->Html->link('← Back to List', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
	</div>

	<div class="card mb-4">
		<div class="card-header">
			<h3>
				<span class="badge badge-warning">UPDATE</span>
				Log Entry #<?= h($auditLog->id) ?>
			</h3>
		</div>
		<div class="card-body">
			<p><strong>Article:</strong> #<?= h($auditLog->primary_key) ?>
				<?php if ($auditLog->display_value) { ?>
					- <?= h($auditLog->display_value) ?>
				<?php } ?>
			</p>
			<p><strong>Changed:</strong> <?= h($auditLog->created->format('Y-m-d H:i:s')) ?> (<?= h($auditLog->created->timeAgoInWords()) ?>)</p>
		</div>
	</div>

	<?= $this->Form->create(null, ['type' => 'post']) ?>
	<div class="card">
		<div class="card-header">
			<h4>Select Fields to Revert</h4>
			<p class="mb-0">Check the fields you want to restore to their previous values.</p>
		</div>
		<div class="card-body">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th width="50">
							<input type="checkbox" id="select-all" />
						</th>
						<th>Field</th>
						<th>Original Value <span class="text-muted">(will be restored)</span></th>
						<th>Current Value <span class="text-muted">(will be replaced)</span></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($auditLog->changed_data as $field => $newValue) { ?>
						<tr>
							<td class="text-center">
								<input
									type="checkbox"
									name="fields[]"
									value="<?= h($field) ?>"
									class="field-checkbox"
								/>
							</td>
							<td><strong><?= h($field) ?></strong></td>
							<td>
								<span class="text-success">
									<?php
									$originalValue = $auditLog->original_data[$field] ?? 'N/A';
									if (is_string($originalValue) && strlen($originalValue) > 100) {
										echo h(substr($originalValue, 0, 100)) . '...';
									} else {
										echo h($originalValue);
									}
									?>
								</span>
							</td>
							<td>
								<span class="text-danger">
									<?php
									if (is_string($newValue) && strlen($newValue) > 100) {
										echo h(substr($newValue, 0, 100)) . '...';
									} else {
										echo h($newValue);
									}
									?>
								</span>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
		<div class="card-footer">
			<?= $this->Form->button(__('Revert Selected Fields'), ['class' => 'btn btn-warning']) ?>
			<?= $this->Html->link(__('Cancel'), ['action' => 'viewLog', $auditLog->id], ['class' => 'btn btn-secondary']) ?>
		</div>
	</div>
	<?= $this->Form->end() ?>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const selectAll = document.getElementById('select-all');
			const fieldCheckboxes = document.querySelectorAll('.field-checkbox');

			selectAll.addEventListener('change', function() {
				fieldCheckboxes.forEach(function(checkbox) {
					checkbox.checked = selectAll.checked;
				});
			});

			fieldCheckboxes.forEach(function(checkbox) {
				checkbox.addEventListener('change', function() {
					const allChecked = Array.from(fieldCheckboxes).every(cb => cb.checked);
					selectAll.checked = allChecked;
				});
			});
		});
	</script>
</div>
