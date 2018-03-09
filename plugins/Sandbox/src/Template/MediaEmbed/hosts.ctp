<?php
/**
 * @var \App\View\AppView $this
 * @var \MediaEmbed\Object\MediaObject $mediaObject
 */
?>

<nav class="actions col-md-3 col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/media_embed'); ?>
</nav>
<div class="col-md-9 col-sm-8 col-xs-12">

<h2>MediaEmbed</h2>

<h3>Supported Sites</h3>
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
