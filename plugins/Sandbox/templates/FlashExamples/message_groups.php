<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h1>Message Groups</h1>
<p>You can customize the grouping with the <code>types</code> config of the helper.</p>

<?php
$this->Flash->transientWarning('This is a warning...');
$this->Flash->transientError('An error occurred somewhere');
$this->Flash->transientWarning('This is a second very interesting warning');
$this->Flash->transientSuccess('Good Job :) You did it');
$this->Flash->transientInfo('I am some info message for you');
?>

<h2>Example</h2>

<h3>Serious stuff</h3>
<?php echo $this->Flash->render('flash', ['types' => ['error', 'warning']]); ?>

<h3>Not so serious stuff</h3>
<?php echo $this->Flash->render('flash', ['types' => ['success', 'info']]); ?>


<h3>Explanations</h3>
The above output has the following code in the controller (or view using transient* methods):
<?php
$codeHighlight = '$this->Flash->warning(\'This is a warning...\');
$this->Flash->error(\'An error occurred somewhere\');
$this->Flash->warning(\'This is a second very interesting warning\');
$this->Flash->success(\'Good Job :) You did it\');
$this->Flash->info(\'I am some info message for you\');';

echo $this->Highlighter->highlight($codeHighlight, ['lang' => 'php']);
?>
