<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Dto\Github\PullRequestDto $pullRequestDto
 */
?>
<p>
	<b>PR: <?php echo h($pullRequestDto->getNumber()); ?> (<?php echo h($pullRequestDto->getTitle()); ?>)</b>
	<?php foreach ($pullRequestDto->getLabels() as $label) { ?>
		<span class="badge" style="background-color: #<?php echo h($label->getColor()); ?>"><?php echo h($label->getName()); ?></span>
	<?php } ?>
	<div><small>Created: <?php echo $pullRequestDto->getCreatedAt(); ?></small></div>
</p>
<p>
	Head: <?php echo h($pullRequestDto->getHead()->getRef()) . ':' . $pullRequestDto->getHead()->getSha(); ?>
		by <?php echo h($pullRequestDto->getHead()->getUser()->getLogin()) ?>
	<br>
	Base: <?php echo h($pullRequestDto->getBase()->getRef()) . ':' . $pullRequestDto->getBase()->getSha(); ?>
		by <?php echo h($pullRequestDto->getBase()->getUser()->getLogin()) ?>
</p>
