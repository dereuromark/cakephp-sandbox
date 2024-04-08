<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxPost $sandboxPost
 */
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/comments'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Demo as Guest</h3>

	<h4><?php echo h($sandboxPost->title); ?></h4>
	<p>
		<?php echo h($sandboxPost->content); ?>
	</p>

	<h5>Comments</h5>

	<?php if ($sandboxPost->comments) { ?>
		<?php
		/** @var \Comments\Model\Entity\Comment $comment */
		foreach ($sandboxPost->comments as $comment) {
		?>
			<p><?php echo h($comment->content) ?></p>
		<?php
		}
		?>
	<?php
	}
	?>

	<?php
	echo $this->element('comments/comments', ['alias' => 'SandboxPosts', 'id' => $sandboxPost->id]);
	?>

</div>
