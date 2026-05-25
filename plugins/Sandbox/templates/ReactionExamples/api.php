<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxPost $post
 * @var \Sandbox\Model\Entity\SandboxUser $user
 * @var array<string, int> $counts
 * @var array<string> $userReactions
 * @var \Sandbox\Model\Entity\SandboxPost|null $withReactions
 * @var \Sandbox\Model\Entity\SandboxPost[] $reactedByUser
 * @var string|null $allowedError
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/reactions'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>Behavior API</h3>
	<p>
		Attach the behavior to any table and you get a small, explicit API. All examples below run live
		against the demo post <b><?php echo h($post->title); ?></b> (id <?php echo (int)$post->id; ?>)
		and your demo user <b><?php echo h($user->username); ?></b> (id <?php echo (int)$user->id; ?>).
	</p>

	<pre><code>// In your Table::initialize()
$this-&gt;addBehavior('Reactions.Reactable');

// Write
$this-&gt;Posts-&gt;addReaction(['modelId' =&gt; $id, 'userId' =&gt; $uid, 'reaction' =&gt; '👍']);
$this-&gt;Posts-&gt;toggleReaction(['modelId' =&gt; $id, 'userId' =&gt; $uid, 'reaction' =&gt; '🎉']);
$this-&gt;Posts-&gt;removeReaction(['modelId' =&gt; $id, 'userId' =&gt; $uid, 'reaction' =&gt; '👍']);

// Read
$counts = $this-&gt;Posts-&gt;reactionCounts($id);
$mine = $this-&gt;Posts-&gt;userReactions($id, $uid);</code></pre>

	<h4><code>reactionCounts($id)</code></h4>
	<?php if ($counts) { ?>
		<ul>
			<?php foreach ($counts as $reaction => $count) { ?>
				<li><span style="font-size:1.2rem"><?php echo h($reaction); ?></span> &times; <?php echo (int)$count; ?></li>
			<?php } ?>
		</ul>
	<?php } else { ?>
		<p class="text-muted">No reactions on this post yet — add some on the <?php echo $this->Html->link(__('Overview'), ['action' => 'index']); ?> page.</p>
	<?php } ?>

	<h4><code>userReactions($id, $uid)</code></h4>
	<p>
		<?php echo $userReactions ? h(implode(' ', $userReactions)) : '<span class="text-muted">' . __('You have not reacted to this post.') . '</span>'; ?>
	</p>

	<h4>Finder: <code>find('reactions', id: $id)</code></h4>
	<p>Loads the record with all its reactions and the reacting users contained.</p>
	<?php if ($withReactions && $withReactions->reactions) { ?>
		<table class="table table-sm">
			<thead><tr><th>Reaction</th><th>User</th><th>When</th></tr></thead>
			<tbody>
			<?php foreach ($withReactions->reactions as $reaction) { ?>
				<tr>
					<td style="font-size:1.2rem"><?php echo h($reaction->reaction); ?></td>
					<td><?php echo h($reaction->sandbox_user->username ?? ('User #' . $reaction->user_id)); ?></td>
					<td><?php echo $reaction->created ? h($reaction->created->nice()) : ''; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	<?php } else { ?>
		<p class="text-muted">No reactions contained yet.</p>
	<?php } ?>

	<h4>Finder: <code>find('reactedBy', userId: $uid)</code></h4>
	<p>Finds the records a given user has reacted to.</p>
	<?php if ($reactedByUser) { ?>
		<ul>
			<?php foreach ($reactedByUser as $reactedPost) { ?>
				<li><?php echo h($reactedPost->title); ?></li>
			<?php } ?>
		</ul>
	<?php } else { ?>
		<p class="text-muted">You have not reacted to anything yet.</p>
	<?php } ?>

	<h4>Allow-list guard</h4>
	<p>
		By default any reaction key is accepted. Pass an <code>allowed</code> allow-list to reject the rest
		(an invalid key raises a <code>BadRequestException</code>):
	</p>
	<pre><code>$this-&gt;addBehavior('Reactions.Reactable', [
    'allowed' =&gt; ['👍', '👎', '❤️', 'rocket'],
]);</code></pre>
	<p>
		Live result of attempting a disallowed key:
		<code><?php echo $allowedError ? h($allowedError) : __('(no exception)'); ?></code>
	</p>

	<h4>Helper widget</h4>
	<p>The interactive picker on the <?php echo $this->Html->link(__('Overview'), ['action' => 'index']); ?> page is just:</p>
	<pre><code>// AppView::initialize()
$this-&gt;loadHelper('Reactions.Reactions');

// Template
echo $this-&gt;Reactions-&gt;widget('Posts', $post-&gt;id);
echo $this-&gt;Reactions-&gt;counts('Posts', $post-&gt;id);</code></pre>
	<p class="text-muted"><small>
		Two POST strategies are available: <code>controller</code> (default — posts to the plugin's own
		<code>ReactionsController</code>) and <code>action</code> (posts back to the current action, processed by the
		<code>Reactable</code> component). This demo uses the <code>action</code> strategy to stay self-contained.
	</small></p>

</div></div>
