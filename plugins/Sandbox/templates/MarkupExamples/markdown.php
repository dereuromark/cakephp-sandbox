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

<h2>Markdown to HTML</h2>
<a href="https://github.com/dereuromark/cakephp-markup" target="_blank">[Markup Plugin]</a>

<p>
To begin with, the lines you need to display code:
</p>
<?php
$dataPrint = '$markdownText = ...' . PHP_EOL;
$dataPrint .= 'echo $this->Markdown->convert($markdownText)';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php']);
?>

<h3>Examples</h3>
<p>The following examples are configured to use the `CommonMarkMarkdown` engine.</p>

<div class="code-snippet"><?php
$text = <<<TXT
Some **bold** text and also some *italic*.
TXT;
echo $this->Markdown->convert($text);
?></div>

<div class="code-snippet"><?php
$dataPrint = '#### hello world

You can write text [with links](http://example.com).

1. one thing (yeah!)
2. two thing `i can write code`, and `more` wipee!';
echo $this->Markdown->convert($dataPrint, ['lang' => 'markdown']);
?></div>

<div class="code-snippet"><?php
	$text = <<<TXT
This is an HTML example.

*[HTML]: Hyper Text Markup Language

Also lets

> quote something :)

Because that's how it is done.
TXT;

	echo $this->Markdown->convert($text);
	?></div>

<p>You can register your own custom converter filters, see docs for details.</p>

</div></div>
