<h1>Geshi - TextHighlighting:</h1>
To begin with, the lines you need to display code:
<?php
$data_print='$var=\'Some <b>Text</b> for Geshi\';
$this->Geshi->highlightText($var,\'php\',\'none\');';
echo $this->Geshi->highlightText($data_print,'php');
?>
1. parameter: String to Print<br>
2. parameter: What kind of Code (PHP, SQL, CSS, JS etc)<br />
3. parameter: Numbering (none, normal, fancy)
<br/><br/>

<h2>Some Examples - what you can do with it</h2>
<?php
$data_print='div.paging {
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
echo $this->Geshi->highlightText($data_print,'css');

$data_print='function toggleMe(id) {
 var e=document.getElementById(id);
 if (!e)return true;
 if (e.style.display=="none") {
	e.style.display="block"
 } else {
	e.style.display="none"
 }
 return true;
}';
echo $this->Geshi->highlightText($data_print,'javascript');

$data_print='<b>Wow</b>
<u> Underline text</u>
<input type="text"/>';
echo $this->Geshi->highlightText($data_print,'html4strict');


$data_print='SELECT * FROM `telbuch_types`
WHERE `user_name` = \'testmensch\'
ORDER BY userid ASC LIMIT 0 , 30 ';
echo $this->Geshi->highlightText($data_print,'mysql');

$data_print='<addresses>
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
echo $this->Geshi->highlightText($data_print,'xml');

$data_print='User-agent: EmailCollector
Disallow: /

User-Agent: *
Disallow: /verzeichnis3/';
echo $this->Geshi->highlightText($data_print,'robots');


?>