<?php
/**
 * @var \App\View\AppView $this
 */

$this->append('css');
?>
<style>
/* Tiptap editor styles */
#tiptap-editor {
	min-height: 300px;
	max-height: 55vh;
	overflow-y: auto;
	padding: 20px;
	padding-top: 0;
	border: 1px solid #dee2e6;
	border-top: 0;
	border-radius: 0 0 0.375rem 0.375rem;
	background: #fff;
}
.tiptap {
	outline: none;
	line-height: 1.75;
}
.tiptap > * + * {
	margin-top: 0.75em;
}
.tiptap h1, .tiptap h2, .tiptap h3, .tiptap h4, .tiptap h5, .tiptap h6 {
	line-height: 1.3;
	padding-top: 0.75em;
	padding-bottom: 0.5em;
}
.tiptap h1 { font-size: 1.8em; }
.tiptap h2 { font-size: 1.5em; }
.tiptap h3 { font-size: 1.25em; }
.tiptap h4 { font-size: 1.1em; }
.tiptap h5 { font-size: 1em; font-weight: 600; }
.tiptap h6 { font-size: 0.9em; font-weight: 600; color: #6c757d; }
.tiptap p {
	margin: 0;
}
.tiptap code {
	background: #f8f9fa;
	padding: 3px 6px;
	border-radius: 4px;
	font-family: 'Fira Code', 'JetBrains Mono', monospace;
	font-size: 0.9em;
}
.tiptap pre {
	background: #212529;
	color: #f8f9fa;
	padding: 16px 20px;
	border-radius: 8px;
	overflow-x: auto;
	margin: 1em 0;
}
.tiptap pre code {
	background: none;
	padding: 0;
	display: block;
	color: inherit;
}
.tiptap blockquote {
	border-left: 4px solid #6c757d;
	margin: 1em 0;
	padding-left: 16px;
	color: #6c757d;
	font-style: italic;
}
.tiptap ul, .tiptap ol {
	padding-left: 24px;
	margin: 0.5em 0;
}
.tiptap li {
	margin: 0.25em 0;
}
.tiptap li p {
	margin: 0;
}
.tiptap a {
	color: #0d6efd;
	text-decoration: none;
}
.tiptap a:hover {
	text-decoration: underline;
}
.tiptap hr {
	border: none;
	border-top: 2px solid #dee2e6;
	margin: 2em 0;
}
/* Djot-specific marks */
.tiptap mark {
	background: #fff3cd;
	padding: 1px 4px;
	border-radius: 3px;
}
.tiptap .djot-insert {
	color: #198754;
	text-decoration: none;
	border-bottom: 1px dashed #198754;
}
.tiptap .djot-delete {
	color: #dc3545;
	text-decoration: line-through;
}
.tiptap sup {
	font-size: 0.75em;
	vertical-align: super;
}
.tiptap sub {
	font-size: 0.75em;
	vertical-align: sub;
}
.tiptap s {
	text-decoration: line-through;
	color: #6c757d;
}
.tiptap abbr {
	text-decoration: underline dotted;
	cursor: help;
}
/* Hard breaks - show a subtle symbol */
.tiptap .hard-break {
	display: inline;
	color: #adb5bd;
	font-size: 0.75em;
	user-select: none;
}
/* Definition lists */
.tiptap dl.djot-definition-list {
	margin: 1em 0;
}
.tiptap dl.djot-definition-list dt {
	font-weight: 600;
	margin-top: 0.5em;
}
.tiptap dl.djot-definition-list dd {
	margin-left: 1.5em;
	margin-bottom: 0.5em;
	padding-left: 0.5em;
	border-left: 2px solid #dee2e6;
}
/* Tables */
.tiptap table {
	border-collapse: collapse;
	width: 100%;
	margin: 1em 0;
}
.tiptap th, .tiptap td {
	border: 1px solid #dee2e6;
	padding: 8px 12px;
	text-align: left;
}
.tiptap th {
	background: #f8f9fa;
	font-weight: 600;
}
.tiptap .selectedCell {
	background: rgba(13, 110, 253, 0.1);
}
/* Task lists */
.tiptap ul[data-type="taskList"] {
	list-style: none;
	padding-left: 0;
}
.tiptap ul[data-type="taskList"] li {
	display: flex;
	align-items: flex-start;
	gap: 8px;
}
.tiptap ul[data-type="taskList"] li > label {
	flex-shrink: 0;
	margin-top: 4px;
}
.tiptap ul[data-type="taskList"] input[type="checkbox"] {
	width: 16px;
	height: 16px;
}
/* Images */
.tiptap img {
	max-width: 100%;
	height: auto;
	border-radius: 8px;
	margin: 1em 0;
}
.tiptap img.ProseMirror-selectednode {
	outline: 3px solid #0d6efd;
}
/* Divs */
.tiptap .djot-div {
	border-left: 3px solid #6c757d;
	padding: 12px 16px;
	margin: 1em 0;
	background: #f8f9fa;
	border-radius: 0 8px 8px 0;
}
.tiptap .djot-div.warning {
	border-left-color: #ffc107;
	background: #fff3cd;
}
.tiptap .djot-div.tip {
	border-left-color: #198754;
	background: #d1e7dd;
}
.tiptap .djot-div.danger {
	border-left-color: #dc3545;
	background: #f8d7da;
}
.tiptap .djot-div.note {
	border-left-color: #0d6efd;
	background: #cfe2ff;
}
.tiptap .djot-div.info {
	border-left-color: #6c757d;
	background: #e9ecef;
}
/* Video embeds */
.tiptap .wpdjot-embed {
	margin: 1em 0;
	padding: 0;
}
.tiptap .wpdjot-embed iframe {
	max-width: 100%;
	border-radius: 8px;
}
/* Floating controls (language selector, table controls) */
.floating-control {
	position: absolute;
	z-index: 100;
	background: #fff;
	border: 1px solid #dee2e6;
	border-radius: 6px;
	padding: 4px 8px;
	box-shadow: 0 2px 8px rgba(0,0,0,0.15);
}
.floating-control select {
	min-width: 120px;
	font-size: 12px;
	padding: 2px 24px 2px 8px;
	border: none;
	background: transparent;
}
.floating-control select:focus {
	outline: none;
	box-shadow: none;
}
.table-controls {
	display: flex;
	gap: 4px;
}
.table-controls .btn {
	padding: 2px 6px;
	font-size: 11px;
}
.tiptap p.is-editor-empty:first-child::before {
	content: attr(data-placeholder);
	color: #adb5bd;
	pointer-events: none;
	float: left;
	height: 0;
}
/* Menubar styles */
.tiptap-menubar {
	background: #f8f9fa;
	padding: 8px 10px;
	display: flex;
	gap: 4px;
	flex-wrap: wrap;
	border: 1px solid #dee2e6;
	border-radius: 0.375rem 0.375rem 0 0;
}
.tiptap-menubar .btn-group {
	margin-right: 4px;
}
.tiptap-menubar .btn {
	padding: 4px 8px;
}
.tiptap-menubar .btn.is-active {
	background-color: #0d6efd;
	border-color: #0d6efd;
	color: #fff;
}
.tiptap-menubar .divider {
	width: 1px;
	background: #dee2e6;
	margin: 0 8px;
	align-self: stretch;
}
/* Output panel */
.output-panel {
	background: #fff;
	border: 1px solid #dee2e6;
	border-radius: 0.375rem;
}
.output-header {
	background: #f8f9fa;
	padding: 0 15px;
	display: flex;
	justify-content: space-between;
	align-items: center;
	border-bottom: 1px solid #dee2e6;
	border-radius: 0.375rem 0.375rem 0 0;
}
.output-tabs .nav-link {
	border: none;
	border-bottom: 2px solid transparent;
	border-radius: 0;
	padding: 12px 16px;
	color: #6c757d;
}
.output-tabs .nav-link.active {
	color: #0d6efd;
	border-bottom-color: #0d6efd;
	background: transparent;
}
.output-content {
	padding: 16px 20px;
	font-family: 'Fira Code', 'JetBrains Mono', monospace;
	font-size: 13px;
	white-space: pre-wrap;
	color: #495057;
	max-height: 400px;
	overflow: auto;
	line-height: 1.6;
}
/* Rendered Preview tab: normal prose instead of monospace source */
.output-content.rendered-mode {
	font-family: inherit;
	font-size: 14px;
	white-space: normal;
	color: inherit;
}
/* Cursor-follow highlight: source lines of the block the TipTap cursor is in */
.output-content .src-line.src-line-active {
	background: #fff3cd;
	border-radius: 2px;
}
/* Cursor-follow highlight in the rendered preview + click affordance */
.output-content.rendered-mode [data-startpos],
.output-content.rendered-mode [data-source-line] {
	cursor: pointer;
}
.output-content.rendered-mode .pos-active {
	outline: 2px solid rgba(13, 110, 253, 0.35);
	background: rgba(13, 110, 253, 0.08);
	border-radius: 2px;
}
</style>
<?php
$this->end();
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/djot') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Djot WYSIWYG Editor</h2>
<p>
	A rich text editor powered by <a href="https://tiptap.dev" target="_blank">Tiptap</a>
	with <a href="https://djot.net" target="_blank">Djot</a> output.
	Uses the <code>DjotKit</code> module from
	<a href="https://github.com/php-collective/djot-grammars" target="_blank">djot-grammars</a>.
	The <em>Djot Output</em> tab highlights the source lines of the block your cursor is in; the
	<em>Rendered Preview</em> tab follows the cursor too and jumps back to the editor on click.
	The preview renderer is switchable: <strong>djot-php</strong> (default) renders on the server
	with <code>data-source-line</code> anchors on nested blocks as well, so the cursor resolves to
	the exact paragraph inside a quote or list item; <strong>djot.js</strong> renders instantly in
	the browser and shows each element's exact <code>line:col:offset</code> range on hover (inline
	elements included), but syncs at top level only - djot.js end positions of lazy-closing
	containers overshoot into the next block.
