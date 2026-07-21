<?php
/**
 * @var \App\View\AppView $this
 * @var string $carve
 * @var array<string, array{label: string, limit: int|null, length: int, text: string, losses: array<\MarkupCarve\Chat\Loss>}> $results
 * @var string|null $error
 */
?>

<style>
/* A chat client shows a heading a little larger, not page-title large. */
.chat-preview h1, .chat-preview h2, .chat-preview h3,
.chat-preview h4, .chat-preview h5, .chat-preview h6 {
	font-size: 1.05rem;
	font-weight: 700;
	margin: 0 0 .4rem;
}
.chat-preview p { margin: 0 0 .5rem; }
.chat-preview > :last-child { margin-bottom: 0; }
.chat-preview pre { margin: 0 0 .5rem; }
</style>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Carve &rarr; Chat Platforms</h2>
<p>
	The <?= $this->Html->link('carve-php-chat', 'https://github.com/markup-carve/carve-php-chat', ['target' => '_blank']) ?>
	package renders a Carve document into the markup a chat client actually accepts.
	WhatsApp, Slack, Telegram and Discord each take a small, mutually incompatible subset
	of Markdown-like syntax, with different link forms, different escaping rules and
	different length caps. Signal takes none at all - see below.
</p>
<p class="text-muted small">
	Pandoc has no writer for any chat platform, so this is not reachable through the
	<?= $this->Html->link('pandoc bridge', 'https://github.com/markup-carve/pandoc-carve', ['target' => '_blank']) ?>.
	Each platform here is a JSON flavor table keyed by Carve node type - adding one costs no PHP.
</p>

<div class="alert alert-info">
	<strong>Chat formats cannot express most of Carve.</strong>
	Rather than mangling silently, the renderer records every degradation: headings become
	bold lines, tables are flattened to monospace, footnotes move to a numbered appendix,
	and links are inlined where the target has no link syntax at all. Those are listed
	under each output below.
</div>

<?php
echo $this->Form->create();
echo $this->Form->control('carve', ['type' => 'textarea', 'rows' => 14, 'value' => $carve, 'label' => 'Carve markup']);
echo $this->Form->submit('Export');
echo $this->Form->end();
?>

<?php if ($error !== null) { ?>
	<div class="alert alert-danger"><?= h($error) ?></div>
<?php } ?>

