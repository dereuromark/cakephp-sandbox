<?php
/**
 * @var \App\View\AppView $this
 */
$engines = [
	'DomPdf' => 'dom',
	'WkHtmlToPdf' => 'wk',
	'Tcpdf' => 'tc',
	//'Mpdf' => 'm'
];
?>

<h2>Pdf Tests</h2>
For details on how to use it see <a href="http://www.dereuromark.de/2014/04/08/generating-pdfs-with-cakephp/">generating-pdfs-with-cakephp</a> or the <a href="https://github.com/ceeram/CakePdf">CakePDF plugin</a> directly.

<ul>
	<li><b><?php echo $this->Html->link('The plain HTML template', ['action' => 'pdf_test']); ?></b></li>
<?php foreach ($engines as $engine => $action) { ?>
	<li><b><?php echo $this->Html->link($engine, ['action' => 'pdf_test', $action, '_ext' => 'pdf']); ?></b> | <?php echo $this->Html->link('Custom Download Filename', ['action' => 'pdf_test', $action, 'foo-bar', '_ext' => 'pdf']); ?> | <?php echo $this->Html->link('Force Download', ['action' => 'pdf_test', $action, '_ext' => 'pdf', '?' => ['download' => 1]]); ?></li>
<?php } ?>
	<li>Mpdf has been removed as it was quite buggy</li>
</ul>

<h3>Notes</h3>
<p>For me DomPdf was the one working out of the box on all systems. Even though slower than WkHtmlToPdf that usually suffices for background PDF tasks.
<br />WkHtmlToPdf on the other hand seems to support some more advanced CSS features like floating etc. With the custom binary path you can make WkHtmlToPdf work both on linux and windows without problems.</p>

<p>
Note that it's best to use PNG images, as GIF don't seem to work with most PDF engines.
</p>
<p>
Also note the <i>Custom Download Filename trick</i> from <a href="http://www.dereuromark.de/2011/11/21/serving-views-as-files-in-cake2">here</a> when displaying PDFs that you want the user to display the PDF first and manually download afterwards. This will ensure the filename is what it was intended to be.
</p>

<h3>Installation of WkHtmlToPdf</h3>
I got the binary files from <a href="http://code.google.com/p/wkhtmltopdf/downloads/list">code.google.com/p/wkhtmltopdf/downloads/list</a>.
Put them somewhere in your app or on your system and link them via `Configure::write('CakePdf.binary', $path)`.
In my case:
<pre>
if (WINDOWS) {
	Configure::write('CakePdf.binary', APP . 'files\wkhtmltopdf\wkhtmltopdf.exe');
} else {
	Configure::write('CakePdf.binary', APP . 'files/wkhtmltopdf/bin/wkhtmltopdf');
}
</pre>