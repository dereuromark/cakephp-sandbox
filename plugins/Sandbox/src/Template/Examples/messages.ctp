<h1>Messages:</h1>
The message helper "flash" is capable of handling multiple flash messages (of one kind). <br/>
Additionally, they now could be sorted by desired priority (instead of appearing at random).

<br/>

<h2>Unsorted example</h2>
The above output has the following code in the controller:
<?php
$codeHighlight = '$this->flashMessage(\'An error occured somewhere - mabye\',\'error\');
$this->flashMessage(\'This is a warning...\',\'warning\');
$this->flashMessage(\'This is a second very interesting warning\',\'warning\');
$this->flashMessage(\'Good Job :) You did it\',\'success\');
$this->flashMessage(\'I am a info message for you\',\'info\');';

echo $this->Highlighter->highlight($codeHighlight, ['lang' => 'php']);
?>
1. parameter: Message<br>
2. parameter: What kind of Message (error, warning, success, info)<br />




<br /><br />
Notice: you could easily print a sorted list as well, but you have to modify your message output function for this. Just read them all out and temp. save them in an array. Now you can ouput them in the prefered order (1 errors, 2 warning, 3 success, 4 info e.g.).
