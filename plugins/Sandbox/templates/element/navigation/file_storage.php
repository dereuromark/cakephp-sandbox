<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>FileStorage Plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-file-storage" target="_blank">[FileStorage Plugin]</a>
</p>

<h3>File Storage Examples</h3>
<p>Universal file storage abstraction with support for multiple backends.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Actions') ?></li>
	<li><?= $this->Html->link(__('Back to Plugins'), ['controller' => 'PluginExamples', 'action' => 'index']) ?></li>
	<li><?= $this->Html->link(__('Overview'), ['controller' => 'FileStorageExamples', 'action' => 'index']) ?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Upload Demos') ?></li>
	<li><?php echo $this->Navigation->link('Image Upload', ['action' => 'images'])?></li>
	<li><?php echo $this->Navigation->link('PDF Upload', ['action' => 'pdfs'])?></li>
	<li><?php echo $this->Navigation->link('General Files', ['action' => 'files'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Advanced Features') ?></li>
	<li><?php echo $this->Navigation->link('Drag & Drop Upload', ['action' => 'dragDropUpload'])?></li>
</ul>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('Image Processing') ?></li>
	<li><?php echo $this->Navigation->link('Image Variants', ['action' => 'variants'])?></li>
</ul>
