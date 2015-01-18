<?php
use Cake\I18n\I18n;
?>

<div class="source-link" style="float: right;">
<?php if ($this->Session->read('Config.language') === 'de') { ?>
	<b>DE</b>
<?php } else { ?>
	<?php echo $this->Form->postLink('DE', array('?' => array('lang' => 'de'))); ?>
<?php } ?>
 |
<?php if ($this->Session->read('Config.language') === 'en') { ?>
	<b>EN</b>
<?php } else { ?>
	<?php echo $this->Form->postLink('EN', array('?' => array('lang' => 'en'))); ?>
<?php } ?>
</div>

<h2>I18n</h2>
<p>
Current locale (<code><?php echo h('echo I18n::locale();'); ?></code>): <b><?php echo I18n::locale();?></b>
</p>

<h3>
Let's try to translate something.
</h3>


<code><?php echo h("echo __('A simple string.');"); ?></code>
<pre>
<?php
	echo __('A simple string.');
?>
</pre>

<h3>Using Placeholders</h3>
<code><?php echo h("echo __('Hello, my name is {0}, I\'m {1} years old.', ['Sara', 12]);"); ?></code>
<pre>
<?php
	echo __('Hello, my name is {0}, I\'m {1} years old.', ['Sara', 12]);
?>
</pre>


<h3>Complex placeholders</h3>
<p><i>(Experimental)</i></p>

<code><?php echo h("echo __('You have traveled {0,number,decimal} kilometers in {1,number,integer} weeks.', [5423.344, 5.1]);"); ?></code>
<pre>
<?php
echo __(
	'You have traveled {0,number,decimal} kilometers in {1,number,integer} weeks.',
	[5423.344, 5.1]
);

?>
</pre>

<code><?php echo h("echo __('Your balance on the {0,date} is {1,number,currency}. {2,number,percent} more.', ['2014-01-13 11:12:00', 1354.376], 0.02);"); ?></code>
<pre>
<?php
echo __(
	'Your balance on the {0,date} is {1,number,currency}. {2,number,percent} more.',
	['2014-01-13 11:12:00', 1354.376, 0.02]
);
?>
</pre>