</p>

<div class="alert alert-info py-2">
	<i class="bi bi-info-circle"></i>
	This demo uses the Tiptap integration from
	<a href="https://github.com/php-collective/djot-grammars" target="_blank">djot-grammars</a>.
	Run <code>composer assets</code> to install the module files.
</div>

<div class="mb-4">
	<div class="tiptap-menubar" id="menubar">
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="bold" title="Strong *text*"><i class="bi bi-type-bold"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="italic" title="Emphasis _text_"><i class="bi bi-type-italic"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="code" title="Code `text`"><i class="bi bi-code"></i></button>
		</div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="highlight" title="Highlight {=text=}"><i class="bi bi-pencil-fill"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="strike" title="Strikethrough {~text~}"><i class="bi bi-type-strikethrough"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="djotDelete" title="Delete {-text-}"><i class="bi bi-dash-lg"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="djotInsert" title="Insert {+text+}"><i class="bi bi-plus-lg"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="superscript" title="Superscript ^text^">x²</button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="subscript" title="Subscript ~text~">x₂</button>
		</div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="abbr" title="Abbreviation"><i class="bi bi-chat-square-text"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="clearFormat" title="Clear formatting"><i class="bi bi-eraser"></i></button>
		</div>
		<div class="divider"></div>
		<select class="form-select form-select-sm" id="blockType" style="width: auto; min-width: 110px;" title="Block type">
			<option value="paragraph">Paragraph</option>
			<option value="heading1">Heading 1</option>
			<option value="heading2">Heading 2</option>
			<option value="heading3">Heading 3</option>
			<option value="heading4">Heading 4</option>
			<option value="heading5">Heading 5</option>
			<option value="heading6">Heading 6</option>
		</select>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="bulletList" title="Bullet list"><i class="bi bi-list-ul"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="orderedList" title="Ordered list"><i class="bi bi-list-ol"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="taskList" title="Task list"><i class="bi bi-check2-square"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="definitionList" title="Definition list"><i class="bi bi-card-list"></i></button>
		</div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="blockquote" title="Blockquote"><i class="bi bi-quote"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="codeBlock" title="Code block"><i class="bi bi-file-code"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="divBlock" title="Container block (tip, warning, etc)"><i class="bi bi-card-text"></i></button>
		</div>
		<div class="divider"></div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="link" title="Link"><i class="bi bi-link-45deg"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="image" title="Image"><i class="bi bi-image"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="video" title="Video embed"><i class="bi bi-play-btn"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="horizontalRule" title="Horizontal rule"><i class="bi bi-hr"></i></button>
		</div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="insertTable" title="Insert table"><i class="bi bi-table"></i></button>
		</div>
		<div class="divider"></div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="undo" title="Undo (Ctrl+Z)"><i class="bi bi-arrow-counterclockwise"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="redo" title="Redo (Ctrl+Shift+Z)"><i class="bi bi-arrow-clockwise"></i></button>
		</div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#shortcutsModal" title="Keyboard shortcuts"><i class="bi bi-keyboard"></i></button>
		</div>
	</div>
	<div id="tiptap-editor"></div>
	<!-- Floating table controls -->
	<div id="table-controls" class="floating-control table-controls" style="display: none;">
		<button type="button" class="btn btn-sm btn-outline-secondary" data-table-cmd="addColumnAfter" title="Add column">+Col</button>
		<button type="button" class="btn btn-sm btn-outline-secondary" data-table-cmd="deleteColumn" title="Delete column">-Col</button>
		<button type="button" class="btn btn-sm btn-outline-secondary" data-table-cmd="addRowAfter" title="Add row">+Row</button>
		<button type="button" class="btn btn-sm btn-outline-secondary" data-table-cmd="deleteRow" title="Delete row">-Row</button>
		<button type="button" class="btn btn-sm btn-outline-danger" data-table-cmd="deleteTable" title="Delete table"><i class="bi bi-trash"></i></button>
	</div>
	<!-- Floating language selector for code blocks -->
	<div id="code-language-selector" class="floating-control" style="display: none;">
		<select class="form-select form-select-sm" id="codeLanguage">
			<option value="">Plain text</option>
			<option value="php">PHP</option>
			<option value="javascript">JavaScript</option>
			<option value="typescript">TypeScript</option>
			<option value="python">Python</option>
			<option value="html">HTML</option>
			<option value="css">CSS</option>
			<option value="sql">SQL</option>
			<option value="bash">Bash</option>
			<option value="json">JSON</option>
			<option value="xml">XML</option>
			<option value="yaml">YAML</option>
			<option value="markdown">Markdown</option>
			<option value="ruby">Ruby</option>
			<option value="go">Go</option>
			<option value="rust">Rust</option>
			<option value="java">Java</option>
			<option value="c">C</option>
			<option value="cpp">C++</option>
			<option value="csharp">C#</option>
		</select>
	</div>
