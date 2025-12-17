<?php
/**
 * @var \App\View\AppView $this
 * @var array<\App\Model\Entity\User> $entities
 * @var array<\App\Dto\SimpleUserDto> $dtosWithout
 * @var array<\App\Dto\UserWithMatchingDto> $dtosWith
 * @var array $rawArrays
 */
?>
<h1>DTO Projection Demo: Matching with _matchingData</h1>

<p>
    This demo shows <code>projectAs()</code> with <code>matching()</code> queries.
    <strong>Key insight:</strong> <code>_matchingData</code> IS available in DTOs if you
    explicitly add it as a constructor parameter.
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

<h2>DTO WITHOUT _matchingData property</h2>
<p>
    Using <code>SimpleUserDto</code> which does NOT have a <code>$_matchingData</code> property.
    The matching data is silently ignored.
</p>
<pre><?php
foreach ($dtosWithout as $dto) {
    echo "User #{$dto->id}: {$dto->username}\n";
    echo "  Type: " . get_class($dto) . "\n";
    echo "  Has _matchingData property: " . (property_exists($dto, '_matchingData') ? 'yes' : 'no') . "\n";
}
?></pre>

<h2>DTO WITH _matchingData property</h2>
<p>
    Using <code>UserWithMatchingDto</code> which HAS a <code>$_matchingData</code> property.
    The matching data is included as an array.
</p>
<pre><?php
foreach ($dtosWith as $dto) {
    echo "User #{$dto->id}: {$dto->username}\n";
    echo "  Type: " . get_class($dto) . "\n";
    if ($dto->_matchingData !== null) {
        foreach ($dto->_matchingData as $alias => $data) {
            if (is_array($data)) {
                echo "  _matchingData[{$alias}]: " . ($data['name'] ?? 'unknown') . " (array)\n";
            } else {
                echo "  _matchingData[{$alias}]: " . $data->name . " (" . get_class($data) . ")\n";
            }
        }
    }
}
?></pre>

<h2>Raw Array showing _matchingData structure</h2>
<pre><?php
foreach (array_slice($rawArrays, 0, 2) as $row) {
    echo "User #{$row['id']}: {$row['username']}\n";
    if (isset($row['_matchingData']['Roles'])) {
        echo "  _matchingData[Roles]: " . json_encode($row['_matchingData']['Roles'], JSON_PRETTY_PRINT) . "\n";
    }
}
?></pre>

<h2>DTO Definitions</h2>
<pre><code>// SimpleUserDto - does NOT include _matchingData
readonly class SimpleUserDto
{
    public function __construct(
        public int $id,
        public string $username,
        public ?string $email = null,
        public ?SimpleRoleDto $role = null,
        public ?DateTime $created = null,
    ) {}
}

// UserWithMatchingDto - INCLUDES _matchingData
readonly class UserWithMatchingDto
{
    public function __construct(
        public int $id,
        public string $username,
        public ?string $email = null,
        public ?DateTime $created = null,
        public ?array $_matchingData = null,  // <-- Explicit property
    ) {}
}</code></pre>

<h2>Key Takeaway</h2>
<p>
    <code>_matchingData</code> (and <code>_joinData</code>) work with DTOs just like any other field.
    If you want them in your DTO, add them as constructor parameters. If you don't need them, omit them.
</p>
