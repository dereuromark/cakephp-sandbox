<?php
/**
 * @var \App\View\AppView $this
 */
use Carbon\Carbon;
?>

<h2>Carbon (extends DateTime)</h2>

<h3>Now</h3>
<?php
printf("Now: %s", Carbon::now());
?>


<h3>Age</h3>
1987-03-04: Age <?php echo Carbon::create('1987', '03', '04')->age; ?>

<h3>Timezone</h3>
<?php echo Carbon::now()->timezoneName; ?>

<h3>Localization</h3>
<?php echo Carbon::now()->format('l jS \\of F Y h:i:s A'); ?>
<br /><br />
German (setlocale(LC_TIME, 'German');)
<br />
<?php
	setlocale(LC_TIME, 'German');
	echo Carbon::now()->formatLocalized('%A %d %B %Y');
?>

<h3>Diffs</h3>
<?php
	echo h('Carbon::now()->subDays(24)->diffForHumans();');
	echo '<br/>';
	echo Carbon::now()->subDays(24)->diffForHumans();
?>