</div>

<div class="output-panel mt-4">
	<div class="output-header">
		<ul class="nav output-tabs" role="tablist">
			<li class="nav-item">
				<button class="nav-link active" data-tab="djot">Djot Output</button>
			</li>
			<li class="nav-item">
				<button class="nav-link" data-tab="rendered">Rendered Preview</button>
			</li>
			<li class="nav-item">
				<button class="nav-link" data-tab="html">HTML Source</button>
			</li>
			<li class="nav-item">
				<button class="nav-link" data-tab="json">Document JSON</button>
			</li>
		</ul>
		<div class="d-flex align-items-center gap-2">
			<select class="form-select form-select-sm" id="renderEngine" style="width: auto;" title="Preview renderer">
				<option value="php" selected>djot-php (server)</option>
				<option value="js">djot.js (browser)</option>
			</select>
			<button type="button" class="btn btn-sm btn-outline-secondary" id="copy-btn">
				<i class="bi bi-clipboard"></i> Copy
			</button>
		</div>
	</div>
	<div class="output-content" id="output-djot"></div>
	<div class="output-content rendered-mode d-none" id="output-rendered"></div>
	<div class="output-content d-none" id="output-html"></div>
	<div class="output-content d-none" id="output-json"></div>
</div>

<div class="modal fade" id="imageModal" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title">Insert Image</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body py-2">
				<div class="mb-2">
					<label for="imageUrl" class="form-label small mb-1">Image URL</label>
					<input type="text" class="form-control form-control-sm" id="imageUrl" placeholder="https://example.com/image.jpg">
				</div>
				<div class="mb-0">
					<label for="imageAlt" class="form-label small mb-1">Alt text</label>
					<input type="text" class="form-control form-control-sm" id="imageAlt" placeholder="Description of image">
				</div>
			</div>
			<div class="modal-footer py-2">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-sm btn-primary" id="insertImageBtn">Insert</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="divModal" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title">Insert Div Container</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body py-2">
				<label for="divType" class="form-label small mb-1">Container type</label>
				<select class="form-select form-select-sm" id="divType">
					<option value="">Default</option>
					<option value="tip">Tip</option>
					<option value="warning">Warning</option>
					<option value="danger">Danger</option>
					<option value="note">Note</option>
				</select>
			</div>
			<div class="modal-footer py-2">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-sm btn-primary" id="insertDivBtn">Insert</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="videoModal" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title">Insert Video</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body py-2">
				<div class="mb-2">
					<label for="videoUrl" class="form-label small mb-1">Video URL</label>
					<input type="text" class="form-control form-control-sm" id="videoUrl" placeholder="https://www.youtube.com/watch?v=...">
				</div>
				<div class="small text-muted">
					Supported: YouTube, Vimeo
				</div>
			</div>
			<div class="modal-footer py-2">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-sm btn-primary" id="insertVideoBtn">Insert</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="abbrModal" tabindex="-1">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title">Abbreviation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body py-2">
				<div class="mb-2">
					<label for="abbrText" class="form-label small mb-1">Abbreviation</label>
					<input type="text" class="form-control form-control-sm" id="abbrText" placeholder="e.g. HTML">
				</div>
				<div class="mb-2">
					<label for="abbrTitle" class="form-label small mb-1">Full text (shown on hover)</label>
					<input type="text" class="form-control form-control-sm" id="abbrTitle" placeholder="e.g. HyperText Markup Language">
				</div>
			</div>
			<div class="modal-footer py-2">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-sm btn-primary" id="insertAbbrBtn">Insert</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="shortcutsModal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header py-2">
				<h5 class="modal-title"><i class="bi bi-keyboard me-2"></i>Keyboard Shortcuts</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal"></button>
			</div>
			<div class="modal-body py-2">
				<div class="row">
					<div class="col-6">
						<h6 class="text-muted mb-2">Text Formatting</h6>
						<table class="table table-sm table-borderless mb-3">
							<tr><td><kbd>Ctrl</kbd>+<kbd>B</kbd></td><td>Bold</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>I</kbd></td><td>Italic</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>E</kbd></td><td>Code</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>X</kbd></td><td>Strikethrough</td></tr>
						</table>
						<h6 class="text-muted mb-2">Headings</h6>
						<table class="table table-sm table-borderless mb-3">
							<tr><td><kbd>Ctrl</kbd>+<kbd>Alt</kbd>+<kbd>1-6</kbd></td><td>Heading 1-6</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>Alt</kbd>+<kbd>0</kbd></td><td>Paragraph</td></tr>
						</table>
					</div>
					<div class="col-6">
						<h6 class="text-muted mb-2">Lists & Blocks</h6>
						<table class="table table-sm table-borderless mb-3">
							<tr><td><kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>7</kbd></td><td>Ordered list</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>8</kbd></td><td>Bullet list</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>9</kbd></td><td>Task list</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>B</kbd></td><td>Blockquote</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>Alt</kbd>+<kbd>C</kbd></td><td>Code block</td></tr>
						</table>
						<h6 class="text-muted mb-2">General</h6>
						<table class="table table-sm table-borderless mb-3">
							<tr><td><kbd>Ctrl</kbd>+<kbd>Z</kbd></td><td>Undo</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>Shift</kbd>+<kbd>Z</kbd></td><td>Redo</td></tr>
							<tr><td><kbd>Ctrl</kbd>+<kbd>A</kbd></td><td>Select all</td></tr>
							<tr><td><kbd>Shift</kbd>+<kbd>Enter</kbd></td><td>Hard break ↵</td></tr>
						</table>
						<h6 class="text-muted mb-2">Definition Lists</h6>
						<table class="table table-sm table-borderless">
							<tr><td><kbd>Enter</kbd> (in term)</td><td>Go to definition</td></tr>
							<tr><td><kbd>Shift</kbd>+<kbd>Enter</kbd> (term)</td><td>Add another term</td></tr>
							<tr><td><kbd>Shift</kbd>+<kbd>Enter</kbd> (def)</td><td>Add another definition</td></tr>
							<tr><td><kbd>Enter</kbd> (empty def)</td><td>New term+def pair</td></tr>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer py-2">
				<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

</div>

