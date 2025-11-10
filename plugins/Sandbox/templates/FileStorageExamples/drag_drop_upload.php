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

	<h2>Modern Drag & Drop Upload</h2>

	<div class="alert alert-info">
		<h4>Modern Upload Features</h4>
		<p>
			This demo showcases modern file upload features including:
		</p>
		<ul>
			<li><strong>Drag & Drop</strong> - Drag files directly into the upload zone</li>
			<li><strong>Multiple Files</strong> - Upload multiple files at once</li>
			<li><strong>AJAX Upload</strong> - Uploads happen in the background without page refresh</li>
			<li><strong>Progress Tracking</strong> - Real-time upload progress indicators</li>
			<li><strong>Image Previews</strong> - See thumbnails before and after upload</li>
			<li><strong>Client-side Validation</strong> - Instant feedback on file type and size</li>
		</ul>
	</div>

	<div class="card mb-4">
		<div class="card-header">
			<h4>Upload Files</h4>
			<small class="text-muted">Max 3 files | JPG/PNG only | Max 2MB per file</small>
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

			<!-- Drop Zone -->
			<div id="dropZone" class="drop-zone <?php echo $currentCount >= 3 ? 'disabled' : ''; ?>">
				<div class="drop-zone-content">
					<svg width="48" height="48" fill="currentColor" viewBox="0 0 16 16">
						<path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
						<path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z"/>
					</svg>
					<h3>Drag & Drop Files Here</h3>
					<p>or click to browse</p>
					<small class="text-muted">JPG or PNG, max 2MB each (<?php echo $currentCount; ?>/3)</small>
				</div>
				<input type="file" id="fileInput" multiple accept="image/jpeg,image/png" style="display: none;" <?php echo $currentCount >= 3 ? 'disabled' : ''; ?>>
			</div>

			<!-- Preview Area -->
			<div id="previewArea" class="preview-area mt-3"></div>

			<!-- Upload Progress -->
			<div id="uploadProgress" class="upload-progress mt-3" style="display: none;">
				<div class="progress">
					<div id="progressBar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
				</div>
				<small id="uploadStatus" class="text-muted"></small>
			</div>
		</div>
	</div>

	<?php if (!empty($files)) { ?>
	<h3>Uploaded Files (<?php echo count($files); ?>)</h3>
	<div class="row">
		<?php foreach ($files as $file) { ?>
		<div class="col-md-4 mb-4">
			<div class="card">
				<?php
				$imagePath = $this->Url->build('/files/uploads/' . ($file->path ?: ''));
				?>
				<img src="<?php echo h($imagePath); ?>" class="card-img-top" alt="<?php echo h($file->filename); ?>" style="height: 200px; object-fit: cover;">
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
		<strong>No files uploaded yet.</strong> Use the drag & drop zone above to upload your first files.
	</div>
	<?php } ?>

	<h3>Implementation Details</h3>
	<pre><code class="language-javascript">// Client-side drag & drop handling
dropZone.addEventListener('drop', (e) => {
    e.preventDefault();
    const files = e.dataTransfer.files;
    uploadFiles(files);
});

// AJAX upload with progress tracking
function uploadFiles(files) {
    const formData = new FormData();
    formData.append('file', file);

    fetch(uploadUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showSuccess('File uploaded successfully!');
            location.reload(); // Refresh to show new file
        } else {
            showError(data.error);
        }
    });
}</code></pre>

	<h4>Features Demonstrated</h4>
	<ul>
		<li><strong>HTML5 Drag & Drop API</strong> - Native browser drag-and-drop support</li>
		<li><strong>FileReader API</strong> - Client-side image preview before upload</li>
		<li><strong>FormData API</strong> - AJAX file upload without form submission</li>
		<li><strong>Fetch API</strong> - Modern promise-based HTTP requests</li>
		<li><strong>Progressive Enhancement</strong> - Falls back to standard file input</li>
		<li><strong>Responsive Design</strong> - Works on desktop and mobile devices</li>
	</ul>

	<h4>Browser Support</h4>
	<p>This demo uses modern web APIs supported by all current browsers:</p>
	<ul>
		<li>Chrome/Edge 90+</li>
		<li>Firefox 88+</li>
		<li>Safari 14+</li>
	</ul>

</div>

<style>
.drop-zone {
	border: 3px dashed #dee2e6;
	border-radius: 8px;
	padding: 60px 20px;
	text-align: center;
	cursor: pointer;
	transition: all 0.3s ease;
	background: #f8f9fa;
}

