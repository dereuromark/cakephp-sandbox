<?php
/**
 * @var \App\View\AppView $this
 * @var array<\FileStorage\Model\Entity\FileStorage> $files
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page form col-sm-8 col-12">

	<h2>Image Cropping Before Upload</h2>

	<div class="alert alert-info">
		<h4>Advanced Feature</h4>
		<p>
			<strong>Client-Side Image Cropping</strong> allows users to crop and resize images before uploading them to the server.
			This reduces bandwidth usage and ensures images are in the correct format and size.
		</p>
		<p>
			<strong>Features demonstrated:</strong>
		</p>
		<ul>
			<li>Interactive cropping with mouse/touch</li>
			<li>Multiple aspect ratio presets (free, square, 16:9, 4:3, 3:2)</li>
			<li>Zoom in/out controls</li>
			<li>Rotate image</li>
			<li>Real-time preview</li>
			<li>Upload cropped result via AJAX</li>
		</ul>
	</div>

	<div class="card mb-4">
		<div class="card-header">
			<h4>Crop & Upload Image</h4>
			<small class="text-muted">Max 3 cropped images | JPG/PNG only | Max 2MB</small>
		</div>
		<div class="card-body">
			<?php
			$currentCount = count($files);
			if ($currentCount >= 3) {
				?>
				<div class="alert alert-warning">
					<strong>Upload limit reached!</strong> You have uploaded the maximum of 3 images.
					Please delete an existing image first before uploading a new one.
				</div>
				<?php
			}
			?>

			<!-- Step 1: Select Image -->
			<div id="selectStep" class="crop-step">
				<h5>Step 1: Select an Image</h5>
				<input type="file" id="imageInput" accept="image/jpeg,image/png" class="form-control" <?php echo $currentCount >= 3 ? 'disabled' : ''; ?>>
				<small class="form-text text-muted">Choose a JPG or PNG image to crop (max 2MB)</small>
			</div>

			<!-- Step 2: Crop Image -->
			<div id="cropStep" class="crop-step" style="display: none;">
				<h5>Step 2: Crop Your Image</h5>

				<!-- Aspect Ratio Controls -->
				<div class="mb-3">
					<label class="form-label">Aspect Ratio:</label>
					<div class="btn-group" role="group">
						<button type="button" class="btn btn-sm btn-outline-primary" data-aspect="free">Free</button>
						<button type="button" class="btn btn-sm btn-outline-primary active" data-aspect="1">Square (1:1)</button>
						<button type="button" class="btn btn-sm btn-outline-primary" data-aspect="1.7778">16:9</button>
						<button type="button" class="btn btn-sm btn-outline-primary" data-aspect="1.3333">4:3</button>
						<button type="button" class="btn btn-sm btn-outline-primary" data-aspect="1.5">3:2</button>
					</div>
				</div>

				<!-- Cropper Container -->
				<div class="cropper-container-wrapper">
					<img id="cropperImage" src="" alt="Image to crop">
				</div>

				<!-- Crop Controls -->
				<div class="mt-3">
					<button type="button" class="btn btn-secondary btn-sm" id="zoomIn" title="Zoom In">
						<i class="fa fa-search-plus"></i> Zoom In
					</button>
					<button type="button" class="btn btn-secondary btn-sm" id="zoomOut" title="Zoom Out">
						<i class="fa fa-search-minus"></i> Zoom Out
					</button>
					<button type="button" class="btn btn-secondary btn-sm" id="rotateLeft" title="Rotate Left">
						<i class="fa fa-rotate-left"></i> Rotate Left
					</button>
					<button type="button" class="btn btn-secondary btn-sm" id="rotateRight" title="Rotate Right">
						<i class="fa fa-rotate-right"></i> Rotate Right
					</button>
					<button type="button" class="btn btn-secondary btn-sm" id="reset" title="Reset">
						<i class="fa fa-undo"></i> Reset
					</button>
				</div>

				<!-- Action Buttons -->
				<div class="mt-3">
					<button type="button" class="btn btn-primary" id="cropAndUpload">
						<i class="fa fa-crop"></i> Crop & Upload
					</button>
					<button type="button" class="btn btn-outline-secondary" id="cancelCrop">Cancel</button>
				</div>
			</div>

			<!-- Upload Progress -->
			<div id="uploadProgress" class="mt-3" style="display: none;">
				<div class="progress">
					<div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 100%">
						Uploading...
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php if (!empty($files)) { ?>
	<h3>Cropped Images (<?php echo count($files); ?>)</h3>
	<div class="row">
		<?php foreach ($files as $file) { ?>
		<div class="col-md-4 mb-4">
			<div class="card">
				<?php
				$imagePath = $this->Url->build('/files/uploads/' . ($file->path ?: ''));
				?>
				<img src="<?php echo h($imagePath); ?>"
					class="card-img-top image-preview-trigger"
					alt="<?php echo h($file->filename); ?>"
					data-filename="<?php echo h($file->filename); ?>"
					style="height: 200px; object-fit: cover; cursor: pointer;"
					title="Click to view full size">
				<div class="card-body">
					<h5 class="card-title"><?php echo h($file->filename); ?></h5>
					<p class="card-text">
						<small class="text-muted">
							<strong>Size:</strong> <?php echo $this->Number->toReadableSize($file->filesize); ?><br>
							<strong>Type:</strong> <?php echo h($file->mime_type); ?><br>
							<strong>Uploaded:</strong> <?php echo $file->created->timeAgoInWords(); ?>
						</small>
					</p>
					<div class="d-flex justify-content-between">
						<?php echo $this->Html->link('Download', ['action' => 'view', $file->id], ['class' => 'btn btn-sm btn-info']); ?>
						<?php echo $this->Form->postLink(
							'Delete',
							['action' => 'delete', $file->id],
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
		<strong>No cropped images yet.</strong> Use the cropper above to crop and upload your first image.
	</div>
	<?php } ?>

	<h3>How It Works</h3>
	<ol>
		<li><strong>Select:</strong> Choose an image file from your computer</li>
		<li><strong>Crop:</strong> Use the interactive cropper to select the area you want to keep</li>
		<li><strong>Adjust:</strong> Choose aspect ratio, zoom, or rotate as needed</li>
		<li><strong>Upload:</strong> Click "Crop & Upload" to save the cropped version</li>
	</ol>

	<h3>Benefits</h3>
	<ul>
		<li><strong>Better UX:</strong> Users see exactly what will be uploaded</li>
		<li><strong>Reduced Bandwidth:</strong> Only upload the cropped portion</li>
		<li><strong>Consistent Sizing:</strong> Enforce aspect ratios for uniform layouts</li>
		<li><strong>No Server Processing:</strong> Cropping happens client-side</li>
	</ul>

	<h3>Use Cases</h3>
	<ul>
		<li>Profile pictures (square aspect ratio)</li>
		<li>Blog post featured images (16:9)</li>
		<li>Product photos (4:3)</li>
		<li>Social media images (custom ratios)</li>
	</ul>

</div>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body text-center">
				<img id="modalPreviewImage" src="" alt="" class="img-fluid" style="max-height: 80vh;">
			</div>
		</div>
	</div>
</div>

<!-- Load Cropper.js from CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<style>
.crop-step {
	padding: 20px;
	background: #f8f9fa;
	border-radius: 8px;
	margin-bottom: 20px;
}

.cropper-container-wrapper {
	max-width: 100%;
	max-height: 500px;
	background: #000;
	display: flex;
	align-items: center;
	justify-content: center;
	border-radius: 8px;
	overflow: hidden;
}

#cropperImage {
	max-width: 100%;
	max-height: 500px;
	display: block;
}
</style>

<script>
(function() {
	const imageInput = document.getElementById('imageInput');
	const selectStep = document.getElementById('selectStep');
	const cropStep = document.getElementById('cropStep');
	const cropperImage = document.getElementById('cropperImage');
	const uploadProgress = document.getElementById('uploadProgress');
	const uploadUrl = <?php echo json_encode($this->Url->build(['action' => 'imageCropping', '?' => ['ajax' => 1]])); ?>;

	let cropper = null;
	let originalFilename = '';
	let currentAspectRatio = 1; // Default to square

	// Handle file selection
	imageInput.addEventListener('change', function(e) {
		const file = e.target.files[0];

		if (!file) {
			return;
		}

		// Validate file type
		if (!file.type.match('image/jpeg') && !file.type.match('image/png')) {
			alert('Please select a JPG or PNG image.');
			return;
		}

		// Validate file size (2MB)
		if (file.size > 2 * 1024 * 1024) {
			alert('File size must be less than 2MB.');
			return;
		}

		originalFilename = file.name;

		// Read file and display in cropper
		const reader = new FileReader();
		reader.onload = function(event) {
			cropperImage.src = event.target.result;

			// Hide select step, show crop step
			selectStep.style.display = 'none';
			cropStep.style.display = 'block';

			// Initialize cropper
			if (cropper) {
				cropper.destroy();
			}

			cropper = new Cropper(cropperImage, {
				aspectRatio: currentAspectRatio,
				viewMode: 1,
				autoCropArea: 0.8,
				responsive: true,
				background: false,
				zoomOnWheel: true,
			});
		};
		reader.readAsDataURL(file);
	});

	// Aspect ratio buttons
	document.querySelectorAll('[data-aspect]').forEach(button => {
		button.addEventListener('click', function() {
			// Update active state
			document.querySelectorAll('[data-aspect]').forEach(btn => btn.classList.remove('active'));
			this.classList.add('active');

			// Get aspect ratio
			const aspect = this.dataset.aspect;
			if (aspect === 'free') {
				currentAspectRatio = NaN;
			} else {
				currentAspectRatio = parseFloat(aspect);
			}

			// Update cropper
			if (cropper) {
				cropper.setAspectRatio(currentAspectRatio);
			}
		});
	});

	// Zoom controls
	document.getElementById('zoomIn').addEventListener('click', () => {
		if (cropper) cropper.zoom(0.1);
	});

	document.getElementById('zoomOut').addEventListener('click', () => {
		if (cropper) cropper.zoom(-0.1);
	});

	// Rotate controls
	document.getElementById('rotateLeft').addEventListener('click', () => {
		if (cropper) cropper.rotate(-90);
	});

	document.getElementById('rotateRight').addEventListener('click', () => {
		if (cropper) cropper.rotate(90);
	});

	// Reset
	document.getElementById('reset').addEventListener('click', () => {
		if (cropper) cropper.reset();
	});

	// Cancel
	document.getElementById('cancelCrop').addEventListener('click', () => {
		if (cropper) {
			cropper.destroy();
			cropper = null;
		}

		cropperImage.src = '';
		imageInput.value = '';

		cropStep.style.display = 'none';
		selectStep.style.display = 'block';
	});

	// Crop and upload
	document.getElementById('cropAndUpload').addEventListener('click', () => {
		if (!cropper) {
			return;
		}

		// Get cropped canvas
		const canvas = cropper.getCroppedCanvas({
			maxWidth: 2048,
			maxHeight: 2048,
			imageSmoothingEnabled: true,
			imageSmoothingQuality: 'high',
		});

		// Convert to base64
		const croppedImage = canvas.toDataURL('image/png');

		// Show progress
		uploadProgress.style.display = 'block';
		cropStep.style.display = 'none';

		// Upload via AJAX
		const formData = new FormData();
		formData.append('cropped_image', croppedImage);
		formData.append('original_filename', originalFilename);

		fetch(uploadUrl, {
			method: 'POST',
			body: formData,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		.then(response => response.json())
		.then(data => {
			uploadProgress.style.display = 'none';

			if (data.success) {
				// Success! Reload page to show new image
				location.reload();
			} else {
				alert('Error: ' + (data.error || 'Upload failed'));
				selectStep.style.display = 'block';
			}
		})
		.catch(error => {
			console.error('Upload error:', error);
			uploadProgress.style.display = 'none';
			alert('Upload failed: ' + error.message);
			selectStep.style.display = 'block';
		});

		// Cleanup
		if (cropper) {
			cropper.destroy();
			cropper = null;
		}
		imageInput.value = '';
	});

	// Image preview modal handler
	document.querySelectorAll('.image-preview-trigger').forEach(img => {
		img.addEventListener('click', function() {
			const modalImage = document.getElementById('modalPreviewImage');
			const modalTitle = document.getElementById('imagePreviewModalLabel');

			modalImage.src = this.src;
			modalImage.alt = this.alt;
			modalTitle.textContent = this.dataset.filename;

			const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
			modal.show();
		});
	});
})();
</script>
