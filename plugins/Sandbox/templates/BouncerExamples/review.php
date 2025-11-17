<?php
/**
 * @var \App\View\AppView $this
 * @var \Bouncer\Model\Entity\BouncerRecord $bouncerRecord
 */
$isNew = $bouncerRecord->primary_key === null;
$data = json_decode($bouncerRecord->get('data'), true) ?: [];
$originalData = json_decode($bouncerRecord->get('original_data'), true) ?: [];
$isDelete = isset($data['_delete']) && $data['_delete'] === true;
?>

<div class="page view">
	<?= $this->element('Sandbox.bouncer_nav') ?>

	<h2><?= __('Review Pending Change') ?></h2>

	<div class="card mb-3">
		<div class="card-header">
			<h5>Change Information</h5>
		</div>
		<div class="card-body">
			<dl class="row">
				<dt class="col-sm-3">Type:</dt>
				<dd class="col-sm-9">
					<?php if ($isDelete) { ?>
						<span class="badge bg-danger">Delete Article #<?= h($bouncerRecord->primary_key) ?></span>
					<?php } elseif ($isNew) { ?>
						<span class="badge bg-success">New Article</span>
					<?php } else { ?>
						<span class="badge bg-warning">Edit Existing Article #<?= h($bouncerRecord->primary_key) ?></span>
					<?php } ?>
				</dd>

				<dt class="col-sm-3">Submitted by:</dt>
				<dd class="col-sm-9">User #<?= $this->Number->format($bouncerRecord->user_id) ?></dd>

				<dt class="col-sm-3">Submitted at:</dt>
				<dd class="col-sm-9"><?= $this->Time->nice($bouncerRecord->created) ?></dd>
			</dl>
		</div>
	</div>

	<div class="card mb-3">
		<div class="card-header">
			<h5>Proposed Changes</h5>
		</div>
		<div class="card-body">
			<?php if ($isDelete) { ?>
				<div class="alert alert-danger">
					<h6>Deletion Request</h6>
					<p>This is a request to delete the following article:</p>
				</div>
				<h6>Article to be Deleted:</h6>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Field</th>
							<th>Current Value</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($originalData as $field => $value) { ?>
							<?php if ($field !== 'id' && $field !== 'created' && $field !== 'modified' && $field !== '_delete') { ?>
								<tr>
									<td><strong><?= h($field) ?></strong></td>
									<td><?= h($value) ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			<?php } elseif ($isNew) { ?>
				<h6>New Article Data:</h6>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Field</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $field => $value) { ?>
							<?php if ($field !== 'id' && $field !== 'created' && $field !== 'modified') { ?>
								<tr>
									<td><strong><?= h($field) ?></strong></td>
									<td><?= h($value) ?></td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			<?php } else { ?>
				<h6>Changes (Diff View):</h6>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th>Field</th>
							<th width="45%">Original</th>
							<th width="45%">Proposed</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($data as $field => $newValue) { ?>
							<?php
							$oldValue = $originalData[$field] ?? null;
							$hasChanged = $oldValue !== $newValue;
							?>
							<?php if ($field !== 'id' && $field !== 'created' && $field !== 'modified') { ?>
								<tr class="<?= $hasChanged ? 'table-warning' : '' ?>">
									<td><strong><?= h($field) ?></strong></td>
									<td><?= h($oldValue) ?></td>
									<td>
										<?php if ($hasChanged) { ?>
											<strong class="text-danger"><?= h($newValue) ?></strong>
										<?php } else { ?>
											<?= h($newValue) ?>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
						<?php } ?>
					</tbody>
				</table>
			<?php } ?>
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header bg-success text-white">
					<h5>Approve</h5>
				</div>
				<div class="card-body">
					<?= $this->Form->create(null, ['url' => ['action' => 'approve', $bouncerRecord->id]]) ?>
					<?= $this->Form->control('reason', [
						'label' => 'Approval Note (optional)',
						'type' => 'textarea',
						'rows' => 3,
						'class' => 'form-control',
					]) ?>
					<?= $this->Form->control('reviewer_id', ['type' => 'hidden', 'value' => 1]) ?>
					<?php if ($isDelete) { ?>
						<?= $this->Form->button(__('Approve & Delete'), ['class' => 'btn btn-success']) ?>
					<?php } else { ?>
						<?= $this->Form->button(__('Approve & Publish'), ['class' => 'btn btn-success']) ?>
					<?php } ?>
					<?= $this->Form->end() ?>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card">
				<div class="card-header bg-danger text-white">
					<h5>Reject</h5>
				</div>
				<div class="card-body">
					<?= $this->Form->create(null, ['url' => ['action' => 'reject', $bouncerRecord->id]]) ?>
					<?= $this->Form->control('reason', [
						'label' => 'Rejection Reason',
						'type' => 'textarea',
						'rows' => 3,
						'class' => 'form-control',
						'required' => true,
					]) ?>
					<?= $this->Form->control('reviewer_id', ['type' => 'hidden', 'value' => 1]) ?>
					<?= $this->Form->button(__('Reject'), ['class' => 'btn btn-danger']) ?>
					<?= $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>

	<div class="mt-3">
		<?= $this->Html->link(__('Back to Queue'), ['action' => 'pending'], ['class' => 'btn btn-secondary']) ?>
	</div>
</div>
