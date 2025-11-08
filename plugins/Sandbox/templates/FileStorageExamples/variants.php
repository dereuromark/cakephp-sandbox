<?php
/**
 * @var \App\View\AppView $this
 * @var array<\FileStorage\Model\Entity\FileStorage> $images
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h2>Image Variants Demo</h2>
	<p>
		This page demonstrates the automatic image variant generation. When you upload an image,
		the system automatically creates multiple resized versions.
	</p>

	<div class="alert alert-info">
		<strong>Note:</strong> Image variants are generated automatically when you upload a new image.
		If you uploaded images before the variants were configured, they won't have thumbnails.
		<?php echo $this->Html->link('Upload a new image', ['action' => 'images']); ?> to see the automatic variant generation in action.
	</div>

	<?php if (!empty($images)) { ?>
		<?php foreach ($images as $image) { ?>
		<div class="card mb-4">
			<div class="card-header">
				<h4><?php echo h($image->filename); ?></h4>
				<small class="text-muted">
					Original size: <?php echo $this->Number->toReadableSize($image->filesize); ?>
					| Uploaded: <?php echo $image->created->timeAgoInWords(); ?>
				</small>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-3 mb-3">
						<h5>Thumbnail</h5>
						<?php
						$thumbnailPath = $image->getVariantPath('thumbnail');
						if ($thumbnailPath && file_exists(UPLOADS_DIR . $thumbnailPath)) {
							// Build URL from path
							$fullUrl = $this->Url->build('/files/uploads/' . $thumbnailPath);
							$size = getimagesize(UPLOADS_DIR . $thumbnailPath);
							$dimensions = $size ? ' (' . $size[0] . 'x' . $size[1] . ')' : '';
							?>
							<img src="<?php echo h($fullUrl); ?>" alt="Thumbnail" class="img-fluid border zoomable-image" style="cursor: pointer;" data-full-url="<?php echo h($fullUrl); ?>" title="Click to zoom">
							<p class="small mt-2">
								<code>thumbnail</code><?php echo h($dimensions); ?>
							</p>
						<?php } else { ?>
							<div class="alert alert-warning">Thumbnail not generated</div>
						<?php } ?>
					</div>

					<div class="col-md-3 mb-3">
						<h5>Medium</h5>
						<?php
						$mediumPath = $image->getVariantPath('medium');
						if ($mediumPath && file_exists(UPLOADS_DIR . $mediumPath)) {
							// Build URL from path
							$fullUrl = $this->Url->build('/files/uploads/' . $mediumPath);
							$size = getimagesize(UPLOADS_DIR . $mediumPath);
							$dimensions = $size ? ' (' . $size[0] . 'x' . $size[1] . ')' : '';
							?>
							<img src="<?php echo h($fullUrl); ?>" alt="Medium" class="img-fluid border zoomable-image" style="cursor: pointer;" data-full-url="<?php echo h($fullUrl); ?>" title="Click to zoom">
							<p class="small mt-2">
								<code>medium</code><?php echo h($dimensions); ?>
							</p>
						<?php } else { ?>
							<div class="alert alert-warning">Medium not generated</div>
						<?php } ?>
					</div>

					<div class="col-md-3 mb-3">
						<h5>Large</h5>
						<?php
						$largePath = $image->getVariantPath('large');
						if ($largePath && file_exists(UPLOADS_DIR . $largePath)) {
							// Build URL from path
							$fullUrl = $this->Url->build('/files/uploads/' . $largePath);
							$size = getimagesize(UPLOADS_DIR . $largePath);
							$dimensions = $size ? ' (' . $size[0] . 'x' . $size[1] . ')' : '';
							?>
							<img src="<?php echo h($fullUrl); ?>" alt="Large" class="img-fluid border zoomable-image" style="max-width: 200px; cursor: pointer;" data-full-url="<?php echo h($fullUrl); ?>" title="Click to zoom">
							<p class="small mt-2">
								<code>large</code><?php echo h($dimensions); ?>
							</p>
						<?php } else { ?>
							<div class="alert alert-warning">Large not generated</div>
						<?php } ?>
					</div>

					<div class="col-md-3 mb-3">
						<h5>Original</h5>
						<?php
						$imagePath = $this->Url->build('/files/uploads/' . ($image->path ?: ''));
						$fullPath = UPLOADS_DIR . ($image->path ?: '');
						$dimensions = '';
						if (file_exists($fullPath) && function_exists('getimagesize')) {
							$size = getimagesize($fullPath);
							if ($size) {
								$dimensions = $size[0] . 'x' . $size[1];
							}
						}
						?>
						<img src="<?php echo h($imagePath); ?>" alt="Original" class="img-fluid border zoomable-image" style="max-width: 200px; cursor: pointer;" data-full-url="<?php echo h($imagePath); ?>" title="Click to zoom">
						<p class="small mt-2">
							Full resolution<?php if ($dimensions) { ?> (<?php echo h($dimensions); ?>)<?php } ?>
						</p>
					</div>
				</div>

				<h5>Variant Data</h5>
				<pre class="bg-light p-3"><code><?php
					$variants = $image->variants ?: [];
					if (!empty($variants)) {
						echo json_encode($variants, JSON_PRETTY_PRINT);
					} else {
						echo '// No variants generated';
					}
				?></code></pre>
			</div>
		</div>
		<?php } ?>
	<?php } else { ?>
	<div class="alert alert-info">
		<strong>No images uploaded yet.</strong>
		<?php echo $this->Html->link('Upload some images first', ['action' => 'images']); ?> to see the variants in action.
	</div>
	<?php } ?>

	<h3>How Variants Work</h3>
	<ol>
		<li>Upload an image through the <strong><?php echo $this->Html->link('Images demo', ['action' => 'images']); ?></strong></li>
		<li>The ImageProcessor automatically creates variants based on the configuration</li>
		<li>Each variant is stored as a separate file with a hashed name</li>
		<li>Variant metadata (paths, URLs) is stored in the database's <code>variants</code> JSON column</li>
		<li>Access variants using <code>$entity->getVariantUrl('variant_name')</code></li>
	</ol>

	<h3>Regenerating Variants</h3>
	<p>You can regenerate variants for existing images using the command:</p>
	<pre class="bg-dark text-light p-3"><code># Regenerate all configured variants
bin/cake file_storage generate_image_variant --verbose

# Regenerate for specific collection
bin/cake file_storage generate_image_variant FileStorage images --verbose

# Regenerate a specific variant only
bin/cake file_storage generate_image_variant FileStorage images thumbnail --verbose</code></pre>
	<p>
		This is useful when:
	</p>
	<ul>
		<li>You've added new variant configurations</li>
		<li>You've changed existing variant operations (resize dimensions, etc.)</li>
		<li>You need to regenerate corrupted or missing variants</li>
	</ul>

	<h3>Configured Variants</h3>
	<table class="table table-sm">
		<thead>
			<tr>
				<th>Variant Name</th>
				<th>Operation</th>
				<th>Size</th>
				<th>Use Case</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td><code>thumbnail</code></td>
				<td>Cover (zoom-crop)</td>
				<td>150x150px</td>
				<td>List views, avatars</td>
			</tr>
			<tr>
				<td><code>medium</code></td>
				<td>Resize</td>
				<td>400x400px</td>
				<td>Card layouts, previews</td>
			</tr>
			<tr>
				<td><code>large</code></td>
				<td>Resize</td>
				<td>800x800px</td>
				<td>Detail views, galleries</td>
			</tr>
		</tbody>
	</table>

	<div class="alert alert-info mt-4">
		<strong>Note:</strong> The thumbnail variant uses zoom-crop to fill the entire 150x150 area (crops to center, no distortion).
		Medium and large variants maintain the original aspect ratio and fit within their dimensions.
		All variants are automatically optimized for faster loading.
	</div>

</div>

<!-- Image Zoom Modal -->
<div id="imageZoomModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); z-index: 9999; cursor: pointer;">
	<span id="closeModal" style="position: absolute; top: 20px; right: 40px; color: #fff; font-size: 40px; font-weight: bold; cursor: pointer;">&times;</span>
	<img id="zoomedImage" style="display: block; margin: auto; max-width: 90%; max-height: 90%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
</div>

<script>
(function() {
	var modal = document.getElementById('imageZoomModal');
	var zoomedImg = document.getElementById('zoomedImage');
	var closeBtn = document.getElementById('closeModal');

	// Add click handlers to all zoomable images
	var images = document.querySelectorAll('.zoomable-image');
	images.forEach(function(img) {
		img.addEventListener('click', function() {
			var fullUrl = this.getAttribute('data-full-url');
			zoomedImg.src = fullUrl;
			modal.style.display = 'block';
		});
	});

	// Close modal when clicking the X button
	closeBtn.addEventListener('click', function() {
		modal.style.display = 'none';
	});

	// Close modal when clicking outside the image
	modal.addEventListener('click', function(e) {
		if (e.target === modal) {
			modal.style.display = 'none';
		}
	});

	// Close modal when pressing ESC key
	document.addEventListener('keydown', function(e) {
		if (e.key === 'Escape' && modal.style.display === 'block') {
			modal.style.display = 'none';
		}
	});
})();
</script>
