<?php
/**
 * @var \App\View\AppView $this
 * @var bool $debugMode
 */

$this->append('css');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css');
$this->end();
$this->append('script');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-djot.js');
$this->end();

$defaultDjot = <<<'DJOT'
# Djot Playground

This is a *Djot* markup demo.
Try editing this text!

---

## Features

- _emphasis_ and *strong* text
- {=highlighted=} text
- {+inserted+} and {-deleted-} text
- Links: [Djot docs](https://djot.net)
- Inline `code` spans

### Code Block

``` php
<?php
echo "Hello, World!";
```

### Blockquote

> The best way to predict the future is to invent it.

--- _Alan Kay_

### Table

{.table}
| Name   | Type   |
|--------|--------|
| Djot   | Markup |
| PHP    | Code   |

### Lists

1. A *cool*
1. automatically *numbered*

  - sub

    - subsub

1. nested *list*

### Task List

- [ ] Write documentation
- [x] Create examples
- [x] Test features

### Definition List

: Djot

  A lightweight markup language with clean syntax.

: Markdown
: CommonMark

  The predecessors that inspired Djot.

### Super/Subscript

- Superscript: 2^10^ = 1024
- Subscript: H~2~O

### Footnotes

Here is a footnote reference[^1].

[^1]: This is the footnote content.
DJOT;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Djot Playground</h2>
<p>
	<a href="https://github.com/php-collective/djot-php" target="_blank">[Djot-PHP]</a> converts
	<a href="https://djot.net" target="_blank">Djot</a> markup to HTML.
	Edit on the left, see the result on the right.
</p>

<div class="row mb-2 align-items-center">
	<div class="col-auto">
		<label class="form-label small mb-0 me-1">Profile:</label>
		<select class="form-select form-select-sm d-inline-block w-auto" id="opt-profile" title="Profile restricts which features are allowed">
			<option value="">No filter</option>
			<option value="full">Full (all features)</option>
			<option value="article">Article (no raw HTML)</option>
			<option value="comment">Comment (no images/tables)</option>
			<option value="minimal">Minimal (no links/highlights)</option>
		</select>
	</div>
	<div class="col-auto">
		<label class="form-label small mb-0 me-1">Filter:</label>
		<select class="form-select form-select-sm d-inline-block w-auto" id="opt-filter-mode" title="How to handle disallowed elements">
			<option value="to_text">To Text</option>
			<option value="strip">Strip</option>
			<option value="error">Error</option>
		</select>
	</div>
	<div class="col-auto ms-auto">
		<span id="loading-indicator" class="me-2" style="opacity: 0;">
			<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>
		</span>
		<button type="button" class="btn btn-sm btn-outline-primary me-2" id="btn-share" title="Copy shareable link">
			<i class="bi bi-share"></i> Share
		</button>
		<div class="btn-group btn-group-sm" role="group">
			<input type="radio" class="btn-check" name="view-mode" id="view-rendered" value="rendered" checked>
			<label class="btn btn-outline-secondary" for="view-rendered">Preview</label>
			<input type="radio" class="btn-check" name="view-mode" id="view-source" value="source">
			<label class="btn btn-outline-secondary" for="view-source">HTML</label>
		</div>
	</div>
</div>
<div class="row mb-2 align-items-center">
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-warnings">
			<label class="form-check-label" for="opt-warnings">Warnings</label>
		</div>
	</div>
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-strict">
			<label class="form-check-label" for="opt-strict">Strict</label>
		</div>
	</div>
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-soft-break-br">
			<label class="form-check-label" for="opt-soft-break-br" title="Render soft breaks (single newlines) as visible <br> tags. Not part of Djot spec.">Soft break as &lt;br&gt;</label>
		</div>
	</div>
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-significant-newlines">
			<label class="form-check-label" for="opt-significant-newlines" title="Enable significant newlines mode: soft breaks render as <br>, and blocks can interrupt paragraphs without blank lines. Not part of Djot spec.">Significant newlines</label>
		</div>
	</div>
	<?php if ($debugMode) { ?>
	<div class="col-auto">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="opt-raw">
			<label class="form-check-label text-danger" for="opt-raw" title="Disable HTML sanitization (debug only)">Raw</label>
		</div>
	</div>
	<?php } ?>
</div>

<div id="alert-container"></div>

<style>
#output-rendered ul.task-list,
#output-rendered ul.task {
	list-style: none;
	padding-left: 1.5em;
}
#output-rendered ul.task-list li,
#output-rendered ul.task li {
	position: relative;
	padding-left: 0.5em;
	text-indent: 0;
}
#output-rendered ul.task-list li input[type="checkbox"],
#output-rendered ul.task li input[type="checkbox"] {
	position: absolute;
	left: -1.25em;
	top: 0.25em;
}
#output-rendered div.warning,
#output-rendered div.note,
#output-rendered div.info,
#output-rendered div.tip,
#output-rendered div.caution,
#output-rendered div.important {
	padding: 1rem;
	margin: 1rem 0;
	border-radius: 0.25rem;
	border-left: 4px solid;
}
#output-rendered div.warning {
	background-color: #fff3cd;
	border-color: #ffc107;
}
#output-rendered div.note,
#output-rendered div.info {
	background-color: #cff4fc;
	border-color: #0dcaf0;
}
#output-rendered div.tip {
	background-color: #d1e7dd;
	border-color: #198754;
}
#output-rendered div.caution,
#output-rendered div.important {
	background-color: #f8d7da;
	border-color: #dc3545;
}
#output-rendered div.warning > *:first-child,
#output-rendered div.note > *:first-child,
#output-rendered div.info > *:first-child,
#output-rendered div.tip > *:first-child,
#output-rendered div.caution > *:first-child,
#output-rendered div.important > *:first-child {
	margin-top: 0;
}
#output-rendered div.warning > *:last-child,
#output-rendered div.note > *:last-child,
#output-rendered div.info > *:last-child,
#output-rendered div.tip > *:last-child,
#output-rendered div.caution > *:last-child,
#output-rendered div.important > *:last-child {
	margin-bottom: 0;
}
#output-rendered .highlight {
	background-color: #fff3cd;
	padding: 0.1em 0.3em;
	border-radius: 0.2em;
}
#output-rendered .term {
	font-style: italic;
	border-bottom: 1px dotted #666;
}
#output-rendered .class1 {
	color: #0d6efd;
}
#output-rendered .class2 {
	font-weight: bold;
}
#output-rendered span[id] {
	background-color: #e7f1ff;
	padding: 0.1em 0.2em;
	border-radius: 0.2em;
}
#output-rendered div.line-block {
	padding-left: 1em;
	border-left: 3px solid #dee2e6;
	font-style: italic;
}
#output-rendered dl {
	width: auto;
	line-height: 1.5em;
}
#output-rendered dt {
	font-weight: bold;
	width: auto;
	margin-top: 0.5em;
}
#output-rendered dd {
	margin-left: 1.5em;
	margin-top: 0;
}
#output-rendered figure {
	margin: 1em 0;
	padding: 0;
}
#output-rendered figure blockquote {
	margin-bottom: 0.5em;
}
#output-rendered figcaption {
	font-style: italic;
	color: #666;
	font-size: 0.9em;
	padding-left: 1em;
}
#output-rendered figcaption::before {
	content: "— ";
}
#output-rendered table {
	width: 100%;
	margin-bottom: 1rem;
	color: #212529;
	border-collapse: collapse;
}
#output-rendered table th,
#output-rendered table td {
	padding: 0.5rem;
	border: 1px solid #dee2e6;
}
#output-rendered table thead th {
	border-bottom: 2px solid #dee2e6;
	background-color: #f8f9fa;
}
#output-rendered table caption {
	caption-side: bottom;
	font-style: italic;
	color: #666;
	font-size: 0.9em;
	padding-top: 0.5em;
	text-align: left;
}
</style>

