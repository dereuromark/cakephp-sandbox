<?php
/**
 * @var \App\View\AppView $this
 * @var array<array<string, mixed>> $files
 * @var string $owner
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page form col-sm-8 col-12">
	<h2>Resumable Uploads</h2>
	<div class="alert alert-info">Chunks go to the app server and survive dropped connections. Select the same file after a page reload or tab close to resume. On completion, consume sends the file through the normal save pipeline with validation, deduplication, and events. This demo allows files up to 1 GiB and keeps at most 3 rows. Saved rows expire after a day; unfinished uploads expire after an hour without a chunk.</div>
	<div class="card mb-4">
		<div class="card-body">
			<label for="resumableFile">Choose a file</label>
			<input type="file" id="resumableFile" class="form-control mb-3">
			<label for="chunkSize">Chunk size</label>
			<select id="chunkSize" class="form-control mb-3">
				<option value="1">1 MB</option><option value="5" selected>5 MB</option><option value="20">20 MB</option>
			</select>
			<label><input type="checkbox" id="declareHash" checked> Compute SHA-256 before uploading</label>
			<p class="text-muted">Streaming hashing uses hash-wasm. Without it, Web Crypto hashes files up to 200 MB in memory. Larger files upload without a declared hash.</p>
			<button type="button" id="startUpload" class="btn btn-primary">Start</button>
			<button type="button" id="pauseUpload" class="btn btn-secondary" disabled>Pause</button>
			<button type="button" id="resumeUpload" class="btn btn-primary" disabled>Resume</button>
		</div>
	</div>
	<div class="progress mb-2">
		<div id="uploadProgress" class="progress-bar" role="progressbar" aria-label="Upload progress" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="width: 0%">0%</div>
	</div>
	<p id="uploadStatus" aria-live="polite">Choose a file to start.</p>
	<h3>Events</h3>
	<ul id="uploadLog" aria-live="polite"></ul>
	<h3>Current Rows</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead><tr><th>Id</th><th>Filename</th><th>Size</th><th>Hash</th><th>Actions</th></tr></thead>
			<tbody id="uploadRows">
				<?php foreach ($files as $file) { ?>
				<tr><td><?php echo h($file['id']); ?></td><td><?php echo h($file['filename']); ?></td><td><?php echo h($this->Number->toReadableSize($file['filesize'])); ?></td><td><code><?php echo h(substr((string)$file['hash'], 0, 12)); ?></code></td><td><?php echo $this->Form->postLink('Delete', ['action' => 'delete', $file['id']], ['class' => 'btn btn-sm btn-danger']); ?></td></tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<?php echo $this->Html->script('https://cdn.jsdelivr.net/npm/tus-js-client@4.3.1/dist/tus.min.js'); ?>
<?php echo $this->Html->script('https://cdn.jsdelivr.net/npm/hash-wasm@4.12.0/dist/sha256.umd.min.js', ['integrity' => 'sha384-Wgjx+8tLxXJSOx0qsuYHWUruquWEGSmkfn24UY1UGLJpwzCAMKZ3kbRI89jpYIVm', 'crossorigin' => 'anonymous']); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
	const endpoint = <?php echo json_encode($this->Url->build(['plugin' => 'FileStorage', 'controller' => 'Uploads', 'action' => 'collection'])); ?>;
	const consumeUrl = <?php echo json_encode($this->Url->build(['action' => 'resumableUploadConsume'])); ?>;
	const deleteUrl = <?php echo json_encode($this->Url->build(['action' => 'delete'])); ?>;
	const csrf = <?php echo json_encode($this->request->getAttribute('csrfToken')); ?>;
	const owner = <?php echo json_encode($owner); ?>;
	const input = document.getElementById('resumableFile');
	const chunk = document.getElementById('chunkSize');
	const hashOption = document.getElementById('declareHash');
	const start = document.getElementById('startUpload');
	const pause = document.getElementById('pauseUpload');
	const resume = document.getElementById('resumeUpload');
	const status = document.getElementById('uploadStatus');
	let upload = null;
	let started = 0;
	let initialBytes = 0;
	let measuring = false;
	let consuming = false;

	function log(message) {
		const item = document.createElement('li');
		item.textContent = message;
		const list = document.getElementById('uploadLog');
		list.prepend(item);
		while (list.children.length > 100) {
			list.lastChild.remove();
		}
	}
	function readable(bytes) {
		if (!bytes) {
			return '0 B';
		}
		const units = ['B', 'KB', 'MB', 'GB'];
		// Decimal units, like the server-rendered rows.
		const power = Math.min(Math.floor(Math.log(bytes) / Math.log(1000)), 3);
		return (bytes / 1000 ** power).toFixed(2) + ' ' + units[power];
	}
	function controls(active, resumable) {
		start.disabled = active || resumable;
		pause.disabled = !active;
		resume.disabled = !resumable;
		input.disabled = active || resumable;
		chunk.disabled = active || resumable;
		hashOption.disabled = active || resumable;
	}
	function beginMeasurement() {
		measuring = false;
		started = performance.now();
	}
	async function hash(file) {
		if (!hashOption.checked) {
			log('No declared hash. Resume only with the same file bytes.');
			return '';
		}
		status.textContent = 'Computing SHA-256 before uploading...';
		let hasher = null;
		if (window.hashwasm && window.hashwasm.createSHA256) {
			try {
				hasher = await window.hashwasm.createSHA256();
			} catch (error) {
				log('Streaming hashing unavailable. Checking Web Crypto fallback.');
			}
		}
		if (hasher) {
			hasher.init();
			for (let offset = 0; offset < file.size; offset += 8 * 1024 * 1024) {
				hasher.update(new Uint8Array(await file.slice(offset, offset + 8 * 1024 * 1024).arrayBuffer()));
				status.textContent = 'Hashing: ' + readable(Math.min(offset + 8 * 1024 * 1024, file.size)) + ' / ' + readable(file.size);
				await new Promise(resolve => setTimeout(resolve, 0));
			}
			return hasher.digest('hex');
		}
		if (file.size <= 200 * 1024 * 1024 && window.crypto && window.crypto.subtle) {
			const digest = await window.crypto.subtle.digest('SHA-256', await file.arrayBuffer());
			return Array.from(new Uint8Array(digest), byte => byte.toString(16).padStart(2, '0')).join('');
		}
		log('Skipping declared SHA-256: streaming hashing unavailable, and Web Crypto needs the whole file in memory. Resume only with the same file bytes.');
		return '';
	}
	async function consume() {
		if (consuming) {
			return;
		}
		consuming = true;
		controls(true, false);
		pause.disabled = true;
		try {
			const uploadId = new URL(upload.url, window.location.href).pathname.split('/').filter(Boolean).pop();
			const response = await fetch(consumeUrl, {
				method: 'POST',
				headers: {'Content-Type': 'application/json', 'X-CSRF-Token': csrf},
				body: JSON.stringify({uploadId})
			});
			const data = await response.json();
			if (!response.ok || data.status !== 'saved') {
				throw new Error(data.error || 'Could not save the completed upload.');
			}
			const row = document.getElementById('uploadRows').insertRow(0);
			[data.id, data.filename, readable(data.filesize), (data.hash || '').slice(0, 12)].forEach(value => {
				row.insertCell().textContent = value;
			});
			const form = document.createElement('form');
			form.method = 'post';
			form.action = deleteUrl + '/' + encodeURIComponent(data.id);
			const token = document.createElement('input');
			token.type = 'hidden';
			token.name = '_csrfToken';
			token.value = csrf;
			const button = document.createElement('button');
			button.type = 'submit';
			button.className = 'btn btn-sm btn-danger';
			button.textContent = 'Delete';
			form.append(token, button);
			row.insertCell().append(form);
			try {
				const stored = await upload.findPreviousUploads();
				await Promise.all(stored.map(entry => upload.options.urlStorage.removeUpload(entry.urlStorageKey)));
			} catch (error) {
				log('Saved, but the browser could not remove the resume record.');
			}
			log('Saved ' + data.filename + '.');
			status.textContent = 'Upload complete and saved.';
			upload = null;
			controls(false, false);
		} catch (error) {
			log(error.message);
			status.textContent = 'Completed upload is waiting to be saved. Use Resume to retry consume.';
			controls(false, true);
		} finally {
			consuming = false;
		}
	}
	start.addEventListener('click', async () => {
		const file = input.files[0];
		if (!file || file.size > 1024 ** 3) {
			log('Choose a file of at most 1 GiB.');
			return;
		}
		controls(true, false);
		pause.disabled = true;
		try {
			const sha256 = await hash(file);
			if (!window.tus) {
				throw new Error('The tus client could not load. Reload the page to try again.');
			}
			upload = new tus.Upload(file, {
				endpoint,
				chunkSize: Number(chunk.value) * 1024 * 1024,
				retryDelays: [0, 1000, 3000, 5000],
				headers: {'X-CSRF-Token': csrf},
				removeFingerprintOnSuccess: false,
				fingerprint: async file => ['sandbox-large', owner, endpoint, file.name, file.type, file.size, file.lastModified, sha256].join('|'),
				metadata: {filename: file.name, filetype: file.type, model: 'FileStorage', collection: 'large', ...(sha256 ? {sha256} : {})},
				onAfterResponse(request, response) {
					const offset = response.getHeader('Upload-Offset');
					if (request.getMethod() === 'HEAD' && response.getStatus() === 200) {
						log('Resuming from ' + readable(Number(offset)) + ' (offset ' + offset + ').');
						status.textContent = 'Resuming from ' + readable(Number(offset));
					}
				},
				onChunkComplete(size, accepted) {
					log('Chunk accepted: ' + readable(size) + ', offset ' + accepted + '.');
				},
				onShouldRetry(error, attempt) {
					const response = error.originalResponse;
					const code = response ? response.getStatus() : 0;
					const retry = code === 0 || code === 409 || code === 423 || code === 429 || code >= 500;
					if (retry) {
						log('Retry ' + (attempt + 1) + ': ' + error.message);
					}
					return retry;
				},
				onProgress(bytes, total) {
					if (!measuring) {
						initialBytes = bytes;
						started = performance.now();
						measuring = true;
					}
					const percent = total ? bytes / total * 100 : 100;
					const speed = Math.max(0, bytes - initialBytes) / Math.max((performance.now() - started) / 1000, 0.001);
					const bar = document.getElementById('uploadProgress');
					bar.style.width = percent + '%';
					bar.textContent = percent.toFixed(1) + '%';
					bar.setAttribute('aria-valuenow', percent.toFixed(1));
					status.textContent = bytes + ' / ' + total + ' bytes (' + readable(bytes) + ' / ' + readable(total) + ') | ' + percent.toFixed(1) + '% | ' + readable(speed) + '/s';
				},
				onError(error) {
					log(error.message);
					status.textContent = 'Upload stopped. Use Resume to retry.';
					controls(false, true);
				},
				onSuccess: consume
			});
			const previous = await upload.findPreviousUploads();
			if (previous.length) {
				upload.resumeFromPreviousUpload(previous[0]);
				log('Previous upload found. Reading its server offset.');
			}
			beginMeasurement();
			controls(true, false);
			upload.start();
		} catch (error) {
			log(error.message);
			controls(false, false);
		}
	});
	pause.addEventListener('click', async () => {
		pause.disabled = true;
		try {
			await upload.abort();
			log('Paused. Accepted chunks remain on the server.');
			controls(false, true);
		} catch (error) {
			log(error.message);
			controls(true, false);
		}
	});
	resume.addEventListener('click', () => {
		if (status.textContent.startsWith('Completed upload')) {
			consume();
			return;
		}
		beginMeasurement();
		controls(true, false);
		log('Resuming. Reading the server offset.');
		upload.start();
	});
});
</script>
