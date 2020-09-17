<?php
/**
 * @var \App\View\AppView $this
 * @var array $isRated
 * @var array $post
 */
?>

<?php $this->Html->script('/assets/bootstrap-star-rating/js/star-rating.js', ['block' => true]); ?>
<?php $this->Html->css('/assets/bootstrap-star-rating/css/star-rating.css', ['block' => true]); ?>

<h2>Ratings plugin</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-ratings" target="_blank">[Ratings Plugin]</a>
</p>

<h3>Rate now!</h3>

<?php
if (!$isRated) {
	echo $this->Rating->control([
		'item' => $post['id'],
		'js' => true,
	]);
} else {
	echo '<p>';
	echo __('You have already rated.');
	echo $this->Rating->display($isRated['value']);
	echo '</p>';

	echo '<p>For demo purposes:</p>';
	echo $this->Form->postLink('Unrate', ['action' => 'unrate', $post['id']], ['class' => 'btn btn-warning']);
}

?>



<h3>Read-only star rating display</h3>

<h4>2.25 of 5 stars</h4>
<p>Also has a custom title attribute:</p>
<?php
echo $this->Rating->display(2.25, ['steps' => 1], ['title' => 'X of Y stars !!!']);
?>

<h4>3.25 of 5 stars</h4>
<p>With half-steps:</p>
<?php
echo $this->Rating->display(3.25, ['steps' => 2]);
?>


<h4>Bar Rating</h4>
<p>Similar to percentage, here 8.5 of 10:</p>

<?php $this->append('css'); ?>
<style>
	.bar-rating {
		background-color: #0b58a2;
	}
	.bar-rating .inner {
		background-color: #00b3ee;
	}
	.bar-rating .inner span {
		color: white;
		margin-left: 10px;
	}
</style>
<?php $this->end(); ?>

<?php
echo $this->Rating->bar(8.5, 10);