<div class="row">
	<div class="col-md-6">
		<div class="btn-toolbar mb-1" role="toolbar" id="djot-toolbar">
			<div class="btn-group btn-group-sm me-1" role="group">
				<button type="button" class="btn btn-outline-secondary" data-wrap="*" title="Bold"><i class="bi bi-type-bold"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-wrap="_" title="Italic"><i class="bi bi-type-italic"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-wrap="{=" data-wrap-end="=}" title="Highlight"><i class="bi bi-pencil-fill"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-wrap="{-" data-wrap-end="-}" title="Strikethrough"><i class="bi bi-type-strikethrough"></i></button>
			</div>
			<div class="btn-group btn-group-sm me-1" role="group">
				<button type="button" class="btn btn-outline-secondary" data-wrap="`" title="Inline code"><i class="bi bi-code"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-block="```\n\n```\n" data-cursor="-5" title="Code block"><i class="bi bi-file-code"></i></button>
			</div>
			<div class="btn-group btn-group-sm me-1" role="group">
				<button type="button" class="btn btn-outline-secondary" data-prefix="# " title="Heading"><i class="bi bi-type-h1"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-prefix="> " title="Quote"><i class="bi bi-quote"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-prefix="- " title="List"><i class="bi bi-list-ul"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-prefix="1. " title="Numbered list"><i class="bi bi-list-ol"></i></button>
			</div>
			<div class="btn-group btn-group-sm" role="group">
				<button type="button" class="btn btn-outline-secondary" data-action="link" title="Link"><i class="bi bi-link-45deg"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-action="image" title="Image"><i class="bi bi-image"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-action="table" title="Table"><i class="bi bi-table"></i></button>
				<button type="button" class="btn btn-outline-secondary" data-block="---\n" title="Horizontal rule"><i class="bi bi-hr"></i></button>
			</div>
		</div>
		<textarea id="djot-input" class="form-control font-monospace" rows="20" placeholder="Enter Djot markup..."><?= h($defaultDjot) ?></textarea>
	</div>
	<div class="col-md-6">
		<div id="output-rendered" class="border rounded p-3 bg-white" style="min-height: 100%; max-height: 480px; overflow-y: auto;"></div>
		<pre id="output-source" class="border rounded p-3 bg-light d-none" style="min-height: 100%; max-height: 480px; overflow-y: auto; margin: 0;"><code></code></pre>
	</div>