<script type="importmap">
{
	"imports": {
		"@tiptap/core": "https://esm.sh/@tiptap/core@2",
		"@tiptap/starter-kit": "https://esm.sh/@tiptap/starter-kit@2",
		"@tiptap/extension-code-block": "https://esm.sh/@tiptap/extension-code-block@2",
		"@tiptap/extension-highlight": "https://esm.sh/@tiptap/extension-highlight@2",
		"@tiptap/extension-subscript": "https://esm.sh/@tiptap/extension-subscript@2",
		"@tiptap/extension-superscript": "https://esm.sh/@tiptap/extension-superscript@2",
		"@tiptap/extension-link": "https://esm.sh/@tiptap/extension-link@2",
		"@tiptap/extension-placeholder": "https://esm.sh/@tiptap/extension-placeholder@2",
		"@tiptap/extension-image": "https://esm.sh/@tiptap/extension-image@2",
		"@tiptap/extension-table": "https://esm.sh/@tiptap/extension-table@2",
		"@tiptap/extension-table-row": "https://esm.sh/@tiptap/extension-table-row@2",
		"@tiptap/extension-table-cell": "https://esm.sh/@tiptap/extension-table-cell@2",
		"@tiptap/extension-table-header": "https://esm.sh/@tiptap/extension-table-header@2",
		"@tiptap/extension-task-list": "https://esm.sh/@tiptap/extension-task-list@2",
		"@tiptap/extension-task-item": "https://esm.sh/@tiptap/extension-task-item@2",
		"@tiptap/extension-bullet-list": "https://esm.sh/@tiptap/extension-bullet-list@2",
		"@tiptap/extension-list-item": "https://esm.sh/@tiptap/extension-list-item@2",
		"@tiptap/extension-hard-break": "https://esm.sh/@tiptap/extension-hard-break@2",
		"@djot/djot": "https://esm.sh/@djot/djot@0",
		"djot-grammars/djot-kit.js": "https://esm.sh/gh/php-collective/djot-grammars@761c487/tiptap/djot-kit.js?external=@tiptap/core,@tiptap/starter-kit,@tiptap/extension-code-block,@tiptap/extension-highlight,@tiptap/extension-subscript,@tiptap/extension-superscript,@tiptap/extension-link,@tiptap/extension-image,@tiptap/extension-table,@tiptap/extension-table-row,@tiptap/extension-table-cell,@tiptap/extension-table-header,@tiptap/extension-task-list,@tiptap/extension-task-item,@tiptap/extension-bullet-list,@tiptap/extension-list-item,@tiptap/extension-hard-break",
		"djot-grammars/serializer.js": "https://esm.sh/gh/php-collective/djot-grammars@761c487/tiptap/serializer.js"
	}
}
</script>

<script type="module">
import { Editor } from '@tiptap/core';
import Placeholder from '@tiptap/extension-placeholder';
import * as djot from '@djot/djot';

// Import DjotKit and serializer from djot-grammars via jsdelivr CDN
import { DjotKit } from 'djot-grammars/djot-kit.js';
import { serializeToDjot } from 'djot-grammars/serializer.js';

const initialContent = `
	<h1>Djot WYSIWYG Demo</h1>
	<p>This is a <strong>WYSIWYG editor</strong> that outputs <em>Djot markup</em>.</p>

	<h2>Features</h2>
	<ul>
		<li><strong>Strong</strong> → <code>*text*</code></li>
		<li><em>Emphasis</em> → <code>_text_</code></li>
		<li><mark>Highlight</mark> → <code>{=text=}</code></li>
		<li><span class="djot-delete">Delete</span> → <code>{-text-}</code></li>
		<li><span class="djot-insert">Insert</span> → <code>{+text+}</code></li>
	</ul>

	<h2>Code Example</h2>
	<pre><code class="language-php">&lt;?php
echo "Hello, Djot!";</code></pre>

	<h2>Task List</h2>
	<ul class="task-list">
		<li><input type="checkbox" checked> Learn Djot syntax</li>
		<li><input type="checkbox" checked> Try the WYSIWYG editor</li>
		<li><input type="checkbox"> Share with others</li>
	</ul>

	<h2>Table</h2>
	<table>
		<tr><th>Feature</th><th>Status</th></tr>
		<tr><td>Tables</td><td>✓</td></tr>
		<tr><td>Task lists</td><td>✓</td></tr>
		<tr><td>Code blocks</td><td>✓</td></tr>
	</table>

	<div class="djot-div tip">
		<p>This is a tip container using the <code>DjotDiv</code> extension.</p>
	</div>

	<h2>Definition List</h2>
	<dl>
		<dt>Djot</dt>
		<dd><p>A modern markup language with clean syntax.</p></dd>
		<dt>Tiptap</dt>
		<dd><p>A headless editor framework for the web.</p></dd>
	</dl>

	<p>Edit the content above and see the Djot output below!</p>
`;

const convertUrl = <?= json_encode($this->Url->build(['action' => 'convert'])) ?>;

let currentTab = 'djot';
let editor;
let convertTimer;
let lastResult = { djot: '', html: '' };
// Preview renderer: 'php' renders on the server (djot-php, sanitized, nested
// `data-source-line` anchors); 'js' renders in the browser with djot.js
// (instant, inline-level `data-startpos` tooltips, top-level sync only).
let renderEngine = 'php';

editor = new Editor({
	element: document.getElementById('tiptap-editor'),
	extensions: [
		DjotKit,
		Placeholder.configure({ placeholder: 'Start typing...' }),
	],
	content: initialContent,
	onUpdate: () => {
		invalidatePositions();
		scheduleConvert();
		updateToolbarState();
	},
	onSelectionUpdate: () => {
		updateToolbarState();
		updateCodeLanguageDropdown();
		updateTableControls();
		scheduleCursorSync();
	},
});

window.tiptapEditor = editor;

// --- Source-position mapping (djot.js sourcePositions) -------------------
//
// The serialized Djot text is re-parsed with `sourcePositions: true`, which
// attaches {start, end} = {line, col, offset} ranges to every AST node
// (blocks AND inlines). Top-level PM nodes and top-level Djot AST nodes
// correspond 1:1 by index (the serializer emits them in order), which gives:
//   - forward sync: TipTap cursor -> highlight the block's full source line
//     range in the Djot Output tab / its element in the Rendered Preview tab
//   - reverse sync: click a rendered element -> select the matching block in
//     the TipTap editor (offset containment on top-level ranges)
// The rendered preview also exposes djot.js's data-startpos/data-endpos on
// every element; hover any element (inlines included) to see its exact
// line:col:offset range as a tooltip.
let positionsCache = null;

function invalidatePositions() {
	positionsCache = null;
}

function getPositions() {
	if (positionsCache) {
		return positionsCache;
	}
	const text = serializeToDjot(editor.getJSON());
	let ast = null;
	try {
		ast = djot.parse(text, { sourcePositions: true });
	} catch (e) {
		ast = null;
	}
	positionsCache = { text, ast, blocks: ast ? flattenBlocks(ast.children) : [] };

	return positionsCache;
}

// djot.js wraps headings and their content into nested `section` AST nodes;
// the ProseMirror document is flat. Flattening sections restores the 1:1
// index correspondence between PM top-level nodes and Djot blocks.
function flattenBlocks(children) {
	const out = [];
	for (const node of children || []) {
		if (node.tag === 'section') {
			out.push(...flattenBlocks(node.children));
		} else {
			out.push(node);
		}
	}

	return out;
}

function escapeHtml(text) {
	const div = document.createElement('div');
	div.textContent = text;

	return div.innerHTML;
}

