<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Markup Examples</h2>
<a href="https://github.com/dereuromark/cakephp-markup" target="_blank">[Source]</a>


<h3>Code Highlighting</h3>

<ul>
	<li><?php echo $this->Html->link('Highlighting thought PHP or JS', ['action' => 'markup'])?></li>
</ul>

<h3>Code Transformation</h3>

<p>Parsing from BBCode, Markdown, ... to HTML</p>

<ul>
	<li><?php echo $this->Html->link('Bbcode', ['action' => 'bbcode'])?></li>
	<li><?php echo $this->Html->link('Markdown', ['action' => 'markdown'])?></li>
</ul>

