<?php
/**
 * Graceful-degradation demo: render the same Carve source through every output
 * target and show how interactive constructs degrade.
 *
 * @var \App\View\AppView $this
 * @var string $carve
 * @var string $target
 * @var bool $useRenderers
 * @var string $output Raw renderer output (HTML or text) for the chosen target.
 * @var string $rendered Sanitized HTML preview (HTML/ANSI targets only).
 * @var bool $isHtml Whether the chosen target produced HTML to preview.
 * @var string|null $error
 * @var array<string, string> $targets
 */
?>
<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Graceful Degradation</h2>
<p>
	The same Carve source rendered through one output target. Pick a target and submit to see how
	interactive constructs (tabs, code-group, details, spoiler, mermaid, math) degrade. Tabs and code-group
	flatten to labeled sections in static targets, details and spoiler reveal, and mermaid and math use a
	build-time renderer or fall back to their source.
</p>

<?php if ($error) { ?>
	<div class="alert alert-danger"><strong>Error:</strong> <?= h($error) ?></div>
<?php } ?>

<form method="post" action="<?= $this->Url->build(['action' => 'demo']) ?>">
	<div class="row mb-3">
		<div class="col-md-7">
			<label class="form-label small mb-1" for="carve-input">Carve source</label>
			<textarea class="form-control font-monospace" id="carve-input" name="carve" rows="22"><?= h($carve) ?></textarea>
		</div>
		<div class="col-md-5">
			<label class="form-label small mb-1" for="target-select">Output target</label>
			<select class="form-select" id="target-select" name="target">
				<?php foreach ($targets as $value => $label) { ?>
					<option value="<?= h($value) ?>"<?= $target === $value ? ' selected' : '' ?>><?= h($label) ?></option>
				<?php } ?>
			</select>

			<div class="form-check mt-3">
				<input class="form-check-input" type="checkbox" id="use-renderers" name="use_renderers" value="1"<?= $useRenderers ? ' checked' : '' ?>>
				<label class="form-check-label small" for="use-renderers">
					Use build-time renderers (Static HTML / PDF). Off shows the no-renderer source fallback for mermaid and math.
				</label>
			</div>

			<button type="submit" class="btn btn-primary mt-3">Render</button>

			<p class="small text-muted mt-3 mb-0">
				PDF opens inline as a real <code>application/pdf</code> response (flattened tabs, content intact).
				Markdown and plain text show the raw text. ANSI shows terminal colors converted to HTML.
			</p>
		</div>
	</div>
</form>

<?php if ($target !== 'pdf') { ?>
	<div class="row">
		<?php if ($isHtml) { ?>
			<div class="col-md-6">
				<h5>Rendered output <small class="text-muted">(<?= h($targets[$target] ?? $target) ?>)</small></h5>
				<div class="html-output border rounded p-3"><?= $rendered ?></div>
			</div>
			<div class="col-md-6">
				<h5>HTML source</h5>
				<pre class="border rounded p-2 bg-light" style="max-height: 480px; overflow: auto;"><code><?= h($output) ?></code></pre>
			</div>
		<?php } else { ?>
			<div class="col-12">
				<h5>Output <small class="text-muted">(<?= h($targets[$target] ?? $target) ?>)</small></h5>
				<pre class="border rounded p-3 bg-light" style="max-height: 600px; overflow: auto;"><?= h($output) ?></pre>
			</div>
		<?php } ?>
	</div>
<?php } ?>

</div>

<script>
(function () {
	var select = document.getElementById('target-select');
	if (!select) {
		return;
	}
	var form = select.closest('form');
	if (!form) {
		return;
	}
	// Open the PDF in a new tab so the demo page stays put; every other
	// target renders in place as the normal form response.
	form.addEventListener('submit', function () {
		form.target = select.value === 'pdf' ? '_blank' : '';
	});
})();
</script>
