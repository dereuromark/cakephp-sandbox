<script type="text/javascript">

$(document).ready(function() {


/** Just some testing **/
	$("h2").bind("dblclick", function() {
	 $("#info").html("<b>Double-click happened!</b>");
	 alert($("#info2")[0].innerHTML);
	});
	$("h2").bind("mouseenter", function() {
	 $("#info").text("Hovered in " + this.tagName);
	});
	$("h2").bind("mouseleave", function() {
	 $("#info").text("");
	});



/** Form **/
	$("form").submit(function() {
		$(":submit",this).attr("disabled", "disabled");
	});
	$(":submit",this).removeAttr("disabled");

});

</script>

<div id="ajax-loading"><?php echo $this->Format->icon('loader');?></div>
<div id="ajax-loading-alt"><?php echo $this->Format->icon('loader-alt');?></div>


<h1><?php echo __('Click Events with Jquery');?></h1>
Double Click on this heading above!
<br /><br />
<div id="info"></div>

<br /><br />
It should alert a message with the text out of the following div:
<div id="info2" class="example"><b>what a great example!!!</b></div>

<br />


<h2>Preventing Double Submit</h2>
<?php
$data_print='$("form").submit(function() {
	$(":submit",this).attr("disabled", "disabled");
});
$(":submit",this).removeAttr("disabled");';
echo $this->Geshi->highlight($data_print,'javascript');
?>
The last line I added to ensure that the button is enabled on default (especially after reloading/[F5-force-reload]/Backbutton-Usage). Prevents some little things you dont want to happen.
<br /><br />

<?php echo $this->Form->Create('JqueryExample', array('url'=>'clickevents'))?>
<fieldset>
 		<legend><?php echo __('It gets only submitted ONCE - no matter how often you click the button');?></legend>
<?php echo $this->Form->input('name')?>
</fieldset>
<?php echo $this->Form->End('Try Clicking several times')?>

<br/>
Users won't get the opportunity to click the submit button more than once and will get a visual indication (assuming that
disabled buttons appear so in their browser) that the form is in the process of being submitted.<br /><br />
Careful though: if the browser goes in offline modus or the user hits "stop" in the browser menu the form cannot get posted anymore.
it is "stuck" - button is disabled and the data cannot be sent.<br />
Only thing that helps is pressing [F5] and Hit "yes, Send data once again" to submit the data again manually.