<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h2>BBcode to HTML</h2>
<a href="https://github.com/dereuromark/cakephp-markup" target="_blank">[Markup Plugin]</a>

<p>
To begin with, the lines you need to display code:
</p>
<?php
$dataPrint = '$bbcodeText = ...' . PHP_EOL;
$dataPrint .= 'echo $this->Bbcode->convert($bbcodeText)';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php']);
?>

<h3>Examples</h3>
<p>The following examples are configured to use the `DecodaBbcode` engine.</p>

<div class="code-snippet"><?php
	$text = <<<TXT
Some [b]bold[/b] text and also some [i]italic[/i].
TXT;
echo $this->Bbcode->convert($text);
	?></div>

<div class="code-snippet"><?php
	$text = '[h1]hello world[/h1]
You can write text [url=http://example.com]with links[/url].

Here is a video embed:
[video=youtube]slDY7PguRfI[/video]';
echo $this->Bbcode->convert($text);
	?></div>

<div class="code-snippet"><?php
	$text = <<<TXT
An [abbr="my abbreviation"]abbreviation[/abbr], e.g. [abbr="National Aeronautics and Space Administration"]NASA[/abbr].

Also lets
[quote]quote something :)[/quote]
Because that's how it is done.
TXT;

	echo $this->Bbcode->convert($text);
	?></div>


<p>You can register your own custom converter filters, see docs for details.</p>
