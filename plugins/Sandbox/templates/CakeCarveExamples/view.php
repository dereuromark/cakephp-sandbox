<?php
/**
 * @var \App\View\AppView $this
 * @var string $template
 * @var string $layout
 */

echo $this->element('cake_carve/highlighting');
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake_carve'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>CarveView</h3>
	<p>
		<code>CarveView</code> renders <code>.crv</code> template files. <code>{{name}}</code> placeholders are filled from view
		variables first, then the whole file is converted. A <code>.crv</code> layout places the page with
		<code>{{content}}</code> and can read the template's frontmatter as <code>{{carve.meta.title}}</code>.
	</p>

	<?php echo $this->element('cake_carve/code', ['code' => <<<'PHP'
$this->viewBuilder()
	->setClassName('MarkupCarve/CakeCarve.Carve')
	->setLayout('carve_document')
	->setOption('extensions', ['frontmatter']);
$this->set('name', 'CakePHP sandbox');
PHP, 'lang' => 'php']); ?>

	<h4 class="h6">Template <code>document.crv</code></h4>
	<?php echo $this->element('cake_carve/code', ['code' => $template, 'lang' => 'carve']); ?>

	<h4 class="h6">Layout <code>layout/carve_document.crv</code></h4>
	<?php echo $this->element('cake_carve/code', ['code' => $layout, 'lang' => 'carve']); ?>

	<h4 class="h6">Result</h4>
	<iframe src="<?php echo $this->Url->build(['action' => 'document']); ?>" class="w-100 border rounded" style="height: 14rem;" title="CarveView result"></iframe>
	<p class="small text-muted">
		<?php echo $this->Html->link('Open the result on its own', ['action' => 'document']); ?>; it is a bare HTML fragment without the sandbox layout.
	</p>

</div>
</div>
