<?php
/**
 * @var \App\View\AppView $this
 * @var array<\App\Model\Entity\Role> $entities
 * @var array<\App\Dto\SimpleRoleDto> $dtos
 */
?>
<h1>DTO Projection Demo: HasMany</h1>

<p>
    This demo shows <code>projectAs()</code> with Roles containing HasMany Users.
    The <code>#[CollectionOf]</code> attribute specifies the DTO type for array collections.
</p>

<h2>Navigation</h2>
<ul>
    <li><?= $this->Html->link('BelongsTo', ['action' => 'index']) ?></li>
    <li><?= $this->Html->link('HasMany (this page)', ['action' => 'hasMany']) ?></li>
    <li><?= $this->Html->link('BelongsToMany with _joinData', ['action' => 'belongsToMany']) ?></li>
    <li><?= $this->Html->link('Matching with _matchingData', ['action' => 'matching']) ?></li>
    <li><?= $this->Html->link('Benchmark', ['action' => 'benchmark']) ?></li>
</ul>

<h2>Traditional Entities</h2>
<pre><?php
foreach ($entities as $entity) {
    echo "Role #{$entity->id}: {$entity->name}\n";
    echo "  Users: " . count($entity->users) . "\n";
    foreach ($entity->users as $user) {
        echo "    - {$user->username} (" . get_class($user) . ")\n";
    }
}
?></pre>

<h2>DTOs via DtoMapper</h2>
<pre><?php
foreach ($dtos as $dto) {
    echo "Role #{$dto->id}: {$dto->name}\n";
    echo "  Users: " . count($dto->users) . "\n";
    foreach ($dto->users as $user) {
        echo "    - {$user->username} (" . get_class($user) . ")\n";
    }
}
?></pre>

<h2>DTO Definition</h2>
<pre><code>readonly class SimpleRoleDto
{
    public function __construct(
        public int $id,
        public string $name,
        #[CollectionOf(SimpleUserDto::class)]  // Required for array collections
        public array $users = [],
    ) {}
}</code></pre>
