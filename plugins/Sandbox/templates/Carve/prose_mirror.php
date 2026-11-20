<?php
/**
 * @var \App\View\AppView $this
 * @var bool $debugMode
 */
?>

<nav class="actions col-md-2 col-sm-3 col-12">
	<?= $this->element('navigation/carve') ?>
</nav>
<div class="col-md-10 col-sm-9 col-12">

<h2>ProseMirror Bridge</h2>

<div class="alert alert-info">
	<i class="bi bi-info-circle"></i>
	The server-side ProseMirror bridge of carve-php is not part of Carve 0.2.
	The <?= $this->Html->link('WYSIWYG editor', ['action' => 'wysiwyg']) ?> converts between Carve and the editor
	model in the browser with the Tiptap kit from <code>carve-grammars</code>.
</div>

</div>
