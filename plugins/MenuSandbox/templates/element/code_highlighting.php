<?php
/**
 * Syntax highlighting for the code samples on the menu sandbox pages.
 *
 * @var \App\View\AppView $this
 */
$this->append('css');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/github.min.css');
$this->end();
$this->append('script');
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js');
$this->end();
?>
<style>
	.page pre { white-space: pre-wrap; word-break: break-word; }
	.page pre code.hljs { padding: .5rem; }
</style>
<?php $this->Html->scriptStart(['block' => true]); ?>
document.querySelectorAll('pre code[class*="language-"]').forEach(el => hljs.highlightElement(el));
<?php $this->Html->scriptEnd(); ?>
