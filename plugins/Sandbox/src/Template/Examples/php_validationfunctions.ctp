<h1>Some validation (and basic sanitizing) php functions</h1>
Their correct usage is especially important at validating user input.<br />
PHP version: PHP5
<br/><br/>
Our test variable contents are:
<?php
$vars = [];
$vars[1] = 0;
$vars[2] = '0';
$vars[3] = 1;
$vars[4] = '1';

$vars[5] = null;
$vars[6] = false;	// boolean
$vars[7] = true;	// boolean
$vars[8] = '';
$vars[9] = 'string';
$vars[10] = '123string';	// integer with string
$vars[11] = 1.21;
$vars[12] = '1.21';



$dataPrint = '$var1=0;
$var2=\'0\';
$var3=1;
$var4=\'1\';

$var5=null;
$var6=false;	// boolean
$var7=true;	// boolean
$var8=\'\';
$var9=\'string\';
$var10=\'123string\';	// integer with string
$var11=1.21;
$var12=\'1.21\';';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php'])
?>
Lets test them...
<br />

<table class="phpfunctions"><tr><td>
<h2>is_int()</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	echo '<tr><td>$var' . $var . ':</td>';
	if (is_int($v)) {
		echo '<td class="yes">is integer</td>';
	} else {
		echo '<td class="no">is not integer</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<h2>(int) [ sanatize ] =&gt; is_int()</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	$v = (int)$v;
	echo '<tr><td>$var' . $var . ':</td>';
	if (is_int($v)) {
		echo '<td class="yes">is integer</td>';
	} else {
		echo '<td class="no">is not integer</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td></tr></table>

<br />
In my opinion it is better to first use <b>(int)</b> to sanatize the input which is expected to be integer. As 3 and 4 show, even integer values from a string can be used (like via $_GET[]).
<br />
Besides <b>is_int()</b>, validation in CakePHP can benifit from it as well. I always use it in the controllers - before actually querying the database.
<?php
$dataPrint = '# Usually cakePHP does it this way (e.g. console baking)
if (!$id) {
	...
} else {
	...
}

# now my function
function view($id = null) {
$id=(int)$id;
if ($id>0) {
	...
} else {
	...
}';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php']);?>
As you would see in the "<?php echo $this->Html->link('basicfunctions example', ['action' => 'php_basicfunctions'])?>" the usual way queries even if $id contains bad content. Why should we query the database about '123string' or ' ' if it would result in 0 rows anyway? Going my way we only use real integers - what the primary fields usually are.

<br />

<h2>For the sake of completeness the not so strict numberic function:</h2>

If the input doesnt have to be an integer refering to a primary key in your database, you could use this function to determine if the value is valid (any number).
<br /><br />
The above $var variables would result in:

<table class="phpfunctions"><tr><td>
<h2>is_numeric()</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	echo '<tr><td>$var' . $var . ':</td>';
	if (is_numeric($v)) {
		echo '<td class="yes">is integer</td>';
	} else {
		echo '<td class="no">is not integer</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td>
<td>&nbsp;&nbsp;</td>
<td>
<h2>(float) [ sanatize ] =&gt; is_numeric()</h2>
	<table width="99%">
<?php
foreach ($vars as $var => $v)
{
	$v = (float)$v;
	echo '<tr><td>$var' . $var . ':</td>';
	if (is_numeric($v)) {
		echo '<td class="yes">is integer</td>';
	} else {
		echo '<td class="no">is not integer</td>';
	}
	echo '<td class="content">' . $v . '</td></tr>';
}
?>
	</table>
</td></tr></table>
<br />
This could be used for the validation of the following inputs:<br />
weight, size, messurements, etc.<br />
Again, all invalid fields value to 0, we just have to test on <b>&gt;0</b> [bigger zero].
