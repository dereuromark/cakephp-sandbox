<?php
echo $this->Html->css('/sandbox/fontello/css/webfont');
?>

<h2>Fontawesome</h2>

<h3>Setup</h3>
echo $this->Html->css('/sandbox/fontello/css/webfont');

<h3>Nice <?php echo $this->Format->fontIcon('play'); ?> font-icons</h3>
See <a href="http://fontello.com/">fontello.com</a>
<br /><br />
Note: Some of the effects below are possible due to the already included font-awesome css.

<h3>Using <?php echo h('<i>');?>-tag with style font size</h3>
<i class="icon-clouds"></i> icon-clouds
<br />
<small><i class="icon-clouds"></i> icon-clouds (small)</small>
<br />
<p style="font-size: 30px"><i class="icon-clouds"></i> icon-clouds (30px)</p>

<h3>Using icon-x sizes</h3>
<p><i class="icon-clouds"></i> icon-clouds (normal, 14px)</p>
<p><i class="icon-clouds icon-large"></i> icon-clouds (large, +33% = 19px;)</p>
<p><i class="icon-clouds icon-2x"></i> icon-clouds (2x, 28px)</p>
<p><i class="icon-clouds icon-3x"></i> icon-clouds (3x, 42px)</p>
<p><i class="icon-clouds icon-4x"></i> icon-clouds (4x, 56px)</p>
<p><i class="icon-clouds icon-5x"></i> icon-clouds (4x, 70px)</p>

<h3>Rotating</h3>
Normal:<br />
<i class="icon-keyboard"></i>&nbsp;<br />
<br />

Rotated:<br />
<i class="icon-keyboard icon-rotate-90"></i>&nbsp; icon-rotate-90<br />
<i class="icon-keyboard icon-rotate-270"></i>&nbsp; icon-rotate-270<br />
<br />

Spin:<br />
<i class="icon-keyboard icon-spin"></i>&nbsp; icon-spin<br />

<h3>Other features</h3>
<p><i class="icon-clouds icon-2x icon-muted"></i> icon-muted</p>
<p style="background-color: black; padding: 1px;"><i class="icon-clouds icon-2x icon-light"></i> icon-light</p>
<p><i class="icon-clouds icon-2x icon-dark"></i> icon-dark</p>
<p><i class="icon-clouds icon-2x icon-border"></i> icon-border</p>
