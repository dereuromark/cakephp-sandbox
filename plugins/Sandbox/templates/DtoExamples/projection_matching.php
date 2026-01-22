<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $entities
 * @var array<\App\Dto\SimpleUserDto> $dtosWithout
 * @var array<\App\Dto\UserWithMatchingDto> $dtosWithArray
 * @var array<\App\Dto\UserWithMatchingTypedDto> $dtosWithTyped
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/dto'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h1>DTO Projection: Matching with _matchingData</h1>

<p>
	This demo shows <code>projectAs()</code> with <code>matching()</code> queries.
	<strong>Key insight:</strong> <code>_matchingData</code> can be typed as <code>array</code>
	OR as a nested DTO for full type safety.
</p>

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
	echo "User #{$dto->getId()}: {$dto->getUsername()}\n";
	echo "  _matchingData: not available (no property)\n";
}
?></pre>

<h2>3. DTO with _matchingData as <code>array</code></h2>
<p>Using <code>UserWithMatchingDto</code> - matching data as raw array.</p>
<pre><?php
foreach ($dtosWithArray as $dto) {
	echo "User #{$dto->getId()}: {$dto->getUsername()}\n";
	if ($dto->getMatchingData() !== null) {
		foreach ($dto->getMatchingData() as $alias => $data) {
			$type = is_array($data) ? 'array' : get_class($data);
			$name = is_array($data) ? ($data['name'] ?? '?') : $data->name;
			echo "  _matchingData[{$alias}]: {$name} ({$type})\n";
		}
	}
}
?></pre>

<h2>4. DTO with _matchingData as typed DTO</h2>
<p>Using <code>UserWithMatchingTypedDto</code> - fully typed nested DTOs!</p>
<pre><?php
foreach ($dtosWithTyped as $dto) {
	echo "User #{$dto->getId()}: {$dto->getUsername()}\n";
	if ($dto->getMatchingData() !== null) {
		echo "  _matchingData type: " . get_class($dto->getMatchingData()) . "\n";
		if ($dto->getMatchingData()->getRoles() !== null) {
			$role = $dto->getMatchingData()->getRoles();
			echo "  _matchingData->Roles: {$role->getName()} (" . get_class($role) . ")\n";
		}
	}
}
?></pre>

<h2>Key Takeaway</h2>
<ul>
	<li><code>?array</code> - Quick and simple, data stays as arrays</li>
	<li><code>?MatchingDataDto</code> - Full type safety, nested DTOs auto-mapped</li>
	<li>Property names in MatchingDataDto must match association aliases (e.g., <code>Roles</code>)</li>
</ul>

</div></div>
