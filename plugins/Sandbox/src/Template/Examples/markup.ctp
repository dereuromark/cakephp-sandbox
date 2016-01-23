<?php
	echo $this->Html->css('Sandbox.highlighting/github.css');
?>

<script src="https://highlightjs.org/static/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>


<h2>Highlighter - Text Highlighting:</h2>
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
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'mysql']);

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

$dataPrint = 'User-agent: EmailCollector
Disallow: /

User-Agent: *
Disallow: /verzeichnis3/';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'robots']);


