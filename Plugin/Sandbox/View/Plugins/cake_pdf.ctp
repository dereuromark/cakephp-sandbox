<?php
$engines = array(
	'DomPdf' => 'dom',
	'WkHtmlToPdf' => 'wk',
	'Tcpdf' => 'tc',
	//'Mpdf' => 'm'
);
?>

<h2>Pdf Tests</h2>
<ul>
<?php foreach ($engines as $engine => $action) { ?>
	<li><b><?php echo $this->Html->link($engine, array('action' => 'pdf_test', $action, 'ext' => 'pdf')); ?></b> | <?php echo $this->Html->link('Custom Download Filename', array('action' => 'pdf_test', $action, 'foo-bar', 'ext' => 'pdf')); ?> | <?php echo $this->Html->link('Force Download', array('action' => 'pdf_test', $action, 'ext' => 'pdf', '?' => array('download' => 1))); ?></li>
<?php } ?>
	<li>Mpdf has been removed as it was quite buggy</li>
</ul>

<p>
Note the <i>Custom Download Filename trick</i> when displaying PDFs that you want the user to manually download.
</p>

