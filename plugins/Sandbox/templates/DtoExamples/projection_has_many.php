<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Role> $entities
 * @var array<\App\Dto\SimpleRoleDto> $dtos
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h1>DTO Projection: HasMany</h1>

<p>
	This demo shows <code>projectAs()</code> with Roles containing HasMany Users.
</p>

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

<h2>DTOs via projectAs()</h2>
<pre><?php
foreach ($dtos as $dto) {
	echo "Role #{$dto->getId()}: {$dto->getName()}\n";
	$users = $dto->getUsers();
	echo "  Users: " . count($users) . "\n";
	foreach ($users as $user) {
		echo "    - {$user->getUsername()} (" . get_class($user) . ")\n";
	}
}
?></pre>

<h2>Code Example</h2>
<pre><code>// DTO with HasMany collection
$roles = $rolesTable->find()
    ->contain(['Users'])
    ->projectAs(SimpleRoleDto::class)
    ->toArray();

// Generated DTO handles collection automatically
foreach ($roles as $role) {
    echo $role->getName();
    foreach ($role->getUsers() as $user) {
        echo $user->getUsername();
    }
}</code></pre>

</div></div>
