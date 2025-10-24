<?php
/**
 * @var \App\View\AppView $this
 * @var \Sandbox\Model\Entity\SandboxUser $user
 */

?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/cake'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<?php $this->append('script'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
<!-- and it's easy to individually load additional languages -->
<script>hljs.highlightAll();</script>
<?php $this->end(); ?>

<h2>Enum Validation</h2>
<p>
With CakePHP 5.1 we can now use improved validation for enums in our apps. enumOnly() and enumExcept() are now available.
</p>

<p>
	Let's use the `UserStatus` backed enum (int values and string labels) to test it. It can be found in source code for details.
</p>

<?php
	$code = <<<'CODE'
$this->getValidator()->add('status', 'validEnum', [
	'rule' => ['enumOnly', [UserStatus::Active, UserStatus::Inactive]],
	'message' => 'Invalid enum value.'
]);
CODE;

	echo $this->Highlighter->highlight($code, ['lang' => 'php']);
?>

<h4>Submit a form</h4>
<?php echo $this->Form->create($user, ['novalidate' => true]); ?>
<?php echo $this->Form->control('status', ['empty' => ' - please select - ']); ?>
<?php echo $this->Form->submit(); ?>
<?php echo $this->Form->end(); ?>

<br>

<p>
	We left the "Deleted" status in there on purpose. Usually it would not be here.
</p>
<p>
	Here you can see that now the "user" can only select "Active" and "Inactive". "Deleted" is not an allowed value for this form, even
	though it is in the enum.
</p>

</div></div>
