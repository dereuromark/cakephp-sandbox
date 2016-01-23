<h1>Some basic php functions</h1>
Their correct usage is especially important at validating user input.<br />
PHP version: PHP5
<br/><br/>
Our test variable contents are:
<?php
$vars = [];
$vars[1] = 0;
$vars[] = null;
$vars[] = false;
$vars[] = true;
$vars[] = '';
$vars[] = ' ';
$vars[] = 'something';
$vars[] = [];
$vars[] = '0';

$dataPrint = '$var1=0;
$var2=null;
$var3=false;		// boolean
$var4=true;		// boolean
$var5=\'\';
$var6=\' \';		// whitespace
$var7=\'something\';
$var8=array();		// empty array
$var9=\'0\';';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php'])
?>
Lets test them...
<br />







<table class="phpfunctions"><tr><td>
<h2>isset($var)</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	echo '<tr><td>$var' . $var . ':</td>';
	if (isset($v)) {
		echo '<td class="yes">isset</td>';
	} else {
		echo '<td class="no">not isset</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<h2>$var [ if ($var) ]</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	echo '<tr><td>$var' . $var . ':</td>';
	if ($v) {
		echo '<td class="yes">isset</td>';
	} else {
		echo '<td class="no">not isset</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td></tr></table>

<br />
Obviosly, <b>if (isset($var))</b> and <b>if ($var)</b> check two completely different things.<br />
In the second case it has to be a non-empty string or boolean TRUE. The first one (as far as php.net writes) "Returns TRUE if $var exists; FALSE otherwise."

<br />

<table class="phpfunctions"><tr><td>
<h2>!empty($var)</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	echo '<tr><td>$var' . $var . ':</td>';
	if (!empty($v)) {
		echo '<td class="yes">not empty</td>';
	} else {
		echo '<td class="no">empty</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td>
<td>&nbsp;&nbsp;</td>
<td>

<h2>$var!='' [ if ($var!='') ]</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	echo '<tr><td>$var' . $var . ':</td>';
	if ($v != '') {
		echo '<td class="yes">not empty</td>';
	} else {
		echo '<td class="no">empty</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td></tr></table>

<br />
<b>if (!empty($var))</b> is better then <b>if ($var!='')</b> - not only because the second one throws a warning if the variable hasnt been defined before.<br />The first one also checks for empty arrays.


<br />

<table class="phpfunctions"><tr><td>
<h2>$var == null [not recommended]</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v) {
	echo '<tr><td>$var' . $var . ':</td>';
	if ($v == null) {
		echo '<td class="yes">empty</td>';
	} else {
		echo '<td class="no">not empty</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<h2>is_array($var)</h2>
<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	echo '<tr><td>$var' . $var . ':</td>';
	if (is_array($v)) {
		echo '<td class="yes">is array</td>';
	} else {
		echo '<td class="no">is not array</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td></tr></table>

<br />
Ok, not that interesting :)<br />
Although it should be noted that == null is not exactly the same as empty() - at least for empty arrays.

<br />
<br />
<h2>Conclusions</h2>
To filter out any unneccesary or even validation breaking whitespaces, use <b>trim()</b> on them before checking the variable:
<br />
<?php
$dataPrint = '$x=\' string with whitespaces on both ends \'
$y=\' \'	// whitespace that breaks !empty() validation

$x=trim($x);
$y=trim($y);

if (!empty($x) && !empty($y))
{
	...
}';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php']);
