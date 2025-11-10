<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h2>File Storage Plugin</h2>
	<p>
		The FileStorage plugin provides a flexible file storage abstraction layer for CakePHP applications.
		It uses the <a href="https://flysystem.thephpleague.com/" target="_blank">FlySystem</a> library to support multiple storage backends.
	</p>

	<h3>Features</h3>
	<ul>
		<li><strong>Multiple Storage Backends:</strong> Local filesystem, AWS S3, FTP, Dropbox, and more</li>
		<li><strong>Automatic Image Resizing:</strong> Create multiple versions (thumbnails, medium, large) automatically</li>
		<li><strong>Image Optimization:</strong> Automatic file size optimization for faster loading</li>
		<li><strong>File Variants:</strong> Support for multiple versions of files with customizable operations</li>
		<li><strong>Metadata Storage:</strong> Store file information in the database</li>
		<li><strong>Collections:</strong> Organize files into logical groups</li>
		<li><strong>Path Builder:</strong> Flexible path generation with customizable templates</li>
	</ul>

	<h3>Storage Backend</h3>
	<p>
		This demo uses a <strong>Local Filesystem</strong> adapter, storing files in:
		<br><code><?php echo WWW_ROOT . 'files' . DS . 'uploads' . DS; ?></code>
	</p>

	<h3>Examples</h3>
	<div class="row">
		<div class="col-md-4 mb-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Images <span class="badge bg-success">Auto-Resize</span></h5>
					<p class="card-text">Upload and display image files with automatic thumbnail generation and optimization.</p>
					<?php echo $this->Html->link('Try it', ['action' => 'images'], ['class' => 'btn btn-primary']); ?>
				</div>
			</div>
		</div>
		<div class="col-md-4 mb-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">PDFs</h5>
					<p class="card-text">Upload and manage PDF documents.</p>
					<?php echo $this->Html->link('Try it', ['action' => 'pdfs'], ['class' => 'btn btn-primary']); ?>
				</div>
			</div>
		</div>
		<div class="col-md-4 mb-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">General Files</h5>
					<p class="card-text">Upload any type of file.</p>
					<?php echo $this->Html->link('Try it', ['action' => 'files'], ['class' => 'btn btn-primary']); ?>
				</div>
			</div>
		</div>
	</div>

	<h3>Advanced Features</h3>
	<div class="row">
		<div class="col-md-4 mb-3">
			<div class="card border-primary">
				<div class="card-body">
					<h5 class="card-title">
						Drag & Drop Upload
						<span class="badge bg-primary">Modern</span>
						<span class="badge bg-info">AJAX</span>
					</h5>
					<p class="card-text">Modern HTML5 drag-and-drop upload with progress tracking, previews, and client-side validation.</p>
					<?php echo $this->Html->link('Try it', ['action' => 'dragDropUpload'], ['class' => 'btn btn-primary']); ?>
				</div>
			</div>
		</div>
	</div>

	<h3>Image Processing</h3>
	<div class="row">
		<div class="col-md-12 mb-3">
			<div class="card border-success">
				<div class="card-body">
					<h5 class="card-title">
						<i class="fa fa-magic"></i> Image Variants Showcase
						<span class="badge bg-primary">Automatic</span>
					</h5>
					<p class="card-text">
						See how uploaded images are automatically processed into multiple sizes (thumbnail, medium, large).
						View the variants side-by-side with their metadata and file sizes.
					</p>
					<?php echo $this->Html->link('View Variants Demo', ['action' => 'variants'], ['class' => 'btn btn-success']); ?>
				</div>
			</div>
		</div>
	</div>

	<h3>Configuration</h3>
	<p>
		The plugin is configured in <code>config/app_custom.php</code> with the following setup:
	</p>
	<ul>
		<li><strong>Storage Adapter:</strong> Local filesystem</li>
		<li><strong>Path Template:</strong> <code>{model}{ds}{collection}{ds}{randomPath}{ds}{id}{ds}{filename}.{extension}</code></li>
		<li><strong>Random Path Levels:</strong> 1 (for better directory distribution)</li>
		<li><strong>File Sanitization:</strong> URL-safe filenames with max length of 190 characters</li>
	</ul>

	<h3>Usage in Code</h3>
	<p>To use FileStorage in your own tables:</p>
	<pre><code>// In your Table class
$this->addBehavior('FileStorage.FileStorage', [
    'fields' => [
        'file' => 'file',
    ],
]);

// In your controller
$entity = $this->MyModel->newEmptyEntity();
$entity = $this->MyModel->patchEntity($entity, $this->request->getData());
if ($this->MyModel->save($entity)) {
    // File is automatically processed and stored
}</code></pre>

	<h3>CLI Commands</h3>
	<p>Regenerate image variants for existing files:</p>
	<pre class="bg-dark text-light p-3"><code>bin/cake file_storage generate_image_variant --verbose</code></pre>

</div>
