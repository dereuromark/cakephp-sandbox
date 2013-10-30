<?php
$this->Jquery->plugins(array('datepicker-ui'));
?>

<?php $this->Html->scriptStart(array('inline' => false)); ?>

$(document).ready(function() {


	$("#datepicker-basics").datepicker({
		showOn: "both",
		buttonImage: "http://ui.jquery.com/repository/demos_templates/images/calendar.gif",
		buttonImageOnly: true
	});


	$("#togglePostData").click(function () {
		$("#togglePostDataContent").toggle();
	});

	//$("#datepicker-basics").datepicker("disable");


});


$(function() {

	$.datepicker.setDefaults($.datepicker.regional['<?php echo Configure::read('Language.iso2')?>']);


	$("#datepicker-minmax").datepicker({
		showOn: "both",
		dateFormat: "yy-mm-dd",
		minDate: new Date(2008, 1 - 1, 26),
		maxDate: new Date(2009, 1 - 1, 3),
		buttonImage: "http://ui.jquery.com/repository/demos_templates/images/calendar.gif",
		buttonImageOnly: true
	});

	$("#datepicker-slide").datepicker({
		showOn: "both",
		dateFormat: "yy-mm-dd",
		showAnim: "slideDown",
		buttonImage: "http://ui.jquery.com/repository/demos_templates/images/calendar.gif",
		buttonImageOnly: true
	});

	$("#datepicker-advanced").datepicker({
		showOn: "both",
		dateFormat: "yy-mm-dd",
		defaultDate: new Date(2009, 1 - 1, 1),
		appendText: "(format yyyy-mm-dd)",
		buttonImage: "http://ui.jquery.com/repository/demos_templates/images/calendar.gif",
		buttonImageOnly: true
	});

	$("#datepicker-ranges").datepicker({
		rangeSelect: true,
		showOn: "both",
		dateFormat: "yy.mm.dd",
		buttonImage: "http://ui.jquery.com/repository/demos_templates/images/calendar.gif",
		buttonImageOnly: true
	});

	$(".datepicker-readonly").datepicker({
		showOn: "both",
		dateFormat: "yy-mm-dd",
		buttonImage: "http://ui.jquery.com/repository/demos_templates/images/calendar.gif",
		buttonImageOnly: true
	}).attr("readonly", "readonly");
});




<?php $this->Html->scriptEnd(); ?>

<div id="ajax-loading"><?php echo $this->Format->icon('loader');?></div>
<div id="ajax-loading-alt"><?php echo $this->Format->icon('loader-alt');?></div>


<h1><?php echo __('Media Files');?></h1>
Note: See the official Site @ <?php echo $this->Html->link('ui.jquery.com/functional_demos#ui.datepicker','http://ui.jquery.com/functional_demos#ui.datepicker', array('target'=>'_blank'))?> for full reference<br />

<?php
if (!empty($this->request->params['data']['JqueryExample'])) {
?>
<br />
<a href="javascript:void(0);" id="togglePostData" class="display">Show submitted data</a>
<div class="example" id="togglePostDataContent" style="display:none">
<?php echo $this->Html->pre($this->request->params['data']['JqueryExample']);?>
Dont forget to check on valid date formats in php again - before using them for db queries etc.
</div>
<br />
<?php
}
?>


<h2>Example</h2>

<?php echo $this->Form->Create('JqueryExample', array('url'=>'datepicker'))?>
<fieldset>
 		<legend><?php echo __('Hit the submit button to see the posted result');?></legend>

<div class="form-heading">Default one - eather click on the input or the img</div>
<?php echo $this->Form->input('datepicker-basics', array('maxlength'=>10,'id'=>'datepicker-basics'))?>

<br />
<div class="form-heading">Date must be between 2008-01-26 and 2009-02-02</div>
<?php echo $this->Form->input('datepicker-minmax', array('maxlength'=>10,'id'=>'datepicker-minmax'))?>

<br />
<div class="form-heading">Selection Div sliding up/down</div>
<?php echo $this->Form->input('datepicker-slide', array('maxlength'=>10,'id'=>'datepicker-slide'))?>

<br />
<div class="form-heading">Having a default date (1.1.2009) + some text appended at the end</div>
<?php echo $this->Form->input('datepicker-advanced', array('maxlength'=>10,'id'=>'datepicker-advanced'))?>

<br />
<div class="form-heading">Range Selection - date format with [.] in between</div>
<?php echo $this->Form->input('datepicker-ranges', array('maxlength'=>23,'id'=>'datepicker-ranges'))?>

<br />
<div class="form-heading">Readonly may prevent bad input (dont rely on it though)</div>
<?php echo $this->Form->input('datepicker-readonly', array('maxlength'=>10,'class'=>'datepicker-readonly'))?>
<?php echo $this->Form->input('datepicker-readonly2', array('maxlength'=>10,'class'=>'datepicker-readonly'))?>
The last 2 Datepickers dont refer to an ID - but to a CLASS - which makes it possible to use a single $() for a unlimited number of date fields.

</fieldset>
<?php echo $this->Form->end(__('Submit'))?>



<br />
<h2>Todo</h2>
<ul>
<li>Altering the script - or adding some methods to be able to select a range more advanced. Right now, you could get invalid results. If you have to input fields for a range selection e.g., if you insert a date in the first one, the minValue of the second one is not adjusted. Probably could be done with a "onChange".</li>
<li>Dont like the manual [buttonImage: ""] in the JS code - should be able to write it into CSS (where the rest of the img is defined). Need to adjust that, because it gets not displayed correctly if i try do it this way. Maybe s.b. has a solution for that. The manual JS buttonImage could (as an option) still override the css one though.</li>
<li>Changing the given CSS styles generelly - as many do not have the close/delete button or the rest of the menu. also checking on some IE layout bugs - and some bugs appearing in all browsers.</li>
</ul>

<h2>Bugs</h2>
(with the pure query datepicker - not the UI-query datepicker script)
<ul>
<li>Popup immediately (speed: "") does not work (although this one does work on the original site somehow..)</li>
<li>Datepicker Linked to Dropdowns does not work</li>
<li>Alternate Field and Format does not work</li>
</ul>