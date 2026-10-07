<?php
/**
 * @var \App\View\AppView $this
 * @var array<array<string, mixed>> $files
 * @var int $ownedHashesCount
 * @var int $maxFileSize
 * @var int $maxFiles
 */
?>
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/file_storage'); ?>
</nav>
<div class="page form col-sm-8 col-12">
	<h2>Upload Without Re-sending</h2>
	<p>Your browser hashes files of any size in chunks. For files up to 2 MB, it asks the server whether an upload is needed. Larger files are hashed locally only. File bytes are uploaded only when this session has not uploaded that content before, or the stored blob is no longer available.</p>
	<h4>Try this</h4>
	<ol>
		<li>Drop a file: it is hashed in the browser and uploaded.</li>
		<li>Drop the same file again, or a renamed copy: no file bytes are transferred.</li>
		<li>Delete the rows on the Deduplication page and drop it again: no file bytes are transferred while the blob exists.</li>
		<li>Open this page in a private window and drop the same file: it uploads, because that session never sent it.</li>
		<li>Pick a large file, a video or an ISO: it is hashed in chunks in your browser and nothing is sent, because this demo stores at most 2 MB per file.</li>
	</ol>
	<p>When this page loaded, your session had uploaded <?php echo h($ownedHashesCount); ?> distinct file(s). The collection allows <?php echo h($maxFiles); ?> rows.</p>
	<div id="cryptoNotice" class="alert alert-warning" hidden>Browser hashing is unavailable in this context. Files up to 2 MB will always be uploaded. Larger files cannot be hashed and will not be sent. Use HTTPS or localhost to enable hashing.</div>
	<div class="card mb-4">
		<div class="card-header"><h4>Select Files</h4><small class="text-muted">Any type | Hash any size | Store at most 2 MB per file</small></div>
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
	<div class="mb-3" aria-live="polite"><strong>Hashed locally only</strong><br><span id="localBytes">0 B</span><br><small class="text-muted">These bytes never left the browser. The demo stores nothing above 2 MB per file.</small></div>
	<p class="text-muted">Files above 2 MB are hashed but neither sent nor stored. The three counters above cover successful server interactions on this page. Bytes sent counts file content, excluding request metadata and multipart overhead.</p>
	<h3>Results</h3>
	<div class="table-responsive">
		<table class="table table-striped">
			<thead><tr><th>Filename</th><th>Size</th><th>Hash time</th><th>Throughput</th><th>Result</th><th>Bytes sent</th></tr></thead>
			<tbody id="instantResults" aria-live="polite"></tbody>
		</table>
	</div>
	<p class="text-muted">For files marked “hashed only”, a real application would send the 64 character hash and upload the file only if the server does not have that content for this user.</p>
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
	<p>The browser computes SHA-256 with <a href="https://github.com/Daninet/hash-wasm">hash-wasm</a>, reading one 8 MiB chunk at a time so file memory use stays at one chunk. For files up to 2 MB, it then posts the hash, filename, and size. Larger files stay in the browser. The server attaches stored content if this session owns the hash. Otherwise, the browser uploads the file, and the server remembers its saved hash in the session.</p>
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
<script src="https://cdn.jsdelivr.net/npm/hash-wasm@4.12.0/dist/sha256.umd.min.js" integrity="sha384-Wgjx+8tLxXJSOx0qsuYHWUruquWEGSmkfn24UY1UGLJpwzCAMKZ3kbRI89jpYIVm" crossorigin="anonymous"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
	const checkUrl = <?php echo json_encode($this->Url->build(['action' => 'instantUploadCheck'])); ?>;
	const storeUrl = <?php echo json_encode($this->Url->build(['action' => 'instantUploadStore'])); ?>;
	const headers = {'X-Requested-With': 'XMLHttpRequest'};
	const maxFileSize = <?php echo json_encode($maxFileSize); ?>;
	const chunkSize = 8 * 1024 * 1024;
	let canHashWasm = Boolean(window.hashwasm && window.hashwasm.createSHA256);
	const canHashCrypto = Boolean(window.crypto && window.crypto.subtle);
	const dropZone = document.getElementById('instantDropZone');
	const input = document.getElementById('instantFileInput');
	const results = document.getElementById('instantResults');
	let queue = Promise.resolve();
	let handled = 0;
	let sent = 0;
	let saved = 0;
	let local = 0;
	function showHashingNotice() {
		const notice = document.getElementById('cryptoNotice');
		if (canHashCrypto) {
			notice.textContent = 'Chunked hashing is unavailable. Files up to ' + readable(maxFileSize) + ' can be hashed, but larger files cannot be hashed in this browser context and will not be sent.';
		}
		notice.hidden = false;
	}
	if (!canHashWasm) {
		showHashingNotice();
	}

	// WebAssembly can be blocked (CSP, browser policy) even when the script loaded.
	async function createWasmHasher() {
		if (!canHashWasm) {
			return null;
		}
		try {
			return await window.hashwasm.createSHA256();
		} catch (error) {
			canHashWasm = false;
			showHashingNotice();
			return null;
		}
	}

	function readable(bytes) {
		if (bytes === 0) {
			return '0 B';
		}
		const units = ['B', 'KB', 'MB', 'GB'];
		const exponent = Math.min(Math.floor(Math.log(bytes) / Math.log(1024)), units.length - 1);
		return (bytes / Math.pow(1024, exponent)).toLocaleString(undefined, {maximumFractionDigits: 2}) + ' ' + units[exponent];
	}

	function throughput(bytes, elapsed) {
		return (elapsed > 0 ? bytes / (1024 * 1024) / (elapsed / 1000) : 0).toFixed(1);
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
		const row = addRow(results, [file.name, readable(file.size), 'N/A', 'N/A', 'Waiting', '0 B']);
		let bytesSent = 0;
		let hash = '';
		try {
			const hasher = await createWasmHasher();
			if (file.size > maxFileSize && !hasher) {
				throw new Error('Large files cannot be hashed in this browser context. Nothing was sent.');
			}
			let data = {status: 'upload'};
			if (hasher || canHashCrypto) {
				row.cells[4].textContent = 'Hashing';
				const start = performance.now();
				const progress = document.createElement('progress');
				progress.max = 100;
				progress.value = 0;
				progress.setAttribute('aria-label', 'Hashing ' + file.name);
				const progressText = document.createElement('span');
				row.cells[4].replaceChildren(progress, progressText);
				function updateProgress(bytes) {
					const percent = file.size === 0 ? 100 : bytes / file.size * 100;
					const elapsed = performance.now() - start;
					progress.value = percent;
					progressText.textContent = ' ' + percent.toFixed(1) + '% | ' + throughput(bytes, elapsed) + ' MB/s';
				}
				updateProgress(0);
				if (hasher) {
					hasher.init();
					for (let offset = 0; offset < file.size; offset += chunkSize) {
						const end = Math.min(offset + chunkSize, file.size);
						hasher.update(new Uint8Array(await file.slice(offset, end).arrayBuffer()));
						updateProgress(end);
						await new Promise(resolve => setTimeout(resolve, 0));
					}
					hash = hasher.digest('hex');
				} else {
					const buffer = await file.arrayBuffer();
					const digest = await window.crypto.subtle.digest('SHA-256', buffer);
					hash = Array.from(new Uint8Array(digest), byte => byte.toString(16).padStart(2, '0')).join('');
				}
				updateProgress(file.size);
				const elapsed = performance.now() - start;
				row.cells[2].textContent = elapsed >= 1000 ? (elapsed / 1000).toFixed(1) + ' s' : elapsed.toFixed(1) + ' ms';
				row.cells[3].textContent = throughput(file.size, elapsed) + ' MB/s';
				if (file.size > maxFileSize) {
					const badge = document.createElement('span');
					badge.className = 'badge badge-secondary bg-secondary';
					badge.textContent = 'hashed only';
					const hashText = document.createElement('code');
					hashText.className = 'd-block text-break';
					hashText.textContent = hash;
					row.cells[4].replaceChildren(badge, hashText);
					local += file.size;
					document.getElementById('localBytes').textContent = readable(local);
					return;
				}
				row.cells[4].textContent = 'Checking';
				data = await post(checkUrl, new URLSearchParams({hash, filename: file.name, size: String(file.size)}));
			}
			if (data.status === 'upload') {
				const body = new FormData();
				body.append('file', file);
				row.cells[4].textContent = 'Uploading';
				bytesSent = file.size;
				row.cells[5].textContent = readable(bytesSent);
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
			row.cells[4].replaceChildren(badge);
			row.cells[5].textContent = readable(bytesSent);
			handled += file.size;
			sent += bytesSent;
			saved += file.size - bytesSent;
			document.getElementById('handledBytes').textContent = readable(handled);
			document.getElementById('sentBytes').textContent = readable(sent);
			document.getElementById('savedBytes').textContent = readable(saved);
			addRow(document.getElementById('instantRows'), [data.id, data.filename, readable(data.filesize), hash ? hash.slice(0, 12) : 'Unavailable without browser hashing']);
		} catch (error) {
			row.cells[4].textContent = error.message;
			row.cells[4].classList.add('text-danger');
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
