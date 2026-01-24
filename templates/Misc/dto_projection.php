<?php
/**
 * @var \App\View\AppView $this
 * @var array $simpleUsers
 * @var array $usersWithRoles
 * @var array $rolesWithUsers
 * @var array $usersAsEntities
 * @var array $usersAsArrays
 * @var array $sandboxUsers
 * @var array $sandboxUsersAsEntities
 */
?>

<h2>DTO Projection Examples</h2>

<p>See <a href="/sandbox/dto-examples">Sandbox DTO Examples</a> for more comprehensive demos.</p>

<h3>Simple Users (DTO)</h3>
<pre><?= h(print_r($simpleUsers, true)) ?></pre>

<h3>Users with Roles (DTO)</h3>
<pre><?= h(print_r($usersWithRoles, true)) ?></pre>

<h3>Roles with Users (DTO)</h3>
<pre><?= h(print_r($rolesWithUsers, true)) ?></pre>

<h3>Users as Entities (comparison)</h3>
<pre><?= h(print_r($usersAsEntities, true)) ?></pre>

<h3>Users as Arrays (comparison)</h3>
<pre><?= h(print_r($usersAsArrays, true)) ?></pre>

<h3>Sandbox Users with Enum (DTO)</h3>
<pre><?= h(print_r($sandboxUsers, true)) ?></pre>

<h3>Sandbox Users as Entities (comparison)</h3>
<pre><?= h(print_r($sandboxUsersAsEntities, true)) ?></pre>
