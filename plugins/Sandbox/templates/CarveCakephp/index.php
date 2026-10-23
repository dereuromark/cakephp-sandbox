<?php
/** @var \App\View\AppView $this */
$source = "# Preset comparison\n\nHere is /emphasis/ and a [safe link](https://example.com).\n\n[Unsafe link](javascript:alert(1))\n\n```=html\n<div>Raw HTML <a href=\"javascript:alert(1)\" onclick=\"alert(1)\">Unsafe raw link</a></div>\n```\n\n{onclick=\"alert(1)\"}\nA paragraph with an event attribute.";
$examples = [
	'default' => ['preset' => 'default'],
	'comment' => ['preset' => 'comment'],
	'trusted' => ['preset' => 'trusted'],
	'strict' => ['safeMode' => 'strict'],
];
$document = "---json\n{\"title\":\"Document metadata\"}\n---\n# First heading\n\nA short document.\n\n## Second heading\n\nMore content.\n\n## Third heading\n\nEnd.";
$result = $this->Carve->render($document, ['extensions' => ['frontmatter']]);
?>
<nav class="actions col-md-2 col-sm-3 col-12"><?= $this->element('navigation/carve') ?></nav>
<div class="col-md-10 col-sm-9 col-12">
<h2>CakePHP Plugin</h2>
<p>Install the plugin and load it in your application:</p>
<pre><?= h("composer require markup-carve/cakephp-carve\n\$this->addPlugin('MarkupCarve/CakeCarve');") ?></pre>
<p>The same fixed source is rendered with each option set. The trusted preset keeps the raw HTML block, including its unsafe link and event attribute, so its output is shown as source only and never rendered on this page. The standalone link and Carve attribute are filtered in every column. Use trusted only with trusted source.</p>
<pre><?= h($source) ?></pre>
<div class="row">
<?php foreach ($examples as $label => $options) { ?>
	<div class="col-lg-6" data-preset="<?= h($label) ?>">
		<h3><?= h($label) ?></h3>
		<pre><?= h(json_encode($options)) ?></pre>
		<?php $html = $this->Carve->convert($source, $options); ?>
		<?php if ($label !== 'trusted') { ?>
		<div class="carve-output"><?= $html ?></div>
		<?php } ?>
		<pre class="carve-source"><?= h($html) ?></pre>
	</div>
<?php } ?>
</div>
<h3>Document result</h3>
<?= $result->html() ?>
<pre><?= h(json_encode(['toc' => $result->toc(), 'meta' => $result->meta()], JSON_PRETTY_PRINT)) ?></pre>
<p><?= $this->Html->link('Open the CarveView example', ['controller' => 'CarveCakephp', 'action' => 'view']) ?> as a bare fragment.</p>
<h3>Commands</h3>
<pre><?= h("bin/cake carve render document.crv --preset comment\nbin/cake carve convert article.md --from markdown --output article.crv\nbin/cake carve format document.crv --check\nbin/cake carve lint document.crv") ?></pre>
</div>
