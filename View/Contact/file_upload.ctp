<div class="ss">
<?php
echo $this->Html->pre($file_info);
?>
FILE1
<?php
// echo $this->Ajax->link('DeleteIMG #'.$file_info['ContactUpload']['attachments'], array('action'=>'file_delete', $file_info['ContactUpload']['attachments']), array('update'=>'ajaxToggle-'.$file_info['ContactUpload']['attachments']),null,false)
?>

<script type="text/javascript">
<?php
if (!empty($file_info)) {
	echo 'alert(\'Uploaded and attached to the form\');';
} else {
	echo 'alert(\'Error processing the uploaded file\');';
}

?>

document.getElementById('upload_attachments').value='';
</script>
</div>