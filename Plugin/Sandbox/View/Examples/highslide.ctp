<?php
$this->Highslide->changeDefaultOptions(array('captionText'=>'ssss'));
$this->Highslide->changeDefaultOverlays(array());
//pr($this->Highslide->default_options);
?>

<h1>Highslide:</h1>
The JS/CSS Sources can be found at the official <a href="http://vikjavev.no/highslide/" title="opens a new page" target="_blank">Highslide-Site</a>!

<br/>

<h2>What is it able to do</h2>
Read the official docs and try out the examples at the link above.
<br/>
This helper mainly helps to set all options and default values at runtime. It also takes care of some stuff that needs to be printed in the head of each page.
<br /><br />
Notice: this example page only covers the overlays and inline options (seperate one for each highslide). See the codesnippet for the the global settings.
Also notice that all highslides on this page are images - for html/ajax/swl content etc, check out the second example page - or the link above.
<br />

<h2>One line of code - and you can set all kinds of stuff as highslide-clickable</h2>
Take a onclick=""-attribute and insert the following code (here inside a link):
<?php
$data_print='<a href="IMAGE.EXT" onclick="<?php echo $this->Highslide->onclick()?>"/>';
echo $this->Geshi->highlight($data_print,'php');
?>
It uses the href-tag for the image path and opens the link just as a normal one, if JS is not activated.<br />
I didn't use the html-&gt;image() helper-function to show the simple onclick element.

<br /><br />

If you dont want to use this fallback-feature, set it manually in the options array:
<?php
$data_print='.. onclick="<?php echo $this->Highslide->onclick(array(\'src\'=>\'IMAGE.EXT\'))?>" ..';
echo $this->Geshi->highlight($data_print,'php');
?>

Results can be:<br /><br />
<span class="pointer" style="background-color:yellow" onclick="<?php echo $this->Highslide->onclick(array('src'=>$this->Html->url('/img/content/examples/cake.jpg')))?>">I am a &lt;span&gt;-tag | Click me</span>
<br /><br />
<div class="pointer" style="background-color:orange;float:right;" onclick="<?php echo $this->Highslide->onclick(array('src'=>$this->Html->url('/img/content/examples/cake.jpg')))?>">I am a &lt;div&gt;-tag floating at the right | Click me</div>
<br class="clear"/>
<br />
and every other html element (because the href tag is now not necessary anymore).
<br /><br /><br />

This clickable image <?php echo $this->Html->image('icons/loupe.gif', array('title'=>'Click me','alt'=>'I am an image','onclick'=>$this->Highslide->onclick(array('src'=>'http://localhost/c/telapp/img/content/examples/cake.jpg')),'class'=>'pointer'));?> can easily be made combining html- and highslide-helper:
<?php
$data_print='<?php echo $this->Html->image(\'icons/loupe.gif\', array(
	\'title\'=>\'Click me\',
	\'alt\'=>\'I am an image\',
	\'onclick\'=>$this->Highslide->onclick(array(\'src\'=>\'IMAGE.EXT\')),
	\'class\'=>\'pointer\')
);?>';
echo $this->Geshi->highlight($data_print,'php');
?>


<br />