// --- Nested cursor sync via server-side data-source-line anchors -----------
//
// Used in `php` render mode. Top-level ProseMirror nodes correspond 1:1 by
// index to the preview's top-level block elements (sections are flattened);
// deeper levels are matched by descending the ProseMirror ancestor path
// against the preview's block children, so a cursor inside a quoted list
// item resolves to that exact element rather than its top-level container.

// Top-level preview blocks in document order, sections flattened (headings
// get wrapped in <section> by the renderer; the PM document is flat).
function flatBlocks() {
	const renderedEl = document.getElementById('output-rendered');
	const out = [];
	const walk = (container) => {
		for (const el of container.children) {
			// The footnotes section renders at the bottom with mid-document
			// source lines and has no ProseMirror counterpart - skip it so
			// the index mapping stays 1:1 with the editor document.
			if (el.tagName === 'SECTION' && el.getAttribute('role') === 'doc-endnotes') {
				continue;
			}
			if (el.tagName === 'SECTION') {
				walk(el);
			} else {
				out.push(el);
			}
		}
	};
	walk(renderedEl);

	return out;
}

// Block-level element children of a preview node (skips inline markup and
// non-content wrappers like task-list checkboxes/labels).
const BLOCK_TAGS = new Set(['P', 'UL', 'OL', 'LI', 'DL', 'DT', 'DD', 'BLOCKQUOTE', 'PRE', 'DIV', 'TABLE', 'H1', 'H2', 'H3', 'H4', 'H5', 'H6', 'FIGURE', 'ASIDE', 'HR', 'DETAILS']);

function blockChildren(el) {
	return [...el.children].filter(child => BLOCK_TAGS.has(child.tagName));
}

// A tight list item renders its lead paragraph as bare inline content inside
// the <li>; its block-element children then correspond to PM child indexes
// shifted by one (PM index 0 is the omitted lead paragraph).
function hasBareLeadText(el) {
	if (el.tagName !== 'LI') {
		return false;
	}
	for (const node of el.childNodes) {
		if (node.nodeType === Node.TEXT_NODE) {
			if (node.textContent.trim() !== '') {
				return true;
			}
			continue;
		}
		if (node.nodeType !== Node.ELEMENT_NODE) {
			continue;
		}
		if (BLOCK_TAGS.has(node.tagName)) {
			return false;
		}
		// Task-list checkbox chrome does not count as lead text.
		if (node.tagName === 'INPUT' || node.tagName === 'LABEL') {
			continue;
		}

		return true;
	}

	return false;
}

// Deepest preview element for the current editor selection. Structure
// mismatches (e.g. task items whose text is not wrapped) gracefully stop at
// the last matching level. Returns an element carrying data-source-line.
function selectionBlockEl() {
	const $anchor = editor.state.selection.$anchor;
	const blocks = flatBlocks();
	let el = blocks[$anchor.index(0)];
	if (!el) {
		return null;
	}
	for (let depth = 1; depth <= $anchor.depth; depth++) {
		const kids = blockChildren(el);
		let idx = $anchor.index(depth);
		if (hasBareLeadText(el)) {
			// Cursor in the omitted lead paragraph: the <li> itself is the
			// deepest matching preview element.
			if (idx === 0) {
				break;
			}
			idx -= 1;
		}
		if (idx >= kids.length) {
			break;
		}
		el = kids[idx];
	}
	while (el && !el.hasAttribute('data-source-line')) {
		el = el.parentElement && el.parentElement.closest('[data-source-line]');
	}

	return el;
}

// Source line range [start, end] of an anchored preview element: from its own
// anchor up to (excluding) the next anchor in document order with a later line.
function elementLineRange(el) {
	if (!el || !el.hasAttribute('data-source-line')) {
		return null;
	}
	const start = parseInt(el.getAttribute('data-source-line'), 10);
	if (isNaN(start)) {
		return null;
	}
	let end = (lastResult.djot || '').split('\n').length;
	const anchors = [...document.getElementById('output-rendered').querySelectorAll('[data-source-line]')];
	for (let i = anchors.indexOf(el) + 1; i < anchors.length; i++) {
		const line = parseInt(anchors[i].getAttribute('data-source-line'), 10);
		if (!isNaN(line) && line > start) {
			end = line - 1;
			break;
		}
	}

	return { start, end: Math.max(start, end), el };
}

// --- Preview rendering ----------------------------------------------------
//
// Two interchangeable renderers, switchable in the output header:
//   php - the server `convert` endpoint (djot-php with its sourceLines
//         option). The preview HTML carries `data-source-line` anchors on
//         block elements INCLUDING NESTED ONES (blocks inside quotes, divs,
//         list items, footnote and definition bodies, plus li/dt/dd), which
//         is what makes nested cursor sync possible.
//   js  - djot.js in the browser: instant, and its `data-startpos` anchors
//         cover inline elements too (hover any element for its exact
//         line:col:offset). Sync stays TOP-LEVEL only here, because djot.js
//         end positions of lazy-closing containers overshoot into the next
//         block (djot.js issue 141), so nested containment is unreliable.
let requestSeq = 0;

function scheduleConvert() {
	clearTimeout(convertTimer);
	// Client render is instant; only the server round-trip needs a real debounce.
	convertTimer = setTimeout(convert, renderEngine === 'js' ? 50 : 300);
}

async function convert() {
	const doc = editor.getJSON();
	const djotText = serializeToDjot(doc);
	// Guard against out-of-order responses: only the latest request may update output.
	const seq = ++requestSeq;
	if (renderEngine === 'js') {
		try {
			const { ast } = getPositions();
			lastResult = { djot: djotText, html: ast ? djot.renderHTML(ast) : '' };
		} catch (e) {
			lastResult = { djot: djotText, html: '<div class="alert alert-danger">' + escapeHtml(e.message) + '</div>' };
		}
		renderOutput();

		return;
	}
	try {
		const response = await fetch(convertUrl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
			body: new URLSearchParams({ djot: djotText }),
		});
		const result = await response.json();
		if (seq !== requestSeq) {
			return;
		}
		lastResult = result.error
			? { djot: djotText, html: '<div class="alert alert-danger">' + escapeHtml(result.error) + '</div>' }
			: { djot: djotText, html: result.html || '' };
	} catch (e) {
		if (seq !== requestSeq) {
			return;
		}
		lastResult = { djot: djotText, html: '<div class="alert alert-danger">Request failed: ' + escapeHtml(e.message) + '</div>' };
	}
	renderOutput();
}

function renderOutput() {
	// One span per line so cursor-follow can highlight a line range.
	document.getElementById('output-djot').innerHTML = (lastResult.djot || '').split('\n')
		.map((line, i) => `<span class="src-line" data-line="${i + 1}">${escapeHtml(line)}\n</span>`)
		.join('');
	const renderedEl = document.getElementById('output-rendered');
	renderedEl.innerHTML = lastResult.html || '<span class="text-muted">No output</span>';
	if (renderEngine === 'js') {
		// Tooltip with the exact source range on every positioned element,
		// inline elements included - hover to inspect.
		renderedEl.querySelectorAll('[data-startpos]').forEach(el => {
			el.title = 'source ' + el.getAttribute('data-startpos') + ' → ' + el.getAttribute('data-endpos');
		});
	}
	// Debug views: HTML as text (without the internal scroll-sync anchors)
	// and the raw ProseMirror document.
	document.getElementById('output-html').textContent = (lastResult.html || '')
		.replace(/ data-source-line="\d+"/g, '')
		.replace(/ data-(?:startpos|endpos)="[^"]*"/g, '');
	document.getElementById('output-json').textContent = JSON.stringify(editor.getJSON(), null, 2);
	scheduleCursorSync();
}

