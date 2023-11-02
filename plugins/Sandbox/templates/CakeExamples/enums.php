<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxUser $user
 */
?>

<h2>Enums</h2>
<p>
With CakePHP 5 we can now use more native (backed) enums in our apps.
</p>

<p>Let's use the `UserStatus` backed enum (int values and string labels) as it can be found in source code to test it.</p>

<p>First, lets use ::cases() to list all possible enum cases:</p>
<ul>
 <?php
 $cases = \Sandbox\Model\Enum\UserStatus::cases();
 foreach ($cases as $case) {
	 echo '<li>' . $case->label() .  ' (`' . $case->value . '`)</li>';
 }
 ?>
</ul>


<?php if (!empty($result)) {
	echo '<b>Result:</b>';
	echo pre(h($result));
}?>

<h3>In DB and Forms</h3>
<p>For it to work, we need to assign the database table field to enum type:</p>

<div><pre class="code-snippet"><?php
	$text = <<<TXT
// SandboxUsersTable
public function initialize(array \$config): void {
    \$this->getSchema()->setColumnType('status', EnumType::from(UserStatus::class));
}
TXT;
	echo h($text);
	?></pre></div>


<p>Let's load a demo record with the enum included now:</p>

<h4>
<?php echo h($user->username); ?>
</h4>
<p>Status: <?php echo h($user->status->label()); ?></p>


<h4>Submit a form</h4>
<?php echo $this->Form->create($user); ?>
<?php echo $this->Form->control('status'); ?>
<?php echo $this->Form->submit(); ?>
<?php echo $this->Form->end(); ?>