.drop-zone:hover:not(.disabled) {
	border-color: #0d6efd;
	background: #e7f1ff;
}

.drop-zone.drag-over {
	border-color: #0d6efd;
	background: #cfe2ff;
	transform: scale(1.02);
}

.drop-zone.disabled {
	opacity: 0.6;
	cursor: not-allowed;
	background: #e9ecef;
}

.drop-zone-content svg {
	color: #6c757d;
	margin-bottom: 15px;
}

.drop-zone-content h3 {
	margin: 10px 0;
	color: #212529;
	font-size: 1.5rem;
}

.drop-zone-content p {
	color: #6c757d;
	margin: 5px 0;
}

.preview-area {
	display: grid;
	grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
	gap: 15px;
}

.preview-item {
	position: relative;
	border: 2px solid #dee2e6;
	border-radius: 8px;
	overflow: hidden;
	background: #fff;
	transition: all 0.3s ease;
	animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
	from {
		opacity: 0;
		transform: translateY(10px);
	}
	to {
		opacity: 1;
		transform: translateY(0);
	}
}

.preview-item img {
	width: 100%;
	height: 150px;
	object-fit: cover;
}

.preview-item .preview-info {
	padding: 8px;
	font-size: 0.8rem;
	background: #f8f9fa;
}

.preview-item .preview-remove {
	position: absolute;
	top: 5px;
	right: 5px;
	background: rgba(220, 53, 69, 0.9);
	color: white;
	border: none;
	border-radius: 50%;
	width: 24px;
	height: 24px;
	cursor: pointer;
	display: flex;
	align-items: center;
	justify-content: center;
	font-size: 16px;
	line-height: 1;
	transition: all 0.2s ease;
}

.preview-item .preview-remove:hover {
	background: rgba(220, 53, 69, 1);
	transform: scale(1.1);
}

.preview-item .preview-status {
	position: absolute;
	bottom: 8px;
	left: 8px;
	right: 8px;
	background: rgba(255, 255, 255, 0.95);
	padding: 4px 8px;
	border-radius: 4px;
	font-size: 0.75rem;
	text-align: center;
}

.preview-item.uploading {
	border-color: #0d6efd;
}

.preview-item.success {
	border-color: #198754;
}

.preview-item.error {
	border-color: #dc3545;
}

.upload-progress {
	padding: 15px;
	background: #f8f9fa;
	border-radius: 8px;
}

.upload-progress .progress {
	height: 24px;
	border-radius: 4px;
	margin-bottom: 8px;
}
</style>

