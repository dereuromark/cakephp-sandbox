<?php
/**
 * @var \App\View\AppView $this
 * @var array<array<string, mixed>> $files
 * @var int $ownedHashesCount
 * @var int $maxFiles
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page form col-sm-8 col-12">
	<h2>Upload Without Re-sending</h2>
	<p>Your browser hashes each file before asking the server to attach it. File bytes are uploaded only when this session has not uploaded that content before, or the stored blob is no longer available.</p>
	<h4>Try this</h4>
	<ol>
		<li>Drop a file: it is hashed in the browser and uploaded.</li>
		<li>Drop the same file again, or a renamed copy: no file bytes are transferred.</li>
		<li>Delete the rows on the Deduplication page and drop it again: no file bytes are transferred while the blob exists.</li>
		<li>Open this page in a private window and drop the same file: it uploads, because that session never sent it.</li>
	</ol>
	<p>When this page loaded, your session had uploaded <?php echo h($ownedHashesCount); ?> distinct file(s). The collection allows <?php echo h($maxFiles); ?> rows.</p>
	<div id="cryptoNotice" class="alert alert-warning" hidden>Browser hashing is unavailable in this context. Files will always be uploaded. Use HTTPS or localhost to enable hashing.</div>
	<div class="card mb-4">
		<div class="card-header"><h4>Select Files</h4><small class="text-muted">Any type | Max 2 MB per file</small></div>
		<div class="card-body">
			<div id="instantDropZone" class="drop-zone"><h3>Drag &amp; Drop Files Here</h3><p>or click to browse</p></div>
			<label for="instantFileInput" class="mt-3">Choose files</label>
			<input type="file" id="instantFileInput" class="form-control" multiple>
		</div>
	</div>
	<div class="row mb-3" aria-live="polite">
		<div class="col"><strong>File bytes handled</strong><br><span id="handledBytes">0 B</span></div>
		<div class="col"><strong>Bytes sent</strong><br><span id="sentBytes">0 B</span></div>
		<div class="col"><strong>Bytes not sent</strong><br><span id="savedBytes">0 B</span></div>
	</div>
	<p class="text-muted">The demo caps files at 2 MB; the saving grows with file size. Counters cover successful files on this page. Bytes sent counts file content, excluding request metadata and multipart overhead.</p>
	<h3>Results</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead><tr><th>Filename</th><th>Size</th><th>Hash time (ms)</th><th>Result</th><th>Bytes sent</th></tr></thead>
			<tbody id="instantResults" aria-live="polite"></tbody>
		</table>
	</div>
	<h3>Current Rows</h3>
	<p><?php echo $this->Html->link('Manage rows and blobs on the Deduplication page', ['action' => 'deduplication']); ?></p>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead><tr><th>Id</th><th>Filename</th><th>Size</th><th>Hash</th></tr></thead>
			<tbody id="instantRows">
				<?php foreach ($files as $file) { ?>
				<tr><td><?php echo h($file['id']); ?></td><td><?php echo h($file['filename']); ?></td><td><?php echo h($this->Number->toReadableSize($file['filesize'])); ?></td><td><code><?php echo h($file['hash']); ?></code></td></tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<h3>How it works</h3>
	<p>The browser reads the file and computes its SHA-256 hash, then posts the hash, filename, and size. The server attaches stored content if this session owns the hash. Otherwise, the browser uploads the file, and the server remembers its saved hash in the session.</p>
	<div class="alert alert-warning">This authorization rule is session scoped and for the demo only. Unknown content and content uploaded by another session both receive “upload needed.” A real application must check ownership before attaching: allowing arbitrary hashes can give users access to other users' files.</div>
</div>
<style>
#instantDropZone {
	border: 3px dashed #dee2e6;
	border-radius: 8px;
	padding: 60px 20px;
	text-align: center;
	cursor: pointer;
	background: #f8f9fa;
}
#instantDropZone.drag-over {
	border-color: #0d6efd;
	background: #cfe2ff;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
	const checkUrl = <?php echo json_encode($this->Url->build(['action' => 'instantUploadCheck'])); ?>;
	const storeUrl = <?php echo json_encode($this->Url->build(['action' => 'instantUploadStore'])); ?>;
	const headers = {'X-Requested-With': 'XMLHttpRequest'};
	const canHash = Boolean(window.crypto && window.crypto.subtle);
	const dropZone = document.getElementById('instantDropZone');
	const input = document.getElementById('instantFileInput');
	const results = document.getElementById('instantResults');
	let queue = Promise.resolve();
	let handled = 0;
	let sent = 0;
	let saved = 0;
	if (!canHash) {
		document.getElementById('cryptoNotice').hidden = false;
	}

	function readable(bytes) {
		if (bytes === 0) {
			return '0 B';
		}
		const units = ['B', 'KB', 'MB', 'GB'];
		const exponent = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1);
		return (bytes / Math.pow(1024, exponent)).toLocaleString(undefined, {maximumFractionDigits: 2}) + ' ' + units[exponent];
	}

	function addRow(body, values) {
		const row = body.insertRow(0);
		values.forEach(value => {
			row.insertCell().textContent = value;
		});
		return row;
	}

	async function post(url, body) {
		const response = await fetch(url, {method: 'POST', body, headers});
		if (!response.ok) {
			throw new Error('Request failed (' + response.status + ').');
		}
		return response.json();
	}

	async function processFile(file) {
		const row = addRow(results, [file.name, readable(file.size), 'N/A', 'Waiting', '0 B']);
		let bytesSent = 0;
		let hash = '';
		try {
			if (file.size > 2 * 1024 * 1024) {
				throw new Error('File too large. Maximum size is 2 MB.');
			}
			let data = {status: 'upload'};
			if (canHash) {
				row.cells[3].textContent = 'Hashing';
				const start = performance.now();
				const buffer = await file.arrayBuffer();
				const digest = await window.crypto.subtle.digest('SHA-256', buffer);
				hash = Array.from(new Uint8Array(digest), byte => byte.toString(16).padStart(2, '0')).join('');
				row.cells[2].textContent = (performance.now() - start).toFixed(1);
				row.cells[3].textContent = 'Checking';
				data = await post(checkUrl, new URLSearchParams({hash, filename: file.name, size: String(file.size)}));
			}
			if (data.status === 'upload') {
				const body = new FormData();
				body.append('file', file);
				row.cells[3].textContent = 'Uploading';
				bytesSent = file.size;
				row.cells[4].textContent = readable(bytesSent);
				data = await post(storeUrl, body);
			}
			if (data.status === 'error') {
				throw new Error(data.error);
			}
			if (data.status !== 'uploaded' && data.status !== 'attached') {
				throw new Error('Unexpected server response.');
			}
			const badge = document.createElement('span');
			badge.className = 'badge badge-success bg-success';
			badge.textContent = data.status === 'attached' ? 'attached, nothing sent' : 'uploaded';
			row.cells[3].replaceChildren(badge);
			row.cells[4].textContent = readable(bytesSent);
			handled += file.size;
			sent += bytesSent;
			saved += file.size - bytesSent;
			document.getElementById('handledBytes').textContent = readable(handled);
			document.getElementById('sentBytes').textContent = readable(sent);
			document.getElementById('savedBytes').textContent = readable(saved);
			addRow(document.getElementById('instantRows'), [data.id, data.filename, readable(data.filesize), hash ? hash.slice(0, 12) : 'Unavailable without browser hashing']);
		} catch (error) {
			row.cells[3].textContent = error.message;
			row.cells[3].classList.add('text-danger');
		}
	}

	function enqueue(files) {
		Array.from(files).forEach(file => {
			queue = queue.then(() => processFile(file));
		});
	}
	input.addEventListener('change', () => {
		enqueue(input.files);
		input.value = '';
	});
	dropZone.addEventListener('click', () => input.click());
	['dragenter', 'dragover', 'dragleave', 'drop'].forEach(name => {
		dropZone.addEventListener(name, event => {
			event.preventDefault();
			event.stopPropagation();
			dropZone.classList.toggle('drag-over', name === 'dragenter' || name === 'dragover');
		});
	});
	dropZone.addEventListener('drop', event => enqueue(event.dataTransfer.files));
});
</script>