<?php if ($results) { ?>
	<div class="row mt-4">
		<?php foreach ($results as $id => $result) { ?>
			<div class="col-lg-6 mb-4">
				<div class="card h-100">
					<div class="card-header d-flex justify-content-between align-items-center">
						<strong><?= h($result['label']) ?></strong>
						<code class="small text-muted"><?= h($id) ?></code>
					</div>
					<div class="card-body">
						<?php $tabId = 'flavor-' . preg_replace('/[^a-z0-9]+/', '-', $id); ?>
						<ul class="nav nav-tabs nav-sm mb-2" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#<?= $tabId ?>-preview" type="button" role="tab">Preview</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" data-bs-toggle="tab" data-bs-target="#<?= $tabId ?>-markup" type="button" role="tab">Sent</button>
							</li>
							<?php if ($result['isRangeBased']) { ?>
								<li class="nav-item" role="presentation">
									<button class="nav-link" data-bs-toggle="tab" data-bs-target="#<?= $tabId ?>-ranges" type="button" role="tab">
										Ranges <span class="badge bg-secondary"><?= count($result['ranges']) ?></span>
									</button>
								</li>
							<?php } ?>
						</ul>

						<div class="tab-content mb-2">
							<div class="tab-pane fade show active" id="<?= $tabId ?>-preview" role="tabpanel">
								<?php // Escaped by ChatPreviewRenderer; no document content reaches here as live markup. ?>
								<div class="border rounded p-2 chat-preview"><?= $result['preview'] ?></div>
							</div>
							<div class="tab-pane fade" id="<?= $tabId ?>-markup" role="tabpanel">
								<?php // Soft-wrap long lines the way a chat client would; real newlines are preserved. ?>
								<pre class="mb-0" style="white-space: pre-wrap; overflow-wrap: anywhere;"><?= h($result['text']) ?></pre>
							</div>
							<?php if ($result['isRangeBased']) { ?>
								<div class="tab-pane fade" id="<?= $tabId ?>-ranges" role="tabpanel">
									<p class="small text-muted mb-1">
										Plain-text body plus style offsets, counted in
										<code><?= h($result['offsetUnit']) ?></code> units.
									</p>
									<table class="table table-sm small mb-0">
										<thead><tr><th>Style</th><th>Start</th><th>Length</th><th>Selects</th></tr></thead>
										<tbody>
											<?php foreach ($result['ranges'] as $index => $range) { ?>
												<tr>
													<td><code><?= h($range->style) ?></code></td>
													<td><?= $range->start ?></td>
													<td><?= $range->length ?></td>
													<td><code><?= h($result['selections'][$index]) ?></code></td>
												</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
							<?php } ?>
						</div>

						<p class="small text-muted mb-1">
							<?= $this->Number->format($result['length']) ?> chars<?php
							if ($result['limit'] !== null) {
								echo ' of ' . $this->Number->format($result['limit']) . ' allowed';
								if ($result['length'] > $result['limit']) {
									echo ' <span class="badge bg-danger">over limit</span>';
								}
							}
							?>
						</p>

						<?php if ($result['losses']) { ?>
							<details>
								<summary class="small">
									<?= count($result['losses']) ?> degradation<?= count($result['losses']) === 1 ? '' : 's' ?>
								</summary>
								<ul class="small mb-0 mt-2">
									<?php foreach ($result['losses'] as $loss) { ?>
										<li>
											<code><?= h($loss->nodeType) ?></code>
											&rarr; <code><?= h($loss->fallback->value) ?></code>
											<?php if ($loss->sourceLine !== null) { ?>
												<span class="text-muted">(line <?= $loss->sourceLine ?>)</span>
											<?php } ?>
										</li>
									<?php } ?>
								</ul>
							</details>
						<?php } else { ?>
							<p class="small text-success mb-0">Nothing lost.</p>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>

	<h3>Why Discord appears twice</h3>
	<p>
		A masked link <code>[text](url)</code> does not render in a message a person types
		into Discord. It renders in bot API messages, webhook content, embeds and DMs from a
		bot. Discord made that trade-off deliberately, to stop malicious URLs hiding behind
		innocent-looking text. So <code>discord</code> degrades links to <code>text (url)</code>
		and <code>discord-bot</code> extends it with masked links enabled - the two flavor
		files differ by one key.
	</p>

	<h3>Why Signal emits no markup at all</h3>
	<p>
		Signal does not parse markup in message bodies. Its documentation states that Markdown
		<q>is not supported at this time and is not planned</q> - formatting is applied by
		selecting text in the UI, and travels as out-of-band style metadata rather than as
		delimiters. A typed <code>*bold*</code> stays literally <code>*bold*</code>.
	</p>
	<p>
		The message still <em>displays</em> as bold, though - the style just rides alongside
		the text. So <code>signal</code> is a <strong>range-based</strong> flavor: the
		<em>Sent</em> tab is plain text with no delimiters, and the <em>Ranges</em> tab lists
		the offsets that carry the formatting. Its preview is styled like any other, because
		that is what the reader sees.
	</p>
	<p>
		That splits every target into two families, which a flavor declares with
		<code>output</code>:
	</p>
	<ul>
		<li><strong>markup</strong> - formatting lives inside the message string as delimiters
			(WhatsApp, Slack, Telegram <code>parse_mode</code>, Discord).</li>
		<li><strong>ranges</strong> - the body is plain text and the styles travel beside it as
			offsets (Signal, Telegram's <code>entities</code> field, Slack Block Kit).</li>
	</ul>
	<p class="text-muted small">
		Offsets are counted in a unit the flavor declares, which is not guessable: Telegram
		documents its entity offsets in <strong>UTF-16 code units</strong>, so a character
		outside the BMP counts as two. In <code>👍 *bold*</code> the bold span starts at 3 in
		UTF-16, 5 in UTF-8 and 2 in codepoints - measure wrongly and every range after that
		emoji is off.
	</p>

	<h3>Adding a platform</h3>
	<p>
		A flavor is data, not code. Matrix, Zulip, Google Chat or an internal tool need only
		a JSON file loaded through <code>FlavorRegistry::fromJsonFile()</code>:
	</p>
	<pre><code>{
  "id": "zulip",
  "label": "Zulip",
  "verified": "2026-07-21",
  "limits": { "message": 10000 },
  "link": { "style": "markdown" },
  "escape": { "mechanism": "backslash", "chars": "*_`" },
  "nodes": {
    "strong":   { "support": "native", "open": "**", "close": "**" },
    "emphasis": { "support": "native", "open": "*",  "close": "*" },
    "table":    { "support": "none",   "fallback": "codeblock" }
  }
}</code></pre>
	<p class="text-muted small">
		<code>extends</code> merges a parent so a variant states only its deltas. Node types
		left out degrade through their fallback. Each flavor carries a <code>verified</code>
		date because platform syntax changes - Discord added headings and lists in 2023.
	</p>
<?php } ?>

</div>
