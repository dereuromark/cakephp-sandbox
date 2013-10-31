<h1>Pie-Chart:</h1>
Some Examples (just a basic CSS layout - you might want to improve it)

<br/>

<h2>Full one (with both auto-image legend and the ul-listed legend)</h2>
This one even uses its own pre-defined colors (no third value).<br />
The ul-listed legend can be set anywhere in the view (use css for color reference here).<br />
<br />
<?php
$eqData = array();

$eqData[] = array('English', 10);
$eqData[] = array('Spanish', 5);
$eqData[] = array('German', 25);
$eqData[] = array('Dutch', 2);

if ($this->Piechart->create($eqData)) {
	echo $this->Piechart->draw(180, 100, 20, '#ffffff', 1);
	echo $this->Piechart->legend();
}

$eqDataPrint = '$eq_data = array();

$eq_data[] = array(\'English\', 10);
$eq_data[] = array(\'Spanish\', 5);
$eq_data[] = array(\'German\', 25);
$eq_data[] = array(\'Dutch\', 2);

if ($this->Piechart->create($eq_data)) {
	echo $this->Piechart->draw(180, 100, 20, \'#ffffff\', 1);
	echo $this->Piechart->legend();
}';
?>
<br />
<a class="display" href="javascript:void(0)" onclick="toggleMe('example-1')">Show Source Code</a>
<div class="example" id="example-1" style="display:none">
<?php echo $this->Geshi->highlightText($eqDataPrint, 'php')?>
</div>
<br />


<br/>
<h2>With custom colors</h2>
The third value in the array stands for the color<br />
<br />

<?php
$eqData = array();

$eqData[] = array('Male', 10, '#999900');
$eqData[] = array('Female', 5, '#224422');
$eqData[] = array('Unknown', 25, '#00ffff');

//$this->set('eq_data', $eq_data);

if ($this->Piechart->create($eqData)) {
	echo $this->Piechart->draw(180, 100, 20, '#ffffff', 1);
}

$eqDataPrint = '$eq_data = array();

$eq_data[] = array(\'Male\', 10,\'#999900\');
$eq_data[] = array(\'Female\', 5,\'#224422\');
$eq_data[] = array(\'Unknown\', 25,\'#00ffff\');

if ($this->Piechart->create($eq_data)) {
	echo $this->Piechart->draw(180, 100, 20, \'#ffffff\', 1);
}';
?>
<br /><br />
<a class="display" href="javascript:void(0)" onclick="toggleMe('example-2')">Show Source Code</a>
<div class="example" id="example-2" style="display:none">
<?php echo $this->Geshi->highlightText($eqDataPrint, 'php')?>
</div>
<br />

<br />
<h2>Just the Pie</h2>
That's possible as well (forth value at the draw()-function to zero)<br />
<br />
<?php
$eqData = array();

$eqData[] = array('Young', 30, '#009999');
$eqData[] = array('Younger', 5, '#442244');
$eqData[] = array('Youngest', 25, '#ffff00');

//$this->set('eq_data', $eq_data);

if ($this->Piechart->create($eqData)) {
	echo $this->Piechart->draw(180, 100, 20, '#ffffff', 0);
}

$eqDataPrint = '$eq_data = array();

$eq_data[] = array(\'Young\', 30,\'#009999\');
$eq_data[] = array(\'Younger\', 5,\'#442244\');
$eq_data[] = array(\'Youngest\', 25,\'#ffff00\');

if ($this->Piechart->create($eq_data)) {
	echo $this->Piechart->draw(180, 100, 20, \'#ffffff\', 0);
}';
?>
<br /><br />
<a class="display" href="javascript:void(0)" onclick="toggleMe('example-3')">Show Source Code</a>
<div class="example" id="example-3" style="display:none">
<?php echo $this->Geshi->highlightText($eqDataPrint, 'php')?>
</div>
<br />