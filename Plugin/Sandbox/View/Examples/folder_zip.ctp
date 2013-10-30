<?php $this->Html->scriptStart(array('inline' => false)); ?>

$(document).ready(function() {

/** change system **/
	$('#change_system').click(function(e) {

		if ( $(e.target).is('a') ) {
		e.preventDefault();
		var targeturl = $(e.target).attr("href");
		$.ajax({
			type: "post",
			url: targeturl,
			success: function(html) { //so, if data is retrieved, store it in html
					$('#change_system').html(html); //show the html inside .content div
 		 		}
			}); //close $.ajax(
		}
	});


/** Alt Loading V **/
	$("#ajax-loading-alt").bind("ajaxStart", function() {
		$(this).show();
	 }).bind("ajaxStop", function() {
		$(this).hide();
	 });

/** Loading Visuality **/
	$("#ajax-loading").bind("ajaxStart", function() {
		//$("#twitter-message-text").hide();
		$(this).show();
	 }).bind("ajaxStop", function() {
		$(this).hide();
		//$("#twitter-message-text").fadeIn();
	 });

});

<?php $this->Html->scriptEnd(); ?>

<div id="ajax-loading"><?php echo $this->Format->icon('loader');?></div>

<h1>Folder Zip</h1>
This is the CakePHP Version from <?php echo $this->Html->link('www.web-development-blog.com','http://www.web-development-blog.com/archives/tutorial-create-a-zip-file-from-folders-on-the-fly', array('target'=>'_blank'))?>

<br /><br />
Now, the structure of our example file in /ROOT/files/examples/ is the following:
<?php
echo $this->Html->pre(array(
	'folder_zip'=>array(
		'a folder'=>'',
		'containing subfolders'=>array(
			'New Folder'=>'',
			'Some File.txt'
			),
		'1.txt',
		),
	)
)
?>
The content of "folder_zip" now is read and gets zipped (.zip) as "whatever.zip".<br />
We can define a "subfolder" inside the zip, where the files are stored into - but for now we leave them in the root folder of the file.
<br />

<h2>User has to select the operating system - if other than windows</h2>
Please select: You are a [<span id="change_system"><?php echo $this->element('examples/change_system');?></span>] user<br />
This is important - as the way the zip files get created, it might not be readable by the other system. So this has to be checked before the download starts.
<br />
<br />
Go ahead and try the wrong "version" - i cannot open the mac-version under windows anyway :)

<br />

<h2>Example</h2>
Zipping on the fly: <?php echo $this->Html->link('Create and download it (normal mouse click)', array('action'=>'folder_download','folder_zip'), array('id'=>'download'))?>


<br /><br />
Some other ones:
<br />
<?php echo $this->Html->link('An empty folder', array('action'=>'folder_download','folder_empty'), array('id'=>'download'))?> | <?php echo $this->Html->link('An non-existing folder', array('action'=>'folder_download','s'), array('id'=>'download'))?>

<br />

<h2>Looking Ahead</h2>
We could even build some pdf's or other files on the fly - save them to some tmp dir and then zip them all up and start the download.
This way the Component can get quite powerful.<br />
Anyone interested in continuing on this?