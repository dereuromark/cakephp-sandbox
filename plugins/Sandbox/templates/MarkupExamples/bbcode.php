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

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<h2>BBcode to HTML</h2>
<a href="https://github.com/dereuromark/cakephp-markup" target="_blank">[Markup Plugin]</a>

<p>
To begin with, the lines you need to display code:
</p>
<?php
$dataPrint = '$bbcodeText = ...;' . PHP_EOL;
$dataPrint .= 'echo $this->Bbcode->convert($bbcodeText);';
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

</div></div>
