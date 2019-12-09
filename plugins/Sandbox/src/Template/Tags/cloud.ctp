<?php
/**
 * @var \App\View\AppView $this
 * @var array $tags
 */
?>

<nav class="actions col-sm-4 col-xs-12">
	<?php echo $this->element('navigation/tags'); ?>
</nav>
<div class="page index col-sm-8 col-xs-12">

<h3>Tag Cloud</h3>

	<style>
		.tag-cloud li {
			float: left;
			padding: 2px;
			display: inline-block;
			list-style: none;
		}
		.tag-cloud {
			clear: both;
		}
	</style>

	<?php
	$this->loadHelper('Tags.TagCloud');

	echo $this->TagCloud->display($tags, [], ['class' => 'tag-cloud']);
	?>

</div>
