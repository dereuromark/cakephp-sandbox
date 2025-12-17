<?php
/**
 * @var \App\View\AppView $this
 * @var array<\App\Model\Entity\User> $entities
 * @var array<\App\Dto\SimpleUserDto> $dtos
 * @var array $rawArrays
 */
?>
<h1>DTO Projection Demo: Matching with _matchingData</h1>

<p>
    This demo shows <code>projectAs()</code> with <code>matching()</code> queries.
    Note: <code>_matchingData</code> is available in the raw array but not automatically
    mapped to the DTO (it's query metadata, not part of the entity structure).
</p>

<h2>Navigation</h2>
<ul>
    <li><?= $this->Html->link('BelongsTo', ['action' => 'index']) ?></li>
    <li><?= $this->Html->link('HasMany', ['action' => 'hasMany']) ?></li>
    <li><?= $this->Html->link('BelongsToMany with _joinData', ['action' => 'belongsToMany']) ?></li>
    <li><?= $this->Html->link('Matching with _matchingData (this page)', ['action' => 'matching']) ?></li>
    <li><?= $this->Html->link('Benchmark', ['action' => 'benchmark']) ?></li>
</ul>

<h2>Traditional Entities with matching()</h2>
<pre><?php
foreach ($entities as $entity) {
    echo "User #{$entity->id}: {$entity->username}\n";
    if (isset($entity->_matchingData['Roles'])) {
        $role = $entity->_matchingData['Roles'];
        echo "  _matchingData[Roles]: {$role->name} (type: " . get_class($role) . ")\n";
    }
}
?></pre>

<h2>DTOs from matching() Query</h2>
<p>
    The DTO gets the main entity fields. <code>_matchingData</code> is query metadata
    and would need explicit handling if you need it in the DTO.
</p>
<pre><?php
foreach ($dtos as $dto) {
    echo "User #{$dto->id}: {$dto->username}\n";
    echo "  Type: " . get_class($dto) . "\n";
}
?></pre>

<h2>Raw Array showing _matchingData</h2>
<pre><?php
foreach ($rawArrays as $row) {
    echo "User #{$row['id']}: {$row['username']}\n";
    if (isset($row['_matchingData']['Roles'])) {
        $role = $row['_matchingData']['Roles'];
        echo "  _matchingData[Roles]: " . print_r($role, true);
    }
}
?></pre>

<h2>Code Example</h2>
<pre><code>// matching() query with DTO projection
$users = $usersTable->find()
    ->matching('Roles', function ($q) {
        return $q->where(['Roles.id' => 1]);
    })
    ->projectAs(SimpleUserDto::class)
    ->toArray();

// Note: If you need _matchingData in DTOs, add it to your DTO:
// public ?array $_matchingData = null;</code></pre>
