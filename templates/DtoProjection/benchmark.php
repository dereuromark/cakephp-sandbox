<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, array{time: float, memory: int}> $results
 * @var int $iterations
 */
?>
<h1>DTO Projection Demo: Performance Benchmark</h1>

<p>
    Comparing performance of different hydration approaches.
    Query: <code>Users->find()->contain(['Roles'])->limit(50)</code> × <?= $iterations ?> iterations.
</p>

<h2>Navigation</h2>
<ul>
    <li><?= $this->Html->link('BelongsTo', ['action' => 'index']) ?></li>
    <li><?= $this->Html->link('HasMany', ['action' => 'hasMany']) ?></li>
    <li><?= $this->Html->link('BelongsToMany with _joinData', ['action' => 'belongsToMany']) ?></li>
    <li><?= $this->Html->link('Matching with _matchingData', ['action' => 'matching']) ?></li>
    <li><?= $this->Html->link('Benchmark (this page)', ['action' => 'benchmark']) ?></li>
</ul>

<h2>Results</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Method</th>
            <th>Time (ms)</th>
            <th>Memory Delta</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $baseTime = $results['Entity']['time'];
        foreach ($results as $method => $data): ?>
        <tr>
            <td><strong><?= h($method) ?></strong></td>
            <td><?= number_format($data['time'], 2) ?> ms</td>
            <td><?= number_format($data['memory']) ?> bytes</td>
            <td>
                <?php
                $ratio = $baseTime > 0 ? $data['time'] / $baseTime : 0;
                if ($ratio < 1) {
                    echo sprintf('%.1fx faster than Entity', 1 / $ratio);
                } elseif ($ratio > 1) {
                    echo sprintf('%.1fx slower than Entity', $ratio);
                } else {
                    echo 'baseline';
                }
                ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Summary</h2>
<ul>
    <li><strong>Array:</strong> Fastest but no type safety or object features</li>
    <li><strong>cakephp-dto:</strong> Generated optimized code, ~2x faster than Entity</li>
    <li><strong>DtoMapper:</strong> Reflection-based, similar speed to Entity, zero boilerplate</li>
    <li><strong>Entity:</strong> Full ORM features including dirty tracking</li>
</ul>

<h2>Recommendations</h2>
<ul>
    <li>Use <strong>DTOs</strong> for read-heavy operations where you don't need dirty tracking</li>
    <li>Use <strong>cakephp-dto plugin</strong> for maximum performance with generated code</li>
    <li>Use <strong>DtoMapper</strong> for simple readonly DTOs without code generation</li>
    <li>Use <strong>Entities</strong> when you need dirty tracking, validation, or save operations</li>
</ul>