</div>

<p class="text-muted small mt-2">
	<i class="bi bi-shield-check"></i>
	Output is XHTMLed and sanitized via <a href="https://github.com/ezyang/htmlpurifier" target="_blank">HTMLPurifier</a> for security.
	For raw output, clone the <a href="https://github.com/dereuromark/cakephp-sandbox" target="_blank">sandbox repo</a> and run locally in debug mode.
</p>

<div class="modal fade" id="insertModal" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title" id="insertModalTitle">Insert</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body py-2">
				<div class="mb-2">
					<label for="insertUrl" class="form-label small mb-1">URL</label>
					<input type="url" class="form-control form-control-sm" id="insertUrl" placeholder="https://">
				</div>
				<div class="mb-0">
					<label for="insertText" class="form-label small mb-1" id="insertTextLabel">Text</label>
					<input type="text" class="form-control form-control-sm" id="insertText">
					<small class="text-muted" id="insertTextHint"></small>
				</div>
			</div>
			<div class="modal-footer py-2">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-sm btn-primary" id="insertConfirm">Insert</button>
			</div>
		</div>
	</div>
</div>

<h3 class="mt-4">Test Examples</h3>

<h5>Profile Feature Restriction</h5>
<p class="text-muted small">Select different profiles to see how content gets filtered. Violations show which elements were converted to plain text.</p>

