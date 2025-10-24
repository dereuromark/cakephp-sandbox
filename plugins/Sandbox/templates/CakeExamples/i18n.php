<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\I18n\I18n;

$langEn = locale_get_display_name('en');
$langDe = locale_get_display_name('de');

?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<div class="source-link" style="float: right;">
<?php if ($this->request->getSession()->read('Config.language') === 'en') { ?>
	<b><?php echo $langEn; ?></b>
<?php } else { ?>
	<?php echo $this->Form->postLink($langEn, ['?' => ['lang' => 'en']], ['title' => __('Switch language')]); ?>
<?php } ?>
 |
<?php if ($this->request->getSession()->read('Config.language') === 'de') { ?>
	<b><?php echo $langDe; ?></b>
<?php } else { ?>
	<?php echo $this->Form->postLink($langDe, ['?' => ['lang' => 'de']], ['title' => __('Switch language')]); ?>
<?php } ?>
 | <small><i>Add yours here</i></small>
</div>

<h2>I18n</h2>
<p>
Current locale (<code><?php echo h('echo I18n::getLocale();'); ?></code>): <b><?php echo locale_get_display_name(I18n::getLocale(), I18n::getLocale());?> [<?php echo I18n::getLocale();?>]</b>
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
<p><i>(Experimental - most doesn't seem to work properly in PHP5.4)</i></p>

<code><?php echo h("echo __('You have traveled {0,number,decimal} kilometers in {1,number,integer} weeks.', [5423.344, 5.1]);"); ?></code>
<pre>
<?php
echo __(
	'You have traveled {0,number,decimal} kilometers in {1,number,integer} weeks.',
	[5423.344, 5.1]
);

?>
</pre>

<code><?php echo h("echo __('Your balance on the {0,date} is {1,number,currency}. {2,number,percent} more.', [strtotime('2014-01-13 11:12:00'), 1354.376], 0.02);"); ?></code>
<pre>
<?php
echo __(
	'Your balance on the {0,date} is {1,number,currency}. {2,number,percent} more.',
	[strtotime('2014-01-13 11:12:00'), 1354.376, 0.02]
);
?>
</pre>
Note that the strtotime() call is <a href="http://php.net/manual/de/class.messageformatter.php#115841" target="_blank">necessary for PHP &lt; 5.5</a>.


<h4>Debugging</h4>
ICU version: <?php echo INTL_ICU_VERSION; ?>

</div></div>
