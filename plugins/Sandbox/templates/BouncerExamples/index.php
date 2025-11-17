<?php
/**
 * @var \App\View\AppView $this
 */
?>

<div class="page index">
	<?= $this->element('Sandbox.bouncer_nav') ?>

	<h2><?= __('Bouncer Plugin - Approval Workflow') ?></h2>

	<div class="alert alert-info">
		<h4>About Bouncer</h4>
		<p>
			The <strong>Bouncer plugin</strong> implements an approval workflow for CakePHP applications.
			Users propose changes (create or edit records), and admins/moderators can review, approve,
			or reject those changes before they are published to the actual database tables.
		</p>
	</div>

	<h3>Features Demonstrated</h3>

	<div class="row">
		<div class="col-md-6">
			<div class="card mb-3">
				<div class="card-header bg-primary text-white">
					<h5 class="mb-0">User Workflow</h5>
				</div>
				<div class="card-body">
					<ul>
						<li><?= $this->Html->link('View All Articles', ['action' => 'articles']) ?> - See published content</li>
						<li><?= $this->Html->link('Submit New Article', ['action' => 'add']) ?> - Create content for approval</li>
						<li><strong>Edit Articles</strong> - Click edit on any article to propose changes</li>
						<li><strong>Draft Management</strong> - Automatic draft recovery on re-edit</li>
						<li><strong>Validation</strong> - Errors shown immediately, not after approval</li>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="card mb-3">
				<div class="card-header bg-success text-white">
					<h5 class="mb-0">Admin/Moderator Workflow</h5>
				</div>
				<div class="card-body">
					<ul>
						<li><?= $this->Html->link('View Pending Changes', ['action' => 'pending']) ?> - Review queue</li>
						<li><strong>Diff View</strong> - See exactly what changed</li>
						<li><strong>Approve/Reject</strong> - With optional reason/note</li>
						<li><strong>Bypass Option</strong> - Admins can publish directly without approval</li>
						<li><strong>Transaction Safety</strong> - Atomic approval process</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<h3>Use Cases</h3>

	<div class="row">
		<div class="col-md-4">
			<div class="card mb-3">
				<div class="card-header">Content Management</div>
				<div class="card-body">
					Editorial approval for articles, blog posts, and user-generated content.
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card mb-3">
				<div class="card-header">Data Entry Systems</div>
				<div class="card-body">
					Quality control workflow with supervisor approval before data goes live.
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="card mb-3">
				<div class="card-header">User Moderation</div>
				<div class="card-body">
					Review user-submitted changes, profiles, or marketplace listings.
				</div>
			</div>
		</div>
	</div>

	<h3>Configuration Highlights</h3>

	<pre><code class="language-php">// In SandboxArticlesTable
$this->addBehavior('Bouncer.Bouncer', [
    'userField' => 'user_id',              // Track who made changes
    'requireApproval' => ['add', 'edit'],  // Which actions need approval
    'validateOnDraft' => true,             // Validate before storing draft
    'autoSupersede' => true,               // Auto-update existing drafts
]);</code></pre>

	<h3>Try It Out!</h3>

	<p>
		Start by <?= $this->Html->link('creating a new article', ['action' => 'add']) ?>,
		then check the <?= $this->Html->link('pending queue', ['action' => 'pending']) ?> to approve it.
	</p>

	<div class="alert alert-warning">
		<strong>Note:</strong> This demo uses simulated user IDs (user_id=1 for regular users, reviewer_id=1 for admins).
		In a real application, you would integrate with CakePHP's Authentication plugin.
	</div>
</div>
