<script type="text/javascript">

		$(document).ready(function() {
			var options = {
				target: '#output1', // target element(s) to be updated with server response
				beforeSubmit: showRequest, // pre-submit callback
				complete: showResponse // post-submit callback
		};
			// bind 'myForm' and provide a simple callback function
			$('#myForm').ajaxForm(options);
		});

</script>

<div id="ajax-loading"><?php echo $this->Format->icon('loader');?></div>
<div id="ajax-loading-alt"><?php echo $this->Format->icon('loader-alt');?></div>

<h1>An ajax form post set up quickly (CakePHP)</h1>
Using jquery it can be done just with the following snippet in the view:
<?php
$data_print='$(document).ready(function() {
	var options = {
		target: \'#output1\', // target element(s) to be updated with server response
	};
	// bind \'myForm\' and provide a simple callback function
	$(\'#myForm\').ajaxForm(options);
});';
echo $this->Geshi->highlight($data_print,'javascript');
?>


<br />
In the controller you would need sth like this:
<?php
$data_print='function formpost_ajax() {
	$this->autoRender=false;

	if ($this->RequestHandler->isPost () && $this->RequestHandler->isAjax()) {

		echo WHATEVER YOU WANT
		echo \'<br>NOW: <b>\'.date(\'Y-m-d H:i:s\').\'</b> -
			a random number: <b>\'.mt_rand(5, 15).\'</b> - just for fun...\';
	}
}';
echo $this->Geshi->highlight($data_print,'php');
?>

<br />
<h2>Example</h2>




<?php echo $this->Form->Create('JqueryExample', array('id'=>'myForm','url'=>array('action'=>'formpost_ajax')))?>

 <?php echo $this->Form->input('name')?>
 <?php echo $this->Form->input('post', array('type'=>'textarea'))?>

<?php echo $this->Form->End('Submit Commment')?>

<br /><br />


<div id="output1">- this is #output1 div -</div>