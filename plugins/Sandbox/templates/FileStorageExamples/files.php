<?php
/**
 * @var \App\View\AppView $this
 * @var \FileStorage\Model\Entity\FileStorage $fileStorage
 * @var array<\FileStorage\Model\Entity\FileStorage> $files
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page form col-sm-8 col-12">

	<h2>General File Upload Demo</h2>

	<div class="card mb-4">
		<div class="card-header">
			<h4>Upload Any File</h4>
			<small class="text-muted">Max 3 files | Any type | Max 2MB per file</small>
		</div>
		<div class="card-body">
			<?php
			$currentCount = count($files);
			if ($currentCount >= 3) {
				?>
				<div class="alert alert-warning">
					<strong>Upload limit reached!</strong> You have uploaded the maximum of 3 files.
					Please delete an existing file first before uploading a new one.
				</div>
				<?php
			}
			?>
			<?php echo $this->Form->create($fileStorage, ['type' => 'file']); ?>
			<fieldset>
				<legend>Select any file to upload (<?php echo $currentCount; ?>/3)</legend>
				<?php
					echo $this->Form->control('file', [
						'type' => 'file',
						'label' => 'File (max 2MB)',
						'required' => true,
						'disabled' => $currentCount >= 3,
					]);
				?>
				<small class="form-text text-muted">
					<strong>Supported:</strong> Documents (DOC, DOCX, XLS, XLSX, PPT, PPTX), Archives (ZIP, RAR), Text files (TXT, CSV), and more.
					<strong>Maximum file size:</strong> 2MB
				</small>
			</fieldset>
			<?php echo $this->Form->button('Upload File', [
				'class' => 'btn btn-primary',
				'disabled' => $currentCount >= 3,
			]); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>

	<?php if (!empty($files)) { ?>
	<h3>Uploaded Files (<?php echo count($files); ?>)</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead>
				<tr>
					<th>Filename</th>
					<th>Type</th>
					<th>Size</th>
					<th>Uploaded</th>
					<th class="actions">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($files as $file) { ?>
				<tr>
					<td>
						<?php
						// Display appropriate icon based on file extension
						$iconClass = 'fa-file-o';
						$extension = strtolower($file->extension);
						if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'], true)) {
							$iconClass = 'fa-file-image-o';
						} elseif ($extension === 'pdf') {
							$iconClass = 'fa-file-pdf-o text-danger';
						} elseif (in_array($extension, ['doc', 'docx'], true)) {
							$iconClass = 'fa-file-word-o text-primary';
						} elseif (in_array($extension, ['xls', 'xlsx'], true)) {
							$iconClass = 'fa-file-excel-o text-success';
						} elseif (in_array($extension, ['ppt', 'pptx'], true)) {
							$iconClass = 'fa-file-powerpoint-o text-warning';
						} elseif (in_array($extension, ['zip', 'rar', '7z', 'tar', 'gz'], true)) {
							$iconClass = 'fa-file-archive-o';
						} elseif (in_array($extension, ['txt', 'log'], true)) {
							$iconClass = 'fa-file-text-o';
						} elseif (in_array($extension, ['php', 'js', 'css', 'html', 'json', 'xml'], true)) {
							$iconClass = 'fa-file-code-o';
						}
						?>
						<i class="fa <?php echo $iconClass; ?>"></i>
						<?php echo h($file->filename); ?>
					</td>
					<td>
						<span class="badge badge-secondary"><?php echo h(strtoupper($file->extension)); ?></span>
					</td>
					<td><?php echo $this->Number->toReadableSize($file->filesize); ?></td>
					<td>
						<small class="text-muted">
							<?php echo $file->created->timeAgoInWords(); ?>
						</small>
					</td>
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
	<?php } else { ?>
	<div class="alert alert-info">
		<strong>No files uploaded yet.</strong> Use the form above to upload your first file.
	</div>
	<?php } ?>

	<h3>Universal File Storage</h3>
	<p>
		This demo shows how the FileStorage plugin can handle any type of file:
	</p>
	<ul>
		<li><strong>No File Type Restrictions:</strong> Upload documents, spreadsheets, presentations, archives, and more</li>
		<li><strong>Automatic MIME Detection:</strong> File types are automatically detected and stored</li>
		<li><strong>Organized by Collection:</strong> Files can be grouped into logical collections for better organization</li>
		<li><strong>Safe Filenames:</strong> Filenames are automatically sanitized to be URL-safe</li>
	</ul>

	<h3>Common Use Cases</h3>
	<div class="row">
		<div class="col-md-6">
			<h5>Business Applications</h5>
			<ul>
				<li>Employee document management</li>
				<li>Customer file uploads</li>
				<li>Project attachments</li>
				<li>Backup archives</li>
			</ul>
		</div>
		<div class="col-md-6">
			<h5>Content Management</h5>
			<ul>
				<li>Media library management</li>
				<li>Resource downloads</li>
				<li>User-generated content</li>
				<li>Asset management</li>
			</ul>
		</div>
	</div>

	<h4>Path Structure</h4>
	<p>
		Files are stored with this pattern:<br>
		<code>FileStorage/general/{randomPath}/{id}/{filename}.{extension}</code>
	</p>

	<h4>Technical Details</h4>
	<ul>
		<li><strong>Random Path Distribution:</strong> Files are distributed across directories to avoid filesystem limitations</li>
		<li><strong>ID-Based Organization:</strong> Each file gets its own directory based on the database ID</li>
		<li><strong>Extension Preservation:</strong> Original file extensions are maintained for compatibility</li>
	</ul>

</div>
