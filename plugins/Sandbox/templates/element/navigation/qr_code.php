<?php
/**
 * @var \App\View\AppView $this
 */
?>


<h2>QrCode Examples</h2>
<p>
	<a href="https://github.com/dereuromark/cakephp-qrcode" target="_blank">[QrCode Plugin]</a>
</p>

<h3>Display/render QR Codes</h3>
<p>For flyers, quick-links and more.</p>
<p>Or too lazy to type text messages via cellphone? This is the smart way. Just write it via keyboard, scan it and send it via phone.</p>

<ul class="side-nav nav nav-pills nav-stacked flex-column">
	<li class="heading"><?= __('') ?></li>
	<li><?php echo $this->Navigation->link('Basic', ['action' => 'index'])?></li>
	<li><?php echo $this->Navigation->link('SVG Image', ['action' => 'svg'])?></li>
	<li><?php echo $this->Navigation->link('PNG Image', ['action' => 'png'])?></li>

</ul>
