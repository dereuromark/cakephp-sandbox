<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxUser $user
 */

use Cake\Core\Plugin;

?>

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<h2>Enums</h2>
<p>
With CakePHP 5 we can now use more native (backed) enums in our apps. They map to a string or int type usually in your DB.
</p>

<p>
	Let's use the `UserStatus` backed enum (int values and string labels) to test it. It can be found in source code for details.
	We use a tinyint(2) column in the database for the `status` field.
</p>

<?php echo $this->Highlighter->highlight(file_get_contents(Plugin::path('Sandbox') . 'src/Model/Enum/UserStatus.php'), ['lang' => 'php']); ?>

<p>Now lets use `::cases()` to list all possible enum cases:</p>
<ul>
 <?php
 $cases = \Sandbox\Model\Enum\UserStatus::cases();
 foreach ($cases as $case) {
	 echo '<li>' . $case->label() .  ' (`' . $case->value . '`)</li>';
 }
 ?>
</ul>


<h3>In DB and Forms</h3>
<p>When used in forms, CakePHP form helper will automatically extract those to display as dropdown.</p>

<p>For it to work, we need to assign the database table field to enum type:</p>

<?php
$text = <<<TXT
// SandboxUsersTable
public function initialize(array \$config): void {
    \$this->getSchema()->setColumnType('status', EnumType::from(UserStatus::class));
}
TXT;
echo $this->Highlighter->highlight($text, ['lang' => 'php']);
?>

<p>Let's load a demo record with the enum included now:</p>

<h4>
<?php echo h($user->username); ?>
</h4>

<?php
echo $this->Highlighter->highlight(print_r($user, true), ['lang' => 'php']);
?>

<p>
	Unfortunately, enums cannot implement Stringable.
	So here we need to always manually do the respective string output.
</p>

<h4><?php echo h('$user->status->label()');?></h4>
<p>Status: <b><?php echo h($user->status->label()); ?></b></p>


<h4>Submit a form</h4>
<?php echo $this->Form->create($user); ?>
<?php echo $this->Form->control('status'); ?>
<?php echo $this->Form->submit(); ?>
<?php echo $this->Form->end(); ?>

<br>

<h4>Manuel form (without entity passed in)</h4>

<?php echo $this->Form->create(); ?>
<?php echo $this->Form->control('status', ['options' => \Sandbox\Model\Enum\UserStatus::options([\Sandbox\Model\Enum\UserStatus::Deleted, \Sandbox\Model\Enum\UserStatus::Active])]); ?>
<?php echo $this->Form->submit(); ?>
<?php echo $this->Form->end(); ?>

<p>Note the order customization, as well.</p>

<h3>Serialization</h3>
<p>
When serializing, the actual (DB) value (in this case int) is used:
</p>

<h4>json_encode() of the entity containing the enum</h4>

<?php
$text = json_encode($user, JSON_PRETTY_PRINT);
echo $this->Highlighter->highlight($text, ['lang' => 'json']);
?>

<p>
If you also want the human-readable string form, you can add a virtual field `status_string` etc that would include this in the dataset.
</p>

<h4>Unserialize</h4>
<p>json_decode() + patching an entity</p>

<?php
$array = json_decode($text, true);
$entity = \Cake\ORM\TableRegistry::getTableLocator()->get('Sandbox.SandboxUsers')->newEntity($array);
echo $this->Highlighter->highlight(print_r($entity, true), ['lang' => 'json']);
?>

<p>
	Here you can see that it is now a backed enum object again.
</p>

<h4>More examples</h4>
<ul>
	<li><?php echo $this->Html->link('Validation', ['action' => 'enumValidation']);?></li>
</ul>
