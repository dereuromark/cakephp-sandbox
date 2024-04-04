<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxUser $user
 */

$this->loadHelper('Queue.QueueProgress');
?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/favorite'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Basic Usage</h3>
	<p>The most common use cases are usually</p>
	<ul>
		<li>Star (yes/no)</li>
		<li>Like (up/down/none)</li>
		<li>Favorite (some emoji or icon as reaction)</li>
	</ul>

	There are many implementations in modern applications:
	<ul>
		<li>Starred a.k.a GitHub stars (and remove star)</li>
		<li>GitHub Reactions</li>
		<li>Facebook Reactions</li>
		<li>YouTube Likes</li>
		<li>Slack Reactions</li>
		<li>Reddit Votes</li>
		<li>Medium Claps</li>
	</ul>

	<h4>Give it a try</h4>
	<p>
	Hello <b><?php echo h($user->username); ?></b>,
		<br>the following examples will be using this account to "favorite" things.
	</p>

	<p>Note:
	<br>
	The following examples are single-user based for now, they dont include aggregation of the favorites (counter).
		It should be possible to include that in the future demo, the plugin itself supports it.
	</p>


</div>
