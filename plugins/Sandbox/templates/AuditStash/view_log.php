<?php
/**
 * @var \App\View\AppView $this
 * @var \AuditStash\Model\Entity\AuditLog $auditLog
 */
?>
<div class="audit-stash view-log">
    <h1>Audit Log Details</h1>

    <div class="mb-3">
        <?= $this->Html->link('← Back to List', ['action' => 'index'], ['class' => 'btn btn-secondary']) ?>
        <?php if ($auditLog->type === \AuditStash\AuditLogType::Update && $auditLog->original) { ?>
            <?= $this->Html->link(
                'Partial Revert (Select Fields)',
                ['action' => 'partialRevert', $auditLog->id],
                ['class' => 'btn btn-info'],
            ) ?>
            <?= $this->Form->postLink(
                'Revert All Fields',
                ['action' => 'revert', $auditLog->id],
                [
                    'confirm' => 'Are you sure you want to revert ALL fields to their original values?',
                    'class' => 'btn btn-warning',
                    'block' => true,
                ],
            ) ?>
        <?php } ?>
        <?php if ($auditLog->type === \AuditStash\AuditLogType::Delete && $auditLog->original) { ?>
            <?= $this->Form->postLink(
                'Restore Deleted Record',
                ['action' => 'restore', $auditLog->id],
                [
                    'confirm' => 'Are you sure you want to restore this deleted record?',
                    'class' => 'btn btn-success',
                    'block' => true,
                ],
            ) ?>
        <?php } ?>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>
                <span class="badge badge-<?= match($auditLog->type) {
                    \AuditStash\AuditLogType::Create => 'success',
                    \AuditStash\AuditLogType::Update => 'warning',
                    \AuditStash\AuditLogType::Delete => 'danger',
                    \AuditStash\AuditLogType::Revert => 'info',
                } ?>">
                    <?= h(strtoupper($auditLog->type->value)) ?>
                </span>
                Log Entry #<?= h($auditLog->id) ?>
            </h3>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th width="200">ID</th>
                    <td><?= h($auditLog->id) ?></td>
                </tr>
                <tr>
                    <th>Transaction ID</th>
                    <td><code><?= h($auditLog->transaction) ?></code></td>
                </tr>
                <tr>
                    <th>Event Type</th>
                    <td><span class="badge badge-info"><?= h($auditLog->type->value) ?></span></td>
                </tr>
                <tr>
                    <th>Source Table</th>
                    <td><?= h($auditLog->source) ?></td>
                </tr>
                <tr>
                    <th>Primary Key</th>
                    <td><?= h($auditLog->primary_key) ?></td>
                </tr>
                <?php if ($auditLog->display_value) { ?>
                    <tr>
                        <th>Display Value</th>
                        <td><strong><?= h($auditLog->display_value) ?></strong></td>
                    </tr>
                <?php } ?>
                <tr>
                    <th>Created</th>
                    <td><?= h($auditLog->created->format('Y-m-d H:i:s')) ?> (<?= h($auditLog->created->timeAgoInWords()) ?>)</td>
                </tr>
            </table>

            <?php
            $originalData = $auditLog->original ? json_decode($auditLog->original, true) : null;
            $changedData = $auditLog->changed ? json_decode($auditLog->changed, true) : null;
            $metaData = $auditLog->meta ? json_decode($auditLog->meta, true) : null;
            ?>
            <?php if ($originalData) { ?>
                <h4 class="mt-4">Original Values</h4>
                <pre class="bg-light p-3"><?= h(json_encode($originalData, JSON_PRETTY_PRINT)) ?></pre>
            <?php } ?>

            <?php if ($changedData) { ?>
                <h4 class="mt-4">Changed Values</h4>
                <pre class="bg-light p-3"><?= h(json_encode($changedData, JSON_PRETTY_PRINT)) ?></pre>

                <h4 class="mt-4">Changed Fields Comparison</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Field</th>
                            <th>Original Value</th>
                            <th>New Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($changedData as $field => $newValue) { ?>
                            <tr>
                                <td><strong><?= h($field) ?></strong></td>
                                <td><span class="text-danger"><?= h($originalData[$field] ?? 'N/A') ?></span></td>
                                <td><span class="text-success"><?= h($newValue) ?></span></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            <?php } ?>

            <?php if ($metaData) { ?>
                <h4 class="mt-4">Metadata</h4>
                <pre class="bg-light p-3"><?= h(json_encode($metaData, JSON_PRETTY_PRINT)) ?></pre>
            <?php } ?>
        </div>
    </div>
</div>

<?= $this->fetch('postLink') ?>
