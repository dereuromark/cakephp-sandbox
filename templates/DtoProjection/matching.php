<?php
/**
 * @var \App\View\AppView $this
 * @var array<\App\Model\Entity\User> $entities
 * @var array<\App\Dto\SimpleUserDto> $dtosWithout
 * @var array<\App\Dto\UserWithMatchingDto> $dtosWithArray
 * @var array<\App\Dto\UserWithMatchingDtoTyped> $dtosWithTyped
 * @var array $rawArrays
 */
?>
<h1>DTO Projection Demo: Matching with _matchingData</h1>

<p>
    This demo shows <code>projectAs()</code> with <code>matching()</code> queries.
    <strong>Key insight:</strong> <code>_matchingData</code> can be typed as <code>array</code>
    OR as a nested DTO for full type safety.
</p>

<h2>Navigation</h2>
<ul>
    <li><?= $this->Html->link('BelongsTo', ['action' => 'index']) ?></li>
    <li><?= $this->Html->link('HasMany', ['action' => 'hasMany']) ?></li>
    <li><?= $this->Html->link('BelongsToMany with _joinData', ['action' => 'belongsToMany']) ?></li>
    <li><?= $this->Html->link('Matching with _matchingData (this page)', ['action' => 'matching']) ?></li>
    <li><?= $this->Html->link('Benchmark', ['action' => 'benchmark']) ?></li>
</ul>

<h2>1. Traditional Entities</h2>
<pre><?php
foreach ($entities as $entity) {
    echo "User #{$entity->id}: {$entity->username}\n";
    if (isset($entity->_matchingData['Roles'])) {
        $role = $entity->_matchingData['Roles'];
        echo "  _matchingData[Roles]: {$role->name} (" . get_class($role) . ")\n";
    }
}
?></pre>

<h2>2. DTO WITHOUT _matchingData</h2>
<p>Using <code>SimpleUserDto</code> - matching data is silently ignored.</p>
<pre><?php
foreach ($dtosWithout as $dto) {
    echo "User #{$dto->id}: {$dto->username}\n";
    echo "  _matchingData: not available (no property)\n";
}
?></pre>

<h2>3. DTO with _matchingData as <code>array</code></h2>
<p>Using <code>UserWithMatchingDto</code> - matching data as raw array.</p>
<pre><?php
foreach ($dtosWithArray as $dto) {
    echo "User #{$dto->id}: {$dto->username}\n";
    if ($dto->_matchingData !== null) {
        foreach ($dto->_matchingData as $alias => $data) {
            $type = is_array($data) ? 'array' : get_class($data);
            $name = is_array($data) ? ($data['name'] ?? '?') : $data->name;
            echo "  _matchingData[{$alias}]: {$name} ({$type})\n";
        }
    }
}
?></pre>

<h2>4. DTO with _matchingData as <code>MatchingDataDto</code></h2>
<p>Using <code>UserWithMatchingDtoTyped</code> - fully typed nested DTOs!</p>
<pre><?php
foreach ($dtosWithTyped as $dto) {
    echo "User #{$dto->id}: {$dto->username}\n";
    if ($dto->_matchingData !== null) {
        echo "  _matchingData type: " . get_class($dto->_matchingData) . "\n";
        if ($dto->_matchingData->Roles !== null) {
            $role = $dto->_matchingData->Roles;
            echo "  _matchingData->Roles: {$role->name} (" . get_class($role) . ")\n";
        }
    }
}
?></pre>

<h2>DTO Definitions</h2>
<pre><code>// Option 1: _matchingData as array (simple)
readonly class UserWithMatchingDto
{
    public function __construct(
        public int $id,
        public string $username,
        public ?array $_matchingData = null,
    ) {}
}

// Option 2: _matchingData as typed DTO (full type safety)
readonly class MatchingDataDto
{
    public function __construct(
        public ?SimpleRoleDto $Roles = null,  // Property name = association alias
    ) {}
}

readonly class UserWithMatchingDtoTyped
{
    public function __construct(
        public int $id,
        public string $username,
        public ?MatchingDataDto $_matchingData = null,
    ) {}
}</code></pre>

<h2>Key Takeaway</h2>
<ul>
    <li><code>?array</code> - Quick and simple, data stays as arrays</li>
    <li><code>?MatchingDataDto</code> - Full type safety, nested DTOs auto-mapped</li>
    <li>Property names in MatchingDataDto must match association aliases (e.g., <code>Roles</code>)</li>
</ul>
