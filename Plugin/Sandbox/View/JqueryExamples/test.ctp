<script type="text/javascript">

		// wait for the DOM to be loaded
		$(document).ready(function() {
			var options = {
				target: '#output1', // target element(s) to be updated with server response
				beforeSubmit: showRequest, // pre-submit callback
				success: showResponse // post-submit callback
		};
			// bind 'myForm' and provide a simple callback function
			$('#myForm').ajaxForm(options);
		});

// pre-submit callback
function showRequest(formData, jqForm, options) {
	document.getElementById('ajax-loading').style.display = 'block';
	document.getElementById('ajax-loading-alt').style.display = 'block';
	return true;
}

// post-submit callback
function showResponse() {
	document.getElementById('ajax-loading').style.display = 'none';
	document.getElementById('ajax-loading-alt').style.display = 'none';
}
	</script>
<div id="ajax-loading"><?php echo $this->Format->icon('loader');?></div>
<div id="ajax-loading-alt"><?php echo $this->Format->icon('loader-alt');?></div>


<h1><?php echo __('Some little tests to begin with');?></h1>

Notice: in the upper right corner i placed some "loading" divs - which show up during "ajax posting and reveicing".
For demonstration purposes i put both black and white gifs there, usually you can switch between one of them - depending on the layout.

<br />
<h2>Loading some content - by clicking or automatically on page load</h2>
These lines are responsible for the ajax submit (either inline - or better in the head):
<?php
$data_print='<script type="text/javascript">

		// wait for the DOM to be loaded
		$(document).ready(function() {
			var options = {
				target: \'#output1\', // target element(s) to be updated with server response
				beforeSubmit: showRequest, // pre-submit callback
				success: showResponse // post-submit callback
		};
			// bind \'myForm\' and provide a simple callback function
			$(\'#myForm\').ajaxForm(options);
		});

// pre-submit callback
function showRequest(formData, jqForm, options) {
	document.getElementById(\'ajax-loading\').style.display = \'block\';
	document.getElementById(\'ajax-loading-alt\').style.display = \'block\';
	return true;
}

// post-submit callback
function showResponse() {
	document.getElementById(\'ajax-loading\').style.display = \'none\';
	document.getElementById(\'ajax-loading-alt\').style.display = \'none\';
}
	</script>';
echo $this->Geshi->highlightText($data_print,'javascript');
?>
<br />
And the form now gets id="myForm" and the action (if not the same page) - thats it. Now it gets posted via ajax.<br />
This is now from the controller:
<?php
$data_print='function index_ajax() {
	$this->autoRender=false;	// you could (or should!) render a layout here, pushing this content there
	if ($this->RequestHandler->isPost() && $this->RequestHandler->isAjax()) {
		$ajax = \'Here it is...<br><br>\';
		if (!empty($this->request->data[\'JqueryExample\'][\'text\'])) {$ajax .= \'<b>Text:</b> \'.$this->request->data[\'JqueryExample\'][\'text\'].\'<br>\';}
		...
		echo $ajax;
	}
}';
echo $this->Geshi->highlightText($data_print,'php');
?>
<br />

<?php
echo $this->Form->create('JqueryExample', array('url'=>array('action'=>'index_ajax'),'id'=>'myForm'));
echo $this->Form->input('text');
echo $this->Form->input('comment', array('type'=>'textarea'));
echo $this->Form->end('Submit Test');
?>



<br />

<div id="output1">[The content will go right in here]</div>
<br />
<?php echo $this->Format->icon('delete',null,null, array('style'=>'cursor:pointer','onclick'=>'document.getElementById(\'output1\').innerHTML=\'[The content will go right in here]\''))?>


<br />


<h2>df</h2>