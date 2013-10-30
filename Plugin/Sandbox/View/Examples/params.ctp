<h1>Params of the URL passed:</h1>
There are different ways of passing and retrieving url information via $_GET['']. The information of the params are stored in "named", "pass" etc depending on how they are passed. The nice thing about this is, that CakePHP automatically seperates the different params and returns them as array.
Controller and Action params are stored as string, though.
<br /><br />

Test it with the following links:<br /><br />
<?php echo $this->Html->link('Saved in "named"', array('action'=>'params','xyz'=>123,'test'=>'yes','var'=>'s1'))?> | <?php echo $this->Html->link('Saved in "pass"', array('action'=>'params','very','cool','stuff'))?> | <?php echo $this->Html->link('Old fashened', array('action'=>'params','?id=1&teststring=active'))?> (not recommended)

<br />
<h2>Retrieving URL Information</h2>
<b>$this-&gt;params['url']</b>:
<?php
echo $this->Html->pre($this->request->params['url']);
?>

<br />
<b>$this-&gt;params['controller']</b>:
<?php
echo $this->request->params['controller'];
?>
<br /><br />
<b>$this-&gt;params['action']</b>:
<?php
echo $this->request->params['action'];
?>


<br />
<br />
<b>$this-&gt;params['named']</b>:
<?php

echo $this->Html->pre($this->request->params['named']);

?>

<br />
<b>$this-&gt;params['pass']</b>:
<?php

echo $this->Html->pre($this->request->params['pass']);

?>

<?php
//pr($this->request->params);
?>