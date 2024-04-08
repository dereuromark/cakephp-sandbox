<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxUser $user
 */

?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/comments'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h3>Basic Usage</h3>
	<p>The most common use cases are usually</p>
	<ul>
		<li>Flat list</li>
		<li>Tree list</li>
	</ul>

	<h4>Give it a try</h4>
	<p>
	Hello <b><?php echo h($user->username); ?></b>,
		<br>the following examples will be using this account to "comment" things.
	</p>

	<p>Note:
	<br>
	The following examples are not using AJAX for simplicity. With AJAX the experience is way better, though.
	</p>


</div>
