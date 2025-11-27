<?php
/**
 * @var \App\View\AppView $this
 */
?>

<nav class="actions col-md-3 col-sm-4 col-12">
	<?= $this->element('navigation/captchas') ?>
</nav>
<div class="col-md-9 col-sm-8 col-12">

<h2>Captcha Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-captcha" target="_blank">[cakephp-captcha]</a> provides a captcha engine interface to hook in any (image based) captcha type you want to use.
	Out of the box it ships with a simple Math captcha engine.
</p>

<h3>Available Examples</h3>
<ul>
	<li><strong>Math Captcha</strong> - Classic image-based math challenge</li>
	<li><strong>Passive Captcha</strong> - Invisible honeypot-style protection for model-less forms</li>
</ul>

<h3>Key Features</h3>
<ul>
	<li>Simple and unobtrusive</li>
	<li>Without many dependencies or requirements</li>
	<li>Highly extendable via engine interface</li>
	<li>Flood protection built-in</li>
</ul>

</div>
