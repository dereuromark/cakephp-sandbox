<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Carve WYSIWYG Editor</h2>

<div class="alert alert-info">
	<i class="bi bi-info-circle"></i>
	A WYSIWYG editor for Carve needs published JS tooling (a Tiptap kit and a Carve
	serializer). The reference JS implementation
	(<a href="https://github.com/markup-carve/carve-js" target="_blank">carve-js</a>)
	is not published to npm yet, so this page is a placeholder. Meanwhile you can type
	Carve below and preview the server-rendered HTML via
	<a href="https://github.com/markup-carve/carve-php" target="_blank">carve-php</a>.
</div>

<div class="row">
	<div class="col-md-6">
		<label class="form-label"><strong>Carve Input</strong></label>
		<textarea id="carve-input" class="form-control font-monospace" rows="16" placeholder="Enter Carve markup...">/Hello/ *Carve*! This previews through the PHP renderer.

- A list item
- With ==a highlight==
</textarea>
	</div>
	<div class="col-md-6">
		<label class="form-label"><strong>HTML Preview</strong></label>
		<div id="output-rendered" class="border rounded p-3 bg-white" style="min-height: 300px; max-height: 420px; overflow-y: auto;"></div>
	</div>
</div>

</div>

<?php $this->Html->scriptStart(['block' => true]); ?>
(function() {
	const input = document.getElementById('carve-input');
	const output = document.getElementById('output-rendered');
	let timer;

	function render() {
		clearTimeout(timer);
		timer = setTimeout(function() {
			const data = new FormData();
			data.append('carve', input.value);
			fetch('<?= $this->Url->build(['action' => 'convert']) ?>', {
				method: 'POST',
				body: data,
				headers: { 'X-Requested-With': 'XMLHttpRequest' }
			})
			.then(r => r.json())
			.then(d => {
				output.innerHTML = d.html || '<span class="text-muted">Enter some Carve markup...</span>';
			});
		}, 200);
	}

	input.addEventListener('input', render);
	render();
})();
<?php $this->Html->scriptEnd(); ?>
