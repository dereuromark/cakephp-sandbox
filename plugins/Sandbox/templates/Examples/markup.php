<?php
/**
 * @var \App\View\AppView $this
 */
if ($this->request->getQuery('dark')) {
	$file = '//highlightjs.org/static/demo/styles/hybrid.css';
} else {
	$file = 'Sandbox.highlighting/github.css';
}
echo $this->Html->css($file);
?>

<script src="https://highlightjs.org/static/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>


<h2>Highlighter - Text Highlighting:</h2>
<a href="https://github.com/dereuromark/cakephp-markup" target="_blank">[Markup Plugin]</a>


To begin with, the lines you need to display code:
<?php
$dataPrint = '$var = \'Some <b>Text</b> as PHP Code\';
$this->Highlighter->highlight($var, [\'lang\' => \'php\']);';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php']);
?>
<p>
1. parameter: String to Print<br>
2. parameter: Array with lang key: What kind of Code (PHP, SQL, CSS, JS etc)<br />
</p>

The following examples are configured to use the `JsHighlighter`.

<h3>Some Examples - what you can do with it</h3>
<?php
$dataPrint = 'div.paging {
	background:#fff;
	color: #ccc;
	margin-bottom: 2em;
}
div.paging div.disabled {
	color: #ddd;
	display: inline;
}
div.paging span {
}';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'css']);

$dataPrint = 'function toggleMe(id) {
	var e=document.getElementById(id);
	if (!e)return true;
	if (e.style.display=="none") {
		e.style.display="block"
	} else {
		e.style.display="none"
	}
	return true;
}';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'javascript']);

$dataPrint = '<b>Wow</b>
<u> Underline text</u>
<input type="text"/>';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'html4strict']);

$dataPrint = 'SELECT * FROM `telbuch_types`
WHERE `user_name` = \'testmensch\'
ORDER BY userid ASC LIMIT 0 , 30 ';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'sql']);

$dataPrint = '<addresses>
 <person>
	 <name>
		 <first>Ingo</first>
		 <last>Melzer</last>
	 </name>
	 <city>Laupheim</city>
	 <country>Germany</country>
 </person>
 <person>
	 <name>
		 <first>Andreas F.</first>
		 <last>Borchert</last>
	 </name>
	 <city>Lonsee</city>
	 <country>Germany</country>
 </person>
</addresses>';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'xml']);

$dataPrint = '# hello world

you can write text [with links](http://example.com) inline or [link references][1].

* one _thing_ has *em*phasis
* two __things__ are **bold**

[1]: http://example.com

---

hello world
===========

<this_is inline="xml"></this_is>

> markdown is so cool

	so are code segments

1. one thing (yeah!)
2. two thing `i can write code`, and `more` wipee!';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'markdown']);
?>

<p>
<?php echo $this->Html->link('Dark Theme', ['?' => ['dark' => 1]]); ?> | More examples directly at <a href="https://highlightjs.org/static/demo/" target="_blank">highlightjs.org/static/demo</a>
</p>
