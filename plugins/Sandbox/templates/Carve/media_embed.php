<?php
/**
 * @var \App\View\AppView $this
 * @var string $carve
 * @var string $output
 * @var string|null $error
 */
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>Carve &rarr; Media Embeds</h2>
<p>
	The <?= $this->Html->link('carve-php-media-embed', 'https://github.com/markup-carve/carve-php-media-embed', ['target' => '_blank']) ?>
	extension renders audio/video embeds from
	<?= $this->Html->link('35+ providers', 'https://github.com/dereuromark/media-embed', ['target' => '_blank']) ?>
	through concise inline Carve directives, powered by <code>dereuromark/media-embed</code>.
</p>
<p>
	See also the <?= $this->Html->link('main Media Embed demo', ['plugin' => 'Sandbox', 'controller' => 'MediaEmbed', 'action' => 'index']) ?>
	for the standalone (non-Carve) usage.
</p>

<p><strong>Syntax:</strong>
	<code>:youtube[ID]</code>,
	<code>:vimeo[URL]</code>,
	<code>:media[URL]</code> (auto-detect),
	plus any supported provider slug.
</p>
<p class="text-muted small">
	Each rendered embed is stamped with a <code>data-carve-source</code> attribute carrying the
	original directive (e.g. <code>:youtube[ID]</code>). Because media-embed is a one-way transform
	- the iframe URL cannot be reversed back to the directive - this stamp lets a WYSIWYG editor
	round-trip the embed back to its exact Carve source. Look for it in the HTML output below.
</p>

<?php
echo $this->Form->create();
echo $this->Form->control('carve', ['type' => 'textarea', 'rows' => 10, 'value' => $carve, 'label' => 'Carve markup']);
echo $this->Form->submit('Render');
echo $this->Form->end();
?>

<?php if ($error !== null) { ?>
	<div class="alert alert-danger"><?= h($error) ?></div>
<?php } ?>

<?php if ($output !== '') { ?>
	<h3>Rendered</h3>
	<div class="card card-body">
		<?= $output // Trusted iframe HTML produced by media-embed. ?>
	</div>

	<h3>HTML output</h3>
	<pre><?= h($output) ?></pre>
<?php } ?>

</div>