<h3 id="h3_advaced">Advanced Examples</h2>
If you use the options array, you are able to set a hole bunch of settings at runtime - and for just this one specific highslide tag.
<?php
$data_print='1: captioning
<?php echo $this->Html->link($this->Html->image(\'icons/help.png\', array(\'title\'=>\'Click me\',\'alt\'=>\'1\')),
\'/img/content/examples/cake.jpg\', array(
	\'onclick\'=>$this->Highslide->onclick(array(
		\'captionText\'=>\'This is a caption for just this one image\'))),
null,
false);?>

2: positioning
<?php echo $this->Html->link($this->Html->image(\'icons/help.png\', array(\'title\'=>\'Click me\',\'alt\'=>\'1\')),
\'/img/content/examples/cake.jpg\', array(
	\'onclick\'=>$this->Highslide->onclick(array(
		\'targetX\'=>\'h3_advaced 20px\',\'targetY\'=>\'h3_advaced -20px;\'))),
null,
false);?>


3: layouting
<?php echo $this->Html->link($this->Html->image(\'icons/help.png\', array(\'title\'=>\'Click me\',\'alt\'=>\'1\')),
\'/img/content/examples/cake.jpg\', array(
	\'onclick\'=>$this->Highslide->onclick(array(
		\'outlineType\'=>\'glossy-dark\',\'dimmingOpacity\'=>0.70))),
null,
false);?>';
echo $this->Geshi->highlight($data_print,'php');?>
Results in:

<br />

Click on the following icons to see the effects:
<ul>
<li>1: <?php echo $this->Html->link($this->Html->image('icons/help.png', array('title'=>'Click me','alt'=>'1')),'/img/content/examples/cake.jpg', array('onclick'=>$this->Highslide->onclick(array('captionText'=>'This is a caption for just this one image'))),null,false);?></li>
<li>2: <?php echo $this->Html->link($this->Html->image('icons/help.png', array('title'=>'Click me','alt'=>'2')),'/img/content/examples/cake.jpg', array('onclick'=>$this->Highslide->onclick(array('targetX'=>'h3_advaced 20px','targetY'=>'h3_advaced -20px;'))),null,false);?></li>
<li>3: <?php echo $this->Html->link($this->Html->image('icons/help.png', array('title'=>'Click me','alt'=>'3')),'/img/content/examples/cake.jpg', array('onclick'=>$this->Highslide->onclick(array('outlineType'=>'glossy-dark','dimmingOpacity'=>0.70))),null,false);?></li>
</ul>





<br />

<h3 id="h3_advaced">Full reference on the specific options</h2>
they are all set to NULL - but could be set to some value as well...
<?php
$data_print='\'allowSizeReduction\'=>null,
\'anchor\'=>null,
\'align\'=>null,
\'targetX\'=>null,
\'targetY\'=>null,
\'outlineType\'=>null,
\'outlineWhileAnimating\'=>null,
\'spaceForCaption\'=>null,
\'captionId\'=>null,
\'captionText\'=>null,
\'captionEval\'=>null,
\'transitions\'=>null,
\'dimmingOpacity\'=>null,
\'contentId\'=>null,
\'width\'=>null,
\'height\'=>null,
\'allowWidthReduction\'=>null,
\'allowHeightReduction\'=>null,
\'preserveContent\'=>null,
\'objectType\'=>null,
\'cacheAjax\'=>null,
\'objectWidth\'=>null,
\'objectHeight\'=>null,
\'objectLoadTime\'=>null,
\'swfObject\'=>null,
\'wrapperClassName\'=>null,
\'minWidth\'=>null,
\'minHeight\'=>null,
\'slideshowGroup\'=>null,
\'easing\'=>null,
\'easingClose\'=>null,
\'fadeInOut\'=>null,
/* sometimes both overlay and option */
\'thumbnailId\'=>null,
\'slideshowGroup\'=>null';
echo $this->Geshi->highlight($data_print,'php');
?>



<h3 id="h3_advaced">Overlays</h2>
First of all, you have to register the overlays you want to use:

<?php
echo $this->Highslide->registerOverlay(array('tryout'=>array('hideOnMouseOut'=>'true','position'=>'top left','overlayId'=>'my-caption','thumbnailId'=>'my-thumb','opacity'=>'0.8'),'forfun'=>array()));

$data_print='echo $this->Highslide->registerOverlay(array(
\'tryout\'=>array(
	\'hideOnMouseOut\'=>\'true\',
	\'position\'=>\'top left\',
	\'overlayId\'=>\'my-caption\',
	\'thumbnailId\'=>\'my-thumb\',
	\'opacity\'=>\'0.8\'
	),
\'forfun\'=>array()));';
echo $this->Geshi->highlight($data_print,'php');
?>

<a class="display" href="javascript:void(0)" onclick="toggleMe('example-1')">Show the html/javascript output</a>
<div class="example" id="example-1" style="display:none">
<?php
$data_print='<script type="text/javascript">
if (hs.registerOverlay) {
hs.registerOverlay({
	// tryout
	hideOnMouseOut: true,
	position: \'top left\',
	overlayId: \'my-caption\',
	thumbnailId: \'my-thumb\',
	opacity: 0.8
	});
hs.registerOverlay({
	// forfun
	...
	});
}
</script>';
echo $this->Geshi->highlight($data_print,'javascript');
?>
</div>

<br /><br />
Now we need the link with the id 'my-thumb' and an overlay-div with the id 'my-caption'
<?php
$data_print='echo $this->Html->link($this->Html->image(\'cake.icon.gif\', array(
\'title\'=>\'Click me\',
\'alt\'=>\'1\')),
\'/img/content/examples/cake.jpg\', array(
	\'onclick\'=>$this->Highslide->onclick(array(
		\'captionText\'=>\'This one has a custom overlay at the top (mouve the mouse in and out to notice the difference)\',
		\'overlayId\'=>\'my-caption\')),
	\'id\'=>\'my-thumb\'),
null,
false);';
echo $this->Geshi->highlight($data_print,'javascript');
?>

<?php
$data_print='echo $this->Highslide->overlay(array(
\'my-caption\'=>array(
	\'content\'=>\'a header or description\')));';
echo $this->Geshi->highlight($data_print,'javascript');
?>

<?php echo $this->Highslide->overlay(array('my-caption'=>array('content'=>'a header or description')))?>

We are done, click the cake to see the result: <?php echo $this->Html->link($this->Html->image('cake.icon.gif', array('title'=>'Click me','alt'=>'1')),'/img/content/examples/cake.jpg', array('onclick'=>$this->Highslide->onclick(array('captionText'=>'This one has a custom overlay at the top (mouve the mouse in and out to notice the difference)','overlayId'=>'my-caption')),'id'=>'my-thumb'),null,false);?>