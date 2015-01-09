<?php
//echo $this->Html->css('/sandbox/font-awesome/css/font-awesome');
?>

<h2>Fontawesome</h2>

<h3>Setup</h3>
echo $this->Html->css('/sandbox/font-awesome/css/font-awesome');

<h3><i class="icon-ok"></i> Icons en masse!</h3>

See <a href="http://fontawesome.io/icons/">fontawesome.io</a>

<h3>Using <?php echo h('<i>');?>-tag with style font size</h3>
<i class="icon-camera-retro"></i> icon-camera-retro
<br />
<small><i class="icon-camera-retro"></i> icon-camera-retro (small)</small>
<br />
<p style="font-size: 30px"><i class="icon-camera-retro"></i> icon-camera-retro (30px)</p>

<h3>Using icon-x sizes</h3>
<p><i class="icon-camera-retro"></i> icon-camera-retro (normal, 14px)</p>
<p><i class="icon-camera-retro icon-large"></i> icon-camera-retro (large, +33% = 19px;)</p>
<p><i class="icon-camera-retro icon-2x"></i> icon-camera-retro (2x, 28px)</p>
<p><i class="icon-camera-retro icon-3x"></i> icon-camera-retro (3x, 42px)</p>
<p><i class="icon-camera-retro icon-4x"></i> icon-camera-retro (4x, 56px)</p>
<p><i class="icon-camera-retro icon-5x"></i> icon-camera-retro (4x, 70px)</p>

<h3>Quotes</h3>
<p>
<i class="icon-quote-left icon-4x pull-left icon-muted"></i>
Use a few of the new styles together ... lots of new possibilities.
</p>
<br  style="clear: both"/>

<h3>Rotating</h3>
Normal:<br />
<i class="icon-shield"></i>&nbsp;<br />
<br />

Rotated:<br />
<i class="icon-shield icon-rotate-90"></i>&nbsp; icon-rotate-90<br />
<i class="icon-shield icon-rotate-270"></i>&nbsp; icon-rotate-270<br />
<br />

Spin:<br />
<i class="icon-shield icon-spin"></i>&nbsp; icon-spin<br />

<h3>Other features</h3>
<p><i class="icon-camera-retro icon-2x icon-muted"></i> icon-muted</p>
<p style="background-color: black; padding: 1px;"><i class="icon-camera-retro icon-2x icon-light"></i> icon-light</p>
<p><i class="icon-camera-retro icon-2x icon-dark"></i> icon-dark</p>
<p><i class="icon-camera-retro icon-2x icon-border"></i> icon-border</p>
