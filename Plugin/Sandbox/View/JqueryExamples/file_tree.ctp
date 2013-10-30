<?php $this->Jquery->plugins(array('filetree'));?>

<script type="text/javascript">


$(document).ready( function() {

	$('#container-1').fileTree({
		root: 'examples',
		script: '/c/telapp/jquery_examples/file_tree_ajax'
		}, function(file) {
			alert(file);
		});

	$('#container-2').fileTree({
		root: 'examples',
		folderEvent: 'dblclick', expandSpeed: 1, collapseSpeed: 1,
		script: '/c/telapp/jquery_examples/file_tree_ajax'
		}, function(file) {
			alert(file);
		});

});

</script>



		<style type="text/css">

			div.demo {
				width:100%;
				height: 400px;
				border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;
				background: #FFF;
				overflow: scroll;
				padding: 5px;
			}

			div.demobox {
				width: 40%;
				float:left;
				margin-right: 50px;

			}

		</style>




<h1><?php echo __('Dynamic File Tree');?></h1>
This is the CakePHP version from <?php echo $this->Html->link('abeautifulsite.net/notebook_files/58/demo/','http://abeautifulsite.net/notebook_files/58/demo/', array('target'=>'_blank'))?>.<br />
It shows how to use a ajax tree to display a webfolder and its subfolders/content<br />
<?php
$data_print='$(document).ready(function() {
	$(\'#container_id\').fileTree({
		root: \'examples\',
		$script: \'/folder_to_ajax_script/file_tree_ajax\' }, function(file) {
		alert(file);
	});
});';
echo $this->Geshi->highlightText($data_print,'javascript');
?>


<br />

<h2>Example</h2>
Look into the Folder "folder_example_files" for a demo:
<br/><br />

<div class="demobox">
<b>Normal Click</b>
<div id="container-1" class="demo"></div>
</div>

<div class="demobox">
<b>Double-Click</b>
<div id="container-2" class="demo"></div>
</div>

<br class="clear"/>