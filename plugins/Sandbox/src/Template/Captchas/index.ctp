<?php
/**
 * @var \App\View\AppView $this
 */
?>
<h2>Catpcha Examples</h2>
<p>
<a href="https://github.com/dereuromark/cakephp-captcha" target="_blank">[Source]</a>
</p>

<p>
Basically, the plugin provides a captcha engine interface to hook in any (image based) captcha type you want to use.
	Out of the box it ships with a simple Math captcha engine.
</p>

<?php
$this->loadHelper('Captcha.Captcha');

?>

<p>

</p>

<h3>Captcha plugin examples</h3>
<ul>
	<li><?php echo $this->Html->link('Show captchas in action', ['action' => 'math'])?></li>
</ul>
