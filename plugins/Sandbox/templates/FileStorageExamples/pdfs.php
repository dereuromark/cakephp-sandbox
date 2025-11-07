<?php
/**
 * @var \App\View\AppView $this
 * @var \FileStorage\Model\Entity\FileStorage $fileStorage
 * @var array<\FileStorage\Model\Entity\FileStorage> $pdfs
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page form col-sm-8 col-12">

	<h2>PDF Upload Demo</h2>

	<div class="card mb-4">
		<div class="card-header">
			<h4>Upload PDF</h4>
			<small class="text-muted">Max 3 PDFs | PDF only | Max 2MB per file</small>
		</div>
		<div class="card-body">
			<?php
			$currentCount = count($pdfs);
			if ($currentCount >= 3) {
				?>
				<div class="alert alert-warning">
					<strong>Upload limit reached!</strong> You have uploaded the maximum of 3 PDFs.
					Please delete an existing PDF first before uploading a new one.
				</div>
				<?php
			}
			?>
			<?php echo $this->Form->create($fileStorage, ['type' => 'file']); ?>
			<fieldset>
				<legend>Select a PDF document to upload (<?php echo $currentCount; ?>/3)</legend>
				<?php
					echo $this->Form->control('file', [
						'type' => 'file',
						'label' => 'PDF Document (max 2MB)',
						'accept' => '.pdf,application/pdf',
						'required' => true,
						'disabled' => $currentCount >= 3,
					]);
				?>
				<small class="form-text text-muted">
					<strong>Requirements:</strong> PDF format only, maximum file size 2MB
				</small>
			</fieldset>
			<?php echo $this->Form->button('Upload PDF', [
				'class' => 'btn btn-primary',
				'disabled' => $currentCount >= 3,
			]); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>

	<?php if (!empty($pdfs)) { ?>
	<h3>Uploaded PDFs (<?php echo count($pdfs); ?>)</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Filename</th>
					<th>Size</th>
					<th>Uploaded</th>
					<th class="actions">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($pdfs as $pdf) { ?>
				<tr>
					<td>
						<i class="fa fa-file-pdf-o text-danger"></i>
						<?php echo h($pdf->filename); ?>
					</td>
					<td><?php echo $this->Number->toReadableSize($pdf->filesize); ?></td>
					<td>
						<small class="text-muted">
							<?php echo $pdf->created->timeAgoInWords(); ?>
						</small>
					</td>
					<td class="actions">
						<?php echo $this->Html->link('View/Download', ['action' => 'view', $pdf->id], ['class' => 'btn btn-sm btn-info']); ?>
						<?php echo $this->Form->postLink(
							'Delete',
							['action' => 'delete', $pdf->id],
							['confirm' => 'Are you sure?', 'class' => 'btn btn-sm btn-danger', 'block' => true],
						); ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php } else { ?>
	<div class="alert alert-info">
		<strong>No PDFs uploaded yet.</strong> Use the form above to upload your first PDF document.
	</div>
	<?php } ?>

	<h3>PDF Storage Benefits</h3>
	<ul>
		<li><strong>Organized Storage:</strong> PDFs are stored in a dedicated collection</li>
		<li><strong>Metadata Tracking:</strong> File size, MIME type, and upload date are automatically tracked</li>
		<li><strong>Easy Retrieval:</strong> Download or view PDFs directly in the browser</li>
		<li><strong>Secure Deletion:</strong> Both database records and physical files are removed together</li>
	</ul>

	<h3>Use Cases</h3>
	<ul>
		<li>Document management systems</li>
		<li>Invoice and receipt storage</li>
		<li>Report archives</li>
		<li>User manuals and documentation</li>
		<li>Contract and legal document storage</li>
	</ul>

	<h4>Path Structure</h4>
	<p>
		PDFs are stored with this pattern:<br>
		<code>FileStorage/pdfs/{randomPath}/{id}/{filename}.{extension}</code>
	</p>

</div>
