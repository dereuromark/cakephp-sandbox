<?php
/**
 * @var \App\View\AppView $this
 */

echo $this->element('cake_carve/highlighting');

$source = <<<'CARVE'
# Preset comparison

Here is /emphasis/ and a [safe link](https://example.com).

[Unsafe link](javascript:alert(1))

```=html
<div>Raw HTML <a href="javascript:alert(1)" onclick="alert(1)">Unsafe raw link</a></div>
```

{onclick="alert(1)"}
A paragraph with an event attribute.
CARVE;
$examples = [
	'default' => ['preset' => 'default'],
	'comment' => ['preset' => 'comment'],
	'trusted' => ['preset' => 'trusted'],
	'strict' => ['safeMode' => 'strict'],
];
$document = <<<'CARVE'
---json
{"title": "Document metadata"}
---
# First heading

A short document.

## Second heading

More content.

## Third heading

End.
CARVE;
$result = $this->Carve->render($document, ['extensions' => ['frontmatter']]);
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake_carve'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Setup</h3>
	<?php echo $this->element('cake_carve/code', ['code' => 'composer require markup-carve/cakephp-carve', 'lang' => 'bash']); ?>
	<?php echo $this->element('cake_carve/code', ['code' => <<<'PHP'
// src/Application.php
$this->addPlugin('MarkupCarve/CakeCarve');

// src/View/AppView.php
$this->addHelper('MarkupCarve/CakeCarve.Carve');

// any template
echo $this->Carve->convert($text, ['preset' => 'comment']);
PHP, 'lang' => 'php']); ?>

	<h3>Presets and safe mode</h3>
	<p>
		One source rendered with each option set. <code>comment</code> uses the comment profile and strict safe mode,
		<code>strict</code> only tightens safe mode, and <code>trusted</code> turns safe mode off.
	</p>
	<?php echo $this->element('cake_carve/code', ['code' => $source, 'lang' => 'carve']); ?>

	<div class="row">
	<?php foreach ($examples as $label => $options) { ?>
		<?php $html = $this->Carve->convert($source, $options); ?>
		<div class="col-12 mb-3" data-preset="<?php echo h($label); ?>">
			<h4 class="h6"><?php echo h($label); ?> <code><?php echo h((string)json_encode($options)); ?></code></h4>
			<?php if ($label === 'trusted') { ?>
				<p class="text-muted small">Keeps the raw HTML with its <code>javascript:</code> link and event handler, so it is only shown as source here. Use it for trusted authors only.</p>
			<?php } else { ?>
				<div class="carve-output carve-rendered border rounded p-2 mb-2"><?php echo $html; ?></div>
			<?php } ?>
			<div class="carve-source"><?php echo $this->element('cake_carve/code', ['code' => $html, 'lang' => 'html']); ?></div>
		</div>
	<?php } ?>
	</div>

	<h3>Rendered result</h3>
	<p><code>$this->Carve->render()</code> returns a <code>RenderedCarve</code> with the HTML, the table of contents and the frontmatter.</p>
	<?php echo $this->element('cake_carve/code', ['code' => $document, 'lang' => 'carve']); ?>
	<div class="carve-rendered border rounded p-2 mb-2"><?php echo $result->html(); ?></div>
	<?php echo $this->element('cake_carve/code', ['code' => (string)json_encode(['toc' => $result->toc(), 'meta' => $result->meta()], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'lang' => 'json']); ?>

	<h3>Commands</h3>
	<?php echo $this->element('cake_carve/code', ['code' => <<<'BASH'
bin/cake carve render document.crv --preset comment
bin/cake carve convert article.md --from markdown --output article.crv
bin/cake carve format document.crv --check
bin/cake carve lint document.crv
BASH, 'lang' => 'bash']); ?>

</div>
</div>
