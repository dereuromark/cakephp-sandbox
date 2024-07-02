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

	<h3>Likes</h3>
	<p>You can like (up/down) any record with ease.</p>
	<ul>
		<li>Add the LikeableComponent to your controller</li>
		<li>Add the post link icons in the frontend (e.g. using the LikesHelper)</li>
	</ul>

	<h3>Demo</h3>

	<?php
	foreach ($posts as $post) {
	?>
		<h4><?php echo h($post->title); ?></h4>
		<p><?php echo $this->Likes->widget('LikePosts', $post->id, $post->liked ? $post->liked->value : null);?></p>
		<p><?php echo h($post->content) ?></p>
	<?php
	}
	?>


	<hr>

	<p>Note:</p>
	<ul>
		<li>The examples use the native and unobstrusive UTF8 characters/emoji, but you can also use FontAwesome icons or custom HTML snippets</li>
		<li>The example above is not using AJAX or JS, usually it would be advised to create a more sophisticated and user-friendly snippet here</li>
	</ul>


</div>
