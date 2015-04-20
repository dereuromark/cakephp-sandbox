<?php
$int = 100;
if (!empty($this->request->params['named']['loops'])) {
	$int = (int)$this->request->params['named']['loops'];
}

if ($int > 0 && $int < 3001) {
} else {
	$int = 100;
	echo '<div class="messages">';
		echo '<div class="message warning">';
			__('Not a valid loop integer! Changed to <b>' . $int . ' loops</b>');
		echo '</div>';
	echo '</div>';
}

?>
<h1>Usage of Configure:read()</h1>
What needs more time? <br>
Reading certain Configuration stuff the usual way with Configure::read('Variable.value') ?
Or by setting all Configuration Information into Global Constants with define('VARIABLE', $value)?

<h2>Test Parameter</h2>
How many vars to read out (simulated as a loop):<br />
<?php
$times = [10, 50, 100, 500, 1000, 2000, 3000];
foreach ($times as $time) {
	echo ' | ' . $this->Html->link($time, ['controller' => 'examples', 'action' => 'configure_usage', 'loops' => $time], ['title' => 'Click to change loop count']) . ' | ';
}
?>
<br />
<br />
<b>Test 1:</b>
$var = Configure::read('Config.page_name');
<br />
<br />
<b>Test 2:</b>
$var = PAGE_NAME;

<?php
App::uses('Utility', 'Tools.Utility');

$pageName = Configure::read('Config.page_name');
define('PAGE_NAME_FAKE', $pageName);


/** fixing some bug with the microtime timing */
$timeStart = Utility::microtime();
$timeEnd = Utility::microtime();


# versuch 1
$timeStart = Utility::microtime();

for ($i = 0;$i < $int;$i++) {
	$var = Configure::read('Config.page_name');
}

$timeEnd = Utility::microtime();
$time1 = $timeEnd - $timeStart;
$time1 = round(($time1 * 1000), 4);

# versuch 2
$timeStart = Utility::microtime();

for ($i = 0;$i < $int;$i++) {
	$var = PAGE_NAME_FAKE;
}

$timeEnd = Utility::microtime();
$time2 = $timeEnd - $timeStart;
$time2 = round(($time2 * 1000), 4);


?>

<h2>Results</h2>
<div class="messages">
<div class="message success">
<b><?php echo $int?> loops</b><br />
Configure Reading needed <b><?php echo $time1?></b> ms. - Constants Reading needed <b><?php echo $time2?></b> ms.
</div></div>

With 10-20 Configuration Infos needed on a page, this does not really matter. BUT as soon as the project is getting bigger, it is more likely that you have to read out quite a lot variables from your configuration settings (some might be stored in the database, and get written into the config at runtime - as it is on this page). So we are now talking about maybe 50-300 variables.<br />
So we need Configure::read('Config.page_name') to run 50-300 times.<br />
The difference in duration clearly shows us, that <b>it is better to store this kind of information in Constants</b> - as long as they dont have to be changed anymore while loading the page(!). But this should not be the case with almost all your site-wide config settings.<br />
Examples are 'admin email','page name', 'max email until floodProtection', 'allow guests to post', 'pw_minlength', 'maintenance mode (site shut down)' etc.
<br /><br />
Other ones as "language" or "debug" are stored in these Configuration arrays for a reason - because user input or some functions can change the value. it doesnt make sense to store them in constants.



<br />
<h2>Conclusion</h2>
I was really surprised about how much more loading time the 2nd one needed.
This was the point where i changed my former way of setting and reading out configuration values.<br /><br />
To be able to adjust they are stored in the DB (table "configurations") and read out in the before_filter() function in the app_controller.
Now i deleted my old way of writing them into an array:
<pre>
foreach (...) { Configure::write('Config.'.$variable, $value); }
</pre>
And do it this way:
<pre>
foreach (...) { define(strtoupper($variable), ''.$value); }
</pre>

<br>
Besides that, it is now way easier and shorter to access the content of my configuration. Just use the constanct directly.
<?php
