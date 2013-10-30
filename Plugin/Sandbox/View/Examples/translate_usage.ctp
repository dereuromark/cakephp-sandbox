<?php
$int=100;
if (!empty($this->request->params['named']['loops'])) {
	$int=(int)$this->request->params['named']['loops'];
}

if ($int>0 && $int<3001) {
} else {
	$int=100;
	echo '<div class="messages">';
		echo '<div class="message warning">';
			__('Not a valid loop integer! Changed to <b>'.$int.' loops</b>');
		echo '</div>';
	echo '</div>';
}

?>
<h1>Usage of the Cake Translate Function __()</h1>
What needs more time? <br>
Translating the usual way with __('This is a string to be translatet') with .po-files?
Or by dumping all translation strings into Global Constants with define('LANG_TRANSLATE_STRING', $value)?

<h2>Test Parameter</h2>
How many vars to read out (simulated as a loop):<br />
<?php
$times=array(10,50,100,500,1000,2000,3000);
foreach ($times as $time) {
	echo ' | '.$this->Html->link($time, array('controller'=>'examples','action'=>'translate_usage','loops'=>$time), array('title'=>'Click to change loop count')).' | ';
}
?>
<br />
<br />
<b>Test 1:</b>
$var = __('Translate String {ID}');	// TRUE because we dont want to print it
<br />
<br />
<b>Test 2:</b>
$var = LANG_TRANSLATE_STRING_{ID};

<br /><br />
Lets run different tests - one for both string and const. present, and one for each missing (beeing not defined).


<?php

$page_name = 'Translate String';
define('LANG_TRANSLATE_STRING', $page_name);


/** fixing some bug with the microtime timing */
$time_start = AppController::my_microtime();
$time_end = AppController::my_microtime();

for ($i=0;$i<2;$i++) {
	$var = __('Translate String');
}
for ($i=0;$i<2;$i++) {
	$var = LANG_TRANSLATE_STRING_X;
}



### .po string present, Constant MISSING ###

# versuch 1
$time_start = AppController::my_microtime();

for ($i=0;$i<$int;$i++) {
	$var = __('Translate String');
}

$time_end = AppController::my_microtime();
$time_p1 = $time_end - $time_start;
$time_p1 = round(($time_p1*1000),4);

# versuch 2
$time_start = AppController::my_microtime();

for ($i=0;$i<$int;$i++) {
	$var = LANG_TRANSLATE_STRING_X;
}

$time_end = AppController::my_microtime();
$time_p2 = $time_end - $time_start;
$time_p2 = round(($time_p2*1000),4);


### Constant present, .po string MISSING ###

# versuch 1
$time_start = AppController::my_microtime();

for ($i=0;$i<$int;$i++) {
	$var = __('Translate String_X');
}

$time_end = AppController::my_microtime();
$time_c1 = $time_end - $time_start;
$time_c1 = round(($time_c1*1000),4);

# versuch 2
$time_start = AppController::my_microtime();

for ($i=0;$i<$int;$i++) {
	$var = LANG_TRANSLATE_STRING;
}

$time_end = AppController::my_microtime();
$time_c2 = $time_end - $time_start;
$time_c2 = round(($time_c2*1000),4);




### Constant and .po string both present ###

# versuch 1
$time_start = AppController::my_microtime();

for ($i=0;$i<$int;$i++) {
	$var = __('Translate String');
}

$time_end = AppController::my_microtime();
$time_b1 = $time_end - $time_start;
$time_b1 = round(($time_b1*1000),4);

# versuch 2
$time_start = AppController::my_microtime();

for ($i=0;$i<$int;$i++) {
	$var = LANG_TRANSLATE_STRING;
}

$time_end = AppController::my_microtime();
$time_b2 = $time_end - $time_start;
$time_b2 = round(($time_b2*1000),4);




?>

<h2>Results</h2>
<div class="messages">

<div class="message success">
<b><?php echo $int?> loops</b> | Constant not defined<br />
_() Translating needed <b><?php echo $time_p1?></b> ms. - Constants Translating needed <b><?php echo $time_p2?></b> ms.
</div>

<div class="message success">
<b><?php echo $int?> loops</b> | .po-string not defined<br />
_() Translating needed <b><?php echo $time_c1?></b> ms. - Constants Translating needed <b><?php echo $time_c2?></b> ms.
</div>

<div class="message success">
<b><?php echo $int?> loops</b> | BOTH Present<br />
_() Translating needed <b><?php echo $time_b1?></b> ms. - Constants Translating needed <b><?php echo $time_b2?></b> ms.
</div></div>



Its not that much of a gain - but you are now able to handle them more dynamically with the const.-version. You can split them up into a file for each controller if you want and use them anywhere in your project. Not beeing able to set the language in the model can be quite problematic, especially with complicated and widely used validation. You needed to do that in the view - and if one needs to changed you better find all the other ones in the different views as well. Now you can set it in the validation:
<pre>public $validate = array(
	'name' => array(
		'isUnique' => array(
	 		'rule' => array('isUnique'),
	 		'message' => LANG_NAME_ALREADY_TAKEN
		'minLength' => array(
	 		'rule' => array('minLength', 3),
	 		'message' => LANG_AT_LEAST_3
		),
	),
);</pre>
which covers the "never repeat yourself principle


<br />
<h2>Conclusion</h2>
If you really intend to use I10n and L18i for multiple language support - you might want to consider this approach.
<br />Although you might lose some interesting functionality of the __() Function (like singular/plural).
<br /><br />
The sprintf() function though can still be used:
<pre>define('LANG_AT_LEAST','At least %s characters');

// model:
	...
	'message' => sprintf(LANG_AT_LEAST,3)
	...
</pre>

<?php
?>