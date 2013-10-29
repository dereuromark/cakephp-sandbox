<?php


//$this->Html->script('jquery/plugins/form.js',false);
$this->Html->script('jquery/plugins/jqUploader.js',false);
?>

<h1>Contact me:</h1>

<?php echo $this->Form->create('Contact', array('url'=>'/'.$this->request->url));?>
	<fieldset>
 		<legend><?php echo __('Send me an email');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('email');
		echo $this->Form->input('title');
		echo $this->Form->input('message', array('type' => 'textarea'));
		echo $this->Form->input('attachments');
	?>
	</fieldset>

	<div class="files_uploaded" id="files_uploaded">
	..uploaded files..
	</div>
<?php echo $this->Form->end(__('Submit'));?>

<br />
<div class="file_upload">
<h1>Upload:</h1>



<br /><br /><br />

<?php echo $this->Form->create('ContactUpload', array('url'=>'/'.$this->request->url,'id'=>'myUploadForm','type'=>'file'));?>
	<fieldset>
 		<legend><?php echo __('Send me an email');?></legend>
	<?php
		echo '<input name="MAX_FILE_SIZE" value="648576" type="hidden" />';
		?>

<ol>
<li class="jqUploader">
<label for="example1">Choose a file to upload: </label>

<input name="example1" id="example1" type="file" />
</li>
</ol>

	</fieldset>

<?php echo $this->Form->end('Go on');?>

<br /><br />


</div>

<?php

?>