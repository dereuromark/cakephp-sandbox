<?php
/**
 * @var \App\View\AppView $this
 * @var array $hosts
 * @var \MediaEmbed\Provider\ProviderCollection $providers
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?php echo $this->element('navigation/media_embed'); ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>MediaEmbed</h2>

<h3><?php echo count($hosts); ?> Supported Sites/Hosts</h3>

<p>
	Capabilities come from <code>ProviderConfig::hasIframeSupport()</code>,
	<code>hasOEmbedSupport()</code> and <code>hasThumbnailSupport()</code>. Providers marked
	<span class="badge bg-warning text-dark">oEmbed only</span> have no static iframe URL - see
	<?php echo $this->Html->link('oEmbed', ['action' => 'oembed']); ?>.
</p>

<table class="table table-sm">
	<tr>
		<th>Site/Host</th>
		<th>iframe</th>
		<th>oEmbed</th>
		<th>Thumbnail</th>
	</tr>
<?php
foreach ($providers as $slug => $config) {
	echo '<tr>';
	echo '<td>';
	if (empty($config->website) || $config->website === 'localhost') {
		echo h($config->name);
	} else {
		echo $this->Html->link($config->name, $config->website, ['target' => '_blank']);
	}
	if (!$config->hasIframeSupport() && $config->hasOEmbedSupport()) {
		echo ' <span class="badge bg-warning text-dark">oEmbed only</span>';
	}
	echo '</td>';
	echo '<td>' . ($config->hasIframeSupport() ? 'yes' : '-') . '</td>';
	echo '<td>' . ($config->hasOEmbedSupport() ? 'yes' : '-') . '</td>';
	echo '<td>' . ($config->hasThumbnailSupport() ? 'yes' : '-') . '</td>';
	echo '</tr>';
}
?>
</table>

</div>
