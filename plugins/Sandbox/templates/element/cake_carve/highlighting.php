<?php
/**
 * @var \App\View\AppView $this
 */

$this->append('script');
echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/github.min.css');
echo $this->Html->css('Sandbox.highlighting/hljs-carve.css', ['timestamp' => 'force']);
echo $this->Html->css('Sandbox.highlighting/carve-code.css', ['timestamp' => 'force']);
echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js');
echo $this->Html->script('Sandbox.hljs-carve.js');
echo $this->Html->script('Sandbox.hljs-carve-delimited.js');
$this->end();

echo $this->element('carve/output_styles');
?>
<style>
/* The pre already frames the block; keep only highlight.js's colors. */
.carve-rendered pre code.hljs {
	background: transparent;
	padding: 0;
}
</style>
<?php $this->Html->scriptStart(['block' => true]); ?>
document.querySelectorAll('pre code').forEach(el => {
	hljs.highlightElement(el);
});
<?php $this->Html->scriptEnd(); ?>