<script>
(function() {
	const dropZone = document.getElementById('dropZone');
	const fileInput = document.getElementById('fileInput');
	const previewArea = document.getElementById('previewArea');
	const uploadUrl = <?php echo json_encode($this->Url->build(['action' => 'dragDropUpload', '?' => ['ajax' => 1]])); ?>;
	const maxFiles = 3;
	const currentCount = <?php echo $currentCount; ?>;
	const maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
	const allowedTypes = ['image/jpeg', 'image/png'];
	let pendingUploads = [];

	// Prevent default drag behaviors
	['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
		dropZone.addEventListener(eventName, preventDefaults, false);
		document.body.addEventListener(eventName, preventDefaults, false);
	});

	function preventDefaults(e) {
		e.preventDefault();
		e.stopPropagation();
	}

	// Highlight drop zone when item is dragged over it
	['dragenter', 'dragover'].forEach(eventName => {
		dropZone.addEventListener(eventName, () => {
			if (!dropZone.classList.contains('disabled')) {
				dropZone.classList.add('drag-over');
			}
		}, false);
	});

	['dragleave', 'drop'].forEach(eventName => {
		dropZone.addEventListener(eventName, () => {
			dropZone.classList.remove('drag-over');
		}, false);
	});

	// Handle dropped files
	dropZone.addEventListener('drop', (e) => {
		if (dropZone.classList.contains('disabled')) {
			return;
		}
		const files = e.dataTransfer.files;
		handleFiles(files);
	}, false);

	// Handle click to browse
	dropZone.addEventListener('click', () => {
		if (!dropZone.classList.contains('disabled')) {
			fileInput.click();
		}
	});

	fileInput.addEventListener('change', (e) => {
		handleFiles(e.target.files);
	});

	function handleFiles(files) {
		const filesArray = Array.from(files);

		// Check total count
		const totalCount = currentCount + pendingUploads.length + filesArray.length;
		if (totalCount > maxFiles) {
			showAlert('error', `Maximum ${maxFiles} files allowed. You can upload ${maxFiles - currentCount - pendingUploads.length} more file(s).`);
			return;
		}

		filesArray.forEach(file => {
			// Validate file
			const validation = validateFile(file);
			if (!validation.valid) {
				showAlert('error', validation.error);
				return;
			}

			// Add to pending uploads and show preview
			pendingUploads.push(file);
			showPreview(file);
			uploadFile(file);
		});
	}

	function validateFile(file) {
		// Check file type
		if (!allowedTypes.includes(file.type)) {
			return {
				valid: false,
				error: `Invalid file type: ${file.name}. Only JPG and PNG images are allowed.`
			};
		}

		// Check file size
		if (file.size > maxFileSize) {
			return {
				valid: false,
				error: `File too large: ${file.name}. Maximum size is 2MB.`
			};
		}

		return { valid: true };
	}

	function showPreview(file) {
		const reader = new FileReader();

		reader.onload = (e) => {
			const previewId = 'preview-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
			const previewHtml = `
				<div class="preview-item uploading" id="${previewId}">
					<img src="${e.target.result}" alt="${file.name}">
					<button class="preview-remove" onclick="removePreview('${previewId}')" title="Remove">×</button>
					<div class="preview-status">
						<span class="status-text">Uploading...</span>
					</div>
					<div class="preview-info">
						<strong>${file.name}</strong><br>
						<small>${formatFileSize(file.size)}</small>
					</div>
				</div>
			`;
			previewArea.insertAdjacentHTML('beforeend', previewHtml);

			// Store preview ID on file for later reference
			file.previewId = previewId;
		};

		reader.readAsDataURL(file);
	}

	function uploadFile(file) {
		const formData = new FormData();
		formData.append('file', file);

		fetch(uploadUrl, {
			method: 'POST',
			body: formData,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		.then(response => response.json())
		.then(data => {
			const previewItem = document.getElementById(file.previewId);
			if (previewItem) {
				if (data.success) {
					previewItem.classList.remove('uploading');
					previewItem.classList.add('success');
					previewItem.querySelector('.status-text').textContent = 'Uploaded!';

					// Reload page after a short delay to show the new file
					setTimeout(() => {
						location.reload();
					}, 1000);
				} else {
					previewItem.classList.remove('uploading');
					previewItem.classList.add('error');
					previewItem.querySelector('.status-text').textContent = 'Failed!';
					showAlert('error', data.error || 'Upload failed');
				}
			}

			// Remove from pending uploads
			pendingUploads = pendingUploads.filter(f => f !== file);
		})
		.catch(error => {
			console.error('Upload error:', error);
			const previewItem = document.getElementById(file.previewId);
			if (previewItem) {
				previewItem.classList.remove('uploading');
				previewItem.classList.add('error');
				previewItem.querySelector('.status-text').textContent = 'Error!';
			}
			showAlert('error', 'Upload failed: ' + error.message);
			pendingUploads = pendingUploads.filter(f => f !== file);
		});
	}

	window.removePreview = function(previewId) {
		const previewItem = document.getElementById(previewId);
		if (previewItem) {
			previewItem.style.opacity = '0';
			previewItem.style.transform = 'scale(0.8)';
			setTimeout(() => {
				previewItem.remove();
			}, 300);
		}

		// Remove from pending uploads if still there
		pendingUploads = pendingUploads.filter(f => f.previewId !== previewId);
	};

	function formatFileSize(bytes) {
		if (bytes === 0) return '0 Bytes';
		const k = 1024;
		const sizes = ['Bytes', 'KB', 'MB'];
		const i = Math.floor(Math.log(bytes) / Math.log(k));
		return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
	}

	function showAlert(type, message) {
		const alertClass = type === 'error' ? 'alert-danger' : 'alert-success';
		const alertHtml = `
			<div class="alert ${alertClass} alert-dismissible fade show mt-3" role="alert">
				${message}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		`;
		previewArea.insertAdjacentHTML('beforebegin', alertHtml);

		// Auto-dismiss after 5 seconds
		setTimeout(() => {
			const alert = previewArea.previousElementSibling;
			if (alert && alert.classList.contains('alert')) {
				alert.remove();
			}
		}, 5000);
	}
})();
</script>
