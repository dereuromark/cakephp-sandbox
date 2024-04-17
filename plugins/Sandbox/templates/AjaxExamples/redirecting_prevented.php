<?php
/**
 * @var \App\View\AppView $this
 */
?>

<?php $this->append('script'); ?>
<script>
$(function() {
	$('#example-container a').removeAttr('onclick');
	$('#example-container a').click(function(e) {
		e.preventDefault();
		var form = $(this).prev();
		var url = $(form).attr("action");

		var geturl;
		geturl = $.ajax({
			type: 'post',
			url: url,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
				$('#example-target').html('...');
			},
			success: function(res) {
				var content = 'Redirect to: ' + res._redirect.url + ' (status code ' + res._redirect.status + ')' + "<br/><br/>Raw data:<br/>" + JSON.stringify(res);
				content += "<br/><br/>Flash data in header X-Flash:<br/>" + geturl.getResponseHeader('X-Flash');

				$('#example-target').html(content);
			},
			error: function(e) {
				alert("Error");
				console.log(e);
			}
		});
	});
});
</script>
<?php $this->end(); ?>

<?php $this->append('css'); ?>
<style>
.toggle img.icon {
	cursor: pointer;
}
#some-record {
	background-color: #eee;
	width: 40px;
}

</style>
<?php $this->end(); ?>

<nav class="actions col-sm-4 col-12">
	<?php echo $this->element('navigation/ajax'); ?>
</nav>
<div class="page index col-sm-8 col-12">
<h2><?php echo __('Redirecting');?> and AJAX - Using Ajax Plugin</h2>

<p>
A simple AJAX POST with a normal redirect is usually resolved in the RequestHandler to avoid actual redirecting when serving AJAX.
It instead returns the redirected content as part of the response. Using the AjaxComponent you can disable that and instead return
the redirect URL and its status code to manually use it in your JS/jQuery code.
</p>

<div class="toggle">
	<div style="margin-bottom: 10px;"><?php echo $this->Form->postLink(__('A normal POST link'), []); ?></div>

	<div style="margin-bottom: 10px;" id="example-container">
		<?php echo $this->Form->postLink(__('Click me (I am AJAXified).'), []); ?>
	</div>

	<div class="alert alert-info" id="example-target">
	<small><i>The AJAX result (from the redirect) will go here</i></small>
	</div>
</div>

	<hr>

	<p>
		Note:
		The example above also uses Flash plugin which auto-adds the flash messages as <code>X-Flash</code> header to the response.
		If you want to keep the flash messages in the payload, you can also disable the header part using `'noSessionOnAjax'` config set to false (see code).
		<?php echo $this->Html->link('Not using header but payload', ['?' => ['no-header' => true]]); ?>
	</p>

</div>

