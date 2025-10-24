<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/markup'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Overview</h3>
<p>
	The Markup plugin provides powerful tools for code highlighting and text transformation in CakePHP applications.
</p>

<h3>Code Highlighting</h3>
<p>
	Display beautiful syntax-highlighted code snippets using either PHP-based or JavaScript-based highlighting.
</p>
<ul>
	<li><?php echo $this->Html->link('Highlighting through PHP or JS', ['action' => 'markup'])?> - Multiple language support (PHP, CSS, JavaScript, SQL, XML, Markdown, etc.)</li>
</ul>

<h3>Code Transformation</h3>
<p>
	Parse and transform markup formats like BBCode and Markdown into HTML for safe display.
</p>
<ul>
	<li><?php echo $this->Html->link('BBCode', ['action' => 'bbcode'])?> - Parse BBCode tags to HTML</li>
	<li><?php echo $this->Html->link('Markdown', ['action' => 'markdown'])?> - Convert Markdown to HTML</li>
</ul>

<h3>Features</h3>
<ul>
	<li><strong>Multiple Highlighters:</strong> Choose between PHP-based or JavaScript-based code highlighting</li>
	<li><strong>Theme Support:</strong> Light and dark themes for code display</li>
	<li><strong>Safe Parsing:</strong> Secure transformation of user-generated markup</li>
	<li><strong>Extensive Language Support:</strong> Syntax highlighting for dozens of programming languages</li>
</ul>

</div></div>

