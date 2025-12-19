<?php
/**
 * @var \App\View\AppView $this
 * @var array<\App\Dto\UserProjectionDto> $simpleUsers
 * @var array<\App\Dto\UserProjectionDto> $usersWithRoles
 * @var array<\App\Dto\RoleProjectionDto> $rolesWithUsers
 * @var array<\App\Model\Entity\User> $usersAsEntities
 * @var array<array> $usersAsArrays
 * @var array<\Sandbox\Dto\SandboxUserProjectionDto> $sandboxUsers
 * @var array<\Sandbox\Model\Entity\SandboxUser> $sandboxUsersAsEntities
 */
?>

<h1>DTO Projection POC</h1>

<h2>Test 1: Simple Projection (no associations)</h2>
<pre><?php
foreach ($simpleUsers as $user) {
	echo 'Type: ' . get_class($user) . "\n";
	echo 'ID: ' . $user->getId() . "\n";
	echo 'Username: ' . $user->getUsername() . "\n";
	echo 'Email: ' . $user->getEmail() . "\n";
	echo "---\n";
}
?></pre>

<h2>Test 2: Projection with BelongsTo (Users -> Roles)</h2>
<pre><?php
foreach ($usersWithRoles as $user) {
	echo 'Type: ' . get_class($user) . "\n";
	echo 'ID: ' . $user->getId() . "\n";
	echo 'Username: ' . $user->getUsername() . "\n";
	$role = $user->getRole();
	if ($role) {
		echo 'Role Type: ' . get_class($role) . "\n";
		echo 'Role ID: ' . $role->getId() . "\n";
		echo 'Role Name: ' . $role->getName() . "\n";
	} else {
		echo "Role: NULL\n";
	}
	echo "---\n";
}
?></pre>

<h2>Test 3: Projection with HasMany (Roles -> Users)</h2>
<pre><?php
foreach ($rolesWithUsers as $role) {
	echo 'Type: ' . get_class($role) . "\n";
	echo 'ID: ' . $role->getId() . "\n";
	echo 'Name: ' . $role->getName() . "\n";
	$users = $role->getUsers();
	echo 'Users count: ' . count($users) . "\n";
	foreach ($users as $user) {
		echo '  - User Type: ' . get_class($user) . "\n";
		echo '    User: ' . $user->getUsername() . "\n";
	}
	echo "---\n";
}
?></pre>

<h2>Test 4: Entity Hydration (comparison)</h2>
<pre><?php
foreach ($usersAsEntities as $user) {
	echo 'Type: ' . get_class($user) . "\n";
	echo 'ID: ' . $user->id . "\n";
	echo 'Username: ' . $user->username . "\n";
	if ($user->role) {
		echo 'Role Type: ' . get_class($user->role) . "\n";
		echo 'Role Name: ' . $user->role->name . "\n";
	}
	echo "---\n";
}
?></pre>

<h2>Test 5: Raw Arrays (comparison)</h2>
<pre><?php
foreach ($usersAsArrays as $user) {
	echo 'Type: ' . gettype($user) . "\n";
	echo 'ID: ' . $user['id'] . "\n";
	echo 'Username: ' . $user['username'] . "\n";
	if (isset($user['role'])) {
		echo 'Role Type: ' . gettype($user['role']) . "\n";
		echo 'Role Name: ' . $user['role']['name'] . "\n";
	}
	echo "---\n";
}
?></pre>

<h2>Test 6: Projection with Enum Field (SandboxUsers)</h2>
<p>This demonstrates DTO projection with CakePHP's BackedEnum type casting. The <code>status</code> field uses <code>\Sandbox\Model\Enum\UserStatus</code> enum.</p>
<pre><?php
foreach ($sandboxUsers as $user) {
	echo 'Type: ' . get_class($user) . "\n";
	echo 'ID: ' . $user->getId() . "\n";
	echo 'Username: ' . $user->getUsername() . "\n";
	echo 'Email: ' . $user->getEmail() . "\n";
	$status = $user->getStatus();
	if ($status) {
		echo 'Status Type: ' . get_class($status) . "\n";
		echo 'Status Name: ' . $status->name . "\n";
		echo 'Status Value: ' . $status->value . "\n";
		echo 'Status Label: ' . $status->label() . "\n";
	} else {
		echo "Status: NULL\n";
	}
	echo "---\n";
}
?></pre>

<h2>Test 7: Entity Hydration with Enum (comparison)</h2>
<pre><?php
foreach ($sandboxUsersAsEntities as $user) {
	echo 'Type: ' . get_class($user) . "\n";
	echo 'ID: ' . $user->id . "\n";
	echo 'Username: ' . $user->username . "\n";
	echo 'Email: ' . $user->email . "\n";
	$status = $user->status;
	if ($status) {
		echo 'Status Type: ' . get_class($status) . "\n";
		echo 'Status Name: ' . $status->name . "\n";
		echo 'Status Value: ' . $status->value . "\n";
		echo 'Status Label: ' . $status->label() . "\n";
	} else {
		echo "Status: NULL\n";
	}
	echo "---\n";
}
?></pre>
