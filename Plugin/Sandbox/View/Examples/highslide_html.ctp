<?php
$this->Highslide->changeDefaultOverlays(array());
//pr($this->Highslide->default_options);
?>

<h1>Highslide:</h1>
The JS/CSS Sources can be found at the official <a href="http://vikjavev.no/highslide/" title="opens a new page" target="_blank">Highslide-Site</a>!

<br/>

<h2>What is it able to do</h2>
Read the official docs and try out the examples at the link above.
<br/>
Notice: this example page covers html/ajax/swl content etc (see also the first example page for images, if you have not done so far)
<br />

<h2>One line of code - and you can set all kinds of stuff as highslide-clickable</h2>
Take a onclick=""-attribute and insert the following code (here inside a link):
<?php
$dataPrint = '<a href="IMAGE.EXT" onclick="<?php echo $this->Highslide->onclick()?>"/>';
echo $this->Geshi->highlightText($dataPrint, 'php');
?>
It uses the href-tag for the image path and opens the link just as a normal one, if JS is not activated.<br />
I didn't use the html-&gt;image() helper-function to show the simple onclick element.

<br /><br />