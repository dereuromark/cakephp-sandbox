<?php
/**
 * @var \App\View\AppView $this
 * @var \MediaEmbed\Object\MediaObject|null $mediaObject
 * @var bool $privacy
 * @var bool $responsive
 * @var bool $customize
 * @var bool $placeholder
 * @var bool $oEmbed
 * @var bool $oEmbedOnly
 * @var \MediaEmbed\OEmbed\OEmbedResponse|null $oEmbedResponse
 * @var string|null $oEmbedHtml
 * @var string|null $oEmbedError
 * @var string|null $thumbnail
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
	Now bundles <b>45+ services</b> (YouTube, Vimeo, TikTok, Spotify, TED, Sketchfab, Apple Podcasts, Deezer, Bluesky, Flickr, Tumblr, Speaker Deck, ...).
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
$oEmbedOnlyDemoUrls = [
	'Bluesky' => 'https://bsky.app/profile/bsky.app/post/3mbhel6ij7s2y',
	'Flickr' => 'https://www.flickr.com/photos/bees/2341623661/',
	'Speaker Deck' => 'https://speakerdeck.com/speakerdeck/introduction-to-speakerdeck',
	'Tumblr' => 'https://staff.tumblr.com/post/822057428507049984/in-case-youre-looking-for-a-blog-thats-gone',
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
<p>
	<b>oEmbed-only demo URLs</b> (no static iframe URL, markup comes from the provider):
	<?php $links = [];
	foreach ($oEmbedOnlyDemoUrls as $label => $url) {
		$links[] = $this->Html->link($label, ['action' => 'index', '?' => ['url' => $url]]);
	}
	echo implode(' &middot; ', $links);
	?>
	<br>
	See <?php echo $this->Html->link('oEmbed', ['action' => 'oembed']); ?> for how those providers are configured.
</p>

<?php
echo $this->Form->create();
echo $this->Form->control('url', ['default' => $this->request->getData('url') ?: $this->request->getQuery('url')]);
echo $this->Form->control('privacy', ['type' => 'checkbox', 'checked' => $privacy, 'label' => 'Privacy mode (no-cookie / dnt)']);
echo $this->Form->control('responsive', ['type' => 'checkbox', 'checked' => $responsive, 'label' => 'Show responsive (16:9) embed']);
echo $this->Form->control('placeholder', ['type' => 'checkbox', 'checked' => $placeholder, 'label' => 'Show click-to-load (GDPR two-click) placeholder']);
echo $this->Form->control('oembed', ['type' => 'checkbox', 'checked' => $oEmbed, 'label' => 'Fetch oEmbed data (performs an HTTP request to the provider)']);
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

<?php
	if ($oEmbedOnly) {
?>
	<div class="alert alert-info">
		This provider is <b>oEmbed-only</b>: it exposes no static iframe URL.
		<code><?php echo h('$mediaObject->getEmbedCode()'); ?></code> would throw
		<code>EmbedCodeUnavailableException</code> here - use
		<code><?php echo h('$mediaEmbed->oEmbedHtml($mediaObject)'); ?></code> instead (see below).
	</div>
<?php
	} else {
?>
	<p>
	<code><?php echo h('echo $mediaObject->getEmbedCode()'); ?></code>:
</p>
<?php
		echo $mediaObject->getEmbedCode();
?>

	<h4>Embed source</h4>
	<pre><?php echo h($mediaObject->getEmbedSrc()); ?></pre>
<?php
	}
?>

<?php
	if (!empty($responsive) && !$oEmbedOnly) {
?>
	<h4>Responsive embed</h4>
	<p><code><?php echo h('echo $mediaObject->getResponsiveEmbedCode()'); ?></code>:</p>
	<div style="max-width:640px;"><?php echo $mediaObject->getResponsiveEmbedCode(); ?></div>
	<pre><?php echo h($mediaObject->getResponsiveEmbedCode()); ?></pre>
<?php
	}
?>

<?php
	if (!empty($placeholder) && !$oEmbedOnly) {
		$placeholderCode = $mediaObject->getPlaceholderEmbedCode(['thumbnail' => $thumbnail]);
?>
	<h4>Click-to-load placeholder</h4>
	<p>
		<code><?php echo h('echo $mediaObject->getPlaceholderEmbedCode()'); ?></code>:
		nothing is requested from the provider until the user clicks. The real iframe sits in a
		<code>&lt;template&gt;</code>, with a <code>&lt;noscript&gt;</code> fallback.
		No thumbnail is loaded by default - a remote preview image would contact the third party before
		consent. <?php echo $thumbnail ? 'The preview below was passed in explicitly from the fetched oEmbed data.' : 'Tick the oEmbed option above to pass one in explicitly.'; ?>
	</p>
	<div style="max-width:640px;"><?php echo $placeholderCode; ?></div>
	<pre><?php echo h($placeholderCode); ?></pre>
	<p>
		Activation comes from one shared, CSP-friendly snippet printed once per page
		(idempotent, event-delegated, no inline handlers):
	</p>
	<pre><?php echo h('<script>' . \MediaEmbed\Object\MediaObject::placeholderScript() . '</script>'); ?></pre>
	<script><?php echo \MediaEmbed\Object\MediaObject::placeholderScript(); ?></script>
<?php
	}
?>

<?php
	if ($oEmbed || $oEmbedOnly) {
?>
	<h4>oEmbed</h4>
<?php
		if ($oEmbedError) {
?>
	<div class="alert alert-warning"><?php echo h($oEmbedError); ?></div>
<?php
		}
		if ($oEmbedResponse) {
?>
	<p><code><?php echo h('$response = $mediaEmbed->oEmbed($mediaObject);'); ?></code></p>
	<table class="table table-sm">
		<tr><th>type</th><td><?php echo h($oEmbedResponse->type); ?></td></tr>
		<tr><th>title</th><td><?php echo h((string)$oEmbedResponse->title); ?></td></tr>
		<tr><th>authorName</th><td><?php echo h((string)$oEmbedResponse->authorName); ?></td></tr>
		<tr><th>providerName</th><td><?php echo h((string)$oEmbedResponse->providerName); ?></td></tr>
		<tr><th>thumbnailUrl</th><td><?php echo h((string)$oEmbedResponse->thumbnailUrl); ?></td></tr>
		<tr><th>width x height</th><td><?php echo h((string)$oEmbedResponse->width); ?> x <?php echo h((string)$oEmbedResponse->height); ?></td></tr>
		<tr><th>cacheAge</th><td><?php echo h((string)$oEmbedResponse->cacheAge); ?></td></tr>
	</table>
<?php
		}
		if ($thumbnail) {
?>
	<h5>Thumbnail</h5>
	<p>
		<code><?php echo h('$mediaEmbed->thumbnail($mediaObject)'); ?></code> prefers the static
		<code>image-src</code> and falls back to the oEmbed <code>thumbnail_url</code>.
	</p>
	<p><img src="<?php echo h($thumbnail); ?>" alt="Thumbnail" style="max-width:320px;"></p>
<?php
		}
		if ($oEmbedHtml !== null) {
?>
	<h5>Provider markup</h5>
	<p>
		<code><?php echo h('echo $mediaEmbed->oEmbedHtml($mediaObject);'); ?></code>
	</p>
	<div class="alert alert-warning">
		This HTML is controlled by the remote provider. Only render it for providers you trust,
		or sanitize it according to your application policy.
	</div>
	<pre style="overflow-x:auto;"><?php echo h($oEmbedHtml); ?></pre>
	<p>Rendered (the provider's own script decides what it turns into):</p>
	<div style="max-width:640px;border:1px solid #dee2e6;border-radius:.25rem;padding:.5rem;"><?php echo $oEmbedHtml; ?></div>
<?php
		}
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
