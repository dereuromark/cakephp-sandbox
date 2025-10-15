<?php
/**
 * @var \App\View\AppView $this
 * @var array<\Sandbox\Model\Entity\SandboxArticle> $articles
 * @var array<\App\Model\Entity\AuditLog> $auditLogs
 */
?>
<div class="audit-stash index">
    <h1>AuditStash Plugin Demo</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>
                Articles
                <?= $this->Html->link('Add New Article', ['action' => 'add'], ['class' => 'btn btn-sm btn-primary']) ?>
            </h2>

            <?php if (empty($articles)) { ?>
                <p class="alert alert-info">No articles found. Create one to see audit logging in action!</p>
            <?php } else { ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th class="actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($articles as $article) { ?>
                            <tr>
                                <td><?= h($article->id) ?></td>
                                <td><?= h($article->title) ?></td>
                                <td><span class="badge badge-info"><?= h($article->status) ?></span></td>
                                <td class="actions">
                                    <?= $this->Html->link('Edit', ['action' => 'edit', $article->id], ['class' => 'btn btn-sm btn-secondary']) ?>
                                    <?= $this->Form->postLink(
                                        'Delete',
                                        ['action' => 'delete', $article->id],
                                        ['confirm' => 'Are you sure?', 'class' => 'btn btn-sm btn-danger', 'block' => true],
                                    ) ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>

        <div class="col-md-6">
            <h2>Audit Trail (Last 50 Changes)</h2>

            <?php if (empty($auditLogs)) { ?>
                <p class="alert alert-info">No audit logs yet. Make changes to articles to see audit trail!</p>
            <?php } else { ?>
                <div class="list-group">
                    <?php foreach ($auditLogs as $log) { ?>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">
                                    <span class="badge badge-<?= $log->type === \App\Model\Enum\AuditLogType::Create ? 'success' : ($log->type === \App\Model\Enum\AuditLogType::Update ? 'warning' : 'danger') ?>">
                                        <?= h(strtoupper($log->type->value)) ?>
                                    </span>
                                    Article #<?= h($log->primary_key) ?>
                                    <?php if ($log->display_value) { ?>
                                        - <?= h($log->display_value) ?>
                                    <?php } ?>
                                </h6>
                                <small><?= h($log->created->timeAgoInWords()) ?></small>
                            </div>
                            <p class="mb-1">
                                <?php if ($log->changed_fields) { ?>
                                    <strong>Changed Fields:</strong>
                                    <?= h(implode(', ', $log->changed_fields)) ?>
                                <?php } ?>
                            </p>
                            <small>
                                <?= $this->Html->link('View Details', ['action' => 'viewLog', $log->id], ['class' => 'btn btn-sm btn-info']) ?>
                                <?php if ($log->type === \App\Model\Enum\AuditLogType::Delete && $log->original_data) { ?>
                                    <?= $this->Form->postLink(
                                        'Restore',
                                        ['action' => 'restore', $log->id],
                                        ['confirm' => 'Restore this deleted record?', 'class' => 'btn btn-sm btn-success', 'block' => true],
                                    ) ?>
                                <?php } ?>
                            </small>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3>How AuditStash Works</h3>
                </div>
                <div class="card-body">
                    <p>This demo showcases the <strong>AuditStash</strong> plugin with <strong>TablePersister</strong> configuration.</p>

                    <h5>Configuration:</h5>
                    <ul>
                        <li>Plugin loaded in <code>config/plugins.php</code></li>
                        <li>TablePersister configured in <code>config/app(_custom).php</code>:
                            <pre><code>'AuditStash' => [
    'persister' => \AuditStash\Persister\TablePersister::class,
],</code></pre>
                        </li>
                        <li>Behavior added to SandboxArticlesTable:
                            <pre><code>$this->addBehavior('AuditStash.AuditLog');</code></pre>
                        </li>
                        <li>Audit logs stored in <code>audit_logs</code> table</li>
                    </ul>

                    <h5>What Gets Tracked:</h5>
                    <ul>
                        <li><strong>Create:</strong> When a new article is added</li>
                        <li><strong>Update:</strong> When an article is modified (tracks original and changed values)</li>
                        <li><strong>Delete:</strong> When an article is removed</li>
                    </ul>

                    <h5>Demo Features:</h5>
                    <ul>
                        <li><strong>Auto-Rotation:</strong> Logs older than 1 hour are automatically deleted on page load to keep the demo clean</li>
                        <li><strong>Type Safety:</strong> Audit log types use PHP enums for better IDE support and type checking</li>
                    </ul>

                    <h5>Try It Out:</h5>
                    <ol>
                        <li>Click "Add New Article" to create a new record</li>
                        <li>Edit an article to see how changes are tracked</li>
                        <li>Delete an article to see deletion logging</li>
                        <li>View audit log details to see the full change history</li>
                        <li>Use "Partial Revert" to restore selected fields from an update</li>
                        <li>Use "Revert All Fields" to restore all previous values for updated records</li>
                        <li>Use "Restore" to recover deleted records</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
