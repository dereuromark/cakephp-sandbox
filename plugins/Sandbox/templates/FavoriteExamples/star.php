<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxPost[] $posts
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/favorite'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Stars</h3>
	<p>You can star or unstar any record with ease.</p>
	<ul>
		<li>Add the StarableComponent to your controller</li>
		<li>Add the post link icon in the frontend (e.g. using the StarsHelper)</li>
	</ul>

	<h3>Demo</h3>

	<?php
	foreach ($posts as $post) {
	?>
		<h4><?php echo $this->Stars->linkIcon('StarPosts', $post->id, (bool)$post->starred);?> <?php echo h($post->title); ?></h4>
		<p><?php echo h($post->content) ?></p>
	<?php
	}
	?>

</div>
