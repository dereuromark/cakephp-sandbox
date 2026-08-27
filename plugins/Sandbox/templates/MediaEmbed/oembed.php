<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, \MediaEmbed\Provider\ProviderConfig> $oEmbedOnly
 * @var array<string, \MediaEmbed\Provider\ProviderConfig> $oEmbedPlusIframe
 * @var array<string, mixed> $customProviderConfig
 * @var \MediaEmbed\Provider\ProviderConfig|null $customProvider
 * @var string|null $exceptionMessage
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?php echo $this->element('navigation/media_embed'); ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>MediaEmbed: oEmbed</h2>

<p>
	Most providers embed through a static iframe URL. Some only ever hand out markup that the
	provider itself generates - there is no stable iframe URL to build. Those are registered with an
	<code>oembed</code> endpoint instead of an <code>iframe-player</code> template, and the markup is
	fetched at runtime.
</p>

<h3>Fetching provider markup</h3>
<pre><?php echo h(<<<'PHP'
$mediaEmbed = new MediaEmbed();
$mediaObject = $mediaEmbed->parseUrl('https://bsky.app/profile/bsky.app/post/3mbhel6ij7s2y');

$response = $mediaEmbed->oEmbed($mediaObject);   // OEmbedResponse|null (title, author, thumbnail, ...)
$html = $mediaEmbed->oEmbedHtml($mediaObject);   // string|null - the provider-generated embed markup
$thumb = $mediaEmbed->thumbnail($mediaObject);   // static image-src, else the oEmbed thumbnail_url
PHP); ?></pre>

<div class="alert alert-warning">
	<b>Security:</b> <code>oEmbedHtml()</code> returns markup controlled by the remote provider.
	Only render it for providers you trust, or sanitize it according to your application policy.
</div>

<p>
	These calls perform an HTTP request, so a PSR-16 cache applies. This sandbox passes CakePHP's
	cache pool in:
</p>
<pre><?php echo h(<<<'PHP'
$mediaEmbed->setCache(\Cake\Cache\Cache::pool('default'), 3600);
PHP); ?></pre>

<p>
	Try it live on the <?php echo $this->Html->link('parsing page', ['action' => 'index']); ?> - the
	oEmbed-only providers fetch automatically, everything else has an opt-in checkbox.
</p>

<h3>No iframe means no iframe methods</h3>
<p>
	Calling the iframe-specific methods on an oEmbed-only object throws instead of silently returning
	unusable markup:
</p>
<pre><?php echo h(<<<'PHP'
$mediaObject->getEmbedCode(); // or getEmbedSrc()
PHP); ?></pre>
<?php if ($exceptionMessage) { ?>
<pre>MediaEmbed\Exception\EmbedCodeUnavailableException:
<?php echo h($exceptionMessage); ?></pre>
<?php } ?>

<h3>oEmbed-only providers (<?php echo count($oEmbedOnly); ?>)</h3>
<table class="table table-sm">
	<tr>
		<th>Provider</th>
		<th>Slug</th>
		<th>oEmbed endpoint</th>
		<th>Example URL</th>
	</tr>
<?php foreach ($oEmbedOnly as $slug => $config) { ?>
	<tr>
		<td><?php echo $this->Html->link($config->name, $config->website, ['target' => '_blank']); ?></td>
		<td><code><?php echo h($slug); ?></code></td>
		<td><code><?php echo h((string)$config->oEmbed); ?></code></td>
		<td>
			<?php if ($config->exampleUrl) { ?>
				<?php echo $this->Html->link('Parse', ['action' => 'index', '?' => ['url' => $config->exampleUrl]]); ?>
			<?php } ?>
		</td>
	</tr>
<?php } ?>
</table>

<h3>Providers with both iframe and oEmbed (<?php echo count($oEmbedPlusIframe); ?>)</h3>
<p>
	These embed via iframe as before, and additionally expose an oEmbed endpoint for metadata and
	thumbnails.
</p>
<p>
	<?php
	$names = [];
	foreach ($oEmbedPlusIframe as $config) {
		$names[] = h($config->name);
	}
	echo implode(' &middot; ', $names);
	?>
</p>

<h3>Filtering providers by capability</h3>
<pre><?php echo h(<<<'PHP'
$providers = $mediaEmbed->getProviders();

$withOEmbed = $providers->withOEmbedSupport();
$withIframe = $providers->withIframeSupport();
$withThumbnails = $providers->withThumbnailSupport();

foreach ($withOEmbed as $slug => $config) {
    $config->hasOEmbedSupport(); // true
    $config->hasIframeSupport(); // false for oEmbed-only providers
}
PHP); ?></pre>

<h3>Custom oEmbed-only providers</h3>
<p>
	An application can register its own oEmbed-only provider without touching the bundled provider
	file - inline, or from a PHP/JSON file via <code>providers_config</code>, <code>ArrayLoader</code>,
	<code>PhpFileLoader</code> or <code>JsonFileLoader</code>. Note there is no
	<code>iframe-player</code> key:
</p>
<pre><?php echo h(<<<'PHP'
$mediaEmbed = new MediaEmbed([
    'custom_providers' => [[
        'name' => 'Example Social',
        'website' => 'https://social.example.com',
        'url-match' => 'https://social\\.example\\.com/posts/([0-9]+)',
        'embed-width' => 540,
        'embed-height' => 600,
        'oembed' => 'https://social.example.com/oembed',
    ]],
]);

$mediaObject = $mediaEmbed->parseUrl('https://social.example.com/posts/123');
PHP); ?></pre>

<?php if ($customProvider) { ?>
<p>Registered above, the resulting provider config resolves as:</p>
<table class="table table-sm">
	<tr><th>name</th><td><?php echo h($customProvider->name); ?></td></tr>
	<tr><th>slug</th><td><code><?php echo h((string)$customProvider->slug); ?></code></td></tr>
	<tr><th>oEmbed endpoint</th><td><code><?php echo h((string)$customProvider->oEmbed); ?></code></td></tr>
	<tr><th>hasOEmbedSupport()</th><td><?php echo $customProvider->hasOEmbedSupport() ? 'true' : 'false'; ?></td></tr>
	<tr><th>hasIframeSupport()</th><td><?php echo $customProvider->hasIframeSupport() ? 'true' : 'false'; ?></td></tr>
</table>
<?php } ?>

<h3>oEmbed discovery for unknown URLs</h3>
<p>
	For URLs no bundled provider covers, <code>OEmbedDiscovery</code> reads the page's oEmbed
	<code>&lt;link&gt;</code> tag and fetches from there. Only public http(s) endpoints are fetched -
	local and private IP endpoints are rejected.
</p>
<pre><?php echo h(<<<'PHP'
use MediaEmbed\Cache\ArrayCache;
use MediaEmbed\OEmbed\OEmbedDiscovery;

$discovery = new OEmbedDiscovery(cache: new ArrayCache());
$response = $discovery->discover('https://example.com/video/123', maxWidth: 640, maxHeight: 480);

// Or skip discovery when the endpoint is already known:
$discovery = new OEmbedDiscovery(endpoints: [
    'video.example.com' => 'https://example.com/oembed?url={url}',
]);
PHP); ?></pre>

</div>
