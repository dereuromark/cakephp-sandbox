<?php
/**
 * @var \App\View\AppView $this
 * @var \FileStorage\Model\Entity\FileStorage $fileStorage
 * @var array<\FileStorage\Model\Entity\FileStorage> $images
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page form col-sm-8 col-12">

	<h2>Image Upload Demo</h2>

	<div class="card mb-4">
		<div class="card-header">
			<h4>Upload Image</h4>
			<small class="text-muted">Max 3 images | JPG/PNG only | Max 2MB per file</small>
		</div>
		<div class="card-body">
			<?php
			$currentCount = count($images);
			if ($currentCount >= 3) {
				?>
				<div class="alert alert-warning">
					<strong>Upload limit reached!</strong> You have uploaded the maximum of 3 images.
					Please delete an existing image first before uploading a new one.
				</div>
				<?php
			}
			?>
			<?php echo $this->Form->create($fileStorage, ['type' => 'file']); ?>
			<fieldset>
				<legend>Select an image file to upload (<?php echo $currentCount; ?>/3)</legend>
				<?php
					echo $this->Form->control('file', [
						'type' => 'file',
						'label' => 'Image File (JPG or PNG, max 2MB)',
						'accept' => 'image/jpeg,image/png',
						'required' => true,
						'disabled' => $currentCount >= 3,
					]);
				?>
				<small class="form-text text-muted">
					<strong>Requirements:</strong> JPG or PNG format only, maximum file size 2MB
				</small>
			</fieldset>
			<?php echo $this->Form->button('Upload Image', [
				'class' => 'btn btn-primary',
				'disabled' => $currentCount >= 3,
			]); ?>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>

	<?php if (!empty($images)) { ?>
	<h3>Uploaded Images (<?php echo count($images); ?>)</h3>
	<div class="row">
		<?php foreach ($images as $image) { ?>
		<div class="col-md-4 mb-4">
			<div class="card">
				<?php
				$imagePath = $this->Url->build('/files/uploads/' . ($image->path ?: ''));
				?>
				<img src="<?php echo h($imagePath); ?>" class="card-img-top" alt="<?php echo h($image->filename); ?>" style="height: 200px; object-fit: cover;">
				<div class="card-body">
					<h5 class="card-title"><?php echo h($image->filename); ?></h5>
					<p class="card-text">
						<small class="text-muted">
							<strong>Size:</strong> <?php echo $this->Number->toReadableSize($image->filesize); ?><br>
							<strong>Type:</strong> <?php echo h($image->mime_type); ?><br>
							<strong>Uploaded:</strong> <?php echo $image->created->timeAgoInWords(); ?>
						</small>
					</p>
					<div class="d-flex justify-content-between">
						<?php echo $this->Html->link('Download', ['action' => 'view', $image->id], ['class' => 'btn btn-sm btn-info']); ?>
						<?php echo $this->Form->postLink(
							'Delete',
							['action' => 'delete', $image->id],
							['confirm' => 'Are you sure?', 'class' => 'btn btn-sm btn-danger', 'block' => true],
						); ?>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<?php } else { ?>
	<div class="alert alert-info">
		<strong>No images uploaded yet.</strong> Use the form above to upload your first image.
	</div>
	<?php } ?>

	<h3>Automatic Image Variants</h3>
	<p>
		When you upload an image, the system automatically creates multiple resized versions:
	</p>
	<ul>
		<li><strong>Thumbnail</strong> - 150x150px (zoom-crop to fill entire square, no distortion)</li>
		<li><strong>Medium</strong> - 400x400px (maintains aspect ratio)</li>
		<li><strong>Large</strong> - 800x800px (maintains aspect ratio)</li>
	</ul>
	<p>
		These variants are stored in the database's <code>variants</code> JSON field and can be accessed programmatically.
	</p>

	<h3>How it works</h3>
	<ol>
		<li>Select an image file using the file input</li>
		<li>The FileStorage behavior automatically processes the upload</li>
		<li>The ImageProcessor creates multiple resized versions (variants)</li>
		<li>File metadata and variant information are stored in the database</li>
		<li>The physical files are stored on disk using the configured path template</li>
		<li>Images are optimized to reduce file size</li>
	</ol>

	<h4>Path Structure</h4>
	<p>
		Original files:<br>
		<code>FileStorage/images/{randomPath}/{id}/{filename}.{extension}</code>
	</p>
	<p>
		Variant files:<br>
		<code>FileStorage/images/{randomPath}/{id}/{filename}.{hashedVariant}.{extension}</code>
	</p>

	<h4>Technology Stack</h4>
	<ul>
		<li><strong>FlySystem</strong> - Storage abstraction layer</li>
		<li><strong>Intervention Image</strong> - Image manipulation library</li>
		<li><strong>Image Optimizer</strong> - Automatic file size optimization</li>
	</ul>

</div>