<div class="row mb-4">
	<div class="col-md-6">
		<h6>Article Profile Test</h6>
		<p class="text-muted small">Select "Article" profile - all formatting except raw HTML blocks.</p>
		<pre class="bg-light p-2 border rounded"><code class="language-djot"># Full Formatting Works

*Bold*, _italic_, {=highlight=}, `code` - all allowed!

``` =html
&lt;script&gt;alert('This raw block is filtered')&lt;/script&gt;
```

Tables, images, footnotes all work in article mode.</code></pre>
		<button type="button" class="btn btn-sm btn-outline-primary mt-1 try-example" data-profile="article"><i class="bi bi-play-fill"></i> Try this</button>
	</div>
	<div class="col-md-6">
		<h6>Comment Profile Test</h6>
		<p class="text-muted small">Select "Comment" profile - images, headings, and tables will be filtered.</p>
		<pre class="bg-light p-2 border rounded"><code class="language-djot"># This heading will be filtered

*Bold*, _italic_, {=highlight=}, 2^10^ all allowed!

> Blockquotes and `code` work too.

![This image is not allowed](/img/cake.icon.png)

| Tables | Not | Allowed |
|--------|-----|---------|

[Links](https://example.com) work fine!</code></pre>
		<button type="button" class="btn btn-sm btn-outline-primary mt-1 try-example" data-profile="comment"><i class="bi bi-play-fill"></i> Try this</button>
	</div>
</div>

<div class="row mb-4">
	<div class="col-md-6">
		<h6>Minimal Profile Test</h6>
		<p class="text-muted small">Select "Minimal" profile - basic formatting and lists, no links or highlights.</p>
		<pre class="bg-light p-2 border rounded"><code class="language-djot">*Bold*, _italic_, `code`, 2^10^, {+insert+}, {-delete-} work!

- Lists work too
- With nesting

{=Highlights=} become plain text.

Links like [this](https://example.com) are filtered.</code></pre>
		<button type="button" class="btn btn-sm btn-outline-primary mt-1 try-example" data-profile="minimal"><i class="bi bi-play-fill"></i> Try this</button>
	</div>
	<div class="col-md-6">
		<h6>Raw HTML Test</h6>
		<p class="text-muted small">Raw HTML requires "No filter" profile and "Raw" mode enabled.</p>
		<pre class="bg-light p-2 border rounded"><code class="language-djot">Inline raw: `&lt;span style="color:red"&gt;red text&lt;/span&gt;`{=html}

Block raw HTML:

``` =html
&lt;div class="alert alert-info"&gt;
  &lt;strong&gt;Note:&lt;/strong&gt; This is raw HTML!
&lt;/div&gt;
```</code></pre>
		<button type="button" class="btn btn-sm btn-outline-primary mt-1 try-example" data-profile="" data-raw="1"><i class="bi bi-play-fill"></i> Try this</button>
	</div>
</div>

<h5>Warnings &amp; Errors</h5>
<p class="text-muted small">Click "Try this" to load examples with appropriate settings:</p>

<div class="row">
	<div class="col-md-6">
		<h6>Warning Example</h6>
		<p class="text-muted small">Loads with "Warnings" checkbox enabled.</p>
		<pre class="bg-light p-2 border rounded"><code class="language-djot">[undefined link][missing-ref]

This has an undefined footnote[^missing].</code></pre>
		<button type="button" class="btn btn-sm btn-outline-primary mt-1 try-example" data-warnings="1"><i class="bi bi-play-fill"></i> Try this</button>
	</div>
	<div class="col-md-6">
		<h6>Strict Mode Example</h6>
		<p class="text-muted small">Loads with "Strict" checkbox enabled.</p>
		<pre class="bg-light p-2 border rounded"><code class="language-djot">::: warning
This div is never closed.</code></pre>
		<button type="button" class="btn btn-sm btn-outline-primary mt-1 try-example" data-strict="1"><i class="bi bi-play-fill"></i> Try this</button>
	</div>
</div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const input = document.getElementById('djot-input');
	const outputRendered = document.getElementById('output-rendered');
	const outputSource = document.getElementById('output-source');
	const alertContainer = document.getElementById('alert-container');
	const loadingIndicator = document.getElementById('loading-indicator');
	const optProfile = document.getElementById('opt-profile');
	const optFilterMode = document.getElementById('opt-filter-mode');
	const optWarnings = document.getElementById('opt-warnings');
	const optStrict = document.getElementById('opt-strict');
	const optSoftBreakBr = document.getElementById('opt-soft-break-br');
	const optSignificantNewlines = document.getElementById('opt-significant-newlines');
	const optRaw = document.getElementById('opt-raw');
	const viewRendered = document.getElementById('view-rendered');
	const viewSource = document.getElementById('view-source');
	const btnShare = document.getElementById('btn-share');

	let debounceTimer;
	let currentRequest;

	function compress(str) {
		return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g, (match, p1) => String.fromCharCode('0x' + p1)));
	}

	function decompress(str) {
		try {
			return decodeURIComponent(atob(str).split('').map(c => '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2)).join(''));
		} catch (e) {
			return null;
		}
	}

	function loadFromUrl() {
		const params = new URLSearchParams(window.location.search);
		const encoded = params.get('d');
		if (encoded) {
			const decoded = decompress(encoded);
			if (decoded) {
				input.value = decoded;
			}
		}
		if (params.get('profile')) optProfile.value = params.get('profile');
		if (params.get('filter_mode')) optFilterMode.value = params.get('filter_mode');
		if (params.get('warnings') === '1') optWarnings.checked = true;
		if (params.get('strict') === '1') optStrict.checked = true;
		if (params.get('soft_break_br') === '1') optSoftBreakBr.checked = true;
		if (params.get('sig_newlines') === '1') {
			optSignificantNewlines.checked = true;
			optSoftBreakBr.checked = true;
			optSoftBreakBr.disabled = true;
		}
	}

	function getShareUrl() {
		const url = new URL(window.location.href.split('?')[0]);
		url.searchParams.set('d', compress(input.value));
		if (optProfile.value) url.searchParams.set('profile', optProfile.value);
		if (optFilterMode.value !== 'to_text') url.searchParams.set('filter_mode', optFilterMode.value);
		if (optWarnings.checked) url.searchParams.set('warnings', '1');
		if (optStrict.checked) url.searchParams.set('strict', '1');
		if (optSoftBreakBr.checked && !optSignificantNewlines.checked) url.searchParams.set('soft_break_br', '1');
		if (optSignificantNewlines.checked) url.searchParams.set('sig_newlines', '1');
		return url.toString();
	}

	function copyToClipboard(text) {
		if (navigator.clipboard && navigator.clipboard.writeText) {
			return navigator.clipboard.writeText(text);
		}
		// Fallback for HTTP
		const textarea = document.createElement('textarea');
		textarea.value = text;
		textarea.style.position = 'fixed';
		textarea.style.opacity = '0';
		document.body.appendChild(textarea);
		textarea.select();
		try {
			document.execCommand('copy');
			document.body.removeChild(textarea);
			return Promise.resolve();
		} catch (e) {
			document.body.removeChild(textarea);
			return Promise.reject(e);
		}
	}

	function share() {
		const url = getShareUrl();
		copyToClipboard(url).then(() => {
			const originalHtml = btnShare.innerHTML;
			btnShare.innerHTML = '<i class="bi bi-check"></i> Copied!';
			btnShare.classList.remove('btn-outline-primary');
			btnShare.classList.add('btn-success');
			setTimeout(() => {
				btnShare.innerHTML = originalHtml;
				btnShare.classList.remove('btn-success');
				btnShare.classList.add('btn-outline-primary');
			}, 2000);
		}).catch(() => {
			prompt('Copy this URL:', url);
		});
	}

	function convert() {
		clearTimeout(debounceTimer);
		debounceTimer = setTimeout(doConvert, 150);
	}

	function doConvert() {
		if (currentRequest) {
			currentRequest.abort();
		}

		loadingIndicator.style.transition = 'none';
		loadingIndicator.style.opacity = '1';

		const controller = new AbortController();
		currentRequest = controller;

		const formData = new FormData();
		formData.append('djot', input.value);
		formData.append('profile', optProfile.value);
		formData.append('filter_mode', optFilterMode.value);
		formData.append('warnings', optWarnings.checked ? '1' : '0');
		formData.append('strict', optStrict.checked ? '1' : '0');
		formData.append('soft_break_br', optSoftBreakBr.checked ? '1' : '0');
		formData.append('significant_newlines', optSignificantNewlines.checked ? '1' : '0');
		formData.append('raw', optRaw && optRaw.checked ? '1' : '0');

		fetch('<?= $this->Url->build(['action' => 'convert']) ?>', {
			method: 'POST',
			body: formData,
			signal: controller.signal,
			headers: {
				'X-Requested-With': 'XMLHttpRequest'
			}
		})
		.then(response => response.json())
		.then(data => {
			currentRequest = null;
			loadingIndicator.style.transition = 'opacity 0.8s';
			loadingIndicator.style.opacity = '0';
			alertContainer.innerHTML = '';

			if (data.error) {
				alertContainer.innerHTML = '<div class="alert alert-danger py-2"><strong>Error:</strong> ' + escapeHtml(data.error) + '</div>';
			}

			if (data.warnings && data.warnings.length > 0) {
				let warningHtml = '<div class="alert alert-warning py-2"><strong>Warnings:</strong><ul class="mb-0 ps-3">';
				data.warnings.forEach(function(w) {
					warningHtml += '<li>' + escapeHtml(w.message) + ' (line ' + w.line + ')</li>';
				});
				warningHtml += '</ul></div>';
				alertContainer.innerHTML += warningHtml;
			}

			if (data.violations && data.violations.length > 0) {
				let violationHtml = '<div class="alert alert-info py-2"><strong>Profile Violations:</strong> Content was filtered.<ul class="mb-0 ps-3">';
				data.violations.forEach(function(v) {
					violationHtml += '<li><code>' + escapeHtml(v.nodeType) + '</code>: ' + escapeHtml(v.reason) + '</li>';
				});
				violationHtml += '</ul></div>';
				alertContainer.innerHTML += violationHtml;
			}

			outputRendered.innerHTML = data.html || '<span class="text-muted">Enter some Djot markup...</span>';
			outputSource.querySelector('code').textContent = data.html || '';

			// Highlight code blocks
			outputRendered.querySelectorAll('pre code').forEach(el => {
				el.removeAttribute('data-highlighted');
				hljs.highlightElement(el);
			});
		})
		.catch(err => {
			loadingIndicator.style.transition = 'opacity 0.8s';
			loadingIndicator.style.opacity = '0';
			if (err.name !== 'AbortError') {
				console.error('Conversion error:', err);
			}
		});
	}

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	function updateView() {
		if (viewSource.checked) {
			outputRendered.classList.add('d-none');
			outputSource.classList.remove('d-none');
		} else {
			outputRendered.classList.remove('d-none');
			outputSource.classList.add('d-none');
		}
	}

	input.addEventListener('input', convert);
	input.addEventListener('keydown', function(e) {
		if (e.key === 'Tab') {
			e.preventDefault();
			const start = input.selectionStart;
			const end = input.selectionEnd;
			const text = input.value;

			// Find line boundaries for the selection
			let lineStart = start;
			while (lineStart > 0 && text[lineStart - 1] !== '\n') lineStart--;

			let lineEnd = end;
			while (lineEnd < text.length && text[lineEnd] !== '\n') lineEnd++;

			// Get selected lines
			const block = text.substring(lineStart, lineEnd);
			const lines = block.split('\n');

			let modified;
			if (e.shiftKey) {
				// Shift+Tab: unindent
				modified = lines.map(line => line.startsWith('  ') ? line.substring(2) : line);
			} else {
				// Tab: indent
				modified = lines.map(line => '  ' + line);
			}

			const newBlock = modified.join('\n');
			const diff = newBlock.length - block.length;

			input.value = text.substring(0, lineStart) + newBlock + text.substring(lineEnd);
			input.selectionStart = lineStart;
			input.selectionEnd = lineEnd + diff;
			convert();
		}
	});
	optProfile.addEventListener('change', convert);
	optFilterMode.addEventListener('change', convert);
	optWarnings.addEventListener('change', convert);
	optStrict.addEventListener('change', convert);
	optSoftBreakBr.addEventListener('change', convert);
	optSignificantNewlines.addEventListener('change', function() {
		// Auto-toggle soft break checkbox when significant newlines is enabled
		if (optSignificantNewlines.checked) {
			optSoftBreakBr.checked = true;
			optSoftBreakBr.disabled = true;
		} else {
			optSoftBreakBr.disabled = false;
		}
		convert();
	});
	if (optRaw) optRaw.addEventListener('change', convert);
	viewRendered.addEventListener('change', updateView);
	viewSource.addEventListener('change', updateView);
	btnShare.addEventListener('click', share);

	// Toolbar functionality
	document.getElementById('djot-toolbar').addEventListener('click', function(e) {
		const btn = e.target.closest('button');
		if (!btn) return;

		const pos = input.selectionStart;
		const end = input.selectionEnd;
		const text = input.value;
		const selected = text.substring(pos, end);

		// Helper to get newline prefix needed for block elements
		function getBlockPrefix() {
			if (pos === 0) return '';
			const beforeCursor = text.substring(0, pos);
			const lastNewline = beforeCursor.lastIndexOf('\n');
			const currentLine = beforeCursor.substring(lastNewline + 1);
			// Check if there's a blank line before cursor (two newlines in a row)
			if (pos >= 2 && text[pos - 1] === '\n' && text[pos - 2] === '\n') return '';
			// At start of file after nothing
			if (currentLine === '' && lastNewline === -1) return '';
			// Current line is empty (we're on a blank line)
			if (currentLine === '') return '\n';
			// We're at end of a line with content, need blank line
			return '\n\n';
		}

		if (btn.dataset.wrap) {
			// Wrap selection with markers (e.g., *bold*, _italic_)
			const wrapStart = btn.dataset.wrap;
			const wrapEnd = btn.dataset.wrapEnd || wrapStart;
			const newText = wrapStart + selected + wrapEnd;
			input.value = text.substring(0, pos) + newText + text.substring(end);
			input.selectionStart = pos + wrapStart.length;
			input.selectionEnd = pos + wrapStart.length + selected.length;
		} else if (btn.dataset.block) {
			// Insert block element (e.g., code block, hr)
			const blockPrefix = getBlockPrefix();
			const insertText = btn.dataset.block.replace(/\\n/g, '\n');
			input.value = text.substring(0, pos) + blockPrefix + insertText + text.substring(end);
			const cursorOffset = btn.dataset.cursor ? parseInt(btn.dataset.cursor) : 0;
			input.selectionStart = input.selectionEnd = pos + blockPrefix.length + insertText.length + cursorOffset;
		} else if (btn.dataset.prefix) {
			// Add prefix to line (e.g., # heading, > quote)
			const blockPrefix = getBlockPrefix();
			input.value = text.substring(0, pos) + blockPrefix + btn.dataset.prefix + text.substring(end);
			input.selectionStart = input.selectionEnd = pos + blockPrefix.length + btn.dataset.prefix.length;
		} else if (btn.dataset.action === 'link' || btn.dataset.action === 'image') {
			// Show modal for link/image insertion
			showInsertModal(btn.dataset.action, selected, pos, end);
			return; // Don't call convert yet
		} else if (btn.dataset.action === 'table') {
			// Insert table template
			const blockPrefix = getBlockPrefix();
			const table = '| Header 1 | Header 2 |\n|----------|----------|\n| Cell 1   | Cell 2   |\n';
			input.value = text.substring(0, pos) + blockPrefix + table + text.substring(end);
			input.selectionStart = pos + blockPrefix.length + 2;
			input.selectionEnd = pos + blockPrefix.length + 10;
		}

		input.focus();
		convert();
	});

	// Modal for link/image insertion
	const insertModal = new bootstrap.Modal(document.getElementById('insertModal'));
	const insertModalEl = document.getElementById('insertModal');
	const insertText = document.getElementById('insertText');
	const insertUrl = document.getElementById('insertUrl');
	const insertConfirm = document.getElementById('insertConfirm');
	let insertMode = null;
	let insertPos = 0;
	let insertEnd = 0;

	function showInsertModal(mode, selected, pos, end) {
		insertMode = mode;
		insertPos = pos;
		insertEnd = end;

		document.getElementById('insertModalTitle').textContent = mode === 'link' ? 'Insert Link' : 'Insert Image';
		document.getElementById('insertTextLabel').textContent = mode === 'link' ? 'Link text' : 'Alt text';
		document.getElementById('insertTextHint').textContent = mode === 'link' ? 'Optional - leave empty for auto-link' : '';
		insertText.value = selected || '';
		insertUrl.value = mode === 'image' ? '/img/cake.icon.png' : '';
		insertModal.show();

		insertModalEl.addEventListener('shown.bs.modal', function onShown() {
			insertUrl.focus();
			insertUrl.select();
			insertModalEl.removeEventListener('shown.bs.modal', onShown);
		});
	}

	insertConfirm.addEventListener('click', doInsert);
	insertUrl.addEventListener('keydown', function(e) {
		if (e.key === 'Enter') doInsert();
	});

	function doInsert() {
		const text = input.value;
		const linkText = insertText.value;
		const url = insertUrl.value || '#';
		let markup;
		if (insertMode === 'link') {
			markup = linkText ? '[' + linkText + '](' + url + ')' : '<' + url + '>';
		} else {
			markup = '![' + (linkText || 'image') + '](' + url + ')';
		}

		input.value = text.substring(0, insertPos) + markup + text.substring(insertEnd);
		input.selectionStart = input.selectionEnd = insertPos + markup.length;
		insertModal.hide();
		input.focus();
		convert();
	}

	// Highlight djot example code blocks
	document.querySelectorAll('pre code.language-djot').forEach(el => {
		hljs.highlightElement(el);
	});

	// "Try this" buttons for examples
	document.querySelectorAll('.try-example').forEach(btn => {
		btn.addEventListener('click', function() {
			const code = this.previousElementSibling.querySelector('code');
			if (code) {
				input.value = code.textContent;

				// Apply settings from data attributes
				if (this.dataset.profile !== undefined) {
					optProfile.value = this.dataset.profile;
				}
				if (this.dataset.warnings === '1') {
					optWarnings.checked = true;
				} else {
					optWarnings.checked = false;
				}
				if (this.dataset.strict === '1') {
					optStrict.checked = true;
				} else {
					optStrict.checked = false;
				}
				if (optRaw && this.dataset.raw === '1') {
					optRaw.checked = true;
				} else if (optRaw) {
					optRaw.checked = false;
				}

				input.scrollIntoView({ behavior: 'smooth', block: 'center' });
				convert();
			}
		});
	});

	// Load from URL if shared, then convert
	loadFromUrl();
	convert();
})();
<?php $this->Html->scriptEnd(); ?>
