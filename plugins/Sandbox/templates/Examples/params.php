<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h1>Params of the URL passed:</h1>
There are different ways of passing and retrieving url information via $_GET['']. The information of the params are stored in "named", "pass" etc depending on how they are passed. The nice thing about this is, that CakePHP automatically seperates the different params and returns them as array.
Controller and Action params are stored as string, though.
<br /><br />

Test it with the following links:<br /><br />
<?php echo $this->Html->link('Saved in "pass"', ['action' => 'params', 'very', 'cool', 'stuff'])?> | <?php echo $this->Html->link('Query strings', ['action' => 'params', '?' => ['id' => 1, 'teststring' => 'active']])?>

<br />
<h2>Retrieving URL Information</h2>
<b>$this->request->url</b>:
<?php
echo $this->Sandbox->pre($this->request->url);
?>

<br />
<b>$this->request-&gt;params['prefix']</b>:
<i>n/a</i>

<br />
<b>$this->request-&gt;params['plugin']</b>:
<i>n/a</i>

<br />
<b>$this->request-&gt;params['controller']</b>:
<?php
echo $this->request->params['controller'];
?>

<br />
<b>$this->request-&gt;params['action']</b>:
<?php
echo $this->request->params['action'];
?>


<br />
<br />
<b>$this->request-&gt;params['pass']</b>:
<?php

echo $this->Sandbox->pre($this->request->params['pass']);

?>

<br />
<br />
<b>$this->request-&gt;query</b>:
<?php
echo $this->Sandbox->pre($this->request->getQuery());
?>
