<?php
/**
 * @var \App\View\AppView $this
 * @var bool $debugMode
 */

$defaultCarve = <<<'CARVE'
# Carve AST

A paragraph with *strong*, /emphasis/ and a [link](https://example.org).

::: note
Admonitions are divs carrying a class.
:::

- one
- two

|= Lang |= Engine    |
| PHP   | carve-php  |
| JS    | carve-js   |

A footnote reference[^a] and its definition.

[^a]: The definition is a block node in the tree.
CARVE;

$defaultTree = <<<'JSON'
{
  "type": "document",
  "srcByteLength": 44,
  "children": [
    {
      "type": "heading",
      "level": 2,
      "children": [{ "type": "text", "value": "Pasted from another engine" }]
    },
    {
      "type": "paragraph",
      "children": [
        { "type": "text", "value": "Field names are pinned by " },
        { "type": "code", "value": "PART 12" },
        { "type": "text", "value": "." }
      ]
    }
  ]
}
JSON;
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>AST Inspector</h2>
<p>
	The parsed document as JSON, in the shape
	<a href="https://github.com/markup-carve/carve" target="_blank">PART 12</a> of the spec pins.
	Until now the tree was reachable only as PHP objects, so anything that is not
	"source to HTML" had to render HTML and parse it back. This is what editors,
	linters and structural diffing actually want.
</p>

<div class="alert alert-info py-2 small">
	<i class="bi bi-info-circle"></i>
	Same shape as <code>bin/carve --json</code> (and <code>--from-json</code> for the
	other direction). Because the field names are spec-pinned rather than
	engine-private, a tree produced by <strong>carve-js</strong> or
	<strong>carve-rs</strong> decodes here - and one this decoder would lose fields
	from is rejected outright instead of being silently read as a different document.
</div>

<h4>Carve <i class="bi bi-arrow-right"></i> AST</h4>

<div class="row">
	<div class="col-md-6">
		<label class="form-label" for="carve-input"><strong>Carve Source</strong></label>
		<textarea id="carve-input" class="form-control font-monospace" rows="20"><?= h($defaultCarve) ?></textarea>
		<div class="form-check mt-2">
			<input class="form-check-input" type="checkbox" id="opt-positions" checked>
			<label class="form-check-label" for="opt-positions">
				Source positions (§4)
				<span class="text-muted small">
					- opt-in: tracking costs work on every parse, so it is off unless asked for.
				</span>
			</label>
		</div>
	</div>
	<div class="col-md-6">
		<div class="d-flex justify-content-between align-items-center mb-1">
			<label class="form-label mb-0" for="ast-output"><strong>AST (JSON)</strong></label>
			<button type="button" class="btn btn-sm btn-outline-secondary" id="btn-copy-ast">
				<i class="bi bi-clipboard"></i> Copy
			</button>
		</div>
		<textarea id="ast-output" class="form-control font-monospace" rows="20" readonly style="font-size: 0.82em;"></textarea>
		<div id="ast-stats" class="small text-muted mt-2"></div>
	</div>
</div>

<div id="encode-alert" class="mt-2"></div>

<hr class="my-4">

<h4>AST <i class="bi bi-arrow-right"></i> rendered</h4>
<p class="text-muted small">
	The reverse direction: paste a tree from any engine and render it through the
	same formats as source. Edit the JSON below - break a field name and watch the
	decoder refuse it rather than guess.
</p>

<div class="row">
	<div class="col-md-6">
		<div class="d-flex justify-content-between align-items-center mb-1">
			<label class="form-label mb-0" for="tree-input"><strong>AST (JSON) input</strong></label>
			<button type="button" class="btn btn-sm btn-outline-secondary" id="btn-fill-tree" title="Copy the tree from the encoder above">
				<i class="bi bi-arrow-up"></i> Use the tree above
			</button>
		</div>
		<textarea id="tree-input" class="form-control font-monospace" rows="16" style="font-size: 0.82em;"><?= h($defaultTree) ?></textarea>
		<div class="form-check mt-2">
			<input class="form-check-input" type="checkbox" id="opt-upgrade">
			<label class="form-check-label" for="opt-upgrade">Upgrade legacy stored payload before decoding</label>
		</div>
	</div>
	<div class="col-md-6">
		<label class="form-label"><strong>Rendered HTML</strong></label>
		<div id="decode-html" class="border rounded p-3 bg-white carve-rendered" style="min-height: 120px;"></div>
		<label class="form-label mt-3" for="decode-carve"><strong>Serialized back to Carve</strong></label>
		<textarea id="decode-carve" class="form-control font-monospace" rows="8" readonly style="font-size: 0.82em;"></textarea>
	</div>
</div>

<div id="decode-alert" class="mt-2"></div>

<h3 class="mt-4">In PHP</h3>
<pre class="bg-light p-3 border rounded"><code class="language-php">use MarkupCarve\Carve\Ast\AstCodec;
use MarkupCarve\Carve\Ast\StoredPayloadUpgrade;
use MarkupCarve\Carve\CarveConverter;
use MarkupCarve\Carve\Parser\BlockParser;

$codec = new AstCodec();

// Source positions are opt-in - they cost work on every parse.
$converter = new CarveConverter(parser: new BlockParser(trackPositions: true));
$document = $converter->parse($source);

$json = $codec->encodeJson($document, JSON_PRETTY_PRINT);
$again = $codec->decodeJson($json);

// Migrate AST JSON stored before the current PART 12 shape.
$upgradedJson = StoredPayloadUpgrade::upgradeJson($legacyJson);
$legacyDocument = $codec->decodeJson($upgradedJson);

$converter->render($again); // identical to render($document)</code></pre>

<?= $this->element('carve/output_styles') ?>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const carveInput = document.getElementById('carve-input');
	const astOutput = document.getElementById('ast-output');
	const astStats = document.getElementById('ast-stats');
	const encodeAlert = document.getElementById('encode-alert');
	const optPositions = document.getElementById('opt-positions');
	const btnCopyAst = document.getElementById('btn-copy-ast');

	const treeInput = document.getElementById('tree-input');
	const decodeHtml = document.getElementById('decode-html');
	const decodeCarve = document.getElementById('decode-carve');
	const decodeAlert = document.getElementById('decode-alert');
	const btnFillTree = document.getElementById('btn-fill-tree');
	const optUpgrade = document.getElementById('opt-upgrade');

	const convertUrl = <?= json_encode($this->Url->build(['action' => 'convertAst'])) ?>;

	function escapeHtml(text) {
		const div = document.createElement('div');
		div.textContent = text;
		return div.innerHTML;
	}

	function post(body) {
		const formData = new FormData();
		Object.keys(body).forEach(key => formData.append(key, body[key]));

		return fetch(convertUrl, {
			method: 'POST',
			body: formData,
			headers: { 'X-Requested-With': 'XMLHttpRequest' }
		}).then(response => response.json());
	}

	let encodeTimer;
	function encode() {
		clearTimeout(encodeTimer);
		encodeTimer = setTimeout(doEncode, 250);
	}

	function doEncode() {
		post({
			direction: 'encode',
			carve: carveInput.value,
			positions: optPositions.checked ? '1' : '0'
		}).then(data => {
			encodeAlert.innerHTML = '';
			if (data.error) {
				encodeAlert.innerHTML = '<div class="alert alert-danger py-2 mb-0"><strong>Error:</strong> ' + escapeHtml(data.error) + '</div>';
				astOutput.value = '';
				astStats.textContent = '';

				return;
			}

			astOutput.value = data.json || '';

			const parts = [data.nodes + ' nodes', data.ms + ' ms'];
			if (optPositions.checked) {
				const percent = data.nodes ? Math.round((data.placed / data.nodes) * 100) : 0;
				parts.push(data.placed + ' placed (' + percent + '%)');
			}
			astStats.innerHTML = parts.map(escapeHtml).join(' &middot; ')
				+ ' &middot; ' + (data.stable
					? '<span class="text-success"><i class="bi bi-check-circle"></i> decode &rarr; render is identical</span>'
					: '<span class="text-danger"><i class="bi bi-x-circle"></i> round trip differs</span>');
		}).catch(err => console.error('AST error:', err));
	}

	let decodeTimer;
	function decode() {
		clearTimeout(decodeTimer);
		decodeTimer = setTimeout(doDecode, 350);
	}

	function doDecode() {
		post({
			direction: 'decode',
			tree: treeInput.value,
			upgrade: optUpgrade.checked ? '1' : '0'
		}).then(data => {
			decodeAlert.innerHTML = '';
			if (data.error) {
				decodeAlert.innerHTML = '<div class="alert alert-danger py-2 mb-0"><strong>Rejected:</strong> ' + escapeHtml(data.error) + '</div>';
				decodeHtml.innerHTML = '<span class="text-muted">-</span>';
				decodeCarve.value = '';

				return;
			}

			decodeHtml.innerHTML = data.html || '';
			decodeCarve.value = data.carve || '';
			if (window.carveDecorateCodeBlocks) {
				window.carveDecorateCodeBlocks(decodeHtml);
			}
		}).catch(err => console.error('AST decode error:', err));
	}

	function copyToClipboard(text, button) {
		if (!navigator.clipboard) {
			return;
		}
		navigator.clipboard.writeText(text).then(() => {
			const original = button.innerHTML;
			button.innerHTML = '<i class="bi bi-check"></i> Copied!';
			setTimeout(() => { button.innerHTML = original; }, 2000);
		});
	}

	carveInput.addEventListener('input', encode);
	optPositions.addEventListener('change', doEncode);
	treeInput.addEventListener('input', decode);
	optUpgrade.addEventListener('change', doDecode);
	btnCopyAst.addEventListener('click', () => copyToClipboard(astOutput.value, btnCopyAst));
	btnFillTree.addEventListener('click', () => {
		if (astOutput.value) {
			treeInput.value = astOutput.value;
			doDecode();
		}
	});

	doEncode();
	doDecode();
})();
<?php $this->Html->scriptEnd(); ?>
