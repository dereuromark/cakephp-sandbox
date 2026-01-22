<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $entities
 * @var array<\App\Dto\UserProjectionDto> $dtos
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h1>DTO Projection: BelongsTo</h1>

<p>
	This demo shows <code>projectAs()</code> with Users containing BelongsTo Roles.
</p>

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

<h2>DTOs via projectAs()</h2>
<pre><?php
foreach ($dtos as $dto) {
	echo "User #{$dto->getId()}: {$dto->getUsername()}";
	if ($dto->getRole()) {
		echo " (Role: {$dto->getRole()->getName()})";
	}
	echo "\n";
	echo "  Type: " . get_class($dto) . "\n";
}
?></pre>

<h2>Code Example</h2>
<pre><code>// DTO projection using cakephp-dto generated class
$users = $usersTable->find()
    ->contain(['Roles'])
    ->projectAs(UserProjectionDto::class)
    ->toArray();

// Access data via typed getters
foreach ($users as $user) {
    echo $user->getUsername();
    echo $user->getRole()?->getName();
}</code></pre>

</div></div>
