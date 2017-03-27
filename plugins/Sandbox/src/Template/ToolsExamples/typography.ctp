<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Typography</h2>

<h3>Preparation</h3>
Use the Typographic behavior to assert that all "localized" characters are correctly transformed back
into standard chars. The database is supposed to be "clean"/uniform.
On output then we can use the helper to format it the way we want it to (American, German, French, ...).

<h3>Helper usage</h3>
<?php
	$text = <<<TEXT
This is some "Interesting Quote" and other's peoples notes on a specific 'topic'.

Please mind the new "paragraph with 'inside quotes' in it"!
TEXT;
?>


Default (for English for example):
<code style="display: block;">
<?php echo $this->Typography->autoTypography($text); ?>
</code>

Low (German, ...):
<code style="display: block;">
<?php
	Configure::write('App.language', 'deu');
	echo $this->Typography->autoTypography($text); ?>
</code>

Angle (France, ...):
<code style="display: block;">
<?php
	Configure::write('App.language', 'fra');
	echo $this->Typography->autoTypography($text); ?>
</code>