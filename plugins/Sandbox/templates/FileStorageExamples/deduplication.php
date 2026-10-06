<?php
/**
 * @var \App\View\AppView $this
 * @var \FileStorage\Model\Entity\FileStorage $fileStorage
 * @var array<\FileStorage\Model\Entity\FileStorage> $files
 * @var array<\Cake\ORM\Entity> $blobs
 * @var int $rowCount
 * @var int $blobCount
 * @var int $logicalBytes
 * @var int $storedBytes
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page form col-sm-8 col-12">
	<h2>Deduplication Demo</h2>
	<p>Identical uploads share one stored file (blob). Each upload keeps its own row and filename. Deleting a row leaves the blob for cleanup.</p>
	<h4>Try this</h4>
	<ol>
		<li>Upload a file.</li>
		<li>Upload the same file again under another name. See one blob with two references.</li>
		<li>Delete one row. The blob stays.</li>
		<li>Delete the last row, wait a minute, then run cleanup. The blob goes.</li>
	</ol>

	<div class="card mb-4">
		<div class="card-header">
			<h4>Upload Any File</h4>
			<small class="text-muted">Max 6 files | Any type | Max 2MB per file</small>
		</div>
		<div class="card-body">
			<?php if ($rowCount >= 6) { ?>
			<div class="alert alert-warning">
				<strong>Upload limit reached!</strong> You have uploaded the maximum of 6 files.
				Please delete an existing file first before uploading a new one.
			</div>
			<?php } ?>
			<?php echo $this->Form->create($fileStorage, ['type' => 'file']); ?>
			<fieldset>
				<legend>Select any file to upload (<?php echo h($rowCount); ?>/6)</legend>
				<?php echo $this->Form->control('file', [
					'type' => 'file',
					'label' => 'File (max 2MB)',
					'required' => true,
					'disabled' => $rowCount >= 6,
				]); ?>
			</fieldset>
			<?php echo $this->Form->button('Upload File', [
				'class' => 'btn btn-primary',
				'disabled' => $rowCount >= 6,
			]); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>

	<div class="row mb-4">
		<div class="col"><strong>Rows</strong><br><?php echo $this->Number->format($rowCount); ?></div>
		<div class="col"><strong>Stored files (blobs)</strong><br><?php echo $this->Number->format($blobCount); ?></div>
		<div class="col"><strong>Logical size</strong><br><?php echo $this->Number->toReadableSize($logicalBytes); ?></div>
		<div class="col"><strong>Stored size</strong><br><?php echo $this->Number->toReadableSize($storedBytes); ?></div>
		<div class="col"><strong>Saved bytes</strong><br><?php echo $this->Number->toReadableSize($logicalBytes - $storedBytes); ?></div>
	</div>
	<small class="text-muted">Sizes cover the uploads listed below. Stored files also include unreferenced Local blobs awaiting cleanup.</small>

	<h3>Uploads</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr><th>Filename</th><th>Size</th><th>Hash</th><th>Blob id</th><th>Path</th><th>Created</th><th class="actions">Actions</th></tr>
			</thead>
			<tbody>
				<?php foreach ($files as $file) { ?>
				<tr>
					<td><?php echo h($file->filename); ?></td>
					<td><?php echo $this->Number->toReadableSize($file->filesize); ?></td>
					<td><code title="<?php echo h($file->hash); ?>"><?php echo h(substr((string)$file->hash, 0, 12)); ?></code></td>
					<td><?php echo h($file->blob_id); ?></td>
					<td><code><?php echo h($file->path); ?></code></td>
					<td><small class="text-muted"><?php echo h($file->created->timeAgoInWords()); ?></small></td>
					<td class="actions">
						<?php echo $this->Html->link('Download', ['action' => 'view', $file->id], ['class' => 'btn btn-sm btn-info']); ?>
						<?php echo $this->Form->postLink(
							'Delete',
							['action' => 'delete', $file->id],
							['confirm' => 'Are you sure?', 'class' => 'btn btn-sm btn-danger', 'block' => true],
						); ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php if (!$files) { ?>
	<div class="alert alert-info">No files uploaded yet. Use the form above to upload your first file.</div>
	<?php } ?>

	<h3>Stored files</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr><th>Blob id</th><th>Hash</th><th>Path</th><th>References</th><th>Last claimed</th></tr>
			</thead>
			<tbody>
				<?php foreach ($blobs as $blob) { ?>
				<tr>
					<td><?php echo h($blob->id); ?></td>
					<td><code title="<?php echo h($blob->hash); ?>"><?php echo h(substr((string)$blob->hash, 0, 12)); ?></code></td>
					<td><code><?php echo h($blob->path); ?></code></td>
					<td>
						<?php echo $this->Number->format($blob->reference_count); ?>
						<?php if (!$blob->reference_count) { ?>
						<span class="badge badge-warning">unreferenced, removed by cleanup after the grace period</span>
						<?php } ?>
					</td>
					<td><?php echo h($blob->touched); ?></td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php echo $this->Form->postLink('Run cleanup', ['action' => 'deduplicationCleanup'], ['class' => 'btn btn-primary']); ?>
	<p class="text-muted">Cleanup removes unreferenced blobs after 60 seconds since their last claim. Blob cleanup covers all models and collections.</p>

	<details>
		<summary>Configuration</summary>
		<pre><code>'FileStorage' => [
	'deduplicate' => [
		'collections' => ['FileStorage' => ['dedup' => true]],
		'gracePeriod' => 60, // 60 seconds is for the demo.
		'root' => 'blobs',
	],
	'imageVariants' => [
		'FileStorage' => ['dedup' => []],
	],
]</code></pre>
	</details>
</div>
