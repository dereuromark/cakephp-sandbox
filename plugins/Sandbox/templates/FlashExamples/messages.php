<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row">
<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/flash'); ?>
</nav>
<div class="page index col-sm-8 col-12">

<h1>Messages</h1>
<p>
The message helper <code>Flash</code> is capable of handling multiple flash messages (of one kind). <br/>
Additionally, they now could be sorted by desired priority (instead of appearing at random).
</p>
<p>You can customize the order with the <code>order</code> config of the helper.</p>


<h2>Auto-sorted example</h2>
The above output has the following code in the controller:
<?php
$codeHighlight = '$this->Flash->warning(\'This is a warning...\');
$this->Flash->error(\'An error occurred somewhere\');
$this->Flash->warning(\'This is a second very interesting warning\');
$this->Flash->success(\'Good Job :) You did it\');
$this->Flash->info(\'I am some info message for you\');';

echo $this->Highlighter->highlight($codeHighlight, ['lang' => 'php']);
?>

</div></div>
