<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxPost[] $posts
 * @var \Sandbox\Model\Entity\SandboxUser $user
 */
?>

<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/reactions'); ?>
</nav>
<div class="page index col-sm-8 col-12">

	<h3>GitHub-style reactions</h3>
	<p>
		Hello <b><?php echo h($user->username); ?></b>,
		<br>open the <code>Add reaction</code> picker on any post below and toggle as many reactions as you like.
		A user may attach several different reactions to the same record, but never the same one twice.
	</p>
	<p>
		Your selections are stored against your demo session user, so they persist across reloads.
		<?php echo $this->Form->postLink(
			__('Reset my reactions'),
			['action' => 'reset'],
			['class' => 'btn btn-sm btn-outline-warning', 'block' => true, 'confirm' => __('Clear all of your demo reactions?')],
		); ?>
	</p>

	<?php foreach ($posts as $post) { ?>
		<div class="card mb-3">
			<div class="card-body">
				<h4 class="card-title h5"><?php echo h($post->title); ?></h4>
				<p class="card-text"><?php echo h($post->content); ?></p>

				<div class="reaction-widget mb-2">
					<?php echo $this->Reactions->widget('SandboxPosts', $post->id); ?>
				</div>

				<div class="reaction-counts text-muted">
					<small>
						<?php
						$counts = $this->Reactions->counts('SandboxPosts', $post->id);
						echo $counts !== '' ? $counts : __('No reactions yet.');
						?>
					</small>
				</div>
			</div>
		</div>
	<?php } ?>

	<p class="text-muted"><small>
		The picker renders each reaction as a <code>postLink()</code> with <code>block =&gt; true</code>,
		so the forms are hoisted out of the surrounding markup (nested forms are invalid HTML) and submitted
		via the layout's post-link block.
	</small></p>

</div></div>

<?php $this->append('css'); ?>
<style>
	.reaction-widget .reaction {
		display: inline-block;
		font-size: 1.2rem;
		line-height: 1.6;
	}
	.reaction-widget details.reaction-buttons {
		display: inline-block;
		margin-left: .25rem;
		vertical-align: middle;
	}
	.reaction-widget details.reaction-buttons > summary {
		cursor: pointer;
		display: inline-block;
		padding: .1rem .5rem;
		border: 1px solid var(--bs-border-color, #ccc);
		border-radius: 1rem;
		font-size: .85rem;
		list-style: none;
	}
	.reaction-widget details.reaction-buttons[open] > summary {
		background: var(--bs-secondary-bg, #eee);
	}
	.reaction-widget details.reaction-buttons a {
		display: inline-block;
		text-decoration: none;
		border: 1px solid transparent;
		border-radius: .5rem;
		padding: .1rem .25rem;
		margin: 0 .1rem;
	}
	.reaction-widget details.reaction-buttons a:hover {
		border-color: var(--bs-border-color, #ccc);
		background: var(--bs-secondary-bg, #f3f3f3);
	}
</style>
<?php $this->end(); ?>
