<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxArticle $article
 */
?>
<div class="audit-stash edit">
    <h1>Edit Article</h1>

    <?= $this->Form->create($article) ?>
    <fieldset>
        <legend>Article Details</legend>
        <?= $this->Form->control('title', ['class' => 'form-control']) ?>
        <?= $this->Form->control('content', ['type' => 'textarea', 'rows' => 5, 'class' => 'form-control']) ?>
        <?= $this->Form->control('status', [
            'options' => ['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived'],
            'class' => 'form-control',
        ]) ?>
    </fieldset>
    <?= $this->Form->button('Update Article', ['class' => 'btn btn-primary']) ?>
    <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
    <?= $this->Form->end() ?>

    <div class="alert alert-info mt-4">
        <strong>Note:</strong> When you update this article, the AuditStash plugin will automatically
        log what changed, storing both the original and new values in the audit_logs table.
    </div>
</div>
