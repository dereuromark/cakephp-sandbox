<?php
/**
 * @var \App\View\AppView $this
 */
?>

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

<pre><?php
$text = <<<TXT
Some **bold** text and also some *italic*.
TXT;
echo $this->Markdown->convert($text);
?></pre>

<pre><?php
$dataPrint = '#### hello world

you can write text [with links](http://example.com).

1. one thing (yeah!)
2. two thing `i can write code`, and `more` wipee!';
echo $this->Markdown->convert($dataPrint, ['lang' => 'markdown']);
?></pre>

<p>You can register your own custom converter filters, see docs for details.</p>
