<?php
$int = 500;
if (!empty($this->request->params['named']['loops'])) {
	$int = (int)$this->request->params['named']['loops'];
}

if ($int > 0 && $int < 20001) {
} else {
	$int = 500;
	echo '<div class="messages">';
		echo '<div class="message warning">';
			__('Not a valid loop integer! Changed to <b>' . $int . ' loops</b>');
		echo '</div>';
	echo '</div>';
}

$array = [];
for ($i = 0;$i < $int;$i++) {
	$array[] = mt_rand(11111, 99999);
}
?>
<h1>About count() and sizeof()</h1>
I stumpled upon a "sizof vs. count" thing at <?php echo $this->Html->link('codesnippets.joyent.com/tag/count', 'http://codesnippets.joyent.com/tag/count', ['target' => '_blank'])?>.
And i just had to check it out :)
<br/>
<h2>Test Parameter</h2>
How much shall the array contain (stored in a loop):<br />
<?php
$times = [500, 1000, 2000, 4000, 8000, 15000, 20000];
foreach ($times as $time) {
	echo ' | ' . $this->Html->link($time, ['controller' => 'examples', 'action' => 'php_arraycount', 'loops' => $time], ['title' => 'Click to change loop count']) . ' | ';
}
?>
<br/><br/>
Our test array is the following:
<?php

$dataPrint = '$array(\'12121\', ..., \'23232\'); // gets filled according to the loops';
echo $this->Highlighter->highlight($dataPrint, ['lang' => 'php'])
?>

With for ($i=0;$i&lt;$int;$i++) we fill it with random numbers.<br />
And then we run the 2 functions on them - getting the (of course already known) array rows.
<br />

<?php
/** fixing some bug with the microtime timing */
$timeStart = AppController::my_microtime();
$timeEnd = AppController::my_microtime();

# versuch 1
$timeStart = AppController::my_microtime();

$count = count($array);

$timeEnd = AppController::my_microtime();
$timeP1 = $timeEnd - $timeStart;
$timeP1 = round(($timeP1 * 1000), 4);

# versuch 2
$timeStart = AppController::my_microtime();

$count = sizeof($array);

$timeEnd = AppController::my_microtime();
$timeP2 = $timeEnd - $timeStart;
$timeP2 = round(($timeP2 * 1000), 4);


# Now switching

# versuch 1
$timeStart = AppController::my_microtime();

$count = sizeof($array);

$timeEnd = AppController::my_microtime();
$timeP3 = $timeEnd - $timeStart;
$timeP3 = round(($timeP3 * 1000), 4);

# versuch 2
$timeStart = AppController::my_microtime();

$count = count($array);

$timeEnd = AppController::my_microtime();
$timeP4 = $timeEnd - $timeStart;
$timeP4 = round(($timeP4 * 1000), 4);
?>


<h2>Results</h2>
<div class="messages">

<div class="message success">
<b><?php echo $int?> loops</b> | First count, then sizeof<br />
count() needed <b><?php echo $timeP1?></b> ms. - sizeof() needed <b><?php echo $timeP2?></b> ms.
</div>

<div class="message success">
<b><?php echo $int?> loops</b> | Switched the processing order<br />
count() needed <b><?php echo $timeP4?></b> ms. - sizeof() needed <b><?php echo $timeP3?></b> ms.
</div>
</div>
We made a second run and switched the two functions - just to make sure, there is no php caching or whatever involved.


<br />
<h2>Conclusion</h2>
This guy does not seem to be right about this. It doesn't matter which one you prefer (i use the count() usually).<br />
<br />Well, he was right about count() beeing slower - but after all, these 0.005 ms total difference (on more than 20000 array rows) doesnt really matter, does it?<br />
So another mythos got busted.
