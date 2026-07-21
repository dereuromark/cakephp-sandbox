<?php
/**
 * @var \App\View\AppView $this
 */

$action = $this->request->getParam('action');
?>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Editors') ?></li>
	<li class="nav-item"><?= $this->Html->link('Carve Playground', ['action' => 'index'], ['class' => 'nav-link' . ($action === 'index' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('WYSIWYG Editor', ['action' => 'wysiwyg'], ['class' => 'nav-link' . ($action === 'wysiwyg' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Roundtrip Test', ['action' => 'roundtrip'], ['class' => 'nav-link' . ($action === 'roundtrip' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Paragraph Interruption', ['action' => 'interruption'], ['class' => 'nav-link' . ($action === 'interruption' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Showcase') ?></li>
	<li class="nav-item"><?= $this->Html->link('Complex Examples', ['action' => 'complexExamples'], ['class' => 'nav-link' . ($action === 'complexExamples' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Extensions', ['action' => 'extensions'], ['class' => 'nav-link' . ($action === 'extensions' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Code Blocks', ['action' => 'codeBlocks'], ['class' => 'nav-link' . ($action === 'codeBlocks' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Media Embeds', ['action' => 'mediaEmbed'], ['class' => 'nav-link' . ($action === 'mediaEmbed' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Chat Export', ['action' => 'chatExport'], ['class' => 'nav-link' . ($action === 'chatExport' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Pandoc Bridge', ['action' => 'pandoc'], ['class' => 'nav-link' . ($action === 'pandoc' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Graceful Degradation', ['action' => 'demo'], ['class' => 'nav-link' . ($action === 'demo' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Converters') ?></li>
	<li class="nav-item"><?= $this->Html->link('Markdown to Carve', ['action' => 'markdownToCarve'], ['class' => 'nav-link' . ($action === 'markdownToCarve' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Djot to Carve', ['action' => 'djotToCarve'], ['class' => 'nav-link' . ($action === 'djotToCarve' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('HTML to Carve', ['action' => 'htmlToCarve'], ['class' => 'nav-link' . ($action === 'htmlToCarve' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('BBCode to Carve', ['action' => 'bbcodeToCarve'], ['class' => 'nav-link' . ($action === 'bbcodeToCarve' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Migration') ?></li>
	<li class="nav-item"><?= $this->Html->link('Migration Fix', ['action' => 'migrationFix'], ['class' => 'nav-link' . ($action === 'migrationFix' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Links') ?></li>
	<li class="nav-item"><?= $this->Html->link('Carve-PHP', 'https://github.com/markup-carve/carve-php', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link('Carve Spec', 'https://github.com/markup-carve/carve', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
</ul>
