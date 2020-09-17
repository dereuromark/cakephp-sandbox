<?php
/**
 * @var \App\View\AppView $this
 * @var \MediaEmbed\Object\MediaObject $mediaObject
 * @var array $hosts
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?php echo $this->element('navigation/media_embed'); ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>MediaEmbed</h2>

<h3><?php echo count($hosts); ?> Supported Sites/Hosts</h3>
<ul>
<?php
foreach ($hosts as $host) {
	echo '<li>';
	if (empty($host['website']) || $host['website'] === 'localhost') {
		echo h($host['name']);
	} else {
		echo $this->Html->link($host['name'], $host['website'], ['target' => '_blank']);
	}
	echo '</li>';
}
?>
</ul>

</div>
