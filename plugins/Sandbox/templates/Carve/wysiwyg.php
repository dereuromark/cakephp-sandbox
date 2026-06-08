<?php
/**
 * @var \App\View\AppView $this
 */

$this->append('css');
?>
<style>
#tiptap-editor {
	min-height: 360px;
	padding: 20px;
	padding-top: 0;
	border: 1px solid #dee2e6;
	border-top: 0;
	border-radius: 0 0 0.375rem 0.375rem;
	background: #fff;
}
.tiptap {
	outline: none;
	line-height: 1.7;
}
.tiptap > * + * {
	margin-top: 0.75em;
}
.tiptap h1, .tiptap h2, .tiptap h3, .tiptap h4, .tiptap h5, .tiptap h6 {
	line-height: 1.3;
	padding-top: 0.5em;
}
.tiptap h1 { font-size: 1.8em; }
.tiptap h2 { font-size: 1.5em; }
.tiptap h3 { font-size: 1.25em; }
.tiptap h4 { font-size: 1.1em; }
.tiptap h5 { font-size: 1em; font-weight: 600; }
.tiptap h6 { font-size: 0.9em; font-weight: 600; color: #6c757d; }
.tiptap p { margin: 0; }
.tiptap code {
	background: #f8f9fa;
	padding: 3px 6px;
	border-radius: 4px;
	font-family: 'Fira Code', monospace;
	font-size: 0.9em;
}
.tiptap pre {
	background: #212529;
	color: #f8f9fa;
	padding: 16px 20px;
	border-radius: 8px;
	overflow-x: auto;
}
.tiptap pre code { background: none; padding: 0; color: inherit; }
.tiptap blockquote {
	border-left: 4px solid #6c757d;
	margin: 1em 0;
	padding-left: 16px;
	color: #6c757d;
}
.tiptap ul, .tiptap ol { padding-left: 24px; }
.tiptap li { margin: 0.25em 0; }
.tiptap li p { margin: 0; }
.tiptap a { color: #0d6efd; }
.tiptap a:hover { text-decoration: underline; }
.tiptap ul[data-type="taskList"] { list-style: none; padding-left: 0; }
.tiptap ul[data-type="taskList"] li { display: flex; align-items: flex-start; gap: 8px; }
.tiptap ul[data-type="taskList"] li > label { flex-shrink: 0; margin-top: 4px; }
.tiptap ul[data-type="taskList"] input[type="checkbox"] { width: 16px; height: 16px; }
.tiptap mark { background: #fff3cd; padding: 1px 4px; border-radius: 3px; }
.tiptap s { text-decoration: line-through; color: #6c757d; }
.tiptap hr { border: none; border-top: 2px solid #dee2e6; margin: 1.5em 0; }
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
.tiptap th { background: #f8f9fa; font-weight: 600; }
.tiptap .selectedCell { background: rgba(13, 110, 253, 0.1); }
.tiptap p.is-editor-empty:first-child::before {
	content: attr(data-placeholder);
	color: #adb5bd;
	pointer-events: none;
	float: left;
	height: 0;
}
.tiptap-menubar {
	background: #f8f9fa;
	padding: 8px 10px;
	display: flex;
	gap: 4px;
	flex-wrap: wrap;
	border: 1px solid #dee2e6;
	border-radius: 0.375rem 0.375rem 0 0;
}
.tiptap-menubar .btn { padding: 4px 8px; }
.tiptap-menubar .btn.is-active {
	background-color: #0d6efd;
	border-color: #0d6efd;
	color: #fff;
}
.tiptap-menubar .divider {
	width: 1px;
	background: #dee2e6;
	margin: 0 6px;
	align-self: stretch;
}
.output-panel { background: #fff; border: 1px solid #dee2e6; border-radius: 0.375rem; }
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
.output-content { padding: 16px 20px; max-height: 380px; overflow: auto; }
.output-content.source {
	font-family: 'Fira Code', monospace;
	font-size: 13px;
	white-space: pre-wrap;
	color: #495057;
}
.preview-render section { margin-bottom: 1em; }
.preview-render mark { background: #fff3cd; padding: 1px 4px; border-radius: 3px; }
</style>
<?php
$this->end();
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Carve WYSIWYG Editor</h2>
<p>
	A rich text editor powered by <a href="https://tiptap.dev" target="_blank">Tiptap</a> with
	<a href="https://github.com/markup-carve/carve-php" target="_blank">Carve</a> output.
</p>

<div class="alert alert-info py-2">
	<i class="bi bi-info-circle"></i>
	Carve has no published JS serializer yet, so this editor round-trips the editor's HTML
	through the PHP converters (<code>HtmlToCarve</code> then <code>CarveConverter</code>) to
	produce the Carve source and a sanitized preview. Output updates shortly after you stop typing.
</div>

<div class="mb-3">
	<div class="tiptap-menubar" id="menubar">
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="bold" title="Strong *text*"><i class="bi bi-type-bold"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="italic" title="Emphasis /text/"><i class="bi bi-type-italic"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="code" title="Code `text`"><i class="bi bi-code"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="highlight" title="Highlight ==text=="><i class="bi bi-pencil-fill"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="strike" title="Strike ~text~"><i class="bi bi-type-strikethrough"></i></button>
		</div>
		<div class="divider"></div>
		<select class="form-select form-select-sm" id="blockType" style="width: auto; min-width: 110px;" title="Block type">
			<option value="paragraph">Paragraph</option>
			<option value="heading1">Heading 1</option>
			<option value="heading2">Heading 2</option>
			<option value="heading3">Heading 3</option>
			<option value="heading4">Heading 4</option>
		</select>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="bulletList" title="Bullet list"><i class="bi bi-list-ul"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="orderedList" title="Ordered list"><i class="bi bi-list-ol"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="taskList" title="Task list"><i class="bi bi-check2-square"></i></button>
		</div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="blockquote" title="Blockquote"><i class="bi bi-quote"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="codeBlock" title="Code block"><i class="bi bi-file-code"></i></button>
		</div>
		<div class="divider"></div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="link" title="Link"><i class="bi bi-link-45deg"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="horizontalRule" title="Horizontal rule"><i class="bi bi-hr"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="insertTable" title="Insert table"><i class="bi bi-table"></i></button>
		</div>
		<div class="divider"></div>
		<div class="btn-group btn-group-sm" role="group">
			<button type="button" class="btn btn-outline-secondary" data-cmd="undo" title="Undo"><i class="bi bi-arrow-counterclockwise"></i></button>
			<button type="button" class="btn btn-outline-secondary" data-cmd="redo" title="Redo"><i class="bi bi-arrow-clockwise"></i></button>
		</div>
	</div>
	<div id="tiptap-editor"></div>
</div>

<div class="output-panel">
	<div class="output-header">
		<ul class="nav output-tabs" role="tablist">
			<li class="nav-item"><button class="nav-link active" data-tab="carve">Carve Source</button></li>
			<li class="nav-item"><button class="nav-link" data-tab="html">HTML Preview</button></li>
		</ul>
		<div>
			<button type="button" class="btn btn-sm btn-outline-secondary" id="copy-btn"><i class="bi bi-clipboard"></i> Copy</button>
		</div>
	</div>
	<div class="output-content source" id="output-carve"><span class="text-muted">Start typing above...</span></div>
	<div class="output-content preview-render d-none" id="output-html"></div>
</div>

</div>

<script type="importmap">
{
	"imports": {
		"@tiptap/core": "https://esm.sh/@tiptap/core@2",
		"@tiptap/starter-kit": "https://esm.sh/@tiptap/starter-kit@2",
		"@tiptap/extension-highlight": "https://esm.sh/@tiptap/extension-highlight@2",
		"@tiptap/extension-link": "https://esm.sh/@tiptap/extension-link@2",
		"@tiptap/extension-placeholder": "https://esm.sh/@tiptap/extension-placeholder@2",
		"@tiptap/extension-table": "https://esm.sh/@tiptap/extension-table@2",
		"@tiptap/extension-table-row": "https://esm.sh/@tiptap/extension-table-row@2",
		"@tiptap/extension-table-cell": "https://esm.sh/@tiptap/extension-table-cell@2",
		"@tiptap/extension-table-header": "https://esm.sh/@tiptap/extension-table-header@2",
		"@tiptap/extension-task-list": "https://esm.sh/@tiptap/extension-task-list@2",
		"@tiptap/extension-task-item": "https://esm.sh/@tiptap/extension-task-item@2"
	}
}
</script>

<script type="module">
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Highlight from '@tiptap/extension-highlight';
import Link from '@tiptap/extension-link';
import Placeholder from '@tiptap/extension-placeholder';
import Table from '@tiptap/extension-table';
import TableRow from '@tiptap/extension-table-row';
import TableCell from '@tiptap/extension-table-cell';
import TableHeader from '@tiptap/extension-table-header';
import TaskList from '@tiptap/extension-task-list';
import TaskItem from '@tiptap/extension-task-item';

const previewUrl = <?= json_encode($this->Url->build(['action' => 'wysiwygPreview'])) ?>;

const initialContent = `
	<h1>Carve WYSIWYG Demo</h1>
	<p>This is a <strong>WYSIWYG editor</strong> that outputs <em>Carve markup</em>.</p>
	<h2>Features</h2>
	<ul>
		<li><strong>Strong</strong> &rarr; <code>*text*</code></li>
		<li><em>Emphasis</em> &rarr; <code>/text/</code></li>
		<li><mark>Highlight</mark> &rarr; <code>==text==</code></li>
	</ul>
	<h2>Task list</h2>
	<ul data-type="taskList">
		<li data-type="taskItem" data-checked="true"><label><input type="checkbox" checked><span></span></label><div><p>Task lists round-trip to <code>- [x]</code></p></div></li>
		<li data-type="taskItem" data-checked="false"><label><input type="checkbox"><span></span></label><div><p>Toggle the checkbox and watch the source</p></div></li>
	</ul>
	<blockquote><p>Edit the content and watch the Carve source below.</p></blockquote>
	<pre><code class="language-php">echo "Hello, Carve!";</code></pre>
`;

let currentTab = 'carve';
let timer;
let requestSeq = 0;
let lastResult = { carve: '', html: '' };

const editor = new Editor({
	element: document.getElementById('tiptap-editor'),
	extensions: [
		StarterKit,
		Highlight,
		Link.configure({ openOnClick: false }),
		Placeholder.configure({ placeholder: 'Start typing...' }),
		Table.configure({ resizable: false }),
		TableRow,
		TableHeader,
		TableCell,
		TaskList,
		TaskItem.configure({ nested: true }),
	],
	content: initialContent,
	onUpdate: () => {
		scheduleConvert();
		updateToolbarState();
	},
	onSelectionUpdate: updateToolbarState,
});

window.tiptapEditor = editor;

function scheduleConvert() {
	clearTimeout(timer);
	timer = setTimeout(convert, 300);
}

async function convert() {
	// Guard against out-of-order responses: only the latest request may update output.
	const seq = ++requestSeq;
	const data = new URLSearchParams({ html: editor.getHTML() });
	try {
		const response = await fetch(previewUrl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
			body: data,
		});
		const result = await response.json();
		if (seq !== requestSeq) {
			return;
		}
		if (result.error) {
			lastResult = { carve: 'Error: ' + result.error, html: '<div class="alert alert-danger">' + escapeHtml(result.error) + '</div>' };
		} else {
			lastResult = { carve: result.carve || '', html: result.html || '' };
		}
	} catch (e) {
		if (seq !== requestSeq) {
			return;
		}
		lastResult = { carve: 'Request failed: ' + e.message, html: '' };
	}
	renderOutput();
}

function renderOutput() {
	const carveEl = document.getElementById('output-carve');
	const htmlEl = document.getElementById('output-html');
	carveEl.textContent = lastResult.carve || '';
	htmlEl.innerHTML = lastResult.html || '<span class="text-muted">No output</span>';
}

function escapeHtml(text) {
	const div = document.createElement('div');
	div.textContent = text;
	return div.innerHTML;
}

function updateToolbarState() {
	document.querySelectorAll('#menubar button[data-cmd]').forEach(btn => {
		const cmd = btn.dataset.cmd;
		const markMap = { bold: 'bold', italic: 'italic', code: 'code', highlight: 'highlight', strike: 'strike', bulletList: 'bulletList', orderedList: 'orderedList', taskList: 'taskList', blockquote: 'blockquote', codeBlock: 'codeBlock', link: 'link' };
		if (markMap[cmd]) {
			btn.classList.toggle('is-active', editor.isActive(markMap[cmd]));
		}
	});
	const blockType = document.getElementById('blockType');
	if (editor.isActive('heading', { level: 1 })) blockType.value = 'heading1';
	else if (editor.isActive('heading', { level: 2 })) blockType.value = 'heading2';
	else if (editor.isActive('heading', { level: 3 })) blockType.value = 'heading3';
	else if (editor.isActive('heading', { level: 4 })) blockType.value = 'heading4';
	else blockType.value = 'paragraph';
}

document.getElementById('blockType').addEventListener('change', (e) => {
	const value = e.target.value;
	if (value === 'paragraph') {
		editor.chain().focus().setParagraph().run();
	} else {
		editor.chain().focus().toggleHeading({ level: parseInt(value.replace('heading', ''), 10) }).run();
	}
});

document.querySelectorAll('#menubar button[data-cmd]').forEach(btn => {
	btn.addEventListener('click', () => {
		const cmd = btn.dataset.cmd;
		const chain = editor.chain().focus();
		switch (cmd) {
			case 'bold': chain.toggleBold().run(); break;
			case 'italic': chain.toggleItalic().run(); break;
			case 'code': chain.toggleCode().run(); break;
			case 'highlight': chain.toggleHighlight().run(); break;
			case 'strike': chain.toggleStrike().run(); break;
			case 'bulletList': chain.toggleBulletList().run(); break;
			case 'orderedList': chain.toggleOrderedList().run(); break;
			case 'taskList': chain.toggleTaskList().run(); break;
			case 'blockquote': chain.toggleBlockquote().run(); break;
			case 'codeBlock': chain.toggleCodeBlock().run(); break;
			case 'horizontalRule': chain.setHorizontalRule().run(); break;
			case 'insertTable': chain.insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run(); break;
			case 'undo': chain.undo().run(); break;
			case 'redo': chain.redo().run(); break;
			case 'link':
				if (editor.isActive('link')) {
					chain.unsetLink().run();
				} else {
					const url = prompt('Enter URL:');
					if (url) chain.setLink({ href: url }).run();
				}
				break;
		}
	});
});

document.querySelectorAll('.output-tabs button').forEach(btn => {
	btn.addEventListener('click', () => {
		document.querySelectorAll('.output-tabs button').forEach(b => b.classList.remove('active'));
		btn.classList.add('active');
		currentTab = btn.dataset.tab;
		document.getElementById('output-carve').classList.toggle('d-none', currentTab !== 'carve');
		document.getElementById('output-html').classList.toggle('d-none', currentTab !== 'html');
	});
});

document.getElementById('copy-btn').addEventListener('click', () => {
	const text = currentTab === 'carve' ? lastResult.carve : lastResult.html;
	navigator.clipboard.writeText(text || '').then(() => {
		const btn = document.getElementById('copy-btn');
		const original = btn.innerHTML;
		btn.innerHTML = '<i class="bi bi-check"></i> Copied!';
		setTimeout(() => { btn.innerHTML = original; }, 1500);
	});
});

convert();
updateToolbarState();
</script>
