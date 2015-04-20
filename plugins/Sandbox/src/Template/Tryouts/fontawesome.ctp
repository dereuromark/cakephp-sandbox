<?php
//echo $this->Html->css('/sandbox/font-awesome/css/font-awesome');
?>

<h2>Fontawesome</h2>

<h3>Setup</h3>
<?php
echo $this->Html->css(Cake\Routing\Router::url('/', true) . 'sandbox/font-awesome/css/font-awesome.css');
?>

<h3><span class="fa fa-check"></span> Icons en masse!</h3>

See <a href="http://fontawesome.io/icons/">fontawesome.io</a>

<h3>Using <?php echo h('<i>');?>-tag with style font size</h3>
<i class="fa fa-camera-retro"></i> fa fa-camera-retro
<br />
<small><i class="fa fa-camera-retro"></i> fa fa-camera-retro (small)</small>
<br />
<p style="font-size: 30px"><i class="fa fa-camera-retro"></i> fa fa-camera-retro (30px)</p>

<h3>Using fa fa-x sizes</h3>
<p><i class="fa fa-camera-retro"></i> fa fa-camera-retro (normal, 14px)</p>
<p><i class="fa fa-camera-retro fa-large"></i> fa fa-camera-retro (large, +33% = 19px;)</p>
<p><i class="fa fa-camera-retro fa-2x"></i> fa fa-camera-retro (2x, 28px)</p>
<p><i class="fa fa-camera-retro fa-3x"></i> fa fa-camera-retro (3x, 42px)</p>
<p><i class="fa fa-camera-retro fa-4x"></i> fa fa-camera-retro (4x, 56px)</p>
<p><i class="fa fa-camera-retro fa-5x"></i> fa fa-camera-retro (4x, 70px)</p>

<h3>Quotes</h3>
<p>
<i class="fa fa-quote-left fa fa-4x pull-left fa fa-muted"></i>
Use a few of the new styles together ... lots of new possibilities.
</p>
<br  style="clear: both"/>

<h3>Rotating</h3>
Normal:<br />
<i class="fa fa-shield"></i>&nbsp;<br />
<br />

Rotated:<br />
<i class="fa fa-shield fa fa-rotate-90"></i>&nbsp; fa fa-rotate-90<br />
<i class="fa fa-shield fa fa-rotate-270"></i>&nbsp; fa fa-rotate-270<br />
<br />

Spin:<br />
<i class="fa fa-shield fa fa-spin"></i>&nbsp; fa fa-spin<br />

<h3>Other features</h3>
<p><i class="fa fa-camera-retro fa fa-2x fa fa-muted"></i> fa fa-muted</p>
<p style="background-color: black; padding: 1px;"><i class="fa fa-camera-retro fa fa-2x fa fa-light"></i> fa fa-light</p>
<p><i class="fa fa-camera-retro fa fa-2x fa fa-dark"></i> fa fa-dark</p>
<p><i class="fa fa-camera-retro fa fa-2x fa fa-border"></i> fa fa-border</p>
