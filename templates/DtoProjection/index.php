<?php
/**
 * @var \App\View\AppView $this
 * @var array<\App\Model\Entity\User> $entities
 * @var array<\App\Dto\SimpleUserDto> $dtosSimple
 * @var array<\App\Dto\UserProjectionDto> $dtosPlugin
 */
?>
<h1>DTO Projection Demo: BelongsTo</h1>

<p>
    This demo shows <code>projectAs()</code> with Users containing BelongsTo Roles.
</p>

<h2>Navigation</h2>
<ul>
    <li><?= $this->Html->link('BelongsTo (this page)', ['action' => 'index']) ?></li>
    <li><?= $this->Html->link('HasMany', ['action' => 'hasMany']) ?></li>
    <li><?= $this->Html->link('BelongsToMany with _joinData', ['action' => 'belongsToMany']) ?></li>
    <li><?= $this->Html->link('Matching with _matchingData', ['action' => 'matching']) ?></li>
    <li><?= $this->Html->link('Benchmark', ['action' => 'benchmark']) ?></li>
    <li><?= $this->Html->link('POC with Enums', ['controller' => 'Misc', 'action' => 'dtoProjection']) ?></li>
</ul>

<h2>Traditional Entities</h2>
<pre><?php
foreach ($entities as $entity) {
    echo "User #{$entity->id}: {$entity->username}";
    if ($entity->role) {
        echo " (Role: {$entity->role->name})";
    }
    echo "\n";
    echo "  Type: " . get_class($entity) . "\n";
}
?></pre>

<h2>DTOs via DtoMapper (SimpleUserDto)</h2>
<p>Uses reflection-based mapping with typed constructor parameters.</p>
<pre><?php
foreach ($dtosSimple as $dto) {
    echo "User #{$dto->id}: {$dto->username}";
    if ($dto->role) {
        echo " (Role: {$dto->role->name})";
    }
    echo "\n";
    echo "  Type: " . get_class($dto) . "\n";
}
?></pre>

<h2>DTOs via cakephp-dto Plugin (UserProjectionDto)</h2>
<p>Uses generated <code>createFromArray()</code> factory method.</p>
<pre><?php
foreach ($dtosPlugin as $dto) {
    echo "User #{$dto->getId()}: {$dto->getUsername()}";
    if ($dto->getRole()) {
        echo " (Role: {$dto->getRole()->getName()})";
    }
    echo "\n";
    echo "  Type: " . get_class($dto) . "\n";
}
?></pre>

<h2>Code Example</h2>
<pre><code>// DtoMapper style (readonly class with typed constructor)
$users = $usersTable->find()
    ->contain(['Roles'])
    ->projectAs(SimpleUserDto::class)
    ->toArray();

// cakephp-dto style (generated class with createFromArray)
$users = $usersTable->find()
    ->contain(['Roles'])
    ->projectAs(UserProjectionDto::class)
    ->toArray();</code></pre>
