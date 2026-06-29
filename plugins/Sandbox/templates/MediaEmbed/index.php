<?php
/**
 * @var \App\View\AppView $this
 * @var \MediaEmbed\Object\MediaObject|null $mediaObject
 * @var bool $privacy
 * @var bool $responsive
 * @var bool $customize
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

<p>
	Now bundles <b>35+ services</b> (YouTube, Vimeo, TikTok, Spotify, TED, Sketchfab, Apple Podcasts, Deezer, ...).
	See the full list under <?php echo $this->Html->link('Hosts', ['action' => 'hosts']); ?>.
</p>

<h3>Parsing Video URL</h3>
<p>
	Try a public Youtube, Vimeo, TED, Spotify or Dailymotion URL etc.
</p>

<?php
$demoUrls = [
	'YouTube' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
	'Vimeo' => 'https://vimeo.com/channels/staffpicks/99585787',
	'TED' => 'https://www.ted.com/talks/sir_ken_robinson_do_schools_kill_creativity',
	'Spotify' => 'https://open.spotify.com/track/4iV5W9uYEdYUVa79Axb7Rh',
	'Sketchfab' => 'https://sketchfab.com/3d-models/the-great-drawing-room-2QpgjMeXKHq6L8KIBAJjRrFV3jg',
];
?>
<p>
	<b>Demo URLs:</b>
	<?php $links = [];
	foreach ($demoUrls as $label => $url) {
		$links[] = $this->Html->link($label, ['action' => 'index', '?' => ['url' => $url]]);
	}
	echo implode(' &middot; ', $links);
	?>
</p>

<?php
echo $this->Form->create();
echo $this->Form->control('url', ['default' => $this->request->getData('url') ?: $this->request->getQuery('url')]);
echo $this->Form->control('privacy', ['type' => 'checkbox', 'checked' => $privacy, 'label' => 'Privacy mode (no-cookie / dnt)']);
echo $this->Form->control('responsive', ['type' => 'checkbox', 'checked' => $responsive, 'label' => 'Show responsive (16:9) embed']);
echo $this->Form->control('customize', ['type' => 'checkbox', 'checked' => $customize, 'label' => 'Customize via immutable withParam()/withAttribute()']);
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

	<h4>Embed source</h4>
	<pre><?php echo h($mediaObject->getEmbedSrc()); ?></pre>

<?php
	if (!empty($responsive)) {
?>
	<h4>Responsive embed</h4>
	<p><code><?php echo h('echo $mediaObject->getResponsiveEmbedCode()'); ?></code>:</p>
	<div style="max-width:640px;"><?php echo $mediaObject->getResponsiveEmbedCode(); ?></div>
	<pre><?php echo h($mediaObject->getResponsiveEmbedCode()); ?></pre>
<?php
	}
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