// Forward sync: TipTap cursor -> highlight in the active output tab.
let cursorSyncScheduled = false;

function scheduleCursorSync() {
	if (cursorSyncScheduled || (currentTab !== 'djot' && currentTab !== 'rendered')) {
		return;
	}
	cursorSyncScheduled = true;
	requestAnimationFrame(() => {
		cursorSyncScheduled = false;
		syncCursorHighlight();
	});
}

function topLevelAstNode() {
	const { blocks } = getPositions();
	if (!blocks.length) {
		return null;
	}
	const index = editor.state.selection.$anchor.index(0);
	const node = blocks[index];
	if (!node || !node.pos) {
		return null;
	}
	// djot.js end positions can overshoot into the following blank line /
	// next block (observed with tables); clamp to the next block's start.
	const next = blocks[index + 1];
	let endLine = node.pos.end.line;
	if (next && next.pos && next.pos.start.line <= endLine) {
		endLine = Math.max(node.pos.start.line, next.pos.start.line - 2);
	}

	return { node, endLine };
}

// Scroll only within the output pane - scrollIntoView would also scroll the
// page itself (e.g. jumping down to the output panel on initial load).
function scrollPaneTo(outputEl, el) {
	const offset = el.getBoundingClientRect().top - outputEl.getBoundingClientRect().top + outputEl.scrollTop;
	outputEl.scrollTop = Math.max(0, offset - outputEl.clientHeight / 3);
}

// Current cursor target, per renderer: `php` resolves the deepest anchored
// preview element (nested), `js` the top-level Djot AST block. Both yield a
// source line range plus the preview element to highlight.
function cursorTarget() {
	if (renderEngine === 'php') {
		return elementLineRange(selectionBlockEl());
	}
	const target = topLevelAstNode();
	if (!target) {
		return null;
	}
	const sp = target.node.pos.start;
	const el = document.getElementById('output-rendered')
		.querySelector(`[data-startpos="${sp.line}:${sp.col}:${sp.offset}"]`);

	return { start: sp.line, end: target.endLine, el };
}

function syncCursorHighlight() {
	const range = cursorTarget();
	if (!range) {
		return;
	}
	if (currentTab === 'djot') {
		const sourceEl = document.getElementById('output-djot');
		sourceEl.querySelectorAll('.src-line-active').forEach(el => el.classList.remove('src-line-active'));
		let firstLine = null;
		for (let line = range.start; line <= range.end; line++) {
			const el = sourceEl.querySelector(`.src-line[data-line="${line}"]`);
			if (!el || (line > range.start && line === range.end && el.textContent.trim() === '')) {
				continue;
			}
			el.classList.add('src-line-active');
			firstLine = firstLine || el;
		}
		if (firstLine && editor.isFocused) {
			scrollPaneTo(sourceEl, firstLine);
		}
	} else if (currentTab === 'rendered') {
		const renderedEl = document.getElementById('output-rendered');
		renderedEl.querySelectorAll('.pos-active').forEach(el => el.classList.remove('pos-active'));
		if (range.el) {
			range.el.classList.add('pos-active');
			if (editor.isFocused) {
				scrollPaneTo(renderedEl, range.el);
			}
		}
	}
}

// Resolve a clicked preview element to a ProseMirror position.
//   php - walk up to the top-level block recording the child-index path, so
//         a nested block maps to the matching nested PM node.
//   js  - top-level only, matched by start offsets (see the comment inside).
function clickTargetPos(target) {
	if (renderEngine === 'php') {
		const anchorEl = target.closest('[data-source-line]');
		if (!anchorEl) {
			return null;
		}
		const blocks = flatBlocks();
		const renderedEl = document.getElementById('output-rendered');
		let top = anchorEl;
		const path = [];
		while (top && top.parentElement && !blocks.includes(top)) {
			const parent = top.parentElement === renderedEl || top.parentElement.tagName === 'SECTION'
				? null
				: top.parentElement;
			if (!parent) {
				break;
			}
			const idx = blockChildren(parent).indexOf(top);
			if (idx < 0) {
				// Non-block wrapper in between - fall back to the block level.
				path.length = 0;
				top = top.closest('[data-source-line]');
				break;
			}
			// Tight <li>: PM child 0 is the omitted lead paragraph, so DOM block
			// children start at PM index 1.
			path.unshift(hasBareLeadText(parent) ? idx + 1 : idx);
			top = parent;
		}
		while (top && top !== renderedEl && !blocks.includes(top)) {
			path.length = 0;
			top = top.parentElement;
		}
		const index = blocks.indexOf(top);
		if (index < 0 || index >= editor.state.doc.childCount) {
			return null;
		}
		// Walk the PM document along the recorded path (bounds-guarded; a
		// structure mismatch just stops at the deepest matching node).
		let pmPos = 0;
		for (let i = 0; i < index; i++) {
			pmPos += editor.state.doc.child(i).nodeSize;
		}
		let node = editor.state.doc.child(index);
		for (const idx of path) {
			if (idx >= node.childCount) {
				break;
			}
			let off = pmPos + 1;
			for (let i = 0; i < idx; i++) {
				off += node.child(i).nodeSize;
			}
			node = node.child(idx);
			pmPos = off;
		}

		return { pmPos, node };
	}
	const el = target.closest('[data-startpos]');
	if (!el) {
		return null;
	}
	const offset = parseInt(el.getAttribute('data-startpos').split(':')[2], 10);
	const { blocks } = getPositions();
	if (!blocks.length || isNaN(offset)) {
		return null;
	}
	// Match by start offsets only: djot.js end positions of lazy-closing
	// containers (lists, tables, dl) overshoot into the next block, so
	// range containment would attribute the next block's start to them.
	// The last block starting at or before the clicked offset is the owner.
	let index = -1;
	for (let i = 0; i < blocks.length; i++) {
		if (blocks[i].pos && blocks[i].pos.start.offset <= offset) {
			index = i;
		} else {
			break;
		}
	}
	if (index < 0 || index >= editor.state.doc.childCount) {
		return null;
	}
	let pmPos = 0;
	for (let i = 0; i < index; i++) {
		pmPos += editor.state.doc.child(i).nodeSize;
	}

	return { pmPos, node: editor.state.doc.child(index) };
}

