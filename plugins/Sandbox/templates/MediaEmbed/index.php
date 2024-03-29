<?php
/**
 * @var \App\View\AppView $this
 * @var \MediaEmbed\Object\MediaObject $mediaObject
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?php echo $this->element('navigation/media_embed'); ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>MediaEmbed</h2>
<p>
<a href="https://github.com/dereuromark/media-embed" target="_blank">[MediaEmbed]</a> is a PHP library to deal with media services, parsing their URLs and displaying audio/video as embed HTML code.
</p>

<h3>Parsing Video URL</h3>
<p>
	Try a public Youtube or Dailymotion URL etc.
</p>

<?php
echo $this->Form->create();
echo $this->Form->control('url', ['default' => $this->request->getQuery('url')]);
echo $this->Form->submit();
echo $this->Form->end();
?>


<?php
if (!empty($mediaObject)) {
?>
<h3>Result</h3>
	<p>
		Type: <b><?php echo h($mediaObject->name()); ?></b> | ID: <b><?php echo h($mediaObject->id()); ?></b>
	</p>

	<p>
	<code><?php echo h('echo $mediaObject->getEmbedCode()'); ?></code>:
</p>
<?php
	echo $mediaObject->getEmbedCode();
?>

	<h4>Details</h4>
	<?php
		$debugInfo = $mediaObject->__debugInfo();
	?>
	<pre><?php echo h(print_r($debugInfo, true)); ?></pre>
<?php
}
?>

</div>
