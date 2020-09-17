<?php
/**
 * @var \App\View\AppView $this
 */

use Cake\Core\Configure;

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/tools'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h2>Typography</h2>

<h3>Preparation</h3>
<p>
Use the Typographic behavior to assert that all "localized" characters are correctly transformed back
into standard chars. The database is supposed to be "clean"/uniform.
On output then we can use the helper to format it the way we want it to (American, German, French, ...).
</p>

<h3>Helper usage</h3>
<?php
	$text = <<<TEXT
This is some "Interesting Quote" and other's peoples notes on a specific 'topic'.

Please mind the new "paragraph with 'inside quotes' in it"!
TEXT;
?>

<p>This is the original text from the database/source:</p>
<code style="display: block; margin-bottom: 10px;">
	<?php echo $this->Text->autoParagraph($text); ?>
</code>

<h4>Now, let's adjust the typography per target audience.</h4>

<p>Default (for English for example):</p>
<code style="display: block; margin-bottom: 10px;">
<?php echo $this->Typography->autoTypography($text); ?>
</code>

<p>Low (German, ...):</p>
<code style="display: block; margin-bottom: 10px;">
<?php
	Configure::write('App.language', 'deu');
	echo $this->Typography->autoTypography($text); ?>
</code>

<p>Angle (France, ...):</p>
<code style="display: block;">
<?php
	Configure::write('App.language', 'fra');
	echo $this->Typography->autoTypography($text); ?>
</code>

</div>