// Reverse sync: click a rendered element -> select that block in TipTap.
document.getElementById('output-rendered').addEventListener('click', (e) => {
	// Leave native interactive controls (details/summary toggles, checkboxes,
	// copy buttons, ...) fully functional - no editor jump.
	if (e.target.closest('summary, input, button, select, textarea, label, audio, video')) {
		return;
	}
	// Only links need their default cancelled, so the preview never
	// navigates away; the click still selects the block in the editor.
	if (e.target.closest('a')) {
		e.preventDefault();
	}
	const hit = clickTargetPos(e.target);
	if (!hit) {
		return;
	}
	const { pmPos, node } = hit;
	// Focus the first text position inside the node - focusing a block-only
	// position (table, definition list) triggers ProseMirror warnings.
	let focusPos = pmPos + 1;
	if (!node.isTextblock) {
		let found = false;
		editor.state.doc.nodesBetween(pmPos, pmPos + node.nodeSize, (n, pos) => {
			if (!found && n.isTextblock) {
				focusPos = pos + 1;
				found = true;
			}

			return !found;
		});
	}
	editor.chain().focus(focusPos).run();
	// Navigate visually too: scroll the editor pane to the selected block.
	// Pane-internal only - the page itself must not move.
	requestAnimationFrame(() => {
		const dom = editor.view.domAtPos(editor.state.selection.anchor).node;
		const el = dom.nodeType === Node.ELEMENT_NODE ? dom : dom.parentElement;
		if (el) {
			scrollPaneTo(document.getElementById('tiptap-editor'), el);
		}
	});
});

function updateToolbarState() {
	document.querySelectorAll('#menubar button[data-cmd]').forEach(btn => {
		const cmd = btn.dataset.cmd;
		let isActive = false;

		switch (cmd) {
			case 'bold': isActive = editor.isActive('bold'); break;
			case 'italic': isActive = editor.isActive('italic'); break;
			case 'code': isActive = editor.isActive('code'); break;
			case 'highlight': isActive = editor.isActive('highlight'); break;
			case 'strike': isActive = editor.isActive('strike'); break;
			case 'djotInsert': isActive = editor.isActive('djotInsert'); break;
			case 'djotDelete': isActive = editor.isActive('djotDelete'); break;
			case 'superscript': isActive = editor.isActive('superscript'); break;
			case 'subscript': isActive = editor.isActive('subscript'); break;
			case 'bulletList': isActive = editor.isActive('bulletList'); break;
			case 'orderedList': isActive = editor.isActive('orderedList'); break;
			case 'taskList': isActive = editor.isActive('taskList'); break;
			case 'definitionList': isActive = editor.isActive('definitionList'); break;
			case 'blockquote': isActive = editor.isActive('blockquote'); break;
			case 'codeBlock': isActive = editor.isActive('codeBlock'); break;
			case 'link': isActive = editor.isActive('link'); break;
		}

		btn.classList.toggle('is-active', isActive);
	});

	// Update block type dropdown
	const blockType = document.getElementById('blockType');
	if (editor.isActive('heading', { level: 1 })) blockType.value = 'heading1';
	else if (editor.isActive('heading', { level: 2 })) blockType.value = 'heading2';
	else if (editor.isActive('heading', { level: 3 })) blockType.value = 'heading3';
	else if (editor.isActive('heading', { level: 4 })) blockType.value = 'heading4';
	else if (editor.isActive('heading', { level: 5 })) blockType.value = 'heading5';
	else if (editor.isActive('heading', { level: 6 })) blockType.value = 'heading6';
	else blockType.value = 'paragraph';
}

function updateCodeLanguageDropdown() {
	const selector = document.getElementById('code-language-selector');
	const select = document.getElementById('codeLanguage');

	if (editor.isActive('codeBlock')) {
		// Show and position the floating selector
		const attrs = editor.getAttributes('codeBlock');
		select.value = attrs.language || '';

		// Find the current code block element in the editor
		const { $from } = editor.state.selection;
		const codeBlockPos = $from.before($from.depth);
		const domNode = editor.view.nodeDOM(codeBlockPos);

		if (domNode && domNode.tagName === 'PRE') {
			const editorEl = document.getElementById('tiptap-editor');
			const editorRect = editorEl.getBoundingClientRect();
			const codeRect = domNode.getBoundingClientRect();

			// Position above the code block, aligned to its right edge
			selector.style.display = 'block';
			selector.style.top = (codeRect.top - editorRect.top + editorEl.offsetTop - selector.offsetHeight - 4) + 'px';
			selector.style.left = (codeRect.right - editorRect.left - selector.offsetWidth - 8) + 'px';
			selector.style.right = 'auto';
		}
	} else {
		// Hide when not in code block
		selector.style.display = 'none';
	}
}

function updateTableControls() {
	const controls = document.getElementById('table-controls');

	if (editor.isActive('table')) {
		// Find the table element
		const tableEl = document.querySelector('#tiptap-editor .tiptap table');
		if (tableEl) {
			const editorEl = document.getElementById('tiptap-editor');
			const editorRect = editorEl.getBoundingClientRect();
			const tableRect = tableEl.getBoundingClientRect();

			// Position above the table, aligned to its right edge
			controls.style.display = 'flex';
			controls.style.top = (tableRect.top - editorRect.top + editorEl.offsetTop - controls.offsetHeight - 4) + 'px';
			controls.style.left = (tableRect.right - editorRect.left - controls.offsetWidth - 8) + 'px';
		}
	} else {
		controls.style.display = 'none';
	}
}

// Code language dropdown - only update when already in code block
document.getElementById('codeLanguage').addEventListener('change', (e) => {
	const language = e.target.value;
	if (editor.isActive('codeBlock')) {
		editor.chain().focus().updateAttributes('codeBlock', { language }).run();
	}
});

// Block type dropdown (headings/paragraph)
document.getElementById('blockType').addEventListener('change', (e) => {
	const value = e.target.value;
	if (value === 'paragraph') {
		editor.chain().focus().setParagraph().run();
	} else {
		const level = parseInt(value.replace('heading', ''));
		editor.chain().focus().toggleHeading({ level }).run();
	}
});

// Table controls
document.querySelectorAll('#table-controls button[data-table-cmd]').forEach(btn => {
	btn.addEventListener('click', () => {
		const cmd = btn.dataset.tableCmd;
		switch (cmd) {
			case 'addColumnAfter': editor.chain().focus().addColumnAfter().run(); break;
			case 'deleteColumn': editor.chain().focus().deleteColumn().run(); break;
			case 'addRowAfter': editor.chain().focus().addRowAfter().run(); break;
			case 'deleteRow': editor.chain().focus().deleteRow().run(); break;
			case 'deleteTable': editor.chain().focus().deleteTable().run(); break;
		}
		updateTableControls();
	});
});

