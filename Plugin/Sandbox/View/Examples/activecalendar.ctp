<?php
$style_array=array();
foreach ($this->Activecalendar->styles as $style)
{
	$style_array[$style]=false;
}

$active_style = !empty($active_style) ? $active_style : 'default';

if (array_key_exists($active_style, $style_array)) {
	$style_array[$active_style]=true;
} else {
	$style_array['default']=true;
}

$this->Activecalendar->includeFiles($active_style);
?>

<div>

<h1>JS Active Calendar (Date Picker)</h1>
Based on the JS script from 2006

<br />


<h2>Change Layout</h2>
Click on the Styles to change the Style for all the calendar-items on this page:<br />
<?php

foreach ($style_array as $style => $value)
{
	if ($value) {
		echo ' -&nbsp;<b>'.$style.'</b>&nbsp;- ';
	} else {
		echo ' -&nbsp;'.$this->Html->link('\''.$style.'\'', array('action'=>'activecalendar','style'=>$style)).'&nbsp;- ';
	}

}
?>
<br /><br />
This is done by the following function:
<?php
$data_print='$this->Activecalendar->includeFiles(); // includes default js and css files
## or ##
$this->Activecalendar->includeFiles(\''.$active_style.'\'); // specific style';
echo $this->Geshi->highlight($data_print,'php');
?>

<h2>Example</h2>
Just one id-tag is enough to get it to work:

<?php
$data_print='echo $this->Form->input(\'published\', array(
	\'type\'=>\'text\',
	\'class\'=>\'datepicker\',
	\'id\'=>$this->Activecalendar->setId() // this needs to be added each time
	));';
echo $this->Geshi->highlight($data_print,'php');
?>





<?php
echo $this->Form->input('published', array('type'=>'text','class'=>'datepicker','id'=>$this->Activecalendar->setId()));

?>

<br />

<h2>Advanced Example</h2>
You can pass a 'datatype' with the setId() - so date-formats can be changed at runtime:
<?php
$data_print='a) \'id\'=>$this->Activecalendar->setId(\'DD-MM-YYYY\') // reverse of YYYY-MM-DD
b) \'id\'=>$this->Activecalendar->setId(\'MM/DD/YYYY\') // american
c) \'id\'=>$this->Activecalendar->setId(\'DD.MM.YYYY\')	// german
';
echo $this->Geshi->highlight($data_print,'php');
?>

<?php
echo $this->Form->input('published a', array('type'=>'text','class'=>'datepicker','id'=>$this->Activecalendar->setId('DD-MM-YYYY')));
?>
<br />
<?php
echo $this->Form->input('published b', array('type'=>'text','class'=>'datepicker','id'=>$this->Activecalendar->setId('MM/DD/YYYY')));
?>
<br />
<?php
echo $this->Form->input('published c', array('type'=>'text','class'=>'datepicker','id'=>$this->Activecalendar->setId('DD.MM.YYYY')));
?>


<br />

<h2>ToDo</h2>
Rewrite the css styles.. they are not working properly due to not correctly named classes.<br />
Anyone interested? All files will immediately be reposted with the changes made.
<br /><br />
These are the original ones:<br/>
<?php
foreach ($style_array as $style => $value) {
echo ' - '.$this->Html->link('\''.$style.'\'','/ajax/activecalendar_old.php?style='.$style.'', array('onclick'=>$this->Highslide->onclick(array('contentId'=>'highslide','objectType'=>'iframe'),'html'))).' - ';
}
?>
<br /><br />
Maybe we can even make up some new and more modern ones..


<?php echo $this->Activecalendar->createInput('test', array('onclick'=>'ss'), array())?>

</div>