<?php
$this->Html->addCrumb('Contact', array('action'=>'index'), array('title'=>'contact me'));
//$this->Html->addCrumb('xx', array('admin'=>'admin','action'=>'edit'), array('title'=>'ccxxs title'));

echo $this->Html->getCrumbs(' &raquo; ','[Home]');


$this->Html->script('jquery/plugins/form.js',false);
?>

<h1>Contact me:</h1>

<?php echo $this->Form->create('Contact', array('action'=>'index'));?>
	<fieldset>
 		<legend><?php echo __('Send me an email');?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('email');
		echo $this->Form->input('title');
		echo $this->Form->input('message', array('type'=>'textarea'));
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


<?php echo $this->Form->create('ContactUpload', array('action'=>'file_upload','id'=>'postUploadForm','type'=>'file'));?>
	<fieldset>
 		<legend><?php echo __('Send me an email');?></legend>
	<?php

		echo $this->Form->input('attachments', array('type'=>'file','id'=>'upload_attachments'));
		echo $this->Form->button('Upload', array('onclick'=>'$(\'#postUploadForm\').ajaxSubmit({target: \'#files_uploaded\', url: \''.$this->Html->url('/contact/file_upload').'\'});return false;'));
	?>
	</fieldset>

<?php echo $this->Form->end();?>



<br />


</div>

<?php

?>