// Toolbar commands
document.querySelectorAll('#menubar button[data-cmd]').forEach(btn => {
	btn.addEventListener('click', () => {
		const cmd = btn.dataset.cmd;

		switch (cmd) {
			case 'bold': editor.chain().focus().toggleBold().run(); break;
			case 'italic': editor.chain().focus().toggleItalic().run(); break;
			case 'code': editor.chain().focus().toggleCode().run(); break;
			case 'highlight': editor.chain().focus().toggleHighlight().run(); break;
			case 'strike': editor.chain().focus().toggleStrike().run(); break;
			case 'djotInsert': editor.chain().focus().toggleDjotInsert().run(); break;
			case 'djotDelete': editor.chain().focus().toggleDjotDelete().run(); break;
			case 'superscript': editor.chain().focus().toggleSuperscript().run(); break;
			case 'subscript': editor.chain().focus().toggleSubscript().run(); break;
			case 'abbr': {
				// If cursor is inside an abbreviation, expand selection to full mark
				if (editor.isActive('djotAbbreviation')) {
					editor.chain().focus().extendMarkRange('djotAbbreviation').run();
				}
				// Pre-fill with selected text and existing title if any (get fresh selection after extend)
				const abbrSel = editor.state.selection;
				const abbrSelectedText = editor.state.doc.textBetween(abbrSel.from, abbrSel.to);
				document.getElementById('abbrText').value = abbrSelectedText || '';
				// Check if selection has existing abbreviation mark
				const abbrAttrs = editor.getAttributes('djotAbbreviation');
				document.getElementById('abbrTitle').value = abbrAttrs?.title || '';
				new bootstrap.Modal(document.getElementById('abbrModal')).show();
				break;
			}
			case 'clearFormat':
				editor.chain().focus().unsetAllMarks().clearNodes().run();
				break;
			case 'bulletList': editor.chain().focus().toggleBulletList().run(); break;
			case 'orderedList': editor.chain().focus().toggleOrderedList().run(); break;
			case 'taskList': editor.chain().focus().toggleTaskList().run(); break;
			case 'definitionList':
				editor.chain().focus().insertDefinitionList().run();
				break;
			case 'blockquote': editor.chain().focus().toggleBlockquote().run(); break;
			case 'codeBlock':
				editor.chain().focus().toggleCodeBlock().run();
				break;
			case 'horizontalRule': editor.chain().focus().setHorizontalRule().run(); break;
			case 'link':
				if (editor.isActive('link')) {
					editor.chain().focus().unsetLink().run();
				} else {
					const url = prompt('Enter URL:');
					if (url) editor.chain().focus().setLink({ href: url }).run();
				}
				break;
			case 'image':
				new bootstrap.Modal(document.getElementById('imageModal')).show();
				break;
			case 'video':
				new bootstrap.Modal(document.getElementById('videoModal')).show();
				break;
			case 'divBlock':
				new bootstrap.Modal(document.getElementById('divModal')).show();
				break;
			case 'insertTable':
				editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run();
				break;
			case 'undo': editor.chain().focus().undo().run(); break;
			case 'redo': editor.chain().focus().redo().run(); break;
		}
	});
});

// Tab switching
document.querySelectorAll('.output-tabs button').forEach(btn => {
	btn.addEventListener('click', () => {
		document.querySelectorAll('.output-tabs button').forEach(b => b.classList.remove('active'));
		btn.classList.add('active');
		currentTab = btn.dataset.tab;
		document.getElementById('output-djot').classList.toggle('d-none', currentTab !== 'djot');
		document.getElementById('output-rendered').classList.toggle('d-none', currentTab !== 'rendered');
		document.getElementById('output-html').classList.toggle('d-none', currentTab !== 'html');
		document.getElementById('output-json').classList.toggle('d-none', currentTab !== 'json');
		scheduleCursorSync();
	});
});

// Renderer switch
document.getElementById('renderEngine').addEventListener('change', (e) => {
	renderEngine = e.target.value;
	convert();
});

// Copy button
document.getElementById('copy-btn').addEventListener('click', () => {
	const tabEl = { djot: 'output-djot', rendered: 'output-rendered', html: 'output-html', json: 'output-json' }[currentTab];
	const text = currentTab === 'rendered'
		? (lastResult.html || '')
			.replace(/ data-source-line="\d+"/g, '')
			.replace(/ data-(?:startpos|endpos)="[^"]*"/g, '')
		: document.getElementById(tabEl).textContent;
	navigator.clipboard.writeText(text).then(() => {
		const btn = document.getElementById('copy-btn');
		const originalHtml = btn.innerHTML;
		btn.innerHTML = '<i class="bi bi-check"></i> Copied!';
		btn.classList.remove('btn-outline-secondary');
		btn.classList.add('btn-success');
		setTimeout(() => {
			btn.innerHTML = originalHtml;
			btn.classList.remove('btn-success');
			btn.classList.add('btn-outline-secondary');
		}, 2000);
	});
});

// Image modal
document.getElementById('insertImageBtn').addEventListener('click', () => {
	const url = document.getElementById('imageUrl').value;
	const alt = document.getElementById('imageAlt').value;
	if (url) {
		editor.chain().focus().setImage({ src: url, alt }).run();
	}
	bootstrap.Modal.getInstance(document.getElementById('imageModal')).hide();
	document.getElementById('imageUrl').value = '';
	document.getElementById('imageAlt').value = '';
});

// Div modal
document.getElementById('insertDivBtn').addEventListener('click', () => {
	const type = document.getElementById('divType').value;
	editor.chain().focus().setDjotDiv({ class: type }).run();
	bootstrap.Modal.getInstance(document.getElementById('divModal')).hide();
});

// Video modal
document.getElementById('insertVideoBtn').addEventListener('click', () => {
	const url = document.getElementById('videoUrl').value.trim();
	if (url) {
		const embedData = getVideoEmbed(url);
		if (embedData) {
			editor.chain().focus().setDjotEmbed({
				src: url,
				html: embedData.html,
			}).run();
		}
	}
	bootstrap.Modal.getInstance(document.getElementById('videoModal')).hide();
	document.getElementById('videoUrl').value = '';
});

// Abbreviation modal
document.getElementById('insertAbbrBtn').addEventListener('click', () => {
	const abbrText = document.getElementById('abbrText').value.trim();
	const abbrTitle = document.getElementById('abbrTitle').value.trim();
	if (abbrText && abbrTitle) {
		const { from, to } = editor.state.selection;
		const hasSelection = from !== to;

		// Build the abbr HTML
		const abbrHtml = `<abbr title="${abbrTitle.replace(/"/g, '&quot;')}">${abbrText}</abbr>`;

		if (hasSelection) {
			// Replace selection with abbr
			editor.chain().focus()
				.deleteSelection()
				.insertContent(abbrHtml, { parseOptions: { preserveWhitespace: true } })
				.run();
		} else {
			// Just insert at cursor
			editor.chain().focus()
				.insertContent(abbrHtml, { parseOptions: { preserveWhitespace: true } })
				.run();
		}
	}
	bootstrap.Modal.getInstance(document.getElementById('abbrModal')).hide();
	document.getElementById('abbrText').value = '';
	document.getElementById('abbrTitle').value = '';
});

// Convert video URL to embed HTML
function getVideoEmbed(url) {
	// YouTube
	let match = url.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/);
	if (match) {
		const videoId = match[1];
		return {
			html: `<iframe width="560" height="315" src="https://www.youtube.com/embed/${videoId}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`,
		};
	}

	// Vimeo
	match = url.match(/vimeo\.com\/(\d+)/);
	if (match) {
		const videoId = match[1];
		return {
			html: `<iframe width="560" height="315" src="https://player.vimeo.com/video/${videoId}" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`,
		};
	}

	// Unknown - just use the URL as-is
	alert('Unsupported video URL. Please use YouTube or Vimeo.');
	return null;
}

// Initial render
convert();
updateToolbarState();
</script>
