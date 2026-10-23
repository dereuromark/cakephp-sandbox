<?php
/**
 * @var \App\View\AppView $this
 */

$action = $this->request->getParam('action');
$controller = $this->request->getParam('controller');
?>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Editors') ?></li>
	<li class="nav-item"><?= $this->Html->link('Carve Playground', ['controller' => 'Carve', 'action' => 'index'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'index' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('WYSIWYG Editor', ['controller' => 'Carve', 'action' => 'wysiwyg'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'wysiwyg' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Roundtrip Test', ['controller' => 'Carve', 'action' => 'roundtrip'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'roundtrip' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('ProseMirror Bridge', ['controller' => 'Carve', 'action' => 'proseMirror'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'proseMirror' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Paragraph Interruption', ['controller' => 'Carve', 'action' => 'interruption'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'interruption' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Showcase') ?></li>
	<li class="nav-item"><?= $this->Html->link('Complex Examples', ['controller' => 'Carve', 'action' => 'complexExamples'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'complexExamples' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Trees', ['controller' => 'Carve', 'action' => 'trees'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'trees' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('AST Inspector', ['controller' => 'Carve', 'action' => 'ast'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'ast' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Extensions', ['controller' => 'Carve', 'action' => 'extensions'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'extensions' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Code Blocks', ['controller' => 'Carve', 'action' => 'codeBlocks'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'codeBlocks' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Media Embeds', ['controller' => 'Carve', 'action' => 'mediaEmbed'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'mediaEmbed' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Chat Export', ['controller' => 'Carve', 'action' => 'chatExport'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'chatExport' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Pandoc Bridge', ['controller' => 'Carve', 'action' => 'pandoc'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'pandoc' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Graceful Degradation', ['controller' => 'Carve', 'action' => 'demo'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'demo' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Converters') ?></li>
	<li class="nav-item"><?= $this->Html->link('Markdown to Carve', ['controller' => 'Carve', 'action' => 'markdownToCarve'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'markdownToCarve' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('Djot to Carve', ['controller' => 'Carve', 'action' => 'djotToCarve'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'djotToCarve' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('HTML to Carve', ['controller' => 'Carve', 'action' => 'htmlToCarve'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'htmlToCarve' ? ' active' : '')]) ?></li>
	<li class="nav-item"><?= $this->Html->link('BBCode to Carve', ['controller' => 'Carve', 'action' => 'bbcodeToCarve'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'bbcodeToCarve' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Migration') ?></li>
	<li class="nav-item"><?= $this->Html->link('Migration Fix', ['controller' => 'Carve', 'action' => 'migrationFix'], ['class' => 'nav-link' . ($controller === 'Carve' && $action === 'migrationFix' ? ' active' : '')]) ?></li>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('CakePHP plugin') ?></li>
	<?php foreach (['index' => 'Overview', 'validation' => 'Validation', 'behavior' => 'Behavior', 'view' => 'CarveView'] as $page => $label) { ?>
	<li class="nav-item"><?= $this->Html->link($label, ['controller' => 'CarveCakephp', 'action' => $page], ['class' => 'nav-link' . ($controller === 'CarveCakephp' && $action === $page ? ' active' : '')]) ?></li>
	<?php } ?>
</ul>
<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Links') ?></li>
	<li class="nav-item"><?= $this->Html->link('cakephp-carve', 'https://github.com/markup-carve/cakephp-carve', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link('Carve-PHP', 'https://github.com/markup-carve/carve-php', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
	<li class="nav-item"><?= $this->Html->link('Carve Spec', 'https://github.com/markup-carve/carve', ['target' => '_blank', 'class' => 'nav-link']) ?></li>
</ul>
